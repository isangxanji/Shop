<?php
//database
/*
define('DB_HOST' = "localhost");
define('DB_USER' = "root"); 
define('DB_PASS' = "");     
define('DB_NAME' = "shop");

//singleton connection class
class Database {
    private static $instance = null;
    private $mysqli;
    private ffunction __construct() {
        //create the MySQLi cconnection
        $this ->mysqli = new sqli(
            DB_HOST, DB_USER, DB_PASS, DB_NAME
        );

        //Check for connection error
        if ($this->mysqli->connect_errno){
            die(json_encode([
                'error' => 'Connection failed: ' . $this->mysqli->connect_error
            ]))
        }
        $this->mysqlli->set_charset('utf8mb4');
        }
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance->mysqli;
        }
}*/



// Connect to MySQL
$conn = mysqli_connect('localhost', 'root', '', 'shoppee');
// Check connection
if (!$conn) {
die('Connection failed: ' . mysqli_connect_error());
}
// Optional: set charset
mysqli_set_charset($conn, 'utf8mb4');


?>