<?php
session_start();
require_once 'includes/db_connection.php';
//redirect to login if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
//joining tables to display bookings 
$sql = "SELECT 
          b.id,
          c.id AS child_id,
          c.name AS child_name,
          v.disease,
          b.preferred_date,
          b.preferred_time,
          b.status,
          b.created_at,
          b.admin_notes
        FROM bookings b
        JOIN children c ON b.child_id = c.id
        JOIN vaccines v ON b.vaccine_id = v.id
        WHERE c.user_id = $user_id
        ORDER BY b.preferred_date ASC";
$result = $connection->query($sql);
if (!$result) {
    die("Invalid query:" . $connection->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-approved {
            background-color: #D4EDDA;
            color: #155724;
        }

        .status-rejected {
            background-color: #F8D7DA;
            color: #721C24;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <?php include 'dashboard_sidebar.php' ?>
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Vaccination Booking Requests</h1>
                        <a href="book_vaccine.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Booking
                        </a>
                    </div>


                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Child ID</th>
                                            <th>Child</th>
                                            <th>Disease</th>
                                            <th>Preferred Date</th>
                                            <th>Preferred Time</th>
                                            <th>Status</th>
                                            <th>Request Date</th>
                                            <th>Admin Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- didplaying bookings data -->
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= $row['child_id'] ?></td>
                                                <td><?= $row['child_name'] ?></td>
                                                <td><?= $row['disease'] ?></td>
                                                <td><?= date('d M Y', strtotime($row['preferred_date'])) ?></td>
                                                <td><?= $row['preferred_time'] ?></td>
                                                <td>
                                                    <span class="status-badge status-<?= strtolower($row['status']) ?>">
                                                        <?= $row['status'] ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
                                                <td>
                                                    <?php if ($row['status'] == 'Rejected' && !empty($row['admin_notes'])): ?>
                                                        <div class="admin-notes" data-bs-toggle="tooltip" title="<?= $row['admin_notes'] ?>">
                                                            <i class="fas fa-comment-alt text-danger"></i>
                                                            <span class="d-none d-md-inline"><?= htmlspecialchars(substr($row['admin_notes'], 0, 20)) ?><?= strlen($row['admin_notes']) > 20 ? '...' : '' ?></span>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <?php if ($result->num_rows == 0): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted">
                                                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                                    <h5>No bookings found</h5>
                                                    <p class="mb-0">You haven't made any vaccination bookings yet.</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </main>
</body>

</html>