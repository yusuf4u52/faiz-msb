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
        <?php
        if(in_array($_SESSION['email'], array('murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','bscalcuttawala@gmail.com','mustafamnr@gmail.com')))
        {
          ?>
          <li><a href="pendingactions.php">Pending Actions</a></li>
          <li><a href="thalisearch.php">Thaali Search</a></li>
          <li><a href="stopMultipleThaalis.php">Stop Multiple Thaalis</a></li>
          <li><a href="../admin/index.php/examples/faiz">Admin</a></li>
          <?php
        }
        ?>
        <li><a href="hoobHistory.php">Paid Receipts</a></li>
        <li><a href="update_details.php">Update details</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>