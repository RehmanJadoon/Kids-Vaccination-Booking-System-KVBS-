<?php
date_default_timezone_set('Asia/Karachi');
session_start();
require_once 'includes/db_connection.php'; //including db connection file

// Redirect if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; //setting user session in var
$child_id = $vaccine_id = $worker_id = $preferred_date = $preferred_time = $admin_notes = '';
$errorMessage = $successMessage = ''; //declaring empty vars

$children = "SELECT * FROM children WHERE user_id = $user_id"; //display user's own children
$child_result = $connection->query($children);

if(!$child_result){
    $errorMessage = "Invalid query:" . $connection->error;
}

$vaccines = "SELECT * FROM vaccines WHERE status = 'Available'"; //displaying available vaccines for user to book
$vaccines_result = $connection->query($vaccines);

if(!$vaccines_result){
    $errorMessage = "Invalid query:" . $connection->error;
}

$workers = "SELECT * FROM workers WHERE status = 'Active'";
$workers_result = $connection->query($workers);

if(!$workers_result){
    $errorMessage = "Invalid query: " . $connection->error;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){ //applying condition to check for request method
    $child_id = $_POST['child_id'];
    $vaccine_id = $_POST['vaccine_id'];
    $worker_id = $_POST['worker_id'];
    $preferred_date = $_POST['preferred_date'];
    $preferred_time = $_POST['preferred_time'];
    $admin_notes = $_POST['admin_notes'];

    do{ //applying loop & condition below to not empty required fields
        if(empty($child_id) || empty($vaccine_id) || empty($worker_id) || empty($preferred_date) || empty($preferred_time)){
            $errorMessage = "Please fill the required fields" . $connection->error;
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
            if($preferred_time <= $current_time) {
                $errorMessage = "Cannot book past time. Select future time.";
                break;
            }
        }
        //inserting the booking data into bookings table in database
        $sql = "INSERT INTO bookings (child_id, vaccine_id, worker_id, preferred_date, preferred_time, admin_notes) VALUES('$child_id', '$vaccine_id', '$worker_id', '$preferred_date', '$preferred_time', '$admin_notes')";
        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }
        $child_id = $vaccine_id = $worker_id = $preferred_date = $preferred_time = $admin_notes = ''; //setting form fields to empty after submission
        $successMessage = "Vaccination visit booked successfully";
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
            <?php include 'dashboard_sidebar.php' ?>
            
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Book Vaccination</h1>
                    <a href="dashboard.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
<!-- displaying error/ success messages -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?= $errorMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?= $successMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
<!-- child booking form strats here -->
                <div class="form-container">
                    <form method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Select Child</label>
                                <select class="form-select" name="child_id" required>
                                    <option value="">Select Child</option>
                                    <?php while ($child = $child_result->fetch_assoc()): ?>
                                        <option value="<?= $child['id'] ?>" 
                                            <?= ($child_id) == $child['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($child['name']) ?> (<?= htmlspecialchars($child['age']) ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <small class="text-muted">Don't see your child? <a href="add_child.php">Register a child first</a></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Select Vaccine</label>
                                <select class="form-select" name="vaccine_id" required>
                                    <option value="">Select Vaccine</option>
                                    <?php while ($vaccine = $vaccines_result->fetch_assoc()): ?>
                                        <option value="<?= $vaccine['id'] ?>" 
                                            <?= ($vaccine_id) == $vaccine['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($vaccine['disease']) ?> - <?= htmlspecialchars($vaccine['age_range']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                                <label class="form-label required">Select Healthcare Worker</label>
                                <select class="form-select" name="worker_id" required>
                                    <option value="">Select Worker</option>
                                    <?php while ($worker = $workers_result->fetch_assoc()): ?>
                                        <option value="<?= $worker['id'] ?>" 
                                            <?= ($worker_id) == $worker['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($worker['full_name']) ?> (<?= htmlspecialchars($worker['specialization']) ?>) (<?= htmlspecialchars($worker['available_time']) ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
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
                                       value="<?= htmlspecialchars($_POST['preferred_time'] ?? '09:00') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" name="admin_notes" rows="3"> <?php htmlspecialchars($admin_notes) ?></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-calendar-check"></i> Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>