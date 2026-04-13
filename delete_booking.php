<?php
session_start(); //starting session

if(isset($_GET['id'])){
    $booking_id = $_GET['id'];

require_once 'includes/db_connection.php';

//if user is not logged in then redirect to login.php page
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
//delete entry when click on specific id
$sql = "DELETE FROM bookings WHERE id = '$booking_id'";
$connection->query($sql);
}
header("Location: /kidsvacc/dashboard.php");
exit;
?>
