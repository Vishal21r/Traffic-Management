<?php include 'includes/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <p class="hero-subtext">TRAFFIC MANAGEMENT SYSTEM</p>
            <h1 class="hero-title">Smart Traffic Management for <span class="highlight">Safer Roads</span></h1>
            <p class="hero-description">Real-time analytics and intelligent tracking to reduce congestion and prevent accidents. Our system provides comprehensive analytics and management for modern cities.</p>
            <div class="hero-buttons">
                <a href="dashboard.php" class="btn btn-primary">View Dashboard</a>
                <a href="accident-report.php" class="btn btn-outline">Report Accident</a>
            </div>
        </div>
    </section>

    <!-- Live Traffic Dashboard Preview -->
    <section class="dashboard-preview">
        <div class="container">
            <h2>Live Traffic Dashboard</h2>
            <p>Monitor congestion data, accident reports, and traffic flow in real-time across the city.</p>
            <div class="dashboard-preview-content">
                <div class="traffic-chart">
                    <canvas id="trafficChart"></canvas>
                </div>
                <div class="metrics">
                    <div class="metric-card">
                        <h3>3</h3>
                        <p>Active Incident Alerts</p>
                    </div>
                </div>
                <div class="heatmap">
                    <div id="trafficHeatmap"></div>
                </div>
            </div>
            <a href="dashboard.php" class="btn btn-secondary">View complete dashboard data and metrics</a>
        </div>
    </section>

    <!-- Accident Reporting Section -->
    <section class="accident-report">
        <div class="container">
            <h2>Report an Accident</h2>
            <p>Help improve road safety by reporting accidents and hazards you encounter.</p>
            <div class="accident-form-preview">
                <form action="accident-report.php" method="post" class="accident-form-sample">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="e.g., Main St & 5th Ave">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" id="time" name="time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Describe what happened..."></textarea>
                    </div>
                    <a href="accident-report.php" class="btn btn-primary">Complete Report</a>
                </form>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Comprehensive Features</h2>
            <p>Our smart management system offers a seamless way to monitor, analyze, and enhance traffic flow.</p>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3>Real-time Traffic Monitoring</h3>
                    <p>View live traffic conditions across the city with real-time updates every minute.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>Incident Tracking</h3>
                    <p>Comprehensive incident management system for accidents, construction, and traffic delays.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Analytics Dashboard</h3>
                    <p>Visualize traffic patterns, congestion hotspots, and historical data.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Instant Notifications</h3>
                    <p>Receive alerts about major incidents, unusual congestion, or system updates.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Detailed Reports</h3>
                    <p>Generate comprehensive reports on traffic patterns and accident statistics.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <div class="container">
            <h2>Ready to transform your traffic management?</h2>
            <a href="dashboard.php" class="btn btn-primary">Get Started</a>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
