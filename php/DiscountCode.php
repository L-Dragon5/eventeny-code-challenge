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
        $sql = 'SELECT * FROM discount_code WHERE status=1';
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

    /**
     * Add new discount code.
     * 
     * @param Database  $db     Database object
     * @param array     $dc     fields of object to add
     * 
     * @return bool     Whether added successfully
     */
    public static function add(Database $db, $dc) {
        $sql = 'INSERT INTO discount_code (name, type, amount, start_date, end_date, num_uses) VALUES (?,?,?,?,?,?)';
        $stmt = $db->conn()->prepare($sql);

        // Prevent percents over 100%.
        // Prevent numbers below 0.
        if ($dc['type'] === 'P' && $dc['amount'] > 100.00) {
            $dc['amount'] = 100.00;
        } else if ($dc['amount'] < 0) {
            $dc['amount'] = 0.00;
        }

        // Date formatting.
        if (!empty($dc['start_date'])) {
            $startDate = new DateTime($dc['start_date']);
            $dc['start_date'] = $startDate->format('Y-m-d H:i:s');
        } else {
            $startDate = new DateTime();
            $dc['start_date'] = $startDate->format('Y-m-d H:i:s');
        }

        if (!empty($dc['end_date'])) {
            $endDate = new DateTime($dc['end_date']);
            $dc['end_date'] = $endDate->format('Y-m-d H:i:s');
        } else {
            $dc['end_date'] = NULL;
        }

        $result = $stmt->execute([
            $dc['name'],
            $dc['type'],
            $dc['amount'],
            $dc['start_date'],
            $dc['end_date'],
            $dc['num_uses'],
        ]);
        
        return $result;
    }

    /**
     * Edit discount code based on id.
     * 
     * @param Database  $db     Database object
     * @param int       $id     id of discount code
     * @param array     $dc     fields to edit on object
     * 
     * @return bool     Whether updated successfully
     */
    public static function edit(Database $db, $id, $dc) {
        $sql = 'UPDATE discount_code SET name=:name, type=:type, amount=:amount, start_date=:startDate, end_date=:endDate, num_uses=:numUses WHERE id=:id';
        $stmt = $db->conn()->prepare($sql);

        // Prevent percents over 100%.
        // Prevent numbers below 0.
        if ($dc['type'] === 'P' && $dc['amount'] > 100.00) {
            $dc['amount'] = 100.00;
        } else if ($dc['amount'] < 0) {
            $dc['amount'] = 0.00;
        }

        // Date formatting.
        if (!empty($dc['start_date'])) {
            $startDate = new DateTime($dc['start_date']);
            $dc['start_date'] = $startDate->format('Y-m-d H:i:s');
        } else {
            $startDate = new DateTime();
            $dc['start_date'] = $startDate->format('Y-m-d H:i:s');
        }

        if (!empty($dc['end_date'])) {
            $endDate = new DateTime($dc['end_date']);
            $dc['end_date'] = $endDate->format('Y-m-d H:i:s');
        } else {
            $dc['end_date'] = NULL;
        }

        $result = $stmt->execute([
            'name' => $dc['name'],
            'type' => $dc['type'],
            'amount' => $dc['amount'],
            'startDate' => $dc['start_date'],
            'endDate' => $dc['end_date'],
            'numUses' => $dc['num_uses'],
            'id' => $id,
        ]);
        
        return $result;
    }

    /**
     * Remove discount code based on id.
     * Sets status to 0.
     * 
     * @param Database  $db     Database object
     * @param int       $id     id of discount code
     * 
     * @return bool     Whether deleted successfully
     */
    public static function remove(Database $db, $id) {
        $sql = 'UPDATE discount_code SET status=0 WHERE id=?';
        $stmt = $db->conn()->prepare($sql);
        $result = $stmt->execute([$id]);
        
        return $result;
    }

    /**
     * Check if discount code is within date active.
     * 
     * @param Database  $db     Database object
     * @param int       $id     id of discount code
     * 
     * @return bool     Whether used successfully
     */
    public static function checkDate(Database $db, $id) {
        $sql = 'SELECT start_date, end_date FROM discount_code WHERE id=?';
        $stmt = $db->conn()->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $startDate = $result['start_date'];
        $endDate = $result['end_date'];

        if (empty($endDate)) {
            return true;
        } else {
            $startDate = new DateTime($startDate);
            $endDate = new DateTime($endDate);
            $curTime = new DateTime();
            
            if ($curTime->getTimestamp() > $startDate->getTimestamp() && $curTime->getTimestamp() <= $endDate->getTimestamp()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Use one use of the discount code.
     * 
     * @param Database  $db     Database object
     * @param int       $id     id of discount code
     * 
     * @return bool     Whether used successfully
     */
    public static function useOne(Database $db, $id) {
        $sql = 'SELECT num_uses FROM discount_code WHERE id=?';
        $stmt = $db->conn()->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $uses = $result['num_uses'];

        if ($uses === -1) {
            return true;
        } else if ($uses !== -1 && $uses > 0) {
            $sql = 'UPDATE discount_code SET num_uses=? WHERE id=?';
            $stmt = $db->conn()->prepare($sql);
            $result = $stmt->execute([($uses - 1), $id]);
            return $result;
        } else if ($uses === 0) {
            return false;
        }

        return false;
    }
}
