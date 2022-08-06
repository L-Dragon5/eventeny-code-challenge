<?php
session_start();
require_once('php/Database.php');
require_once('php/Cart.php');
require_once('php/DiscountCode.php');

// Create database and cart objects for use and calculations.
$dc = isset($_SESSION['discount-code']) ? unserialize($_SESSION['discount-code']) : null;
$db = new Database();
$cart = new Cart(165.00, $dc);
$success = false;
$errors = false;

if ($dc) {
  $success = true;
  $successMessage = "Code '" . $dc->name . "' has been applied.";
}

// If form is submitted with discount code.
if (isset($_POST['discount-code'])) {
  // Sanitize data coming in.
  $discountCodeValue = htmlspecialchars($_POST['discount-code']);

  // Find discount code object by the name value
  $discountCode = DiscountCode::findByName($db, $discountCodeValue);

  // If not found, throw error.
  // If found, set it in cart for calculations and display.
  if (empty($discountCode)) {
    $errors = true;
    $error = "Code '" . $discountCodeValue . "' does not exist.";
  } else {
    $success = true;
    $successMessage = "Code '" . $discountCodeValue . "' has been applied.";
    $_SESSION['discount-code'] = serialize($discountCode);

    $cart->discount($discountCode);
  }
}

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="cart.js" defer></script>
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
          <?php if (null !== $cart->discount()): ?>
          <tr>
            <td>Subtotal</td>
            <td>&dollar;<?php echo number_format($cart->subtotal(), 2); ?></td>
          </tr>
          <tr>
            <td>Discount</td>
            <td style="color: green;">-&dollar;<?php echo number_format($cart->discountValue(), 2); ?></td>
          </tr>
          <?php endif; ?>
          <tr>
            <td>Total</td>
            <td>&dollar;<?php echo number_format($cart->total(), 2); ?></td>
          </tr>
        </tbody>
      </table>

      <form class="discount-code-form" action="" method="post">
        <?php if ($errors): ?>
          <div class="discount-code-error" style="display: block;"><?php echo $error; ?></div>
        <?php else: ?>
          <div class="discount-code-error"></div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="discount-code-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <label for="discount-code-input">Discount Code</label>
        <input type="text" id="discount-code-input" name="discount-code" />
        <input type="submit" value="Apply Code" class="button apply-discount-code" />
      </form>
    </main>

    <footer>
      <span>&copy; Joseph Oh <?php echo date("Y"); ?></span>
    </footer>
  </body>
</html>
