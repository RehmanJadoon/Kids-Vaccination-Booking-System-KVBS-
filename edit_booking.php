<?php
date_default_timezone_set('Asia/Karachi');
session_start();
require_once 'includes/db_connection.php';



// Redirect if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; //storing user session in var
$booking_id = $_GET['id'];
$vaccine_id = $worker_id = $preferred_date = $preferred_time = $admin_notes = ''; //initializing empty var's
$errorMessage = $successMessage = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$booking_sql = "SELECT b.*, c.user_id 
                                FROM bookings b
                                JOIN children c ON b.child_id = c.id
                                WHERE b.id = $booking_id AND c.user_id = $user_id"; //fetching data from tables using JOIN
$booking_result = $connection->query($booking_sql);

if (!$booking_result || $booking_result->num_rows === 0) { //if query failed & there's no entry then redirect to dashboard.php
    header("Location: dashboard.php");
    exit();
}
$row = $booking_result->fetch_assoc();
//displaying data that we've fetched
$vaccine_id = $row['vaccine_id'];
$worker_id = $row['worker_id'];
$preferred_date = $row['preferred_date'];
$preferred_time = $row['preferred_time'];
$admin_notes = $row['admin_notes'];

$vaccines_sql = "SELECT * FROM vaccines WHERE status = 'Available'"; //displaying available vaccines
$vaccines_result = $connection->query($vaccines_sql);

$workers = "SELECT * FROM workers WHERE status = 'Active'";
$workers_result = $connection->query($workers);

if(!$workers_result){
    $errorMessage = "Invalid query: " . $connection->error;
}
//now updated data is sending in database using POST method
if($_SERVER['REQUEST_METHOD'] == 'POST'){    
    $vaccine_id = $_POST["vaccine_id"];
    $worker_id = $_POST["worker_id"];
    $preferred_date = $_POST["preferred_date"];
    $preferred_time = $_POST["preferred_time"];
    $admin_notes = $_POST["admin_notes"];

    do{ //applying do while loop
        if(empty($vaccine_id) || empty($worker_id) || empty($preferred_date) || empty($preferred_time)){ //if these fields are empty
            $errorMessage = "Please fill all required fields" . $connection->error; //show error
            break;
        }
        $wk_days = date('N', strtotime($preferred_date));
        if($wk_days >= 6){
            $errorMessage = "Appointment can be booked Monday to Friday";
            break;
        }
        $working_hrs = date('H', strtotime($preferred_time));
        if($working_hrs < 9 || $working_hrs >= 17){
            $errorMessage = "Appointment can be booked in working hours only i.e. 0900 AM to 0500 PM";
            break;
        }
        $today = date('Y-m-d');
        if($preferred_date == $today) {
        $preferred_time_24 = date('H:i', strtotime($preferred_time));    
        $current_time = date('H:i');
            if($preferred_time_24 <= $current_time) {
                $errorMessage = "Cannot book past time. Select future time.";
                break;
            }
        }
//updating query to update the data in database
        $sql = "UPDATE bookings SET vaccine_id = '$vaccine_id', worker_id = '$worker_id', preferred_date = '$preferred_date', preferred_time = '$preferred_time' WHERE id = $booking_id";
        $result = $connection->query($sql);
//if query is not successful, it'll show error 
        if(!$result){
            $errorMessage = "Invalid query:" .  $connection->error;
            break;
        }
//success message
        $successMessage = "Booking updated successfully";
    }while(false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            background: white;
        }
        .required:after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- dashbarod sidebar including -->
            <?php include 'dashboard_sidebar.php'?>
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Update Booking</h1>
                    <a href="dashboard.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
<!-- success/ error messages -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?= $successMessage ?></div>
                <?php endif; ?>

                <div class="form-container">
                    <form method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6"> 
                            <label class="form-label required">Select Vaccine</label>
                            <select class="form-select" name="vaccine_id" required>
                            <!-- showing available vaccines in dropdown -->
                            <option value="">Select Vaccine</option>
                                <?php while ($vaccine = $vaccines_result->fetch_assoc()): ?>
                                    <option value="<?= $vaccine['id'] ?>" 
                                        <?= ($vaccine_id) == $vaccine['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($vaccine['disease']) ?> - <?= htmlspecialchars($vaccine['age_range']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Select Healthcare Worker</label>
                            <select class="form-select" name="worker_id" required>
                            <!-- showing available workers in dropdown -->
                            <option value="">Select Worker</option>
                                <?php while ($worker = $workers_result->fetch_assoc()): ?>
                                    <option value="<?= $worker['id'] ?>" 
                                        <?= ($worker_id) == $worker['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($worker['full_name']) ?> - <?= htmlspecialchars($worker['specialization']) ?> - <?= htmlspecialchars($worker['available_time']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Preferred Date</label>
                                <input type="date" class="form-control" name="preferred_date" 
                                       min="<?= date('Y-m-d') ?>" 
                                       value="<?= htmlspecialchars($preferred_date) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Preferred Time</label>
                                <input type="time" class="form-control" name="preferred_time" 
                                       value="<?= htmlspecialchars($preferred_time) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" name="admin_notes" rows="3"><?= 
                                htmlspecialchars($admin_notes) 
                            ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <!-- by clicking below button to execute update query -->
                                <i class="fas fa-save"></i> Update Booking
                            </button>
                            <!-- want to cancel the edit booking operation, click below -->
                            <a href="dashboard.php" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>