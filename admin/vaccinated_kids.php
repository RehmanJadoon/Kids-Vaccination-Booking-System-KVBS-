<?php 
session_start(); //starting session
require_once '../includes/db_connection.php'; //including db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
//storing admin session in admin_id var and to check valid session of admin
$admin_id = $_SESSION['admin_id'];
$admin_check_sql = "SELECT id FROM admins WHERE id = $admin_id";
$admin_result = $connection->query($admin_check_sql);

if (!$admin_result) {
    $errorMessage = "Invalid query: " . $connection->error;
    header("Location: admin_login.php");
    exit;
}

if ($admin_result->num_rows === 0) {
    $errorMessage = "Invalid admin session:" . $connection->error;
    header("Location: admin_login.php");
    exit;
}
//query to display all vaccinated kids and joining different tables using JOIN
$vaccinated_kids = "SELECT 
          b.id,
          b.child_id,
          b.vaccine_id,
          b.preferred_date,
          b.preferred_time,
          b.status,
          b.created_at,
          b.admin_notes,
          u.firstname AS parent_firstname,
          u.lastname AS parent_lastname,
          c.name AS child_name,
          c.city AS child_city,
          v.disease,
          v.vaccine_name,
          f.comments
        FROM bookings b
        JOIN children c ON b.child_id = c.id
        JOIN users u ON c.user_id = u.id 
        JOIN vaccines v ON b.vaccine_id = v.id
        LEFT JOIN feedback f ON b.id = f.booking_id
        WHERE b.status = 'Approved'
        AND CONCAT(b.preferred_date, ' ', b.preferred_time) < NOW()
        ORDER BY b.preferred_date DESC, b.preferred_time DESC";

$vaccinated_result = $connection->query($vaccinated_kids);
$bookings = mysqli_fetch_all($vaccinated_result, MYSQLI_ASSOC);

$connection->close();
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
        .status-vaccinated {
            background-color: #D4EDDA;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Vaccinated Kids</h1>
                </div>
                <!-- displaying error/ success messges -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $errorMessage ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $successMessage ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- table to display vaccinated kids record -->
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Parent Name</th>
                                        <th>Child ID</th>
                                        <th>Child Name</th>
                                        <th>Disease</th>
                                        <th>Vaccine Name</th>
                                        <th>Vaccinated On</th>
                                        <th>Area</th>
                                        <th>Status</th>
                                        <th>User's Comment</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($bookings as $booking):?>        
                                <tr>
                                            <td><?= htmlspecialchars($booking['id'])?></td>
                                            <td><?= htmlspecialchars($booking['parent_firstname']) . ' ' . htmlspecialchars($booking['parent_lastname'])?></td>
                                            <td><?= htmlspecialchars($booking['child_id'])?></td>
                                            <td><?= htmlspecialchars($booking['child_name'])?></td>
                                            <td><?= htmlspecialchars($booking['disease'])?></td>
                                            <td><?= htmlspecialchars($booking['vaccine_name'])?></td>
                                            <td><?= date('d M Y', strtotime($booking['preferred_date'])) . " " . htmlspecialchars($booking['preferred_time'])?></td>
                                            <td><?= htmlspecialchars($booking['child_city']) ?></td>
                                            <td> <span class="status-badge status-vaccinated">VACCINATED</td>
                                            <td><?php if (!empty($booking['comments'])): ?>
                                                            <?= htmlspecialchars($booking['comments']) ?>
                                                    <?php else: ?>
                                                        No comment
                                                    <?php endif; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</body>

</html>