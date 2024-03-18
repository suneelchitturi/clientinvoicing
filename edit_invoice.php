<?php
include 'header.php';
include 'db.php';

// Retrieve invoice details to edit
$invoiceID = $_GET['id'];
$sql = "SELECT i.*, ci.`TotalPaid` FROM invoices i LEFT JOIN clientinvoice ci ON i.`InvoiceID` = ci.`InvoiceID` WHERE i.`InvoiceID` = $invoiceID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $invoice = $result->fetch_assoc(); // Fetch invoice details
} else {
    echo "Invoice not found";
}

// Handle form submission for updating invoice
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form input values
    $clientName = $_POST['clientName'];
    $invoiceDate = $_POST['invoiceDate'];
    $dueDate = $_POST['dueDate'];
    $discountPercentage = $_POST['discountPercentage'];
    $totalAmount = $_POST['totalAmount'];
    $totalPaid = $_POST['totalPaid'];

    // Prepare and execute SQL query to update invoice data
    $sql = "UPDATE invoices SET ClientName=?, InvoiceDate=?, DueDate=?, DiscountPercentage=?, TotalAmount=? WHERE InvoiceID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdi", $clientName, $invoiceDate, $dueDate, $discountPercentage, $totalAmount, $invoiceID);

    if ($stmt->execute()) {
        echo "Invoice updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
?>

<div class="container">
    <h2>Edit Invoice</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $invoiceID; ?>">
        <div class="form-group">
            <label for="clientName">Client Name:</label>
            <input type="text" class="form-control" id="clientName" name="clientName" value="<?php echo $invoice['ClientName']; ?>" required>
        </div>
        <div class="form-group">
            <label for="invoiceDate">Invoice Date:</label>
            <input type="date" class="form-control" id="invoiceDate" name="invoiceDate" value="<?php echo $invoice['InvoiceDate']; ?>" required>
        </div>
        <div class="form-group">
            <label for="dueDate">Due Date:</label>
            <input type="date" class="form-control" id="dueDate" name="dueDate" value="<?php echo $invoice['DueDate']; ?>" required>
        </div>
        <div class="form-group">
            <label for="discountPercentage">Discount Percentage:</label>
            <input type="number" class="form-control" id="discountPercentage" name="discountPercentage" value="<?php echo $invoice['DiscountPercentage']; ?>">
        </div>
        <div class="form-group">
            <label for="totalAmount">Total Amount:</label>
            <input type="number" class="form-control" id="totalAmount" name="totalAmount" value="<?php echo $invoice['TotalAmount']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="totalPaid">Total Paid:</label>
            <input type="number" class="form-control" id="totalPaid" name="totalPaid" value="<?php echo $invoice['TotalPaid']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>
<style>
    .container {
        margin-top: 50px;
        text-align: center;
    }

    h2 {
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        border: none;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>

<?php include 'footer.php'; ?>
