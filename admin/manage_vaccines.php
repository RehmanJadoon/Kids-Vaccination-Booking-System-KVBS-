<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //including db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
//query to display vaccines data by ascending order
$sql = "SELECT * FROM vaccines ORDER BY id ASC";
$result = $connection->query($sql);

if(!$result){
    die("Invalid query:" . $connection->error);
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
        .book-status {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
        }
        .book-enabled {
            background-color: #28a745;
        }
        .book-disabled {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <!-- including sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Vaccines</h1>
                    <a href="add_vaccine.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Vaccine
                    </a>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- display vaccines data table -->
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Vaccine ID</th>
                                        <th>Disease</th>
                                        <th>Vaccine Name</th>
                                        <th>Brand</th>
                                        <th>Child Age Range</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['disease']) ?></td>
                                        <td><?= htmlspecialchars($row['vaccine_name']) ?></td>
                                        <td><?= htmlspecialchars($row['brand']) ?></td>
                                        <td><?= htmlspecialchars($row['age_range']) ?></td>
                                        <td>
                                            <span class="badge <?= $row['status'] == 'Available' ? 'bg-success' : 'bg-secondary' ?> status-badge">
                                                <?= $row['status'] ?>
                                            </span>
                                        </td>
                                        <td class="action-btns">
                                            <!-- edit vaccine -->
                                            <a href="edit_vaccine.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- delete vaccine -->
                                            <a href="delete_vaccine.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
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