<?php
include 'header.php'; 
include 'db.php'; // Include database connection file

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

// Function to insert client payment record into the database
function insertClientPayment($invoiceId, $paymentDate, $paymentAmount)
{
    global $conn;

    $invoiceId = sanitizeInput($invoiceId);
    $paymentDate = sanitizeInput($paymentDate);
    $paymentAmount = sanitizeInput($paymentAmount);

    $sql = "INSERT INTO clientpayments (InvoiceId, PaymentDate, PaymentAmount)
            VALUES ('$invoiceId', '$paymentDate', '$paymentAmount')";

    if (mysqli_query($conn, $sql)) {
        echo "Client payment record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceId = $_POST["invoiceId"];
    $paymentDate = $_POST["paymentDate"];
    $paymentAmount = $_POST["paymentAmount"];

    // Insert client payment record
    insertClientPayment($invoiceId, $paymentDate, $paymentAmount);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Payment</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* style.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%; /* Reduced container width */
    margin: 20px auto; /* Adjusted margin */
    padding: 10px; /* Reduced padding */
}

h1 {
    text-align: center;
    margin-bottom: 20px; /* Reduced margin */
    font-size: 24px; /* Adjusted font size */
}

form {
    width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

form label,
form input,
form select {
    display: block;
    margin-bottom: 1px; /* Reduced margin */
}

input[type="text"],
input[type="date"],
select {
    width: 100%;
    padding: 6px; /* Reduced padding */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 15px; /* Adjusted margin */
}

input[type="submit"] {
    width: 100%;
    padding: 8px; /* Reduced padding */
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 1px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
    <h1>Client Payment</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="invoiceId">Invoice ID:</label>
            <input type="text" name="invoiceId" id="invoiceId">
        </div>

        <div class="form-group">
            <label for="paymentDate">Payment Date:</label>
            <input type="date" name="paymentDate" id="paymentDate">
        </div>

        <div class="form-group">
            <label for="paymentAmount">Payment Amount:</label>
            <input type="text" name="paymentAmount" id="paymentAmount">
        </div>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
