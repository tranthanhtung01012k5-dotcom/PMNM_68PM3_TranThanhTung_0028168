<?php
    require_once  '../app/core/ConnectDB.php';

    class sinhvienModel {
        private $conn;

        public function __construct() {
           $this->conn = ConnectDB::connect();
        }
        public function getAllSinhVien() {
            $query = "SELECT * FROM sinhvien";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }

?>