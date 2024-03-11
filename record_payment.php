<!-- record_payment.php -->
<?php 
include 'header.php'; 
include 'db.php'; // Include database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $invoiceId = $_POST["invoice_id"];
    $paymentDate = $_POST["payment_date"];
    $paymentAmount = $_POST["payment_amount"];

    // Insert payment record into clientpayments table
    $sql = "INSERT INTO clientpayments (InvoiceId, PaymentDate, PaymentAmount) VALUES ('$invoiceId', '$paymentDate', '$paymentAmount')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Payment recorded successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Retrieve list of invoices from the database
$sql = "SELECT * FROM clientinvoice";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Record Payment</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="invoice_id">Select Invoice:</label>
            <select class="form-control" id="invoice_id" name="invoice_id">
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["InvoiceId"] . "'>" . $row["InvoiceId"] . "</option>";
                    }
                } else {
                    echo "<option>No invoices found</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="payment_date">Payment Date:</label>
            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
        </div>
        <div class="form-group">
            <label for="payment_amount">Payment Amount:</label>
            <input type="text" class="form-control" id="payment_amount" name="payment_amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Record Payment</button>
    </form>
</div>

<?php include 'footer.php'; ?>
