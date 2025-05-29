<?php
namespace App\Models;

use App\Model;
use PDO;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    
    // Tính chất đóng gói: các thuộc tính private/protected
    protected $fillable = [
        'ho_ten', 'hinh_anh', 'email', 'so_dien_thoai', 'ngay_sinh', 'trang_thai'
    ];

    public function __construct()
    {
        parent::__construct(); // Tính chất kế thừa: gọi constructor của class cha
    }

    // Lấy tất cả khách hàng
    public static function all($search = null)
    {
        $instance = new static();
        $sql = "SELECT * FROM {$instance->table}";
        
        if ($search) {
            $sql .= " WHERE ho_ten LIKE :search OR email LIKE :search OR so_dien_thoai LIKE :search";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $instance->connection->prepare($sql);
        
        if ($search) {
            $searchParam = "%{$search}%";
            $stmt->bindParam(':search', $searchParam);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy khách hàng theo ID
    public static function find($id)
    {
        $instance = new static();
        $sql = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = :id";
        $stmt = $instance->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo mới khách hàng
    public function create(array $data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        return $stmt->execute();
    }

    // Cập nhật khách hàng
    public function update($id, array $data)
    {
        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
        }
        $setClause = implode(', ', $setParts);
        
        $sql = "UPDATE {$this->table} SET $setClause WHERE {$this->primaryKey} = :id";
        $stmt = $this->connection->prepare($sql);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Xóa khách hàng
    public static function delete($id)
    {
        $instance = new static();
        $sql = "DELETE FROM {$instance->table} WHERE {$instance->primaryKey} = :id";
        $stmt = $instance->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Kiểm tra email đã tồn tại
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        if ($excludeId) {
            $sql .= " AND {$this->primaryKey} != :excludeId";
        }
        
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        if ($excludeId) {
            $stmt->bindParam(':excludeId', $excludeId);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Validate dữ liệu khách hàng
    public function validateCustomer($data, $isUpdate = false, $id = null)
    {
        $errors = [];

        // Validate họ tên
        if (empty($data['ho_ten'])) {
            $errors['ho_ten'] = 'Họ tên không được để trống';
        } elseif (strlen($data['ho_ten']) < 2) {
            $errors['ho_ten'] = 'Họ tên phải có ít nhất 2 ký tự';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email không được để trống';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không đúng định dạng';
        } elseif ($this->emailExists($data['email'], $isUpdate ? $id : null)) {
            $errors['email'] = 'Email đã tồn tại';
        }

        // Validate số điện thoại
        if (empty($data['so_dien_thoai'])) {
            $errors['so_dien_thoai'] = 'Số điện thoại không được để trống';
        } elseif (!preg_match('/^[0-9]{10,11}$/', $data['so_dien_thoai'])) {
            $errors['so_dien_thoai'] = 'Số điện thoai phải là 10-11 chữ số';
        }

        // Validate ngày sinh
        if (empty($data['ngay_sinh'])) {
            $errors['ngay_sinh'] = 'Ngày sinh không được để trống';
        } else {
            $birthDate = new \DateTime($data['ngay_sinh']);
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y;
            if ($age < 16) {
                $errors['ngay_sinh'] = 'Khách hàng phải từ 16 tuổi trở lên';
            }
        }

        return $errors;
    }
}