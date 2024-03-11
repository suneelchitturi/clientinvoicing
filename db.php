<?php
// Database connection
$servername = "localhost";
$username = "abc"; // Default username for XAMPP
$password = "Suneel@143#"; // Default password for XAMPP (empty)
$dbname = "client_invoicing"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
