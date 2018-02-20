<?php

class Database {
    private static $servername = "wm66.wedos.net";
    private static $database = "d73909_warship";
    private static $username = "w73909_warship";
    private static $password = "rfWgdmUm";

    private static function getConnection() {
        $connection = new mysqli(self::$servername, self::$username, self::$password, self::$database);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        return $connection;
    }

    public static function query($query) {
        $connection = self::getConnection();
        $result = $connection->query($query);
        $connection->close();
        return $result;

    }
}
