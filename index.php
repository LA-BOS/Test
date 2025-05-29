<?php
session_start();
// Đây là file chạy chính (Là nơi chúng require các file)
require_once "./env.php";    // Chứa các biến môi trường

require "./vendor/autoload.php";

// Nơi use các class cần thiết
require "./routes/web.php";

