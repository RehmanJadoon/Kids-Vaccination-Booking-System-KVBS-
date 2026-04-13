<?php
session_start();
require_once 'includes/db_connection.php';

if (!isset($_SESSION["user"])) { //redirecting if not logged in 
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = $name = $age = $gender = $blood_group = $city = $address = ''; //initializing empty var's
$errorMessage = $successMessage = '';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!isset($_GET['id'])) {
        header("Location: /kidsvacc/registered_kids.php");
        exit();
}
$id = $_GET["id"];

$sql = "SELECT * FROM children WHERE id = '$id'"; //displaying child's info
$result = $connection->query($sql); 
$row = $result->fetch_assoc();

if(!$row){ //if query not successfully the redirect
    header("Location: /kidsvacc/registered_kids.php");
    exit;
} //displaying data in fields
$name = $row["name"];
$age = $row["age"];
$gender = $row["gender"];
$blood_group = $row["blood_group"];
$city = $row["city"];
$address = $row["address"];

}else{ //posting the updated data 
    $id = $_POST["id"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $blood_group = $_POST["blood_group"];
    $city = $_POST["city"];
    $address = $_POST["address"];

    do{ //applying do while loop
        if(empty($name) || empty($age) || empty($gender) || empty($city) || empty($address)){ //if required fields are emtpy
            $errorMessage = "All fields are required" . $connection->error; //show error
            break;
        }
        //if same child exists & exclude the current child
        $check_sql = "SELECT id FROM children WHERE name = '$name' AND user_id = '$user_id' AND id != '$id'";  
        $check_result = $connection->query($check_sql);

        if($check_result->num_rows > 0){
            $errorMessage = "Child name already exists for this user" . $connection->error;
            break;
        }
//updating the child's info
        $sql = "UPDATE children SET name = '$name', age = '$age', gender = '$gender', blood_group = '$blood_group', city = '$city', address = '$address' WHERE id = '$id'";
        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }

        $successMessage = "Child updated successfully";
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
            <?php include 'dashboard_sidebar.php'?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Child Information</h1>
                    <a href="registered_kids.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Children
                    </a>
                </div>
<!-- error/ success messages -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?= $successMessage ?></div>
                <?php endif; ?>
<!-- first it will display the specific child's info, edit and then clik on update button -->
                <div class="form-container">
                    <form method="POST">
                        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($id) ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Child's Full Name</label>
                                <input type="text" class="form-control" name="name" 
                                       value="<?= htmlspecialchars($name) ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label required">Age</label>
                                <input type="text" class="form-control" name="age" 
                                       value="<?= htmlspecialchars($age) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Gender</label>
                                <select class="form-select" name="gender" required>
                                    <option value="Male" <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Other" <?= $gender == 'Other' ? 'selected' : '' ?>>Other</option>
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
                                <i class="fas fa-save"></i> Update Child
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>