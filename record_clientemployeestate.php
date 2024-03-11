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

// Define variables and initialize with empty values
$clientName = $employeeName = $employeeStateId = $startDate = $status = $rate = $dueDays = $endDate = "";
$clientNameErr = $employeeNameErr = $employeeStateIdErr = $startDateErr = $statusErr = $rateErr = $dueDaysErr = $endDateErr = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate client name
    if (empty(trim($_POST["clientName"]))) {
        $clientNameErr = "Please enter client name.";
    } else {
        $clientName = trim($_POST["clientName"]);
    }

    // Validate employee name
    if (empty(trim($_POST["employeeName"]))) {
        $employeeNameErr = "Please enter employee name.";
    } else {
        $employeeName = trim($_POST["employeeName"]);
    }

    // Validate employee state ID (you may remove this validation if not needed)
    if (empty(trim($_POST["employeeStateId"]))) {
        $employeeStateIdErr = "Please enter employee state ID.";
    } else {
        $employeeStateId = trim($_POST["employeeStateId"]);
    }

    // Validate start date
    if (empty(trim($_POST["startDate"]))) {
        $startDateErr = "Please enter start date.";
    } else {
        $startDate = trim($_POST["startDate"]);
    }

    // Validate status (you may add additional validation if needed)
    $status = trim($_POST["status"]);

    // Validate rate
    if (empty(trim($_POST["rate"]))) {
        $rateErr = "Please enter rate.";
    } else {
        $rate = trim($_POST["rate"]);
    }

    // Validate due days (you may add additional validation if needed)
    $dueDays = trim($_POST["dueDays"]);

    // Validate end date (you may add additional validation if needed)
    $endDate = trim($_POST["endDate"]);

    // Check input errors before inserting into database
    if (empty($clientNameErr) && empty($employeeNameErr) && empty($employeeStateIdErr) && empty($startDateErr) && empty($statusErr) && empty($rateErr) && empty($dueDaysErr) && empty($endDateErr)) {
        // Prepare an insert statement
        $sql = "INSERT INTO clientemployeestate (ClientName, EmployeeName, EmployeeStateId, StartDate, Status, Rate, DueDays, EndDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssissdss", $paramClientName, $paramEmployeeName, $paramEmployeeStateId, $paramStartDate, $paramStatus, $paramRate, $paramDueDays, $paramEndDate);

            // Set parameters
            $paramClientName = $clientName;
            $paramEmployeeName = $employeeName;
            $paramEmployeeStateId = $employeeStateId;
            $paramStartDate = $startDate;
            $paramStatus = $status;
            $paramRate = $rate;
            $paramDueDays = $dueDays;
            $paramEndDate = $endDate;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success page or display success message
                echo "Records inserted successfully.";
            } else {
                echo "Error: Unable to execute query. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Employee State</title>
    <link rel="stylesheet" href="style.css">
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
<h1>Client Employee State</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="clientName">Client Name:</label>
        <input type="text" name="clientName" id="clientN"><br><br>

        <label for="employeeName">Employee Name:</label>
        <input type="text" name="employeeName" id="employeeName"><br><br>

        <label for="employeeStateId">Employee State ID:</label>
        <input type="text" name="employeeStateId" id="employeeStateId"><br><br>

        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" id="startDate"><br><br>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="Active">Active</option>
            <option value="Closed">Closed</option>
        </select><br><br>

        <label for="rate">Rate:</label>
        <input type="text" name="rate" id="rate"><br><br>

        <label for="dueDays">Due Days:</label>
        <input type="text" name="dueDays" id="dueDays"><br><br>

        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" id="endDate"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
