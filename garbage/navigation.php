<nav class="navbar navbar-inverse">
  <div class="container-fluid">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="logocontainer">
        <a class="" href="index.php">
          <img alt="Brand" class="logo" src="img/S21_brand.png">
        </a>
      </div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="index.php">Home</a></li>
        <?php 
        if($_SESSION["user"]){
          echo '<li><a href="../search.php">Search</a></li>';
          echo '<li><a href="../profile.php">Profile</a></li>';
          echo '<li><a href="../skills.php">Skills</a></li>';
          echo '<li><a href="../logout.php">Logout</a></li>';
        } 
        else {
          echo '<li><a href="../login.php">Login</a></li>';
          echo '<li><a href="../join.php">Join</a></li>';
        }
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


