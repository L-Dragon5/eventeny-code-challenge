<?php
session_start();

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
      <table>
        <thead>
          <tr>
            <td>Product</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Total</td>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

      <table>
        <tbody>
          <?php if (isset($discountCode)): ?>
          <tr>
            <td>Subtotal</td>
            <td>&dollar;</td>
          </tr>
          <tr>
            <td>Discount</td>
            <td>&dollar;</td>
          </tr>
          <?php endif; ?>
          <tr>
            <td>Total</td>
            <td>&dollar;</td>
          </tr>
        </tbody>
      </table>

      <div class="discount-code">
        <label for="discount-code-input">Discount Code</label>
        <input type="text" id="discount-code-input" />
        <input type="submit" value="Apply Code" class="button" />
      </div>

      <div class="actions">
        <input type="submit" value="Submit Order" class="button" />
      </div>
    </main>

    <footer>
      <span>&copy; Joseph Oh <?php echo date("Y"); ?></span>
    </footer>
  </body>
</html>
