<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //includign db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//query to display all registered users
$sql = "SELECT * FROM users";
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
                    <h1 class="h2">Registered Users</h1>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- table to display all registered users -->
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                      <tr>
                                        <td><?=$row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['firstname']) ?></td>
                                        <td><?= htmlspecialchars($row['lastname']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                        <td><?= htmlspecialchars($row['address']) ?></td>
                                        </tr>  
                                        <?php endwhile; ?>
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