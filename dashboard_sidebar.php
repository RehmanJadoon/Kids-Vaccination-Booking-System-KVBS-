<?php
//including the db connection file
require_once 'includes/db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; //putting user session in var

// Fetching user details
$user_sql = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = $connection->query($user_sql);

if(!$user_result || $user_result->num_rows === 0){ //applying condition to check user
    die("Not found:" . $connection->error);
}
$user = $user_result->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVBS</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #148ba9;
            --secondary-color: #f8f9fa;
        }

        .sidebar {
            background: var(--primary-color);
            min-height: 100vh;
            height: 100%;
            left: 0;
            top: 0;
            color: white;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            margin-left: -250px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .main-content {
            background: var(--secondary-color);
            margin-left: 250px;
            transition: all 0.3s;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px 10px;
            width: auto;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>

    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="position-sticky pt-3">
            <div class="card dashboard-card mb-4">
                <div class="card-body text-center">
                    <!-- displaying user data -->
                    <h5><?= htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']) ?></h5>
                    <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
                    <p class="text-muted"><?= htmlspecialchars($user['address']) ?></p>
                    <p class="text-muted"><?= htmlspecialchars($user['phone']) ?></p>
                    <a href="edit_profile.php" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <a href="logout.php" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>

            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_child.php" class="nav-link">
                        <i class="fas fa-baby"></i> Register Child
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registered_kids.php">
                        <i class="fas fa-child"></i> Registered Kids
                    </a>
                </li>
                <li class="nav-item">
                    <a href="book_vaccine.php" class="nav-link">
                        <i class="fas fa-syringe"></i> Book Vaccination
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_bookings.php" class="nav-link">
                        <i class="fas fa-list"></i> View Bookings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vaccinated_childs.php">
                    <i class="fas fa-child"></i> Vaccinated Kids
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <script>
        // dashboard sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mainContent = document.getElementById('mainContent');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 767.98 &&
                    !sidebar.contains(event.target) &&
                    event.target !== sidebarToggle) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="icons/bootstrap-icons.json"></script>

</body>

</html>