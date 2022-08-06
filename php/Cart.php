<?php
class Cart
{
    private $subtotal;
    private $discount;
    private $discountValue = 0.00;
    
    /**
     * Cart constructor.
     * 
     * @param float     $subtotal
     * @param DiscountCode|null     $discount
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
     * @param DiscountCode|float    $amt    Amount to set
     * 
     * @return null|DiscountCode   Cart discounts amount
     */
    public function discount($dc = null) {
        if (empty($dc)) {
            return $this->discount;
        } else {
            $this->discount = $dc;
        }
    }

    /**
     * Retrieve value of discount in cart.
     * 
     * @return float    Discount value in correlation with cart subtotal
     */
    public function discountValue() {
        $this->calculate();
        return $this->discountValue;
    }

    /**
     * Retrieve total cart amount.
     * 
     * @return float    Cart total after discounts applied
     */
    public function total() {
        $this->calculate();
        $total = $this->subtotal - $this->discountValue;
        return $total < 0 ? 0 : $total;
    }

    private function calculate() {
        // Get values based on discount type.
        switch ($this->discount->type) {
            case 'P':
                $this->discountValue = ($this->discount->amount / 100) * $this->subtotal;
                break;
            case 'F':
                $this->discountValue = $this->discount->amount;
                break;
        }
    }
}
