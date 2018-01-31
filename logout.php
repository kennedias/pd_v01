<?php
    session_start();
    unset($_SESSION["puzzleSession"]);
    header('Location: index.php');

?>