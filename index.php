<?php

include("includes/db_connector.php");
$errors=array();

if($_POST["submit"]=="join"){

  $name = $_POST["name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $confirmEmail = $_POST["confirmEmail"];
  $datebirth = $_POST["datebirth"];
  $password = $_POST["password"];  
  $passwordConfirmation = $_POST["passwordConfirmation"]; 

  echo strlen($username);
  echo strlen(trim($username," "));
  
  $name = filter_var($name,FILTER_SANITIZE_STRING);
  $username = filter_var($username,FILTER_SANITIZE_STRING);
  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
  }
  else{
    $errors["email"] = "invalid email";
  }
  
  if(filter_var($confirmEmail,FILTER_VALIDATE_EMAIL)){
    $confirmEmail = filter_var($confirmEmail,FILTER_SANITIZE_EMAIL);
  }
  else{
    $errors["email"] = "invalid email";
  }  
  
  if($email != $confirmEmail){
      $errors["emailConfirmation"] = "invalid email confirmation";
  }

  if(count($errors)>0){
 //   echo "There are errors" .$errors["username"]. "and" .$errors["email"];
 //   exit();
  }
  $hash = password_hash($password,PASSWORD_DEFAULT);
  
  $query = "INSERT INTO userdetails (name,username,email,datebirth,password) VALUES('$name','$username','$email','$datebirth','$hash')";
  if($connection->query($query)){
    $last_id = $connection->insert_id;
    session_start();
    $_SESSION["puzzleSession"]=array("username"=>$username,"email"=>$email,"userid"=>$last_id);
    header('Location: profile.php');
  }
  else{
    echo "whoops, something is wrong";
  }
}


if($_POST["submit"]=="login"){
    
  $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
  $password = $_POST["password"];
  $query = "SELECT * FROM userdetails WHERE email='$email'";
  $result = $connection->query($query);

  if($result->num_rows>0){
    $row = $result->fetch_assoc();
    $stored_password = $row["password"];
    $username = $row["username"];
    $userid = $row["userID"];

    if(password_verify($password,$stored_password)){
        session_start();
        $_SESSION["puzzleSession"]=array("username"=>$username,"email"=>$email,"userid"=>$userid);
        header('Location: profile.php');
    }
    else{
      echo "<p>email or password does not match our records</p>";
    }
  }
}

?>
<!doctype html>
<html lang="en">
      <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="ICON" type="image/x-icon" href='images/logo_Title.ICO' />
    <link rel="stylesheet" type="text/css" href="myCss/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="myCss/myStyle.css">
  </head>	
	<body>
		<div class="container0">
			<header>
        <?php include("includes/navigation.php");?>
      </header>
      <form method="post" action="index.php">
        <div class="container1">
            <div class="container">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <h2>About you</h2>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 field-label-responsive">
                            <label for="name">Name</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="... Your name" required autofocus>
                                    <input type="text" name="username" class="form-control" id="username"
                                           placeholder="... Your nick name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-control-feedback">
                                    <span class="text-danger align-middle">
                                        <!-- Put name validation error messages here -->
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 field-label-responsive">
                            <label for="email">E-Mail Address</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                                    <input type="text" name="email" class="form-control" id="email"
                                           placeholder="you@example.com" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-control-feedback">
                                    <span class="text-danger align-middle">
                                        <!-- Put e-mail validation error messages here -->
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 field-label-responsive">
                            <label for="email">Confirm E-Mail Address</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                                    <input type="text" name="confirmEmail" class="form-control" id="confirmEmail"
                                           placeholder="you@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-control-feedback">
                                    <span class="text-danger align-middle">
                                        <!-- Put e-mail validation error messages here -->
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 field-label-responsive">
                            <label for="birth">Date of Birth</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-birthday-cake" aria-hidden="true"></i></div>
                                    <input type="date" name="datebirth" class="form-control" id="datebirth"  max="1950-12-31" min="2000-01-01"
                                           placeholder="Date of Birth">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-control-feedback">
                                    <span class="text-danger align-middle">
                                        <!-- Put e-mail validation error messages here -->
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 field-label-responsive">
                            <label for="password">Password</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-danger">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="Password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 field-label-responsive">
                            <label for="password">Confirm Password</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon" style="width: 2.6rem">
                                        <i class="fa fa-repeat"></i>
                                    </div>
                                    <input type="password" name="passwordConfirmation" class="form-control"
                                           id="passwordConfirmation" placeholder="Password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: center; margin-bottom: 5px;">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <!--<a href="#" style="color:lightblue;text-decoration:none; font-size:18pt;"><i class="fa fa-user-plus"></i> Join</a> -->
                            <button type="submit" value="join" name="submit"/><i class="fa fa-user-plus"></i> Join </button>
                        </div>
                    </div>
            </div>
        </div>
      </form>
      <footer>
        <?php include("includes/footer.php");?>
      </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"> </script>    
  </body>
</html>