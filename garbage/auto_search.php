<?php

    include("includes/db_connector.php");
    
    echo "<p>Search</p>";
    
    //connect with the database
    $db = $connection;
    
    //get search term
    $searchTerm = $_GET['term'];
    print_r($_GET); 

    
    //get matched data from skills table
    $query = $db->query("SELECT * FROM skills WHERE s_description LIKE '%".$searchTerm."%' ");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['skill'];
    }
    
    //return json data
    echo json_encode($data);
?>