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
$booking_id = $_GET['booking_id'];

$check_sql = "SELECT b.* FROM bookings b 
              JOIN children c ON b.child_id = c.id 
              WHERE b.id = $booking_id AND c.user_id = $user_id";
$check_result = $connection->query($check_sql);

if ($check_result->num_rows == 0) {
    header("Location: vaccinated_childs.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comments = mysqli_real_escape_string($connection, $_POST['comments']);

    // Check if feedback already exists
    $exists = "SELECT id FROM feedback WHERE booking_id = $booking_id";
    $check_exists = $connection->query($exists);

    if ($check_exists->num_rows > 0) {
        $update_feedback = "UPDATE feedback SET comments = '$comments', created_at = NOW() 
                WHERE booking_id = $booking_id";
    $update_result = $connection->query($update_feedback);
    }else{
        $submit_feedback = "INSERT INTO feedback (booking_id, user_id, comments) 
        VALUES ('$booking_id', '$user_id', '$comments')";
    $submit_result = $connection->query($submit_feedback);
    }
    header("Location: vaccinated_childs.php?feedback=success");
    exit;
}

// Get existing feedback if any
$feedback = $connection->query("SELECT comments FROM feedback WHERE booking_id = $booking_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>

    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <?php include 'dashboard_sidebar.php' ?>
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Feedback Form</h1>
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
                <div class="form-container">
                    <form method="POST">
                        <div class="row mb-3">
                            <div class="col-md-12">
                            <label class="form-label h5">Your Comments</label>
                            <textarea name="comments" class="form-control" rows="5"
                                placeholder="Share your experience..." required><?= htmlspecialchars($feedback['comments'] ?? '') ?></textarea>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        <a href="vaccinated_childs.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
        </div>
    </div>
    </main>
    <?php $connection->close(); ?>
</body>

</html>