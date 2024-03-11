<?php
// Establishing the database connection
$servername = "localhost";
$username = "abc"; // Default username for XAMPP MySQL
$password = "Suneel@143#"; // Default password for XAMPP MySQL
$database = "client_invoicing"; // Your database name

$conn = mysqli_connect($servername, $username, $password, $database);

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

// Function to fetch all clients
function getClients()
{
    global $conn;
    $sql = "SELECT * FROM clients";
    $result = mysqli_query($conn, $sql);
    $clients = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $clients[] = $row;
        }
    }
    return $clients;
}

// Function to add a new client
function addClient($clientName, $phone, $email, $country, $addr1, $addr2, $addr3, $city, $state, $zip, $ein)
{
    global $conn;
    $clientName = sanitizeInput($clientName);
    $phone = sanitizeInput($phone);
    $email = sanitizeInput($email);
    $country = sanitizeInput($country);
    $addr1 = sanitizeInput($addr1);
    $addr2 = sanitizeInput($addr2);
    $addr3 = sanitizeInput($addr3);
    $city = sanitizeInput($city);
    $state = sanitizeInput($state);
    $zip = sanitizeInput($zip);
    $ein = sanitizeInput($ein);
    $sql = "INSERT INTO clients (ClientName, Phone, EmailId, Country, Addr1, Addr2, Addr3, City, State, Zip, EIN)
            VALUES ('$clientName', '$phone', '$email', '$country', '$addr1', '$addr2', '$addr3', '$city', '$state', '$zip', '$ein')";
    return mysqli_query($conn, $sql);
}

// Add a new client if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_client"])) {
    $clientName = $_POST["client_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $country = $_POST["country"];
    $addr1 = $_POST["addr1"];
    $addr2 = $_POST["addr2"];
    $addr3 = $_POST["addr3"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $ein = $_POST["ein"];
    addClient($clientName, $phone, $email, $country, $addr1, $addr2, $addr3, $city, $state, $zip, $ein);
    header("Location: clients.php"); // Redirect after adding client
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients</title>
</head>
<body>
    <h1>Manage Clients</h1>

    <!-- Client Form -->
    <h2>Add New Client</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="client_name">Client Name:</label><br>
        <input type="text" id="client_name" name="client_name" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="country">Country:</label><br>
        <input type="text" id="country" name="country" required><br>
        <label for="addr1">Address Line 1:</label><br>
        <input type="text" id="addr1" name="addr1" required><br>
        <label for="addr2">Address Line 2:</label><br>
        <input type="text" id="addr2" name="addr2"><br>
        <label for="addr3">Address Line 3:</label><br>
        <input type="text" id="addr3" name="addr3"><br>
        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" required><br>
        <label for="state">State:</label><br>
        <input type="text" id="state" name="state" required><br>
        <label for="zip">Zip:</label><br>
        <input type="text" id="zip" name="zip" required><br>
        <label for="ein">EIN:</label><br>
        <input type="text" id="ein" name="ein" required><br>
        <input type="submit" name="add_client" value="Add Client">
    </form>

    <!-- List of Clients -->
    <h2>List of Clients</h2>
    <ul>
        <?php foreach (getClients() as $client): ?>
            <li><?php echo $client["ClientName"]; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
