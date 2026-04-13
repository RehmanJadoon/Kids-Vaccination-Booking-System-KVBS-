<?php
require_once 'includes/db_connection.php'; //including db connetion file
//query to display vaccines data
$vaccine_sql = "SELECT * FROM vaccines ORDER BY id ASC";
$vaccine_result = $connection->query($vaccine_sql);

if(!$vaccine_result){
    die("Invalid query:" . $connection->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
  <?php include 'navbar.php'?>
    <div class="hero-slider">
        <div class="slide active" style="background-image: url('images/vaccine15.jpg')">
            <div class="slide-overlay">
                <div class="container slide-content align-items-center">
                    <h1 class="slide-title">VACCINES</h1>
                    <h4 style="font-weight: bold; color: #148ba9;">Childhood Vaccines</h4>
                </div>
            </div>
        </div>
    </div>

<section class="login-section py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Vaccine ID</th>
                                        <th>Disease</th>
                                        <th>Vaccine Name</th>
                                        <th>Brand</th>
                                        <th>Child Age Range</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- displaying vaccines -->
                                    <?php while ($vaccine = $vaccine_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $vaccine['id'] ?></td>
                                        <td><?= htmlspecialchars($vaccine['disease']) ?></td>
                                        <td><?= htmlspecialchars($vaccine['vaccine_name']) ?></td>
                                        <td><?= htmlspecialchars($vaccine['brand']) ?></td>
                                        <td><?= htmlspecialchars($vaccine['age_range']) ?></td>
                                        <td>
                                            <span class="badge <?= $vaccine['status'] == 'Available' ? 'bg-success' : 'bg-secondary' ?> status-badge">
                                                <?= $vaccine['status'] ?>
                                            </span>
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
</section>    
<?php include 'footer.php'?>

</body>

</html>