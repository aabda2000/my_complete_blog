<?php
class DBConnection
{

    private static $instance = null;

    // specify your own database credentials
    private static $host = "localhost";
    private static $db_name = "blog";
    private static $username = "root";
    private static $password = "orange";

    public static function getConnection()
    {

        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
                self::$instance->exec("set names utf8");
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
        }
        return self::$instance;
    }
}
