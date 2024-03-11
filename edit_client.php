<?php 
include 'header.php'; 
include 'db.php'; 

// Check if client ID is provided and is a valid number
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $clientId = $_GET["id"];

    // Retrieve client information from the database
    $sql = "SELECT * FROM clients WHERE ClientId = $clientId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        echo "Client not found";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}
?>

<div class="container">
    <h2>Edit Client</h2>
    <style>
        /* Add CSS styles here */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <form action="update_client.php" method="post">
        <input type="hidden" name="clientId" value="<?php echo $client['ClientId']; ?>">
        <div class="form-group">
            <label for="clientName">Client Name:</label>
            <input type="text" name="clientName" id="clientName" value="<?php echo $client['ClientName']; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" value="<?php echo $client['Phone']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $client['EmailId']; ?>" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" name="country" id="country" value="<?php echo $client['Country']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php include 'footer.php'; ?>
