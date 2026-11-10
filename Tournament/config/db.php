<?php
// konfigurasi koneksi database
class Database {
    // atribut koneksi
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "db_tournament";
    public $conn;

    // constructor inisialisasi PDO
    public function __construct() {
        $this->conn = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
            $this->username,
            $this->password
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
