<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="js/admin.js" defer></script>
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
      <div class="actions">
        <input type="submit" value="+ Add Discount Code" class="button add-discount-code" />
      </div>

      <table class="admin">
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Start Date</th>
            <th>Expiration Date</th>
            <th># of Uses</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </main>

    <footer>
      <span>&copy; Joseph Oh <?php echo date("Y"); ?></span>
    </footer>
  </body>
</html>
