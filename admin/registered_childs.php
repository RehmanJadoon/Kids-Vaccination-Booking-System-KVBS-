<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //including db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//query to display all kids by ascending order
$sql = "SELECT * FROM children ORDER BY id ASC";
$result = $connection->query($sql);

if(!$result){
    die("Invalid query: ". $connection->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <!-- including sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Registered Kids</h1>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- table to display registered kids -->
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Child ID</th>
                                        <th>Child Name</th>
                                        <th>Parent Name</th>
                                        <th>Parent ID</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Blood Group</th>
                                        <th>City</th>
                                        <th>Full Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    while($row = $result->fetch_assoc()): ?>
                                      <tr>
                                        <td><?= htmlspecialchars($row['id'])?></td>
                                        <td><?= htmlspecialchars($row['name'])?></td>
                                        <td><?= htmlspecialchars($row['parent_name'])?></td>
                                        <td><?= htmlspecialchars($row['user_id'])?></td>
                                        <td><?= htmlspecialchars($row['age'])?></td>
                                        <td><?= htmlspecialchars($row['gender'])?></td>
                                        <td><?= htmlspecialchars($row['blood_group'])?></td>
                                        <td><?= htmlspecialchars($row['city'])?></td>
                                        <td><?= htmlspecialchars($row['address'])?></td>
                                    </tr> 
                                    <?php endwhile;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>