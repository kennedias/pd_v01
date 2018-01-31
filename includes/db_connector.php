<?php
// connecting to a database
$host = "localhost";
// name of the database to connect to
$database = "puzzle";
// mysql username to use to access the database
$user = "kennedias";
// database password for the username
$password = "";
//make the connection
$connection = mysqli_connect($host,$user,$password,$database);
//check if there is an error
if(!$connection){
    echo "there has been an error ".mysqli_connect_error();
}
else{
  //  echo "connected!";
}

?>