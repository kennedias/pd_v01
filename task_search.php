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
              <h2>Opportunities Search</h2>
                <form action="task_search.php" method="post">
                    <div class="input-group">
                        <div class="input-group-btn search-panel">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            	<span id="search_concept">All</span> <span class="caret"></span>
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
                    $select_query = "SELECT a.id, a.taskdomainid, a.userid, a.taskname, a.description, a.onlineflag, a.activeflag, a.start, a.finish, a.location, b.description AS taskdescription, c.username "
                                            ." FROM task a, taskdomain b, user c WHERE a.taskdomainid=b.id AND a.userid = c.id AND a.userid <> $s_userid "; 
                    
                    if ($criteria !== null  && !empty($criteria) && $searchkey !== null && !empty($searchkey) ){
                        if($criteria == "name"){
                            $select_query = $select_query." AND a.taskname LIKE '%$searchkey%' ";
                            
                        }else if($criteria == "location"){
                            $select_query =  $select_query." AND a.location LIKE '%$searchkey%' ";
                            
                        } 
                    }
                    
                    $select_query =  $select_query."ORDER BY a.taskname";

                    if ($select_query !== null  && !empty($select_query)){
                        echo "<div id='resultList'  class='row'>";
                            echo "<hgroup class='mb20'>";
                                echo "<h1>Opportunities</h1>";
                                echo "</hgroup>";
                
                            echo "<section class='col-xs-12 col-sm-6 col-md-12'>"; 
                                foreach ($connection->query($select_query) as $row){
                                    $id=$row["id"];
                                    $taskdomainid=$row["taskdomainid"];
                                    $taskdescription=$row["taskdescription"];
                                    $taskname=$row["taskname"];
                                    $description=$row["description"];
                                    $onlineflagvalue = $row["onlineflag"];
                                    $start = $row["start"];
                                    $finish = $row["finish"];
                                    $location = $row["location"];
                                    $activeflagvalue = $row["activeflag"];
                                    $username = $row["username"];
                                    $userid = $row["userid"];
                                    $onvalue="<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
                                    $offvalue="<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
                                    
                                   
                                    echo "<article class='search-result row'>";
                                        echo "<div class='col-xs-12 col-sm-12 col-md-2'>";
                                        switch ($taskdomainid) {
                                            case 1:
                                                echo "<span class='glyphicon glyphicon-briefcase' aria-hidden='true'></span>";
                                                break;
                                            case 2:
                                                 echo "<span class='glyphicon glyphicon-camera' aria-hidden='true'></span>";
                                                break;
                                            case 3:
                                                 echo "<span class='glyphicon glyphicon-blackboard' aria-hidden='true'></span>";
                                                break;
                                            default:
                                                 echo "<span class='glyphicon glyphicon-fishes' aria-hidden='true'></span>";
                                        }    
                                            
                                        echo "</div>";
                                        echo "<div class='col-xs-12 col-sm-12 col-md-5 excerpet'>";
                                            echo "<h3><a href='task_details.php?taskid=$id' title=''>$taskname</a></h3>";
                                            if($activeflagvalue){
                                                echo "<label for='active'>Active: $onvalue </label>";
                                            }else{
                                                echo "<label for='active'>Active: $offvalue </label>";
                                            }
                                            echo "</br><label for='taskdescription'>Type: $taskdescription</label>";
                                            echo "</br><label for='username'><a href='profile_consult.php?userid_consult=$userid' title=''> Posted by:$username</a></label>";   
                                            echo "</br><label for='location'>Location: $location</label>";
                                            echo "</br><label for='start'>Start: $start</label> - <label for='finish'>Finish: $finish</label>";
                                            echo "</br>"; 
                                            if($onlineflagvalue){
                                                echo "<label for='online'>Online: $onvalue </label>";
                                            }else{
                                                echo "<label for='online'>Online: $offvalue </label>";
                                            }
                                            echo "</br>";
                                            echo "<label for='description'>Description: $description</label>";
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
