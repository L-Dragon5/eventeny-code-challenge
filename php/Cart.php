<?php
class Cart
{
    private $subtotal;
    private $discount;
    
    /**
     * Cart constructor.
     * 
     * @param float     $subtotal
     * @param float     $discount
     */
    public function __construct($subtotal = 0.00, $discount = null) {
        $this->subtotal = $subtotal;
        $this->discount = $discount;
    }

    /**
     * Retrieve/Set subtotal.
     * If parameter is set, set the value.
     * If not, retrieve and return it.
     * 
     * @param null|float    $amt    Amount to set
     * 
     * @return null|float   Cart subtotal amount
     */
    public function subtotal($amt = null) {
        if (empty($amt)) {
            return $this->subtotal;
        } else {
            $this->subtotal = $amt;
        }
    }

    /**
     * Retrieve/Set discount value.
     * If parameter is set, set the value.
     * If not, retrieve and return it.
     * 
     * @param null|float    $amt    Amount to set
     * 
     * @return null|float   Cart discounts amount
     */
    public function discount($amt = null) {
        if (empty($amt)) {
            return $this->discount;
        } else {
            $this->discount = $amt;
        }
    }

    /**
     * Retrieve total cart amount.
     * 
     * @return float    Cart total after discounts applied
     */
    public function total() {
        $total = $this->subtotal - $this->discount;
        return $total < 0 ? 0 : $total;
    }
}
