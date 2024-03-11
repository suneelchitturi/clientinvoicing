<?php 
include 'db.php'; 

// Check if client ID is provided and is a valid number
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $clientId = $_GET["id"];

    // Delete client from the database
    $sql = "DELETE FROM clients WHERE ClientId = $clientId";
    if ($conn->query($sql) === TRUE) {
        echo "Client deleted successfully";
    } else {
        echo "Error deleting client: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
