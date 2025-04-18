<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header-fix.css">
    <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php'): ?>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <?php endif; ?>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="assets/img/logo.svg" alt="TrafficSafe">
                <span>TrafficSafe</span>
            </a>
        </div>
        
        <nav id="mainNav">
            <ul class="main-menu">
                <li class="menu-item"><a href="index.php">Home</a></li>
                
                <li class="menu-item has-dropdown">
                    <a href="#">Dashboard </a>
                    <ul class="dropdown-menu">
                        <li><a href="dashboard.php">Traffic Dashboard</a></li>
                        <li><a href="map.php">Traffic Map</a></li>
                    </ul>
                </li>
                
                <li class="menu-item"><a href="features.php">Features</a></li>
                <li class="menu-item"><a href="accident-report.php">Report Accident</a></li>
                <li class="menu-item"><a href="accident-management.php">Manage Accidents</a></li>
            </ul>
        </nav>
        
        <div class="header-actions">
            <a href="dashboard.php" class="btn btn-primary">Get Started</a>
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
<script src="assets/js/header.js"></script>