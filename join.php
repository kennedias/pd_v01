<?php

include("includes/db_connector.php");

$errors=array();
if($_POST["submit"]=="join"){
  $username = $_POST["username"];

  echo strlen($username);
  echo strlen(trim($username," "));
  $email = $_POST["email"];
  $password = $_POST["password"];
  $username = filter_var($username,FILTER_SANITIZE_STRING);
  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
  }
  else{
    $errors["email"] = "invalid email";
  }

  if(count($errors)>0){
    echo "There are errors" .$errors["username"]. "and" .$errors["email"];
    exit();
  }
  $hash = password_hash($password,PASSWORD_DEFAULT);
  $query = "INSERT INTO user (username,email,password) VALUES('$username','$email','$hash')";
  if($connection->query($query)){
    $last_id = $connection->insert_id;
    session_start();
    $_SESSION["user"]=array("username"=>$username,"email"=>$email,"userid"=>$last_id);
    header('Location: profile.php');
  }
  else{
    echo "whoops, something is wrong";
  }
  
}
?>
<html>
    <?php include("includes/head.php");?>
    <body>
    <?php include("includes/navigation.php");?>
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
              <h2>Join</h2>
              <form action="join.php" method="post">
                  <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="username" class="form-control" placeholder="user name">
                  </div>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="you@domain.com">
                  </div>
                  <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control" placeholder="password">
                  </div>
                  <div class="text-right">
                      <button class="btn btn-success" name="submit" type="submit" value="join">Join</button>
                  </div>
              </form>
            </div>
          </div>
      </div>
      <?php include("includes/footer.php");?>
    </body>
  </body>
</html>