<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand font-bold" href="/users/">FMB (Poona Students)</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php if ($_SESSION['role']) { ?>
          <li><a href="/users/musaid.php">Musaid</a></li>
        <?php } ?>
        <?php
        if (in_array($_SESSION['email'], array('mohammedizzy@msbinstitute.com','nationalminerals52@gmail.com', 'mesaifee52@gmail.com', 'murtaza52@gmail.com', 'murtaza.sh@gmail.com', 'yusuf4u52@gmail.com', 'tzabuawala@gmail.com', 'mustafamnr@gmail.com', 'ismailsidhpuri@gmail.com'))) {
        ?>
          <li><a href="/users/pendingactions.php">Pending Actions</a></li>
          <li><a href="/users/_daily_hisab_entry.php">Daily Hisab</a></li>
          <li><a href="/users/thalisearch.php">Thaali Search</a></li>
          <li><a href="/users/generate_receipt_pdf.php">Export Receipts PDF</a></li>
          <li><a href="/users/requestarchive.txt">CR NR</a></li>
          <li><a href="/users/stopMultipleThaalis.php">Stop Thali</a></li>
          <li><a href="/users/expenses_new.php">Expenses</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Backend <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="/admin/index.php/examples/faiz">Admin</a></li>
              <li><a href="/admin/index.php/examples/receipts">Receipts</a></li>
              <li><a href="/admin/index.php/examples/payments">Payments</a></li>
              <li><a href="/admin/index.php/examples/change">CR NR</a></li>
              <li><a href="/admin/index.php/examples/event_response">Event Response</a></li>
              <li><a href="/admin/index.php/examples/daily_hisab_items">Daily Items</a></li>
              <li><a href="/admin/index.php/examples/daily_menu_count">Menu-Count</a>
              <li><a href="/admin/index.php/examples/sf_hisab">SF Purchases</a></li>
              <li><a href="/users/admin_scripts.php">Scripts</a></li>
            </ul>
          </li>
          <li><a href="/users/notpickedup.php">NotPickedUp</a></li>
          <li><a target="_blank" href="/sms/">SMS</a></li>
        <?php
        }
        ?>
        <?php
        if (in_array($_SESSION['email'], array('yusuf4u52@gmail.com', 'mustafamnr@gmail.com'))) {
        ?>
          <li><a href="/users/amount_received_by.php">Received</a></li>
        <?php
        }
        ?>
        <li><a href="/users/hoobHistory.php">My Receipts</a></li>
        <li><a href="/users/update_details.php">Update details</a></li>
        <li><a href="/users/events.php">Event Registration</a></li>
        <li><a href="/users/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>