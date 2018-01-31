<?php
session_start();
include("includes/db_connector.php");
if(!$_SESSION["user"]){
  header("location:search_results.php");
  exit();
} else{
  $s_userid=$_SESSION["user"]["userid"];
}



?>

<!doctype html>
<html>
    <?php include("includes/head.php");?>
    <body>
      <?php include("includes/navigation2.php");?>
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-md-offset-4">
              <h2>Search</h2>
                <form id="search" name="search">
                  <input type="text" id="search_text">
                  <button role="submit">Search</button>
                </form>
            </div>
          </div>
        </div>    
    
      <?php include("includes/footer.php");?>
    </body>
</html>
