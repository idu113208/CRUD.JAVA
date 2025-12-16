<?php
class Database {
    private $host = "localhost";
    private $db_name = "alumni_db"; // Sesuaikan dengan nama database Anda
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Uncomment line below for debugging
            // echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>