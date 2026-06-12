<?php

class ConnectDB {

    private static $host = '127.0.0.1';
    private static $db_name = 'PMNM_68PM3';
    private static $username = 'root';
    private static $password = '';

    public static $conn;

    public static function connect() {

    if (self::$conn == null) {

        try {
            $host = self::$host;
            $db = self::$db_name;

            self::$conn = new PDO(
                "mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4",
                self::$username,
                self::$password
            );

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Lỗi kết nối: " . $e->getMessage());
        }
    }

    return self::$conn;
}
}

?>