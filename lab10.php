<?php
// Fixed: sqli -> mysqli, locahost -> localhost
$conn = new mysqli("localhost", "root", "", "mydb1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST['submit'] ?? false) {
    // Fixed: Added variable definitions from POST data
    $name = $_POST['name'] ?? '';
    $address1 = $_POST['address1'] ?? '';
    $address2 = $_POST['address2'] ?? '';
    $email = $_POST['email'] ?? '';
    
    // SECURITY WARNING: This is still vulnerable to SQL injection
    // Consider using prepared statements for production code
    $sql = "INSERT INTO USERS (name, address1, address2, email) VALUES ('$name', '$address1', '$address2', '$email')";
    $conn->query($sql);
    
    // Fixed: HTML syntax error - missing >
    echo "<p>Data inserted successfully</p>";
}

if ($_POST['search'] ?? false) {
    // SECURITY WARNING: This is vulnerable to SQL injection
    // Consider using prepared statements for production code
    $result = $conn->query("SELECT * FROM USERS WHERE name = '{$_POST['search_name']}'");
    
    // Fixed: HTML syntax error - missing >
    echo "<h3>Search Results:</h3>";
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Fixed: $id -> $row for the ID field
            echo "ID: " . $row["id"] . "<br>";
            echo "Name: " . $row["name"] . "<br>";
            echo "Address Line1: " . $row["address1"] . "<br>";
            echo "Address Line2: " . $row["address2"] . "<br>";
            echo "Email: " . $row["email"] . "<br><br>";
        }
    } else {
        echo "No data found";
    }
}

$conn->close();
?>

<h2>Enter details</h2>
<form method="post">
    Name: <input type="text" name="name" required><br><br>
    Address1: <input type="text" name="address1" required><br><br>
    Address2: <input type="text" name="address2" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    <!-- Fixed: Submit -> submit (case sensitivity) -->
    <input type="submit" name="submit" value="Submit">
</form>

<br>
<h2>Search by Name</h2>
<form method="post">
    Name: <input type="text" name="search_name" required>
    <input type="submit" name="search" value="Search">
</form>