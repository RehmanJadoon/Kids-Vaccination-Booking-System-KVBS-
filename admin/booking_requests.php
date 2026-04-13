<?php
session_start(); //starting session
require_once '../includes/db_connection.php'; //including db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//declaring empty var's for error/ success messages
$errorMessage = $successMessage = '';

$admin_id = $_SESSION['admin_id']; //storing admin session in var
$admin_check_sql = "SELECT id FROM admins WHERE id = $admin_id"; //checking valid admin session
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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    $admin_notes = $_POST['admin_notes'] ?? '';
//booking requests feedback
    if ($action == 'approve') {
        $status = 'Approved';
    } else if ($action == 'reject') {
        $status = 'Rejected';
    } else {
        $errorMessage = "Invalid session";
        header("Location: booking_requests.php");
        exit;
    }
//updating the booking status after feedback
    $update_sql = "UPDATE bookings SET status = '$status', admin_notes = '$admin_notes', updated_at = NOW() WHERE id = $booking_id";
    $update_result = $connection->query($update_sql);
//displaying success/ error messages
    if ($update_result) {
        $successMessage = "Booking #$booking_id has been $status";
    } else {
        $errorMessage = "Error updating booking: " . $connection->error;
    }
}
//displaying booking requests by joining tables
$sql = "SELECT 
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
          c.address AS child_address,
          v.disease,
          v.vaccine_name,
          w.full_name AS worker_name
        FROM bookings b
        JOIN children c ON b.child_id = c.id
        JOIN users u ON c.user_id = u.id 
        JOIN vaccines v ON b.vaccine_id = v.id
        LEFT JOIN workers w ON b.worker_id = w.id
        ORDER BY b.created_at DESC";

$result = $connection->query($sql);
$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
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

        .action-btns .btn {
            margin-right: 5px;
        }

        .notes-textarea {
            width: 100%;
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
                    <h1 class="h2">Booking Requests</h1>
                </div>
<!-- displaying error/ success messages -->
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
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                    <!--displaying booking request table  -->
                                <tr>
                                        <th>Booking ID</th>
                                        <th>Parent Name</th>
                                        <th>Child ID</th>
                                        <th>Child Name</th>
                                        <th>Disease</th>
                                        <th>Preferred Date & Time</th>
                                        <th>Child Address</th>
                                        <th>Request Date</th>
                                        <th>HC Worker</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($booking['id']) ?></td>
                                            <td><?= htmlspecialchars($booking['parent_firstname'] . ' ' . $booking['parent_lastname']) ?></td>
                                            <td><?= htmlspecialchars($booking['child_id']) ?></td>
                                            <td><?= htmlspecialchars($booking['child_name']) ?></td>
                                            <td><?= htmlspecialchars($booking['disease']) ?></td>
                                            <td><?= date('d M Y', strtotime($booking['preferred_date'])) . " " . htmlspecialchars($booking['preferred_time'])?></td>
                                            <td><small class="text-muted"><?= htmlspecialchars($booking['child_address']) ?></small></td>
                                            <td><small class="text-muted"><?= date('d M Y H:i', strtotime($booking['created_at'])) ?></small></td>
                                            <td><?php if($booking['worker_name']): ?>
                                            <?= htmlspecialchars($booking['worker_name']) ?>
                                            <?php else: ?>
                                            <small class="text-muted">Not assigned</small>
                                            <?php endif; ?>
                                        </td>
                                            <td>
                                                <span class="status-badge status-<?= strtolower($booking['status']) ?>">
                                                    <?= $booking['status'] ?>
                                                </span>
                                            </td>
                                            <td class="action-btns">
                                                <?php if ($booking['status'] == 'Pending'): ?>
                                                    <!-- booking requests approve form -->
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                                        <input type="hidden" name="action" value="approve">
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Approve booking for <?= htmlspecialchars($booking['child_name']) ?>?')">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                    <!-- booking requests rejection form -->
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal<?= $booking['id'] ?>">
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                        <!-- comments for rejection of request -->
                                                        <div class="modal fade" id="rejectModal<?= $booking['id'] ?>" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Reject Booking Request</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Reason for rejection:</label>
                                                                            <textarea name="admin_notes" class="form-control notes-textarea"
                                                                                rows="3" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" name="action" value="reject" class="btn btn-danger">
                                                                            Confirm Rejection
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php else: ?>
                                                    <small class="text-muted"><?= $booking['admin_notes'] ?></small>
                                                <?php endif; ?>
                                            </td>
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

<?php $connection->close(); ?>