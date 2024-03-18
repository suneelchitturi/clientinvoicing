<?php
include 'header.php';
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <style>
        /* CSS styles */
        table {
            width: 80%;
            border-collapse: middle;
        }
        th, td {
            padding: 2px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        td a {
            display: inline-block;
            padding: 2px 5px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 1px;
            transition: background-color 0.3s;
        }
        td a:hover {
            background-color: #007bff;
            color: #fff;
        }
        .print-btn {
            display: inline-block;
            padding: 2px 5px;
            background-color: #28a745;
            color: #fff;
            border: 1px solid #28a745;
            border-radius: 1px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .print-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<?php
$sql = "SELECT i.*, ci.`TotalPaid` FROM invoices i LEFT JOIN clientinvoice ci ON i.`InvoiceID` = ci.`InvoiceID`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Invoices</h2>";
    echo "<table border='1'>
    <tr>
    <th>Invoice ID</th>
    <th>Client Name</th>
    <th>Invoice Date</th>
    <th>Due Date</th>
    <th>Discount Percentage</th>
    <th>Total Amount</th>
    <th>Total Paid</th>
    <th>Actions</th>
    <th>Print</th> <!-- New column for print button -->
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['InvoiceID'] . "</td>";
        echo "<td>" . $row['ClientName'] . "</td>";
        echo "<td>" . $row['InvoiceDate'] . "</td>";
        echo "<td>" . $row['DueDate'] . "</td>";
        echo "<td>" . $row['DiscountPercentage'] . "</td>";
        echo "<td>" . $row['TotalAmount'] . "</td>";
        echo "<td>" . $row['TotalPaid'] . "</td>"; // Display Total Paid
        echo "<td>
                <a href='view_invoices.php?id=" . $row['InvoiceID'] . "'>View</a>
                <a href='edit_invoice.php?id=" . $row['InvoiceID'] . "'>Edit</a>
                <a href='delete_invoice.php?id=" . $row['InvoiceID'] . "'>Delete</a>
              </td>";
        echo "<td>
                <a href='javascript:void(0);' class='print-btn' onclick='printInvoice(" . $row['InvoiceID'] . ")'>Print</a>
              </td>"; 
              
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>

<script>
    function printInvoice(invoiceID) {
        window.open("print_single_invoice.php?id=" + invoiceID, "_blank");
    }
</script>

</body>
</html>

