<?php
session_start(); //starting session

if(isset($_GET['id'])){
    $id = $_GET['id'];
//including db connection file
require_once '../includes/db_connection.php';

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
//delete the specific vaccine
$sql = "DELETE FROM vaccines WHERE id = $id";
$connection->query($sql);
}
header("Location: manage_vaccines.php");
exit;
?>