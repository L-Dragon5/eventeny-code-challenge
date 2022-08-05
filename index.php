<?php
session_start();
require_once('php/Database.php');
require_once('php/Cart.php');

$db = new Database();
$cart = new Cart();

if (!isset($_SESSION['cart_amount'])) {
  $_SESSION['cart_amount'] = 165.00;
}
$cart->subtotal($_SESSION['cart_amount']);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joseph Oh - Eventeny Code Challenge</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Scripts -->
    <script src="index.js" defer></script>
  </head>
  <body>
	  <header>
      <nav>
        <h1 class="header-title">Shopping Cart</h1>

        <div class="nav-links">
          <a href="/">Cart</a>
          <a href="admin.php">Admin</a>
        </div>
      </nav>
    </header>

    <main>
      <table class="cart">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Initial Interview</td>
            <td>&dollar;100.00</td>
            <td>1</td>
            <td>&dollar;100.00</td>
          </tr>
          <tr>
            <td>Interview Challenge</td>
            <td>&dollar;65.00</td>
            <td>1</td>
            <td>&dollar;65.00</td>
          </tr>
        </tbody>
      </table>

      <table class="totals">
        <tbody>
          <?php if (isset($cart->discount)): ?>
          <tr>
            <td>Subtotal</td>
            <td>&dollar;<?php echo number_format($cart->subtotal(), 2); ?></td>
          </tr>
          <tr>
            <td>Discount</td>
            <td>&dollar;<?php echo number_format($cart->discount(), 2); ?></td>
          </tr>
          <?php endif; ?>
          <tr>
            <td>Total</td>
            <td>&dollar;<?php echo number_format($cart->total(), 2); ?></td>
          </tr>
        </tbody>
      </table>

      <div class="discount-code">
        <label for="discount-code-input">Discount Code</label>
        <input type="text" id="discount-code-input" />
        <input type="submit" value="Apply Code" class="button" />
      </div>
    </main>

    <footer>
      <span>&copy; Joseph Oh <?php echo date("Y"); ?></span>
    </footer>
  </body>
</html>
