<?php
use App\Controllers\HomeController;
use App\Controllers\CustomerController; // Sửa từ CustumerController
use Bramus\Router\Router;

$router = new Router();

// Đây là nơi khai báo các route
$router->get('/', HomeController::class . '@index');

$router->get('/about', function() {
    echo 'Trang giới thiệu';
});

$router->get('/user/{id}', function($id) {
    echo "Trang người dùng $id";
});

// Nhóm các đường dẫn admin
$router->mount('/admin', function() use ($router) {
    $router->get('/', function() {
        echo 'Trang quản trị';
    });
    
    // Nhóm đường dẫn customers
    $router->mount('/customers', function() use ($router) {
        // Hiển thị danh sách khách hàng
        $router->get('/', CustomerController::class . '@index');
        
        // Hiển thị form thêm khách hàng
        $router->get('/create', CustomerController::class . '@create');
        
        // Xử lý thêm khách hàng
        $router->post('/store', CustomerController::class . '@store');
        
        // Hiển thị chi tiết khách hàng
        $router->get('/show/(\d+)', CustomerController::class . '@show');
        
        // Hiển thị form sửa khách hàng
        $router->get('/edit/(\d+)', CustomerController::class . '@edit');
        
        // Xử lý cập nhật khách hàng
        $router->post('/update/(\d+)', CustomerController::class . '@update');
        
        // Xóa khách hàng
        $router->get('/delete/(\d+)', CustomerController::class . '@delete');
    });
});

// Chạy router
$router->run();