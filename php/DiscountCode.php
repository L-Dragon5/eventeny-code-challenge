<?php

/**
 * DiscountCode class.
 * 
 * Type = P (Percentage) | F (Fixed Amount)
 */
class DiscountCode
{
    public $id;
    public $name;
    public $type;
    public $amount;
    public $start_date;
    public $end_date;
    public $num_uses;
    public $status;
    public $created_at;
    public $updated_at;

    /**
     * Retrieve all discount codes
     * 
     * @param Database  $db     Database object
     * 
     * @return array    array of DiscountCode objects of all rows in database.
     */
    public static function all(Database $db) {
        $sql = 'SELECT * FROM discount_code';
        $stmt = $db->conn()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'DiscountCode');
    }

    /**
     * Retrieve discount code based on primary key id.
     * 
     * @param Database  $db     Database object
     * @param int       $id     primary key id
     * 
     * @return DiscountCode|false   DiscountCode object from database or false if not found
     */
    public static function find(Database $db ,$id) {
        $sql = 'SELECT * FROM discount_code WHERE id=?';
        $stmt = $db->conn()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'DiscountCode');
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return !empty($result) ? $result : false;
    }

    /**
     * Retrieve discount code based on name.
     * 
     * @param Database  $db     Database object
     * @param string    $name   Discount code name
     * 
     * @return DiscountCode|false   DiscountCode object from database or false if not found
     */
    public static function findByName(Database $db, $name) {
        $sql = 'SELECT * FROM discount_code WHERE name=?';
        $stmt = $db->conn()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'DiscountCode');
        $stmt->execute([$name]);
        $result = $stmt->fetch();

        return !empty($result) ? $result : false;
    }
}
