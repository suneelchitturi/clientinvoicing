<?php
include 'db.php'; // Include database connection file

// Check if invoice ID is provided and is a valid number
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $invoiceId = $_GET["id"];

    // Prepare a delete statement
    $sql = "DELETE FROM clientinvoice WHERE InvoiceId = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("i", $invoiceId);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to view_invoices.php with success message
            header("Location: view_invoices.php?delete=success");
            exit();
        } else {
            // Redirect to view_invoices.php with error message
            header("Location: view_invoices.php?delete=error");
            exit();
        }
    } else {
        // Redirect to view_invoices.php with error message
        header("Location: view_invoices.php?delete=error");
        exit();
    }
} else {
    // Redirect to view_invoices.php if no valid invoice ID is provided
    header("Location: view_invoices.php");
    exit();
}
?>
