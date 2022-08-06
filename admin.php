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

    <div class="modal-screen"></div>
    <div id="modal" class="modal">
      <span class="close">&times;</span>
      <div class="modal-content">
        <form id="admin-discount-code-form" class="modal-form">
          <div class="form-group">
            <div class="form-control">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" required />
            </div>
          </div>
          
          <div class="form-group-radio">
            <div class="form-radio">
              <input type="radio" id="percentage" name="type" value="P" checked/>
              <label for="percentage">Percentage</label>
            </div>
            <div class="form-radio">
              <input type="radio" id="fixed" name="type" value="F" />
              <label for="fixed">Fixed Amount</label>
            </div>
          </div>
          
          <div class="form-group">
            <div class="form-control">
              <label for="amount">Amount</label>
              <input type="number" id="amount" name="amount" min="0" step="0.01" value="0.00" />
            </div>
            <div class="form-control">
              <label for="uses"># of Uses (-1 is infinite)</label>
              <input type="number" id="uses" name="num_uses" min="-1" max="999" step="1" value="-1" />
            </div>
          </div>
          
          <div class="form-group">
            <div class="form-control">
              <label for="start-date">Start Date (leave blank to default today)</label>
              <input type="datetime-local" id="start-date" name="start_date" />
            </div>
            <div class="form-control">
              <label for="end-date">End Date (leave blank for no expiration)</label>
              <input type="datetime-local" id="end-date" name="end_date" />
            </div>
          </div>

          <input type="submit" class="button" value="Save" />
        </form>
      </div>
    </div>
  </body>
</html>
