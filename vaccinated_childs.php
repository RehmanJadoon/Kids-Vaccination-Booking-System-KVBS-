<?php
session_start();
require_once 'includes/db_connection.php';
//redirect if user is not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
//storing user session in $user_id var
$user_id = $_SESSION['user_id'];
//joining different tables to get vaccinated kids data
$vaccinated_childs = "SELECT 
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
        AND c.user_id = '$user_id'
        AND CONCAT(b.preferred_date, ' ', b.preferred_time) < NOW()
        ORDER BY b.preferred_date DESC, b.preferred_time DESC";

$vaccinated_childs_result = $connection->query($vaccinated_childs);
if (!$vaccinated_childs_result) {
    die("Invalid query: " . $connection->connect_error);
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

        .status-vaccinated {
            background-color: #D4EDDA;
            color: #155724;
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
                        <h1 class="h2">Vaccinated Kids Record</h1>
                    </div>


                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Parent Name</th>
                                            <th>Child ID</th>
                                            <th>Child Name</th>
                                            <th>Disease</th>
                                            <th>Vaccine Name</th>
                                            <th>Vaccinated On</th>
                                            <th>Status</th>
                                            <th>Vaccination Certificate</th>
                                            <th>Feedback</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- displaying vaccinated kids record -->
                                        <?php while ($booking = $vaccinated_childs_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $booking['id'] ?></td>
                                                <td><?= $booking['parent_firstname'] . ' ' . $booking['parent_lastname'] ?></td>
                                                <td><?= $booking['child_id'] ?></td>
                                                <td><?= $booking['child_name'] ?></td>
                                                <td><?= $booking['disease'] ?></td>
                                                <td><?= $booking['vaccine_name'] ?></td>
                                                <td><?= date('d M Y', strtotime($booking['preferred_date'])) ?></td>
                                                <td> <span class="status-badge status-vaccinated">VACCINATED</td>
                                                <td><a href="generate_cert.php?booking_id=<?= $booking['id'] ?>" class="btn btn-sm btn-success" title="Download Vaccination Certificate">
                                                        <i class="fas fa-file-pdf"></i> Download
                                                    </a></td>
                                                <td><?php if (!empty($booking['comments'])): ?>
                                                        <span class="badge bg-info text-dark p-2">
                                                            <a href="feedback.php?booking_id=<?= $booking['id'] ?>" class="text-dark text-decoration-none">
                                                            <i class="fas fa-comment"></i>    
                                                            <?= htmlspecialchars(substr($booking['comments'], 0, 30)) ?>
                                                            </a>
                                                        </span>
                                                    <?php else: ?>
                                                        <a href="feedback.php?booking_id=<?= $booking['id'] ?>"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-plus"></i> Give Feedback
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </main>
    <?php $connection->close(); ?>
</body>

</html>