<?php
// test_login.php
echo "<h2>Login Handler Test</h2>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edu2job";

// Test database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection FAILED: " . $conn->connect_error);
} else {
    echo "✅ Database connected!<br>";
}

// Test if user exists
$test_email = "dhanasri@gmail.com";
$test_password = "123456";

$sql = "SELECT id, name, email FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $test_email, $test_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "✅ Login successful! User found:<br>";
    echo "ID: " . $user['id'] . "<br>";
    echo "Name: " . $user['name'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
} else {
    echo "❌ Login failed - user not found or wrong password<br>";
}

$stmt->close();
$conn->close();
?>