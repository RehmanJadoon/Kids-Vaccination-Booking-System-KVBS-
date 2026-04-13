<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVBS</title>
    <link rel="stylesheet" href="/kidsvacc/css/bootstrap.css">
    <link rel="stylesheet" href="/kidsvacc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/kidsvacc/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> 
        :root {
            --primary-color: #148ba9;
            --secondary-color: #f8f9fa;
        }
        .sidebar {
            background: var(--primary-color);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar.collapsed {
            margin-left: -250px;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
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
            <div class="text-center p-4">
                <h5><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></h5>
                <p class="text-muted">Administrator</p>
            </div>
            
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registered_users.php">
                        <i class="fas fa-users-cog"></i> Registered Users
                    </a>
                </li>
                    <li class="nav-item">
                    <a class="nav-link" href="registered_childs.php">
                        <i class="fas fa-child"></i> Registered Kids
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_workers.php">
                        <i class="fas fa-users-cog"></i> Manage Workers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_vaccines.php">
                        <i class="fas fa-syringe"></i> Manage Vaccines
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking_requests.php">
                        <i class="fas fa-calendar-check"></i> Booking Requests
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vaccinated_kids.php">
                        <i class="fas fa-child"></i> Vaccinated Kids
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link text-danger" href="admin_logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <script>
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
    <script src="/kidsvacc/js/bootstrap.bundle.min.js"></script>
    <script src="/kidsvacc/icons/bootstrap-icons.json"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>