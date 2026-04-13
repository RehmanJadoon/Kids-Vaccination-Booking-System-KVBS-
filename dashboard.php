<?php
session_start();
// Redirect if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
//including database connection file
require_once 'includes/db_connection.php';

$user_id = $_SESSION['user_id']; //storing the user session in var

$user_sql = "SELECT * FROM users WHERE id = '$user_id'"; //fetching user's details from users table
$user_result = $connection->query($user_sql);
$user_result->fetch_assoc();


$child_sql = "SELECT * FROM children WHERE user_id = '$user_id'"; //fetching child's details from db table
$child_result = $connection->query($child_sql); //executing query


$pending_bookings = "SELECT b.*, v.disease, c.name AS child_name 
                                FROM bookings b
                                JOIN vaccines v ON b.vaccine_id = v.id
                                JOIN children c ON b.child_id = c.id
                                WHERE c.user_id = '$user_id' AND b.status = 'Pending'"; //fetching data from different tables using JOIN method
$pending_result = $connection->query($pending_bookings);

$approved_bookings = "SELECT b.*, v.disease, c.name AS child_name 
                                 FROM bookings b
                                 JOIN vaccines v ON b.vaccine_id = v.id
                                 JOIN children c ON b.child_id = c.id
                                 WHERE c.user_id = '$user_id' AND b.status = 'Approved'"; //joining different tables to get data from different tables
$approved_result = $connection->query($approved_bookings);
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <style>
        :root {
            --primary-color: #148ba9;
            --secondary-color: #f8f9fa;
        }
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .badge-pending {
            background-color: #856404;
            color: #856404;
        }
        .badge-approved {
            background-color: #155724;
            color: #155724;
        }
        .badge-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }
        .nav-pills .nav-link {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    
    <div class="container-fluid mt-4">
        <div class="row">
            <!--including sidebar of dashboard  -->
            <?php include 'dashboard_sidebar.php'?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">User Dashboard</h1>
                </div>
                <div class="card dashboard-card">
                    <div class="card-header bg-white border-0">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <!--here it will show pending/ approved booking requests  -->
                        <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button">
                                    Pending Requests
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-approved-tab" data-bs-toggle="pill" data-bs-target="#pills-approved" type="button">
                                    Approved Visits
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-pending">
                                <?php if ($pending_result->num_rows > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Child</th>
                                                    <th>Disease</th>
                                                    <th>Date/Time</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($booking = $pending_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($booking['child_name']) ?></td>
                                                    <td><?= htmlspecialchars($booking['disease']) ?></td>
                                                    <td>
                                                        <?= date('M j, Y', strtotime($booking['preferred_date'])) ?><br>
                                                        <?= date('g:i A', strtotime($booking['preferred_time'])) ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pending text-dark">Pending</span>
                                                    </td>
                                                    <td>
                                                        <a href="edit_booking.php?id=<?= $booking['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="delete_booking.php?id=<?= $booking['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <!-- if there's no booking pending then it will show this -->
                                    <div class="text-center py-4">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5>No Pending Requests</h5>
                                        <p>You haven't made any vaccination requests yet.</p>
                                        <a href="book_vaccine.php" class="btn btn-primary">Book Now</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- showing approved booking requests -->
                            <div class="tab-pane fade" id="pills-approved">
                                <?php if ($approved_result->num_rows > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Child</th>
                                                    <th>Disease</th>
                                                    <th>Preferred Date/Time</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($booking = $approved_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($booking['child_name']) ?></td>
                                                    <td><?= htmlspecialchars($booking['disease']) ?></td>
                                                    <td>
                                                        <?= date('M j, Y', strtotime($booking['preferred_date'])) ?><br>
                                                        <?= date('g:i A', strtotime($booking['preferred_time'])) ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-approved">Approved</span>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                                        <h5>No Approved Visits</h5>
                                        <p>Your pending requests will appear here once approved.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                </main>
</body>
</html>