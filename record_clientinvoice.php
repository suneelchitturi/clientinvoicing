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

// Fetch due date from clients database
$dueDate = ""; // Initialize due date variable
$sql = "SELECT `Due Date` FROM clients WHERE ClientName = 'XYZ Pvt Ltd'"; // Adjust the query as per your database schema
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $dueDate = $row["Due Date"];
}

// Function to insert client invoice record into the database
function insertClientInvoice($clientName, $invoiceDate, $dueDate, $totalAmount, $totalPaid, $paymentDate)
{
    global $conn;
    
    $clientName = sanitizeInput($clientName);
    $invoiceDate = sanitizeInput($invoiceDate);
    $dueDate = sanitizeInput($dueDate);
    $totalAmount = sanitizeInput($totalAmount);
    $totalPaid = sanitizeInput($totalPaid);
    $paymentDate = sanitizeInput($paymentDate);

    $sql = "INSERT INTO clientinvoice (ClientName, InvoiceDate, DueDate, TotalAmount, TotalPaid, PaymentDate)
            VALUES ('$clientName', '$invoiceDate', '$dueDate', '$totalAmount', '$totalPaid', '$paymentDate')";

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
    // Due date is fetched from the clients database
    $totalAmount = $_POST["totalAmount"];
    $totalPaid = $_POST["totalPaid"];
    $paymentDate = $_POST["paymentDate"];

    // Insert client invoice record
    insertClientInvoice($clientName, $invoiceDate, $dueDate, $totalAmount, $totalPaid, $paymentDate);
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
        input[type="date"],
        select {
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
        <label for="clientName">Client Name:</label>
        <select name="clientName" id="clientName">
            <?php
            // Fetch client names from the clients database
            $sql = "SELECT ClientName FROM clients";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["ClientName"] . "'>" . $row["ClientName"] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="invoiceDate">Invoice Date:</label>
        <input type="date" name="invoiceDate" id="invoiceDate" value="<?php echo date('Y-m-d'); ?>"><br><br>

        <label for="dueDate">Due Date:</label>
        <input type="date" name="dueDate" id="dueDate" ><br><br>

        <!-- Removed Bill Amount and Discounts fields -->

        <label for="totalAmount">Total Amount:</label>
        <input type="text" name="totalAmount" id="totalAmount" ><br><br>

        <label for="totalPaid">Total Paid:</label>
        <input type="text" name="totalPaid" id="totalPaid"><br><br>

        <label for="paymentDate">Payment Date:</label>
        <input type="date" name="paymentDate" id="paymentDate"><br><br>

        <input type="submit" value="Submit">
    </form>

    <script>
        // Fetch due date and total amount based on invoice date
        document.getElementById('invoiceDate').addEventListener('change', function() {
            var invoiceDate = this.value;

            // AJAX request to fetch due date and total amount
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    document.getElementById('dueDate').value = response.dueDate;
                    document.getElementById('totalAmount').value = response.totalAmount;
                }
            };
            xhr.open('GET', 'fetch_due_and_total.php?invoiceDate=' + invoiceDate, true);
            xhr.send();
        });
    </script>
</body>
</html>

 

<?php
// Close the database connection
mysqli_close($conn);
?>
