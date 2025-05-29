<?php
namespace App;

use PDO;
use PDOException;

class Model
{
    protected $connection;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->connect();
    }

    // Kết nối database
    protected function connect()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USERNAME,
                DB_PASSWORD
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
