
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#shop-app" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php">Dashboard</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="shop-app">
      <ul class="nav navbar-nav">
        <li><a href="catagory.php?do=manage">Catagory</a></li>
        <li><a href="item.php">Items</a></li>
        <li><a href="members.php">Members</a></li>
        <li><a href="#">Statistics</a></li>
        <li><a href="#">Logs</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if(isset($_SESSION['admin_username'])){ echo $_SESSION['admin_username']; } ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=edit&userId=<?php echo $_SESSION['admin_ID']; ?>">Edit profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>