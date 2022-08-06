<?php
class Database
{
    protected $conn;

    private $host;
    private $user;
    private $pass;
    private $db;
    
    /**
     * Database constructor.
     * 
     * @param string    $host   database host
     * @param string    $user   database username
     * @param string    $pass   database password
     * @param string    $db     database name
     */
    public function __construct ($host = "localhost", $user = "root", $pass = "", $db = "eventeny-code-challenge") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;

        // Connect to SQL database.
        $this->conn = $this->connectToDb();

        // Set up tables.
        $this->setUpDiscountCodeTable();
        // $this->seedDiscountCodeTable();
    }

    /**
     * Get PDO connection object.
     * 
     * @return PDO  Connection object
     */
    public function conn() {
        return $this->conn;
    }

    /**
     * Connect to Database.
     * 
     * @return PDO
     */
    private function connectToDb() {
        try {
            return new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8',
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

    /**
     * Set up DiscountCode table.
     */
    private function setUpDiscountCodeTable() {
        $sql = "CREATE TABLE IF NOT EXISTS discount_code (
            id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
            name VARCHAR(200) NOT NULL,
            type VARCHAR(1) NOT NULL DEFAULT 'P',
            amount DECIMAL(6, 2) UNSIGNED NOT NULL DEFAULT '0.00',
            start_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            end_date TIMESTAMP,
            num_uses TINYINT NOT NULL DEFAULT -1,
            status TINYINT NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->conn->exec($sql);
    }

    /**
     * Seed DiscountCode table with dummy data.
     */
    private function seedDiscountCodeTable() {
        $this->conn->exec('TRUNCATE discount_code');
        $sql = "INSERT INTO discount_code (name, type, amount) VALUES
            ('TEST50', 'P', '50.00'),
            ('TEST100', 'P', '100.00'),
            ('TESTA5', 'F', '5.00')
        ";

        $this->conn->exec($sql);
    }
}
