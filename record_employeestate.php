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

// Function to insert employee state record into the database
function insertEmployeeState( $employeeName)
{
    global $conn;
    
    //$employeestateId = sanitizeInput($employeestateId);
    $employeeName = sanitizeInput($employeeName);

    $sql = "INSERT INTO employeestate ( EmployeeName)
            VALUES ('$employeeName')";

    if (mysqli_query($conn, $sql)) {
        echo "Employee state record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeName = $_POST["employeeName"];

    // Insert employee state record
    insertEmployeeState($employeeName);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EmployeeState</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
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
    <h1>EmployeeState</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="employeestateId">EmployeeStateId:</label>
        <input type="text" name="employeestateId" id="employeestateId"><br><br>
        <label for="employeeName">Employee Name:</label>
        <input type="text" name="employeeName" id="employeeName"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>


<?php
// Close the database connection
mysqli_close($conn);
?>
