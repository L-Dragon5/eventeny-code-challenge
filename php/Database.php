<?php
class Database
{
    protected $conn;

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "";
    
    public function __construct ($host, $user, $pass, $db) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;

        $this->conn = $this->connectToDb();
    }

    private function connectToDb() {
        try {
            return new PDO(
                'mysql:host' . $this->host . ';dbname=' . $this->db . ';charset=utf8',
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
