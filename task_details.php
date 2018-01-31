<?php
session_start();
include("includes/db_connector.php");
if(!$_SESSION["user"]){
  header("location:index.php");
  exit();
} else{
  $s_userid=$_SESSION["user"]["userid"];
}

$taskid = filter_var($_GET["taskid"],FILTER_SANITIZE_STRING);

if ($taskid == null || empty($taskid)){
    $taskid = filter_var($_POST["taskid"],FILTER_SANITIZE_STRING);
}

if($_POST["submit"]=="tasksubscribe"){
    $query = "INSERT INTO tasksubs (taskid,userid,date_subs) VALUES($taskid,$s_userid,NOW());";
    echo $query;
    if($connection->query($query)){
    header('Location: task_details.php?taskid=$taskid');
    }
    else{
        echo "whoops, something is wrong";
    }
}

if ($s_userid  != nul && !empty($s_userid) && 
    $taskid    != nul && !empty($taskid)){

    $querySelectTask = "SELECT a.id, a.taskname, a.description, a.onlineflag, a.activeflag, a.start, a.finish, "
                      ." a.location, b.description AS taskdescription, c.username "
                      ." FROM task a, taskdomain b, user c WHERE a.taskdomainid=b.id AND a.userid = c.id AND a.id=$taskid"; 
    $resultSelectTask =$connection->query($querySelectTask);
    
    if($resultSelectTask->num_rows>0){
        while($row=$resultSelectTask->fetch_assoc()){
            $taskname=$row["taskname"];
            $description=$row["description"];
            $onlineflag = $row["onlineflag"];
            $activeflag = $row["activeflag"];
            $start = $row["start"];
            $finish = $row["finish"];
            $location = $row["location"];
            $taskdescription = $row["taskdescription"];
            $username = $row["username"];
        }
    }
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
            <h2>Opportunity manager</h2>
            <form action="task_details.php" method="post"  enctype="multipart/form-data">
                <input type="hidden" id="taskid" name="taskid" value="<?php echo htmlspecialchars($taskid); ?>">
                <div class="form-group">
                    <label for="taskname">Opportunity title: <?php echo htmlspecialchars($taskname); ?></label>
                </div>
                <div class="form-group">
                    <label for="taskdescription">Type: <?php echo htmlspecialchars($taskdescription); ?></label>
                </div>
                <div class="form-group">
                    <label for="start">Start: <?php echo htmlspecialchars($start); ?></label>
                </div>
                    <div class="form-group">
                    <label for="finish">Finish: <?php echo htmlspecialchars($finish); ?></label>
                </div>
                <div class="form-group">
                    <label for="activeflag">Task Online:</label>
                        </br>
                        <label class="switch">
                           <input type="checkbox" id="onlineflag" name="onlineflag" class="form-control" <?php if($onlineflag){ echo "checked";} ?> onclick="return false;">
                           <div class="slider round"></div>
                    </label>
                </div>
                <div class="form-group">
                    <label for="location">Location: <?php echo htmlspecialchars($location); ?></label>
                </div>
                <div class="form-group">
                    <label for="activeflag">Active:</label>
                    </br>
                    <label class="switch">
                       <input type="checkbox" id="activeflag" name="activeflag" class="form-control" <?php if($activeflagvalue){ echo "checked";} ?> onclick="return false;">
                       <div class="slider round"></div>
                    </label>
                </div>
                <div class="form-group">
                  <label for="description">Description: <?php echo htmlspecialchars($description); ?></label>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-success" name="submit" value="tasksubscribe">Subscribe</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      <?php include("includes/footer.php");?>
    </body>
</html>