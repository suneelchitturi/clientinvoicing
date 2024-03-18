<?php
include 'header.php';
include 'db.php';

// Fetch client names and due dates from the database
$clientData = array(); // Initialize an empty array to store client data
$sql = "SELECT ClientName, `Due Date` FROM clients"; // Note the use of backticks for `Due Date`
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $clientData[$row["ClientName"]] = $row["Due Date"];
    }
}

// Fetch employee names and rates from the database
$employeeData = array(); // Initialize an empty array to store employee data
$sql = "SELECT EmployeeName, Rate FROM clientemployeestate";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $employeeData[$row["EmployeeName"]] = $row["Rate"];
    }
}

// Initialize variables for form fields
$clientName = $invoiceDate = $dueDate = $billAmount = $employeeStateId = "";
$clientNameErr = $invoiceDateErr = $dueDateErr = $billAmountErr = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Example validation, you can adjust as needed
    if (empty($_POST['clientName']) || empty($_POST['invoiceDate']) || empty($_POST['dueDate']) || empty($_POST['totalAmount'])) {
       echo "All fields are required.";
    } else {
        // Retrieve form input values
        $clientName = $_POST['clientName'];
        $invoiceDate = $_POST['invoiceDate'];
        $dueDate = $_POST['dueDate'];
        $discountPercentage = $_POST['discountPercentage'];
        $totalAmount = $_POST['totalAmount'];

        // Prepare and execute SQL query to insert invoice data
        $sql = "INSERT INTO invoices (ClientName, InvoiceDate, DueDate, DiscountPercentage, TotalAmount) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssd", $clientName, $invoiceDate, $dueDate, $discountPercentage, $totalAmount);

        if ($stmt->execute()) {
            echo "Invoice saved successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }
}

?>

<div class="container">
    <h2>Create Invoice</h2>
    <style>
        /* style.css */

        /* Style for the form container */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Style for the form header */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style for form fields and labels */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 1px;
            box-sizing: border-box;
        }

        /* Style for error messages */
        .text-danger {
            color: red;
        }

        /* Style for the table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Style for the Submit button */
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="clientName">Client Name:</label>
            <select class="form-control" id="clientName" name="clientName">
                <option value="">Select Client</option>
                <?php foreach ($clientData as $name => $dueDate): ?>
                    <option value="<?php echo $name; ?>" data-due-date="<?php echo $dueDate; ?>"><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="invoiceDate">Invoice Date:</label>
            <!-- Set default value to current date -->
            <input type="date" class="form-control" id="invoiceDate" name="invoiceDate" value="<?php echo date('Y-m-d'); ?>">
            <span class="text-danger"><?php echo $invoiceDateErr; ?></span>
        </div>
        <div class="form-group">
            <label for="dueDate">Due Date:</label>
            <input type="date" class="form-control" id="dueDate" name="dueDate" readonly>
            <span class="text-danger"><?php echo $dueDateErr; ?></span>
        </div>
        <!-- Table with dynamic number of rows -->
        <div class="form-group">
            <table class="table" id="invoiceTable">
                <thead>
                    <tr>
                        <th>EmployeeName</th>
                        <th>Hours</th>
                        <th>Rate</th> <!-- New column for displaying the rate -->
                        <th>Description</th>
                        <th>Bill Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row template -->
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <tr class="row-template">
                            <td>
                                <select class="form-control employeeName" name="employeeName[]">
                                    <option value="">Select Employee</option>
                                    <?php foreach ($employeeData as $employee => $rate): ?>
                                        <option value="<?php echo $employee; ?>" data-rate="<?php echo $rate; ?>"><?php echo $employee; ?></option>
                                    <?php endforeach; ?>
                                      
                                </select>
                            </td>
                            <td><input type="number" class="form-control hours" name="hours[]" value=""></td>
                            <td><input type="number" class="form-control rate" name="rate[]" value="" readonly></td> <!-- Readonly input field for displaying the rate -->
                            <td><input type="text" class="form-control description" name="description[]" value=""></td>
                            <td><input type="number" class="form-control billAmount" name="billAmount[]" value="" readonly></td>
                        </tr>
                    <?php endfor; ?>  
                </tbody>
            </table>
            <!-- Add row button -->
            <button type="button" class="btn btn-primary" id="addRowBtn">Add Row</button>
            <!-- Discount in percentage row -->
            <tr>        
                <td>Discount (%)</td>
                <td colspan="3"></td>
                <td><input type="number" class="form-control discountPercentage" name="discountPercentage" value="0"></td>
            </tr>
            <!-- Total amount row -->
            <tr>
                <td>Total Amount</td>
                <td colspan="3"></td>
                <td><input type="number" class="form-control totalAmount" name="totalAmount" value="" readonly></td>
            </tr>
           
</div>
      

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
       
        
</div>
    </form>
</div>

<script>
    document.getElementById('clientName').addEventListener('change', function() {
        var dueDateInput = document.getElementById('dueDate');
        var selectedClient = this.options[this.selectedIndex];
        dueDateInput.value = selectedClient.getAttribute('data-due-date');
    });

    // Add event listener to invoice date input
    document.getElementById('invoiceDate').addEventListener('input', function() {
        var dueDateInput = document.getElementById('dueDate');
        var invoiceDate = new Date(this.value); // Get the value of invoice date
        var dueDate = new Date(invoiceDate.getTime() + (7 * 24 * 60 * 60 * 1000)); // Set due date as 7 days from invoice date
        dueDateInput.value = dueDate.toISOString().slice(0,10); // Update due date input field
    });

    // Add event listener to employee select inputs
    document.querySelectorAll('.employeeName').forEach(function(select) {
        select.addEventListener('change', function() {
            var row = this.closest('tr');
            var selectedEmployee = this.value;
            var rate = this.options[this.selectedIndex].getAttribute('data-rate');
            row.querySelector('.rate').value = rate;
            calculateBillAmount(row);
        });
    });

    // Calculate bill amount based on hours and rate
    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('hours') || event.target.classList.contains('rate')) {
            var row = event.target.closest('tr');
            calculateBillAmount(row);
        }
    });

    // Function to calculate bill amount
    function calculateBillAmount(row) {
        var hours = parseFloat(row.querySelector('.hours').value);
        var rate = parseFloat(row.querySelector('.rate').value);

        // Calculate bill amount
        var billAmount = hours * rate;

        // Update bill amount
        var billAmountInput = row.querySelector('.billAmount');
        billAmountInput.value = isNaN(billAmount) ? '' : billAmount.toFixed(2);

        // Recalculate total amount
        calculateTotalAmount();
    }

    // Calculate total amount
    function calculateTotalAmount() {
        var discountPercentage = parseFloat(document.querySelector('.discountPercentage').value);
        var billAmountInputs = document.querySelectorAll('.billAmount');
        var totalAmount = 0;

        billAmountInputs.forEach(function(input) {
            var billAmount = parseFloat(input.value);
            if (!isNaN(billAmount)) {
                totalAmount += billAmount;
            }
        });

        // Apply discount
        var discountedTotalAmount = totalAmount * (1 - (discountPercentage / 100));

        // Update total amount
        var totalAmountInput = document.querySelector('.totalAmount');
        totalAmountInput.value = isNaN(discountedTotalAmount) ? '' : discountedTotalAmount.toFixed(2);
    }

    // Recalculate total amount when discount percentage changes
    document.querySelector('.discountPercentage').addEventListener('input', calculateTotalAmount);

    // Add row button functionality
    document.getElementById('addRowBtn').addEventListener('click', function() {
        var tableBody = document.querySelector('#invoiceTable tbody');
        var rowTemplate = document.querySelector('.row-template');
        var newRow = rowTemplate.cloneNode(true);
        // Clear values in the new row
        newRow.querySelectorAll('input').forEach(function(input) {
            input.value = '';
        });
        tableBody.appendChild(newRow);

        // Check if more rows are needed
        var rows = tableBody.querySelectorAll('tr');
        if (rows.length >= 6) {
            var addMoreBtn = document.createElement('button');
            addMoreBtn.setAttribute('type', 'button');
            addMoreBtn.setAttribute('class', 'btn btn-primary');
            addMoreBtn.textContent = 'Add More Rows';
            addMoreBtn.addEventListener('click', function() {
                var newRow = rowTemplate.cloneNode(true);
                newRow.querySelectorAll('input').forEach(function(input) {
                    input.value = '';
                });
                tableBody.appendChild(newRow);
            });
            tableBody.parentElement.appendChild(addMoreBtn);
            document.getElementById('addRowBtn').style.display = 'none'; // Hide initial add row button
        }
    });
      // Function to calculate due amount
      function calculateDueAmount() {
        var totalAmount = parseFloat(document.querySelector('.totalAmount').value);
        var totalPaid = parseFloat(document.querySelector('#totalPaid').value);

        // Calculate due amount
        var dueAmount = totalAmount - totalPaid;

        // Update due amount field
        var dueAmountInput = document.querySelector('#dueAmount');
        dueAmountInput.value = isNaN(dueAmount) ? '' : dueAmount.toFixed(2);
    }

    // Calculate due amount when total paid field changes
    document.getElementById('totalPaid').addEventListener('input', calculateDueAmount);

    // Calculate due amount initially
    calculateDueAmount();
    function printInvoice(invoiceID) {
        window.open("print_invoice.php?id=" + invoiceID, "_blank");
    }
</script>

<?php include 'footer.php'; ?>
