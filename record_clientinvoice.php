<?php
include 'header.php'; 
include 'db.php';

// Check the database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize user inputs
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Function to insert client invoice record into the database
function insertClientInvoice($clientName, $invoiceDate, $dueDate, $billAmount, $discounts, $totalAmount, $paymentDate)
{
    global $conn;
    
    $clientName = sanitizeInput($clientName);
    $invoiceDate = sanitizeInput($invoiceDate);
    $dueDate = sanitizeInput($dueDate);
    $billAmount = sanitizeInput($billAmount);
    $discounts = sanitizeInput($discounts);
    $totalAmount = sanitizeInput($totalAmount);
    $paymentDate = sanitizeInput($paymentDate);

    // Calculate total amount after discount
    $totalAmount = $billAmount * (1 - ($discounts / 100));

    $sql = "INSERT INTO clientinvoice (ClientName, InvoiceDate, DueDate, BillAmount, Discounts, TotalAmount, PaymentDate)
            VALUES ('$clientName', '$invoiceDate', '$dueDate', '$billAmount', '$discounts', '$totalAmount', '$paymentDate')";

    if (mysqli_query($conn, $sql)) {
        echo "Client invoice record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientName = $_POST["clientName"];
    $invoiceDate = $_POST["invoiceDate"];
    $dueDate = $_POST["dueDate"];
    $billAmount = $_POST["billAmount"];
    $discounts = $_POST["discounts"];
    $totalAmount = $_POST["totalAmount"];
    $paymentDate = $_POST["paymentDate"];

    // Insert client invoice record
    insertClientInvoice($clientName, $invoiceDate, $dueDate, $billAmount, $discounts, $totalAmount, $paymentDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Invoice</title>
    <style>
     /* style.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    width: 300px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
}

input[type="text"],
input[type="date"] {
    width: 100%;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
    
</head>
<body>
    <h1>Client Invoice</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="clientId">Client Name:</label>
        <input type="text" name="clientName" id="clientName" required><br><br>

        <label for="invoiceDate">Invoice Date:</label>
        <input type="date" name="invoiceDate" id="invoiceDate" value="<?php echo date('Y-m-d'); ?>"><br><br>

        <label for="dueDate">Due Date:</label>
        <input type="date" name="dueDate" id="dueDate" value="Invoice"><br><br>

        <label for="billAmount">Bill Amount:</label>
        <input type="text" name="billAmount" id="billAmount"><br><br>

        <label for="discounts">Discounts (%):</label>
        <input type="text" name="discounts" id="discounts"><br><br>

        <label for="totalAmount">Total Amount:</label>
        <input type="text" name="totalAmount" id="totalAmount" readonly><br><br>

        <label for="paymentDate">Payment Date:</label>
        <input type="date" name="paymentDate" id="paymentDate"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
