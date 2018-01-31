<?php
session_start();
include("includes/db_connector.php");
if(!$_SESSION["puzzleSession"]){
	header("location:index.php");
	exit();
} else{
	$s_userid=$_SESSION["puzzleSession"]["userid"];
	
	$querySelectUser = "SELECT `name`, `username`, `email`, `datebirth`, `country`, `city`, `postalcode`, `gender`, `picture`, `usertime` FROM `userdetails` WHERE userID='$s_userid'";  
	$resultSelectUser =$connection->query($querySelectUser);
	
	if($resultSelectUser->num_rows>0){
	  while($row=$resultSelectUser->fetch_assoc()){
	    $name = $row["name"];
	    $username = $row["username"];
	    $email = $row["email"];
	    $datebirth = $row["datebirth"];
	    $country = $row["country"];
	    $city = $row["city"];
	    $postalcode = $row["postalcode"];
	    $gender = $row["gender"];
	    $picture = $row["picture"];
	  }
	} 
}

if($_POST["submit"]=="profile"){
	
  $name = filter_var($_POST["name"],FILTER_SANITIZE_STRING);
  $username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
  $country = $_POST["country"];
  $city = $_POST["city"];
  $datebirth = $_POST["datebirth"];
  $picture = $_POST["picture"];
  $gender = $_POST["gender"];
  $password = $_POST["password"];

  //---------handle image upload for profile picture
  //set directory where image will be stored
  $profile_image_dir = "img_profile";
  
  if($_FILES["profile_image_upload"]["name"]){
    $imageerrors = array();
    //get the name of the file
    $file = $_FILES["profile_image_upload"]["name"];
    //get name only without extension
    $filename = pathinfo($file,PATHINFO_FILENAME);
    //get the file extension
    $filextension = pathinfo($file,PATHINFO_EXTENSION);
    //check the file extension, only allow png,jpg,jpeg and gif
    if(strtolower($filextension)!="png"
    && strtolower($filextension)!="jpg"
    && strtolower($filextension)!="jpeg"
    && strtolower($filextension)!="png")
    {
      $errors["image_type"] = "only jpg,jpeg,png or gif allowed";
    }
    //create a unique name for the image and append the extension
    $newfilename = strtolower($filename).uniqid().".".$filextension;
    //rename the file
    $_FILES["profile_image_upload"]["name"] = $newfilename;
    //check file size against limit of 1MB
    if($_FILES["profile_image_upload"]["size"]>20000000){
      $errors["image_size"] = "2MB limit exceeded";
    }
    //check if file is an image
    if(!getimagesize($_FILES["profile_image_upload"]["tmp_name"])){
      $errors["image_file"] = "file is not an image"; 
    }
    
    echo $errors;
    //check if there are no errors
    if(!count($errors)>0){
      echo "<p>File : $newfilename</p>";
      //move image to profile dir
      move_uploaded_file($_FILES["profile_image_upload"]["tmp_name"], $profile_image_dir."/".$newfilename);
      //add imagename to update query
      //$updatequery = $updatequery.",profile_image='$newfilename'";
      echo "moved";
      
    }
    else{
      print_r($errors);
    }
  }
  
  $queryUpdateUser="UPDATE userdetails SET name='$name', username='$username', 
  country='$country', email='$email', 
  city='$city', datebirth='$datebirth', gender='$gender'";
  
  if ($newfilename != nul && !empty($newfilename)){
    $queryUpdateUser.=", picture='$newfilename'";
  }
  $queryUpdateUser.=" WHERE userid=$s_userid";
  $resultUpdateUser =$connection->query($queryUpdateUser);
  
}


?>

<!doctype html>
<html lang="en">
  <?php include("includes/head.php");?>
  <body>
      <div class="container0">
      	<header>
          <?php include("includes/navigation.php");?>
        </header>
        <div class="container1">
		<div class="container">
			<h3> Profile</h3>
			<form action="profile.php" method="post">
				<div class="row">
                            		<div class="col-sm-6">
				<!--			<form action="profile.php" method="post">  -->
						<input type="radio" name="gender" <?php if (isset($gender) && $gender=="F") echo "checked";?> value="F">Sheila
						<input type="radio" name="gender" <?php if (isset($gender) && $gender=="M") echo "checked";?> value="M">Bloke
						<br><br>
						Name<br>
						<input style="width:80%;" name="name" type="text" maxlength="64" value="<?php echo htmlspecialchars($name); ?>" 
						placeholder="... Your name"><br><br>
						User name<br>
						<input style="width:80%;" name="username" type="text" maxlength="64" value="<?php echo htmlspecialchars($username); ?>" 
						placeholder="... Think about nickname that gives a clue about yourself"><br><br>
						Date of birth
						<input style="width:40%;" name="datebirth" type="date" value="<?php echo htmlspecialchars($datebirth); ?>"><br><br>
						<div class="country">
							<div class="country1">
								<fieldset class="well">
									<legend class="well-legend">Selecting Country</legend>
									<select>
										<option value=" " selected>Select</option>
										<option value="Australia">Australia</option>
									</select>
								</fieldset>
							</div>
							<div class="city">
								<fieldset class="well" >
									<legend class="well-legend" >Enter your city</legend>
									<input name="city" type="text" maxlength="40" size="45" value="<?php echo htmlspecialchars($city); ?>">
								</fieldset>
							</div>
						</div>
				<!--	</form> -->
				</div>
						<div class="col-sm-6">
							<img src="images/avatar.jpg" alt="error" style="width:20%; height:20%; border:1px solid; box-sizing:border-box; float:right; margin-right:50px; margin-top:15px; padding:5px;" >
							<div class="emailBox">
							<!--	<form action="mailto:5796@ait.nsw.edu.au" method="post"> -->
									<br>
									Email<br>
									<input style="width:80%;" name="email" type="text" maxlength="64" placeholder="... Email" value="<?php echo htmlspecialchars($email); ?>"><br><br>
									Confirm email<br>
									<input style="width:80%;" name="confirmemail" type="text" maxlength="64" placeholder="... Confirm email"><br><br>
									<br><br>
									<div class="passwordBox">
										<div class="passwordBox1">
											Password<br>
											<input name="password" type="password" maxlength="20" >
										</div>
										<div class="passwordBox2">
											Confirm password<br>
											<input name="confirmpassword" type="password" maxlength="20" >
										</div>
									</div>	
						<!--		</form> -->
							</div>
						</div>
                        </div>
				        <div class="row  bodyBelow">
                            <div class="col ">
                            	<button type="submit" value="profile" name="submit" class="btn btn-primary btn-sm">Update</button>
                            	<button type="button" class="btn btn-success btn-sm">About Yourself</button>
                            	<button type="button" class="btn btn-warning btn-sm">Album</button>
                            	<br><p></p>
                              <!--  <ul>
                                    <li><a href="Update.html " style="background-color:#b6d7a8"> Update</a> </li> 
                              			<li><a href=" " style="background-color:#9fc5f8"> About Yourself</a> </li>
                                    	<li><a href=" " style="background-color:#f9cb9c"> Album</a> </li>
                               
                               
                               		<li><button type="submit" value="profile" name="submit"/>Update</button></li>
                                    <li><button type="submit" value="profile" name="submit"/>About Yourself</button></li>
                                    <li><button type="submit" value="profile" name="submit"/>Album</button></li>
                                    
                                </ul> -->
                            </div>
                        </div>
                        </form>
					</div>
				</div>
        <footer>
			<?php include("includes/footer.php");?>
		</footer>
      </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"> </script>
  </body>
</html>
