<?php
session_start();
include("includes/db_connector.php");
if(!$_SESSION["user"]){
  header("location:index.php");
  exit();
} else{
  $s_userid=$_SESSION["user"]["userid"];
}

?>

<!doctype html>
<html>
    <?php include("includes/head.php");?>
    
    <body>
      <?php include("includes/navigation.php");?>
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-md-offset-4">
              <h2>User Search</h2>
                <form action="user_search.php" method="post">
                    <div class="input-group">
                        <div class="input-group-btn search-panel">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            	<span id="search_concept">Name</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#name">Name</a></li>
                              <li><a href="#location">Location</a></li>
                            </ul>
                        </div>
                        <input type="hidden" name="criteria" value="name" id="criteria">         
                        <input type="text" class="form-control" id="searchkey" name="searchkey" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="submit" value="search"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
          </div>
          <div class="row">
            <?php

                if($_POST["submit"]=="search"){
                    //print_r($_POST);
                    $searchkey = $_POST['searchkey'];
                    $criteria = $_POST['criteria']; 
                    $select_query = null;
                    
                    if ($criteria !== null  && !empty($criteria) && $searchkey !== null && !empty($searchkey) ){
                        if($criteria == "name"){
                            $select_query = "SELECT id, username, location, picture, nationality FROM user_basicinfo_view WHERE username LIKE '%$searchkey%' ORDER BY username";
                            
                        }else if($criteria == "location"){
                            $select_query = "SELECT id, username, location, picture, nationality FROM user_basicinfo_view WHERE location LIKE '%$searchkey%' ORDER BY location";
                            
                        } else {
                            //error
                            echo "<p>No criteria selected.</p>";
                        }
                    }
                    
                    if ($select_query !== null  && !empty($select_query)){
                        echo "<div id='resultList'  class='row'>";
                            echo "<hgroup class='mb20'>";
                                echo "<h1>Search Results</h1>";
                                echo "<h2 class='lead'>Results found for the search for <strong class='text-danger'>$searchkey</strong></h2>";
                                echo "</hgroup>";
                
                            echo "<section class='col-xs-12 col-sm-6 col-md-12'>"; 
                                foreach ($connection->query($select_query) as $row){
                                    $id=$row["id"];
                                    $username = $row["username"];
                                    $nationality_code = $row["nationality_code"];
                                    $location = $row["location"];
                                    $picture = $row["picture"];
                                    $nationality = $row["nationality"];
                                   
                                    echo "<article class='search-result row'>";
                                        echo "<div class='col-xs-12 col-sm-12 col-md-3'>";
                                            if ($picture != nul && !empty($picture)){
                                                echo "<a href='#' title='profileimage' class='thumbnail'><img src='img_profile/$picture' alt='' /></a>";
                                            }
                                        echo "</div>";
                                        echo "<div class='col-xs-12 col-sm-12 col-md-7 excerpet'>";
                                            echo "<h3><a href='profile_consult.php?userid_consult=$id' title=''>$username</a></h3>";
                                            echo "<label for='location'>Location: $location</label> <br>";
                                            echo "<label for='nationality'>Nationality: $nationality</label>";
                                        echo "</div>";
                                        echo "<span class='clearfix borda'></span>";
                                    echo "</article>";
                                } 
                            echo "</section>";
                        echo "</div>";
                    }   
                }
            ?>
          </div> 
        </div>
   
      <?php include("includes/footer.php");?>
    </body>
</html>
