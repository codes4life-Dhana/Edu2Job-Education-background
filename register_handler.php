<?php
// register_handler.php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edu2job";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Get POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($name) || empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// Check if user already exists
$check_sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already registered"]);
    $stmt->close();
    $conn->close();
    exit;
}

// Insert new user
$insert_sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insert_sql);
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Registration successful"]);
} else {
    echo json_encode(["status" => "error", "message" => "Registration failed"]);
}

$stmt->close();
$conn->close();
?>