<?php
session_start();
if(isset($_GET['id'])){
    $id = $_GET['id'];

require_once 'includes/db_connection.php';

//if user is not logged in then redirect to login.php page
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
//delete child's entry when click on child's id 
$sql = "DELETE FROM children WHERE id = $id";
$connection->query($sql);
}
header("Location: /kidsvacc/registered_kids.php");
exit;
?>