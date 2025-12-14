<?php
// login_handler.php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edu2job";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Get POST data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Email and password are required"]);
    exit;
}

// Check user credentials
$sql = "SELECT id, name, email FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    
    echo json_encode([
        "status" => "success", 
        "message" => "Login successful",
        "user" => $user
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
}

$stmt->close();
$conn->close();
?>