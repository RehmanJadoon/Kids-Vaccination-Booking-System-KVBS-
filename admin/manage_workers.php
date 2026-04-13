<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //including db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//query to display all workers by ascending order 
$sql = "SELECT * FROM workers ORDER BY id ASC";
$result = $connection->query($sql);

if(!$result){
    die("Invalid query: ". $connection->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .status-badge {
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <!-- including sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Workers</h1>
                    <a href="add_worker.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Worker
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- table to display workers data -->
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Specialization</th>
                                        <th>Availability</th>
                                        <th>Fee</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): 
                                        $status_badge = ($row['status'] == 'Active') ? 'bg-success' : 'bg-secondary';
                                        ?>
                                        <tr>
                                        <td><?=$row['id']?></td>
                                        <td>
                                            <strong><?=$row['full_name']?></strong><br>
                                            <small class="text-muted"><?=$row['gender']?></small>
                                        </td>
                                        <td>
                                            <?=$row['email']?><br>
                                            <?=$row['phone']?>
                                        </td>
                                        <td><?=$row['address']?></td>
                                        <td><?=$row['specialization']?></td>
                                        <td><?=$row['available_time']?></td>
                                        <td>PKR <?=$row['appointment_fee']?></td>
                                        <td>
                                            <span class="badge <?=$status_badge?>  status-badge">
                                                <?=$row['status']?>
                                            </span>
                                        </td    >
                                        <td class="action-btns">
                                            <!-- edit worker -->
                                            <a href="edit_worker.php?id=<?=$row['id']?>" class="btn btn-sm btn-outline-primary">
                                                <i class='fas fa-edit'></i> 
                                            </a>
                                            <!-- delete worker -->
                                            <a href="delete_worker.php?id=<?=$row['id']?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> 
                                            </a>
                                        </td>
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