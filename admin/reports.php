<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //including db connectin file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//storing the admin session in admin_id var & to check admin valid session or not
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
//query to get data of vaccinated kids & more details by joining different tables
$base_query = "SELECT 
          b.id,
          b.child_id,
          b.vaccine_id,
          b.preferred_date,
          b.preferred_time,
          b.status,
          b.worker_id,
          b.created_at,
          b.admin_notes,
          u.firstname AS parent_firstname,
          u.lastname AS parent_lastname,
          c.name AS child_name,
          c.city AS child_city,
          v.disease,
          v.vaccine_name,
          w.full_name AS worker_name
        FROM bookings b
        JOIN children c ON b.child_id = c.id
        JOIN users u ON c.user_id = u.id 
        JOIN vaccines v ON b.vaccine_id = v.id
        LEFT JOIN workers w ON b.worker_id = w.id
        WHERE b.status = 'Approved'
        AND CONCAT(b.preferred_date, ' ', b.preferred_time) < NOW()";
//conditions to search vaccinated kids by using different filters
if (!empty($_GET['vaccine_filter'])) {
   $vaccine_id = $connection->real_escape_string($_GET['vaccine_filter']);
   $base_query .= " AND b.vaccine_id = '$vaccine_id'";
}

if (!empty($_GET['area_filter'])) {
    $area_id = $connection->real_escape_string($_GET['area_filter']);
    $base_query .= " AND c.city = '$area_id'";
}

if (!empty($_GET['from_date'])) {
    $from_date = $connection->real_escape_string($_GET['from_date']);
    $base_query .= " AND b.preferred_date >= '$from_date'";
}
if (!empty($_GET['to_date'])) {
    $to_date = $connection->real_escape_string($_GET['to_date']);
    $base_query .= " AND b.preferred_date <= '$to_date'";
}

$base_query .= " ORDER BY b.preferred_date DESC, b.preferred_time DESC";

$vaccinated_result = $connection->query($base_query);
$bookings = mysqli_fetch_all($vaccinated_result, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .action-btns .btn {
            margin-right: 5px;
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
                    <div class="card-header">
                        <h1 class="h2"> Filter Vaccination Records</h1>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="" class="row g-3">
                            <div class="col-md-3">
                                <!-- serach vaccinated kids by specific vaccine name -->
                                <label class="form-label">Vaccine Type</label>
                                <select name="vaccine_filter" class="form-select">
                                    <option value="">All Vaccines</option>
                                    <?php
                                    $vaccines_sql = "SELECT id, vaccine_name FROM vaccines";
                                    $vaccines_result = $connection->query($vaccines_sql);
                                    while ($vaccine = $vaccines_result->fetch_assoc()) {
                                        $selected = ($_GET['vaccine_filter'] ?? '') == $vaccine['id'] ? 'selected' : '';
                                        echo "<option value='{$vaccine['id']}' $selected>{$vaccine['vaccine_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <!-- search vaccinated kids by specific area -->
                                <label class="form-label">Area/City</label>
                                <select name="area_filter" class="form-select">
                                    <option value="">All Areas</option>
                                    <?php
                                    $areas_sql = "SELECT DISTINCT city FROM children ORDER BY city";
                                    $areas_result = $connection->query($areas_sql);
                                    while ($area = $areas_result->fetch_assoc()) {
                                        $selected = ($_GET['area_filter'] ?? '') == $area['city'] ? 'selected' : '';
                                        echo "<option value='{$area['city']}' $selected>{$area['city']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <!-- search vaccinated kids by date -->
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control" value="<?= $_GET['from_date'] ?? '' ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control" value="<?= $_GET['to_date'] ?? '' ?>">
                            </div>

                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Apply Filters
                                </button>
                                <a href="reports.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <!-- this will show the number of records -->
                            <strong>Showing <?= count($bookings) ?> vaccinated records</strong>
                            <?php if (!empty($_GET)): ?>
                                | <a href="reports.php" class="alert-link">Clear all filters</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card shadow-sm">
                        <div class="card-body p-0"> 
                            <!-- table of displaying recrods -->
                        <?php if (count($bookings) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Parent Name</th>
                                            <th>Child Name</th>
                                            <th>Vaccine</th>
                                            <th>Disease</th>
                                            <th>Vaccinated On</th>
                                            <th>Area</th>
                                            <th>Vaccinated by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($booking['id']) ?></td>
                                                <td><?= htmlspecialchars($booking['parent_firstname'] . ' ' . $booking['parent_lastname']) ?></td>
                                                <td><?= htmlspecialchars($booking['child_name']) ?></td>
                                                <td><?= htmlspecialchars($booking['vaccine_name']) ?></td>
                                                <td><?= htmlspecialchars($booking['disease']) ?></td>
                                                <td>
                                                    <?= date('d M Y', strtotime($booking['preferred_date'])) ?><br>
                                                    <small class="text-muted"><?= htmlspecialchars($booking['preferred_time']) ?></small>
                                                </td>
                                                <td><?= htmlspecialchars($booking['child_city']) ?></td>
                                                <td><?php if($booking['worker_name']): ?>
                                            <?= htmlspecialchars($booking['worker_name']) ?>
                                            <?php else: ?>
                                            <small class="text-muted">Not assigned</small>
                                            <?php endif; ?>
                                        </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h4>No Vaccination Records Found</h4>
                            </div>
                        <?php endif; ?>
                        </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<?php $connection->close(); ?>
</body>

</html>