<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //including db connection file
//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// query to count active workers
$worker_sql = "SELECT COUNT(*) as active_workers FROM workers WHERE status = 'active'";
$worker_result = $connection->query($worker_sql);
$worker = $worker_result->fetch_assoc();
$activeWorkersCount = $worker['active_workers'];

// query to count available vaccines
$vaccine_sql = "SELECT COUNT(*) as available_vaccines FROM vaccines WHERE status = 'available'";
$vaccine_result = $connection->query($vaccine_sql);
$vaccine = $vaccine_result->fetch_assoc();
$availableVaccinesCount = $vaccine['available_vaccines'];
//query to count pending booking requests
$booking_sql = "SELECT COUNT(*) as pending_bookings FROM bookings WHERE status = 'Pending'";
$booking_result = $connection->query($booking_sql);
$row_booking = $booking_result->fetch_assoc();
$pendingBookingsCount = $row_booking['pending_bookings'];
// query to count approved booking requests
$vaccinated_kids = "SELECT COUNT(*) as vaccinated_kids FROM bookings WHERE status = 'Approved' AND CONCAT(preferred_date, ' ', preferred_time) < NOW()";
$vaccinated_result = $connection->query($vaccinated_kids);
$vaccinated = $vaccinated_result->fetch_assoc();
$vaccinatedKidsCount = $vaccinated['vaccinated_kids'];
//displaying pending booking rquests info by joining tables
$pending_bookings = "SELECT 
          b.id,
          u.firstname AS parent_firstname,
          u.lastname AS parent_lastname,
          c.name AS child_name,
          v.disease,
          b.preferred_date,
          b.preferred_time,
          b.status,
          b.created_at
        FROM bookings b
        JOIN children c ON b.child_id = c.id
        JOIN users u ON c.user_id = u.id 
        JOIN vaccines v ON b.vaccine_id = v.id
        WHERE b.status = 'Pending'
        ORDER BY b.created_at DESC";

$booking_result = $connection->query($pending_bookings);
$fetch_bookings = mysqli_fetch_all($booking_result, MYSQLI_ASSOC);


$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        :root {
            --primary-color: #148ba9;
            --secondary-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
         .main-content {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- including sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Admin Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <!-- displaying number of pending bookings (card) -->
                                        <h6 class="card-title"> Pending Bookings </h6>
                                        <h2 class="mb-0"><?php echo $pendingBookingsCount; ?></h2>
                                    </div>
                                    <i class="fas fa-clock fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <!-- displaying number of vaccinated kids  -->
                                        <h6 class="card-title">Vaccinated Kids</h6>
                                        <h2 class="mb-0"><?php echo $vaccinatedKidsCount; ?></h2>
                                    </div>
                                    <i class="fas fa-child fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <!-- displaying number of active workers -->
                                        <h6 class="card-title">Active Workers</h6>
                                        <h2 class="mb-0"><?php echo $activeWorkersCount; ?></h2>
                                    </div>
                                    <i class="fas fa-user-nurse fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <!-- displying number of available vaccines -->
                                        <h6 class="card-title">Available Vaccines</h6>
                                        <h2 class="mb-0"><?php echo $availableVaccinesCount; ?></h2>
                                    </div>
                                    <i class="fas fa-syringe fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Booking Requests</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!--displaying recent/ pending booking requests  -->
                        <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Parent Name</th>
                                        <th>Child Name</th>
                                        <th>Disease</th>
                                        <th>Preferred Date & Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($fetch_bookings as $booking): ?>    
                                <tr>
                                        <td><?= htmlspecialchars($booking['id']) ?></td>
                                        <td><?= htmlspecialchars($booking['parent_firstname'] . ' ' . $booking['parent_lastname']) ?></td>
                                        <td><?= htmlspecialchars($booking['child_name']) ?></td>
                                        <td><?= htmlspecialchars($booking['disease']) ?></td>
                                        <td><?= date('d M Y', strtotime($booking['preferred_date'])) . " " . htmlspecialchars($booking['preferred_time'])?></td>
                                        <td><span class="badge badge-pending text-dark">Pending</span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="booking_requests.php" class="btn btn-link float-end">View All Bookings</a>
                    </div>
                </div>
<!-- adding new worker card -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                                <h5>Add New Worker</h5>
                                <p>Register vaccination workers to the system</p>
                                <a href="add_worker.php" class="btn btn-primary">Add Worker</a>
                            </div>
                        </div>
                    </div>
                    <!-- add new vaccine card -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-syringe fa-3x mb-3 text-success"></i>
                                <h5>Add New Vaccine</h5>
                                <p>Add vaccination details to the system</p>
                                <a href="add_vaccine.php" class="btn btn-success">Add Vaccine</a>
                            </div>
                        </div>
                    </div>
                    <!-- generate vaccination reports card -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-file-export fa-3x mb-3 text-info"></i>
                                <h5>Generate Reports</h5>
                                <p>Export vaccination data and statistics</p>
                                <a href="reports.php" class="btn btn-info">Generate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>
</html>