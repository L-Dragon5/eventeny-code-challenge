<?php

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Scripts -->
    <script src="index.js" defer></script>
  </head>
  <body>
    <header class="admin">
      <nav>
        <h1 class="header-title">Admin Panel</h1>

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
            <td>Discount Code</td>
            <td>Type</td>
            <td>Amount</td>
            <td>Start Date</td>
            <td>Expiration Date</td>
            <td># of Uses</td>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

      <div class="actions">
        <input type="submit" value="+ Add Discount Code" class="button" />
      </div>
    </main>

    <footer>
      <span>&copy; Joseph Oh <?php echo date("Y"); ?></span>
    </footer>
  </body>
</html>
