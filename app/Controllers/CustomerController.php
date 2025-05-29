<?php
namespace App\Controllers;

use App\Controller; // Kế thừa từ Controller
use App\Models\Customer;

class CustomerController extends Controller // Tính chất kế thừa
{
    private $customerModel; // Tính chất đóng gói

    public function __construct()
    {
        $this->customerModel = new Customer();
    }

    // Hiển thị danh sách khách hàng
    public function index()
    {
        $search = $_GET['search'] ?? null;
        $customers = Customer::all($search);
        
        $title = 'Danh sách khách hàng';
        include 'views/customers/index.php';
    }

    // Hiển thị form thêm khách hàng
    public function create()
    {
        $title = 'Thêm khách hàng mới';
        include 'views/customers/create.php';
    }

    // Xử lý thêm khách hàng
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/customers');
        }

        $data = [
            'ho_ten' => trim($_POST['ho_ten'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? ''),
            'ngay_sinh' => $_POST['ngay_sinh'] ?? '',
            'trang_thai' => $_POST['trang_thai'] ?? 'active'
        ];

        // Xử lý upload hình ảnh
        if (is_upload('hinh_anh')) {
            try {
                $data['hinh_anh'] = $this->uploadFile($_FILES['hinh_anh'], 'customers');
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $_SESSION['old_data'] = $data;
                redirect('/admin/customers/create');
            }
        }

        // Validate dữ liệu
        $errors = $this->customerModel->validateCustomer($data);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $data;
            redirect('/admin/customers/create');
        }

        // Lưu vào database
        if ($this->customerModel->create($data)) {
            $_SESSION['success'] = 'Thêm khách hàng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi thêm khách hàng!';
        }

        redirect('/admin/customers');
    }

    // Hiển thị form sửa khách hàng
    public function edit($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            $_SESSION['error'] = 'Không tìm thấy khách hàng!';
            redirect('/admin/customers');
        }

        $title = 'Sửa thông tin khách hàng';
        include 'views/customers/edit.php';
    }

    // Xử lý cập nhật khách hàng
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/customers');
        }

        $customer = Customer::find($id);
        if (!$customer) {
            $_SESSION['error'] = 'Không tìm thấy khách hàng!';
            redirect('/admin/customers');
        }

        $data = [
            'ho_ten' => trim($_POST['ho_ten'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? ''),
            'ngay_sinh' => $_POST['ngay_sinh'] ?? '',
            'trang_thai' => $_POST['trang_thai'] ?? 'active'
        ];

        // Xử lý upload hình ảnh mới
        if (is_upload('hinh_anh')) {
            try {
                // Xóa hình cũ nếu có
                if ($customer['hinh_anh'] && file_exists($customer['hinh_anh'])) {
                    unlink($customer['hinh_anh']);
                }
                $data['hinh_anh'] = $this->uploadFile($_FILES['hinh_anh'], 'customers');
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                redirect("/admin/customers/edit/$id");
            }
        }

        // Validate dữ liệu
        $errors = $this->customerModel->validateCustomer($data, true, $id);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $data;
            redirect("/admin/customers/edit/$id");
        }

        // Cập nhật database
        if ($this->customerModel->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật khách hàng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật khách hàng!';
        }

        redirect('/admin/customers');
    }

    // Xóa khách hàng
    public function delete($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            $_SESSION['error'] = 'Không tìm thấy khách hàng!';
            redirect('/admin/customers');
        }

        // Xóa hình ảnh nếu có
        if ($customer['hinh_anh'] && file_exists($customer['hinh_anh'])) {
            unlink($customer['hinh_anh']);
        }

        if (Customer::delete($id)) {
            $_SESSION['success'] = 'Xóa khách hàng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa khách hàng!';
        }

        redirect('/admin/customers');
    }

    // Hiển thị chi tiết khách hàng
    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            $_SESSION['error'] = 'Không tìm thấy khách hàng!';
            redirect('/admin/customers');
        }

        $title = 'Chi tiết khách hàng';
        include 'views/customers/show.php';
    }
}