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
//print_r($_POST);

if($_POST["submit"]=="taskcreateupdate"){
    $taskname = filter_var($_POST["taskname"],FILTER_SANITIZE_STRING);
    $taskdomainid = filter_var($_POST["taskdomainid"],FILTER_SANITIZE_STRING);
    $description = filter_var($_POST["description"],FILTER_SANITIZE_STRING);
    $start = filter_var($_POST["start"],FILTER_SANITIZE_STRING);
    $finish = filter_var($_POST["finish"],FILTER_SANITIZE_STRING);
    $location = filter_var($_POST["location"],FILTER_SANITIZE_STRING);
    $onlineflag = filter_var($_POST["onlineflag"],FILTER_SANITIZE_STRING);
    $activeflag = filter_var($_POST["activeflag"],FILTER_SANITIZE_STRING);
    $onlineflagvalue=null;
    $activeflagvalue=null;

    if ($onlineflag === "on"){
        $onlineflagvalue = "1";
    } else {
        $onlineflagvalue = "0";
    }
    
    if ($activeflag === "on"){
        $activeflagvalue = "1";
    } else {
        $activeflagvalue = "0";
    }

    if ($s_userid     != null && !empty($s_userid)){
        if ($taskid != null && !empty($taskid)){
            $queryTask="UPDATE task SET taskdomainid=$taskdomainid, taskname='$taskname', description='$description', onlineflag='$onlineflagvalue', "
                                     ." start='$start', finish='$finish', location='$location', activeflag='$activeflagvalue' where id=$taskid and userid=$s_userid";
            $resultTask =$connection->query($queryTask);
        } else {
            $queryTask="INSERT INTO task(id, taskdomainid, userid, taskname, description, onlineflag, activeflag, start, finish, location) "
                            ." VALUES(0,$taskdomainid,$s_userid, '$taskname','$description','$onlineflagvalue', '$activeflagvalue','$start','$finish','$location')";
            $resultTask =$connection->query($queryTask);
            $taskid = $connection->insert_id;
        }
    }
}



if ($s_userid != null && !empty($s_userid) && 
    $taskid   != null && !empty($taskid)){

    $querySelectTask = "SELECT taskdomainid, taskname, description, onlineflag, activeflag, start, finish, location FROM task WHERE id=$taskid AND userid=$s_userid";  
    $resultSelectTask =$connection->query($querySelectTask);
    
   
    
    if($resultSelectTask->num_rows>0){
        while($row=$resultSelectTask->fetch_assoc()){
            $taskdomainid=$row["taskdomainid"];
            $taskname=$row["taskname"];
            $description=$row["description"];
            $onlineflagvalue = $row["onlineflag"];
            $start = $row["start"];
            $finish = $row["finish"];
            $location = $row["location"];
            $activeflagvalue = $row["activeflag"];
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
            <form action="task_manager.php" method="post"  enctype="multipart/form-data">
                <input type="hidden" id="taskid" name="taskid" value="<?php echo htmlspecialchars($taskid); ?>">
                <div class="form-group">
                    <label for="taskname">Opportunity title:</label>
                    <input type="text" class="form-control" id="taskname" name="taskname" placeholder="Title" value="<?php echo htmlspecialchars($taskname); ?>" />
                </div>
                <div class="form-group">
                    <label class="control-label">Opportuniy type</label>
                    <?php 
                      $querySelectTaskType="SELECT id, description FROM taskdomain";
                      echo "<select class='form-control' name='taskdomainid'>";
                     // echo "<option value=''>Select type of opportunity</option>";  
                      foreach ($connection->query($querySelectTaskType) as $row){
                        if($row['id'] == $taskdomainid){
                          echo "<option value=".$row['id']." selected>".$row['description']."</option>";
                        }else {
                        echo "<option value=".$row['id'].">".$row['description']."</option>";  
                        }
                      }
                      echo "</select>";
                    ?>
                </div>
                <div class="form-group">
                    <label for="start">Start:</label>
                    <input type="date" class="form-control" id="start" name="start" placeholder="Date of start" value="<?php echo htmlspecialchars($start); ?>" />
                </div>
                    <div class="form-group">
                    <label for="finish">Finish:</label>
                    <input type="date" class="form-control" id="finish" name="finish" placeholder="Date of finish" value="<?php echo htmlspecialchars($finish); ?>" />
                </div>
                <div class="form-group">
                    <label for="onlineflag">Task Online</label>
                    </br>
                    <label class="switch">
                       <input type="checkbox" id="onlineflag" name="onlineflag" class="form-control" <?php if($onlineflagvalue){ echo "checked";} ?>>
                       <div class="slider round"></div>
                    </label>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" value="<?php echo htmlspecialchars($location); ?>">
                </div>
                <div class="form-group">
                    <label for="activeflag">Active:</label>
                    </br>
                    <label class="switch">
                       <input type="checkbox" id="activeflag" name="activeflag" class="form-control" <?php if($activeflagvalue){ echo "checked";} ?>>
                       <div class="slider round"></div>
                    </label>
                </div>
                <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea class="form-control" id="description" name="description" rows="5" maxlength="140" placeholder="Enter opportunity description..."><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-success" name="submit" value="taskcreateupdate">Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      <?php include("includes/footer.php");?>
    </body>
</html>