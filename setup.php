<?php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL without selecting a database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS traffic_management";
    $pdo->exec($sql);
    echo "<p>Database 'traffic_management' created successfully or already exists.</p>";
    
    // Select the database
    $pdo->exec("USE traffic_management");
    
    // Create tables from the schema
    $sql = file_get_contents('database.sql');
    $pdo->exec($sql);
    echo "<p>Database tables have been created successfully.</p>";
    
    echo "<p>Setup completed! <a href='index.php'>Go to homepage</a></p>";
    
} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
?>
