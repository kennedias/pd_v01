<?php
session_start();
include("includes/db_connector.php");
if(!$_SESSION["user"]){
  header("location:login.php");
  exit();
} else{
  $s_userid=$_SESSION["user"]["userid"];
}

if($_POST["submit"]=="profile"){
  $username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
  $nationality_code = $_POST["nationality"];
  $location = $_POST["location"];
  $birth = $_POST["birth"];
  $mobile = $_POST["mobile"];
  $picture = $_POST["picture"];
  $gender = $_POST["gender"];
  $password = $_POST["password"];

  $queryUpdateUser="UPDATE user SET username='$username', nationality_code='$nationality_code',email='$email', location='$location', birth='$birth', mobile='$mobile', gender='$gender' WHERE id=$s_userid";
  $resultUpdateUser =$connection->query($queryUpdateUser);
  
  if($resultUpdateUser->num_rows>0){
    echo '<h3>rows affected: $resultUpdate->num_rows</h3>';
  } 
}else{
  $querySelectUser = "SELECT username, nationality_code, location, email, birth, gender, mobile, picture FROM user where id='$s_userid'";  
  $resultSelectUser =$connection->query($querySelectUser);

  if($resultSelectUser->num_rows>0){
    while($row=$resultSelectUser->fetch_assoc()){
      $id=$row["id"];
      $username = $row["username"];
      $nationality_code = $row["nationality_code"];
      $location = $row["location"];
      $email = $row["email"];
      $birth = $row["birth"];
      $mobile = $row["mobile"];
      $picture = $row["picture"];
      $gender = $row["gender"];
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
    	        <h2><?php echo "$username"; ?> Skills</h2>
                <div class="control-group" id="fields">
                    
                    <div class="controls"> 
                        <form role="form" autocomplete="off">
                            <div class="entry input-group col-md-8">
                                <input type="text" class="form-control city" name="skill" id="skill"  placeholder="Type something" />
                            	<span class="input-group-btn">
                                    <button class="btn btn-success btn-add" type="button">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </span>
                            </div>
                        </form>
                    <br>
                    <small>Press <span class="glyphicon glyphicon-plus gs"></span> to add another skill.</small>
                    </div>
                </div>
            </div>
    	</div>
    </div>
      <?php include("includes/footer.php");?>
    </body>
</html>