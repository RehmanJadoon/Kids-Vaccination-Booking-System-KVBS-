<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVBS</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/kvbs-logo.png" alt="KVBS">
            </a>
            <button class="navbar-toggler toggler-bgcolor" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon toggler-color"></span>
            </button>
            <div class="navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="vaccines.php">
                            VACCINES
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="consult.php">FREE CONSULT</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="login.php" class="btn btn-light">USER LOGIN</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="./admin/admin_login.php" class="btn btn-light">ADMIN LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
     <script>
window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
        navbar.style.padding = '10px 0';
        document.querySelector('.navbar-brand img').style.height = '80px';
    } else {
        navbar.classList.remove('scrolled');
        navbar.style.padding = '15px 0';
        document.querySelector('.navbar-brand img').style.height = '80px';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    navbarToggler.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        navbarCollapse.classList.toggle('show');
        
        navbarCollapse.classList.remove('collapsing');
    });
    
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 992) {
                navbarCollapse.classList.remove('show');
            }
        });
    });
    
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            navbarCollapse.classList.remove('show');
        }
    });
    
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992 && 
            !navbarCollapse.contains(e.target) && 
            !navbarToggler.contains(e.target) &&
            navbarCollapse.classList.contains('show')) {
            navbarCollapse.classList.remove('show');
        }
    });
});

    </script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="icons/bootstrap-icons.json"></script>


</body>

</html>