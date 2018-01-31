<?php
session_start();
include("includes/db_connector.php");
if(!$_SESSION["user"]){
  header("location:index.php");
  exit();
} else{
  $s_userid=$_SESSION["user"]["userid"];
}

$userid_consult= filter_var($_GET["userid_consult"],FILTER_SANITIZE_STRING);

if ($userid_consult == null || empty($userid_consult)){
    $userid_consult = filter_var($_POST["userid_consult"],FILTER_SANITIZE_STRING);
}

$querySelectUser = "SELECT a.username, b.nationality, a.location, a.email, a.gender, a.picture FROM user a, nationality b where a.nationality_code=b.id AND a.id='$userid_consult'";  
$resultSelectUser =$connection->query($querySelectUser);

if($resultSelectUser->num_rows>0){
  while($row=$resultSelectUser->fetch_assoc()){
    $username = $row["username"];
    $nationality = $row["nationality"];
    $location = $row["location"];
    $email = $row["email"];
    $picture = $row["picture"];
    $gender = $row["gender"];
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
            <h2><?php echo "$username"; ?> Profile</h2>
            <form action="profile_consult.php" method="post"  enctype="multipart/form-data">
              <div class="form-group">
                <div class="profile-image-container">
                   <article class='search-result row'>
                     <a href='#' title='profileimage' class='thumbnail'><img src='img_profile/<?php echo htmlspecialchars($picture); ?>' alt='' /></a>
                   </article>   
                </div>
              </div>
              <div class="form-group">
                <label for='username'>Name: <?php echo htmlspecialchars($username); ?></label> 
              </div>
              <div class="form-group">
                <label class="control-label">Gender: <?php if($gender=="F"){echo "Female";}else{echo "Male";} ?></label>
              </div>  
              <div class="form-group">
                <label class="control-label">Nationality: <?php echo htmlspecialchars($nationality); ?></label>
              </div>
              <div class="form-group">
                <label for="location">Location: <?php echo htmlspecialchars($location); ?></label>
              </div>
              <div class="form-group">
                <label for="email">Email: <?php echo htmlspecialchars($email); ?></label>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php include("includes/footer.php");?>
    </body>
</html>