<?php
// reset_password_handler.php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edu2job";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Get POST data
$email = $_POST['email'] ?? '';
$cricketer = $_POST['cricketer'] ?? '';
$newPassword = $_POST['newPassword'] ?? '';

if (empty($email) || empty($cricketer) || empty($newPassword)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// First verify the user exists and security answer
$verify_sql = "SELECT id FROM users WHERE email = ? AND favourite_cricketer = ?";
$stmt = $conn->prepare($verify_sql);
$stmt->bind_param("ss", $email, $cricketer);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "Invalid email or security answer"]);
    $stmt->close();
    $conn->close();
    exit;
}

// Update password
$update_sql = "UPDATE users SET password = ? WHERE email = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("ss", $newPassword, $email);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Password reset successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No changes made"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Password reset failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>