<?php

class ConnectDB {

    private static $host = '127.0.0.1';
    private static $db_name = 'PMNM_68PM3';
    private static $username = 'root';
    private static $password = '';

    public static $conn;

    public static function connect() {

        if(self::$conn == null){

            try {

                self::$conn = new PDO(
                    "mysql:host=127.0.0.1;port=3307;dbname=PMNM_68PM3;charset=utf8mb4",
                    "root",
                    ""
                );

                self::$conn->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            } catch(PDOException $e) {

                die("Lỗi kết nối: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}

?>