<!-- manage_clients.php -->
<?php 
include 'header.php'; 
include 'db.php'; // Include database connection file

// Retrieve list of clients from the database
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Manage Clients</h2>
    <style>
        /* style.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 8px;
    border: 1px solid #ddd;
}

.table th {
    background-color: #f2f2f2;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #ddd;
}

.btn {
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-primary:hover,
.btn-danger:hover {
    opacity: 0.8;
}
</style>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Client ID</th>
                <th>Client Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ClientId"] . "</td>";
                    echo "<td>" . $row["ClientName"] . "</td>";
                    echo "<td>" . $row["Phone"] . "</td>";
                    echo "<td>" . $row["EmailId"] . "</td>";
                    echo "<td>" . $row["Country"] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_client.php?id=" . $row["ClientId"] . "' class='btn btn-primary'>Edit</a>";
                    echo "<a href='delete_client.php?id=" . $row["ClientId"] . "' class='btn btn-danger ml-2'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No clients found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
