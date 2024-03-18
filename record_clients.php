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

// Function to insert client record into the database
function insertClient($clientName, $phone, $email, $dueDate, $addr1, $addr2, $addr3, $city, $country, $state, $zip, $ein)
{
    global $conn;

    $clientName = sanitizeInput($clientName);
    $phone = sanitizeInput($phone);
    $email = sanitizeInput($email);
    $dueDate = sanitizeInput($dueDate);
    $addr1 = sanitizeInput($addr1);
    $addr2 = sanitizeInput($addr2);
    $addr3 = sanitizeInput($addr3);
    $city = sanitizeInput($city);
    $country = sanitizeInput($country);
    $state = sanitizeInput($state);
    $zip = sanitizeInput($zip);
    $ein = sanitizeInput($ein);

    $sql = "INSERT INTO clients (ClientName, Phone, EmailId, `Due Date`, Addr1, Addr2, Addr3, City, Country, State, Zip, EIN)
            VALUES ('$clientName', '$phone', '$email', '$dueDate', '$addr1', '$addr2', '$addr3', '$city', '$country', '$state', '$zip', '$ein')";

    if (mysqli_query($conn, $sql)) {
        echo "Client record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientName = $_POST["clientName"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $dueDate = $_POST["dueDate"];
    $addr1 = $_POST["addr1"];
    $addr2 = $_POST["addr2"];
    $addr3 = $_POST["addr3"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $ein = $_POST["ein"];

    // Insert client record
    insertClient($clientName, $phone, $email, $dueDate, $addr1, $addr2, $addr3, $city, $country, $state, $zip, $ein);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
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

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="email"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

input[type="date"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
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
    <h1>Client</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="clientName">Client Name:</label>
        <input type="text" name="clientName" id="clientName"><br><br>

        <label for="phone">Phone:</label>
        <input type="number" name="phone" id="phone"><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br><br>

        <label for="country">Country:</label>
        <input type="text" name="country" id="country"><br><br>

        <label for="addr1">Address Line 1:</label>
        <input type="text" name="addr1" id="addr1"><br><br>

        <label for="addr2">Address Line 2:</label>
        <input type="text" name="addr2" id="addr2"><br><br>

        <label for="addr3">Address Line 3:</label>
        <input type="text" name="addr3" id="addr3"><br><br>

        <label for="city">City:</label>
        <input type="text" name="city" id="city"><br><br>

        <label for="state">State:</label>
        <input type="text" name="state" id="state"><br><br>

        <label for="zip">Zip:</label>
        <input type="text" name="zip" id="zip"><br><br>

        <label for="dueDate">Due Date:</label>
        <input type="date" name="dueDate" id="dueDate"><br><br>

        <label for="ein">EIN:</label>
        <input type="text" name="ein" id="ein"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
