<?php
session_start(); //startig session
require_once '../includes/db_connection.php'; //including db connection file

//redirect to admin login page if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
//declaring empty var's
$id = $disease = $vaccine_name = $brand = $age_range = $status = $description = '';
$errorMessage = $successMessage = '';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!isset($_GET['id'])) {
    header("Location: manage_vaccines.php");
    exit();
}
$id = $_GET["id"];
//fetching vaccines data
$sql = "SELECT * FROM vaccines WHERE id = $id";
$result = $connection->query($sql);
$row = $result->fetch_assoc();

if(!$row){
    header("Location: manage_vaccines.php");
    exit;
}
//displaying vaccines data
$disease = $row["disease"];
$vaccine_name = $row["vaccine_name"];
$brand = $row["brand"];
$age_range = $row["age_range"];
$status = $row["status"];
$description = $row["description"];

}else{ //submitting the updated vaccines data
    $id = $_POST["id"];
    $disease = $_POST["disease"];
    $vaccine_name = $_POST["vaccine_name"];
    $brand = $_POST["brand"];
    $age_range = $_POST["age_range"];
    $status = $_POST["status"];
    $description = $_POST["description"];

    do{ //applying do while loop
        if(empty($disease) || empty($vaccine_name) || empty($brand) || empty($age_range) || empty($status)){ //required fields shouldn't be empty
            $errorMessage = "All fields are required" . $connection->error;
            break;
        }//query to check if vaccine already exists or not
        $check_sql = "SELECT id FROM vaccines WHERE vaccine_name = '$vaccine_name' AND id != $id";
        $check_result = $connection->query($check_sql);

        if($check_result->num_rows > 0){
            $errorMessage = "Vaccine already exists" . $connection->error;
            break;
        }
//query to submit update info of vaccines
        $sql = "UPDATE vaccines SET disease = '$disease', vaccine_name = '$vaccine_name', brand = '$brand', age_range = '$age_range', status = '$status', description = '$description' WHERE id = $id";
        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }
//success message
        $successMessage = "Vaccine updated successfully";
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
    
    <div class="container-fluid">
        <div class="row">
            <!-- including sidebar of admin dashboard -->
            <?php include 'admin_sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Vaccine</h1>
                    <a href="manage_vaccines.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Vaccines
                    </a>
                </div>
<!-- displaying error/ success messages -->
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                <?php elseif (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?= $successMessage ?></div>
                <?php endif; ?>
<!-- edit vaccine form -->
                <div class="form-container">
                    <form method="POST">
                        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($id) ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Disease</label>
                                <input type="text" class="form-control" name="disease" 
                                       value="<?= htmlspecialchars($disease) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Vaccine Name</label>
                                <input type="text" class="form-control" name="vaccine_name" 
                                       value="<?= htmlspecialchars($vaccine_name) ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Brand</label>
                                <input type="text" class="form-control" name="brand" 
                                       value="<?= htmlspecialchars($brand) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Age Range</label>
                                <input type="text" class="form-control" name="age_range" 
                                       value="<?= htmlspecialchars($age_range) ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Available" <?= $status == 'Available' ? 'selected' : '' ?>>Available</option>
                                    <option value="Unavailable" <?= $status == 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($description) ?></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save"></i> Update Vaccine
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>