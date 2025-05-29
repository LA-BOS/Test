<?php
use App\Controllers\HomeController;
use App\Controllers\CustumerController;
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

// Nhóm các đường dẫn
$router->mount('/admin', function() use ($router) {
    $router->get('/', function() {
        echo 'Trang quản trị';
    });
    $router->mount('/customers', function() use ($router) {
        $router->get('/', CustumerController::class . '@index');
        });
    }
);

// -------------------
$router->run();