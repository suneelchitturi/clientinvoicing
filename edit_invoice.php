<?php
include 'header.php';
include 'db.php';

// Check if invoice ID is provided in the URL
if(isset($_GET['id'])) {
    $invoiceId = $_GET['id'];

    // Fetch invoice details from the database
    $sql = "SELECT * FROM clientinvoice WHERE InvoiceId = $invoiceId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
    } else {
        echo "Invoice not found.";
        exit();
    }
} else {
    echo "Invoice ID is missing.";
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $clientName = $_POST["clientName"];
    $invoiceDate = $_POST["invoiceDate"];
    $dueDate = $_POST["dueDate"];
    $billAmount = $_POST["billAmount"];
    $discounts = $_POST["discounts"];
    $totalAmount = $_POST["totalAmount"];
    $paymentDate = $_POST["paymentDate"];

    // Update the invoice record in the database
    $sql = "UPDATE clientinvoice SET ClientName = '$clientName', InvoiceDate = '$invoiceDate', DueDate = '$dueDate', BillAmount = '$billAmount', Discounts = '$discounts', TotalAmount = '$totalPaidAmount
    if (mysqli_query($conn, $sql)) {
        echo "Invoice updated successfully.";
    } else {
        echo "Error updating invoice: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 50%;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Edit Invoice</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $invoiceId; ?>">
        <!-- Input fields pre-filled with invoice data -->
        <label for="clientId">Client Name:</label>
        <input type="text" name="clientName" id="clientName" value="<?php echo $invoice['ClientName']; ?>" required><br><br>

        <label for="invoiceDate">Invoice Date:</label>
        <input type="date" name="invoiceDate" id="invoiceDate" value="<?php echo $invoice['InvoiceDate']; ?>" required><br><br>

        <label for="dueDate">Due Date:</label>
        <input type="date" name="dueDate" id="dueDate" value="<?php echo $invoice['DueDate']; ?>" required><br><br>

        <label for="billAmount">Bill Amount:</label>
        <input type="text" name="billAmount" id="billAmount" value="<?php echo $invoice['BillAmount']; ?>" required><br><br>

        <label for="discounts">Discounts:</label>
        <input type="text" name="discounts" id="discounts" value="<?php echo $invoice['Discounts']; ?>"><br><br>

        <label for="totalAmount">Total Amount:</label>
        <input type="text" name="totalAmount" id="totalAmount" value="<?php echo $invoice['TotalAmount']; ?>"><br><br>

        <label for="paymentDate">Payment Date:</label>
        <input type="date" name="paymentDate" id="paymentDate" value="<?php echo $invoice['PaymentDate']; ?>"><br><br>

        <input type="submit" value="Update Invoice">
    </form>
</body>
</html>

<?php include 'footer.php'; ?>
