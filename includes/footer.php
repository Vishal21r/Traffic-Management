<footer>
        <div class="container">
            <div class="footer-columns">
                <div class="footer-column">
                    <div class="logo">
                        <a href="index.php">
                            <img src="assets/img/logo.svg" alt="TrafficSafe">
                            <span>TrafficSafe</span>
                        </a>
                    </div>
                    <p>Advanced real-time traffic management system for safer roads and efficient transportation networks.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="accident-report.php">Report Accident</a></li>
                        <li><a href="features.php">Features</a></li>
                        <li><a href="accident-management.php">Manage Accidents</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <address>
                        <p><i class="fas fa-map-marker-alt"></i> BH-1, Lovely professional University</p>
                        <p><i class="fas fa-phone"></i> +91 7903929325</p>
                        <p><i class="fas fa-envelope"></i> cravi6349@gmail.com</p>
                    </address>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 TrafficSafe. All rights reserved.</p>
                <div class="footer-links">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/main.js"></script>
    <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php'): ?>
    <script src="assets/js/dashboard.js"></script>
    <?php endif; ?>
    <?php if(basename($_SERVER['PHP_SELF']) == 'accident-report.php'): ?>
    <script src="assets/js/accident-report.js"></script>
    <?php endif; ?>
</body>
</html>
