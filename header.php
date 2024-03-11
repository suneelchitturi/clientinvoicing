<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Invoicing</title>
  <style>
    /* Style.css */

/* Global reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
}

.container {
    width: 80%;
    margin: 0 auto;
}

header {
    background-color: #007bff;
    color: #fff;
    padding: 20px 0;
}

header h1 {
    margin-top: 20px; /* Added margin-top */
    margin-bottom: 20px;
    text-align: center; /* Center align the heading */
}

nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    text-align: center; /* Center align the navigation links */
}

nav ul li {
    display: inline;
    margin-right: 10px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

nav ul li a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="mt-5">Client Invoicing</h1>
            <nav>
                <ul>
                    <li><a href="create_invoice.php">Create Invoice</a></li>
                    <li><a href="manage_clients.php">Manage Clients</a></li>
                    <li><a href="view_invoices.php">Invoices</a></li>
                    <li><a href="record_clients.php">Clients</a></li>
                    <li><a href="record_employeestate.php">EmployeeState</a></li>
                    <li><a href="record_clientemployeestate.php">ClientEmployeeState</a></li>
                    <li><a href="record_clientinvoice.php">ClientInvoices</a></li>
                    <li><a href="record_clientpayments.php">ClientPayments</a></li>
                </ul>
            </nav>
        </div>
    </header>
