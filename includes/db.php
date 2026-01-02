<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost","root","","naimat_store");
if($conn->connect_error){
    die("Database Error");
}
?>
