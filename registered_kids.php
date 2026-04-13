<?php
session_start();
require_once 'includes/db_connection.php';
//redirect to login page
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
//fetching child's data from table
$child_sql = "SELECT * FROM children WHERE user_id = '$user_id' ORDER BY created_at ASC";
$child_result = $connection->query($child_sql);

if(!$child_result){
    die("Invalid query: " . $connection->error);
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
        .gender-badge {
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid mt-4">
        <div class="row">
            <?php include 'dashboard_sidebar.php'?>            
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Registered Kids</h1>
                    <a href="add_child.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Child
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Child ID</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Blood Group</th>
                                            <th>City</th>
                                            <th>Full Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- displaying child's info -->
                                        <?php while ($child = $child_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($child['id']) ?></td>
                                            <td><?= htmlspecialchars($child['name']) ?></td>
                                            <td><?= htmlspecialchars($child['age']) ?></td>
                                            <td>
                                                <span class="badge bg-info gender-badge">
                                                    <?= htmlspecialchars($child['gender']) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($child['blood_group'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($child['city']) ?></td>
                                            <td><?= htmlspecialchars($child['address']) ?></td>
                                            <td class="action-btns">
                                                <a href="edit_child.php?id=<?= $child['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="delete_child.php?id=<?= $child['id'] ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this child record?')">
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