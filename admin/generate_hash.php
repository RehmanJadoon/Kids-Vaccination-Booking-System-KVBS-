<?php
$plain_password = "Admin@123"; 
echo password_hash($plain_password, PASSWORD_BCRYPT); //it'll convert the plain password to hash i.e. abc333ebce34der
?>