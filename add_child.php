<?php
session_start();
require_once 'includes/db_connection.php'; //including db connection file

// Redirect if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; //declaring var & put user session in that var
$id = $name = $parent_name = $age = $gender = $blood_group = $city = $address = ''; //declaring empty vars
$errorMessage = $successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //applying condition for request method post
    $name = $_POST["name"]; //posting data in particular fields
    $parent_name = $_POST["parent_name"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $blood_group = $_POST["blood_group"];
    $city = $_POST["city"];
    $address = $_POST["address"];

    do { //do while loop starts & below putting condition that mentioned fields shouldn't be empty
        if (empty($name) || empty($parent_name) || empty($age) || empty($gender) || empty($city) || empty($address)) {
            $errorMessage = "All fields are required" . $connection->error;
            break;
        }
        //running sql query to check if child with same name already exists
        $check_sql = "SELECT id FROM children WHERE name = '$name' AND user_id = '$user_id'";
        $check_result = $connection->query($check_sql);

        if ($check_result->num_rows > 0) {
            $errorMessage = "Child name already exists for this user" . $connection->error;
            break;
        }
        //running sql query to insert data into database columns
        $sql = "INSERT INTO children (user_id, name, parent_name, age, gender, blood_group, city, address) VALUES('$user_id', '$name', '$parent_name', '$age', '$gender', '$blood_group', '$city', '$address')";
        $result = $connection->query($sql);

        if (!$result) { //if query fails error should display
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }
        //after submission the form fields should be empty
        $name = $parent_name = $age = $gender = $blood_group = $city = $address = '';
        $successMessage = "Child registered successfully"; //success message
    } while (false); //loop ends here
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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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
            <!-- including the dashboard sidebar -->
            <?php include 'dashboard_sidebar.php' ?> 
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Register Child</h1>
                        <a href="dashboard.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
<!-- displaying error/succes messages -->
                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger"><?= $errorMessage ?></div>
                    <?php elseif (!empty($successMessage)): ?>
                        <div class="alert alert-success"><?= $successMessage ?></div>
                    <?php endif; ?>

                    <div class="form-container">
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Child's Full Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="<?= htmlspecialchars($name) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Parent/Guardian Name</label>
                                    <input type="text" class="form-control" name="parent_name"
                                        value="<?= htmlspecialchars($parent_name) ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label required">Age</label>
                                    <input type="text" class="form-control" name="age"
                                        value="<?= htmlspecialchars($age) ?>"
                                        placeholder="e.g., 2 years or 6 months" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Gender</label>
                                    <select class="form-select" name="gender" required>
                                        <option value="">Select</option>
                                        <option value="Male" <?= ($gender) == 'Male' ? 'selected' : '' ?>>Male</option>
                                        <option value="Female" <?= ($gender) == 'Female' ? 'selected' : '' ?>>Female</option>
                                        <option value="Other" <?= ($gender) == 'Other' ? 'selected' : '' ?>>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Blood Group</label>
                                    <select class="form-select" name="blood_group">
                                        <option value="">Select</option>
                                        <option value="A+" <?= ($blood_group) == 'A+' ? 'selected' : '' ?>>A+</option>
                                        <option value="A-" <?= ($blood_group) == 'A-' ? 'selected' : '' ?>>A-</option>
                                        <option value="B+" <?= ($blood_group) == 'B+' ? 'selected' : '' ?>>B+</option>
                                        <option value="B-" <?= ($blood_group) == 'B-' ? 'selected' : '' ?>>B-</option>
                                        <option value="AB+" <?= ($blood_group) == 'AB+' ? 'selected' : '' ?>>AB+</option>
                                        <option value="AB-" <?= ($blood_group) == 'AB-' ? 'selected' : '' ?>>AB-</option>
                                        <option value="O+" <?= ($blood_group) == 'O+' ? 'selected' : '' ?>>O+</option>
                                        <option value="O-" <?= ($blood_group) == 'O-' ? 'selected' : '' ?>>O-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required">City</label>
                                    <input type="text" class="form-control" name="city"
                                        value="<?= htmlspecialchars($city) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Complete Address</label>
                                    <textarea class="form-control" name="address" rows="1" required><?= htmlspecialchars($address) ?></textarea>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-save"></i> Register Child
                                </button>
                            </div>
                        </form>
                    </div>
            </main>
        </div>
    </div>
</body>

</html>