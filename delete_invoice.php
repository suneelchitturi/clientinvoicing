<?php
include 'header.php';
include 'db.php';

// Check if invoice ID is provided
if(isset($_GET['id'])) {
    // Retrieve invoice ID from URL parameter
    $invoiceID = $_GET['id'];

    // Prepare and execute SQL query to delete the invoice
    $sql = "DELETE FROM invoices WHERE InvoiceID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invoiceID);

    if ($stmt->execute()) {
        echo "Invoice deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invoice ID not provided.";
}

include 'footer.php';
?>
