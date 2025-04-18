<?php
$host = 'localhost';
$dbname = 'traffic_management';
$username = 'root';
$password = '';

try {
    // First try connecting directly to the database
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // If the database doesn't exist, display a helpful message
        if ($e->getCode() == 1049) {
            die("Database '$dbname' does not exist. Please run <a href='setup.php'>setup.php</a> first to create the database.");
        } else {
            throw $e; // Re-throw any other exceptions
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
