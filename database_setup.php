<?php
// database_setup.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edu2job";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Edu2Job Database Setup</h2>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✅ Database 'edu2job' created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating database: " . $conn->error . "</p>";
}

// Select database
$conn->select_db($dbname);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    education VARCHAR(100),
    experience VARCHAR(50),
    skills TEXT,
    certifications TEXT,
    cgpa VARCHAR(10),
    objective TEXT,
    favourite_cricketer VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✅ Table 'users' created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating table: " . $conn->error . "</p>";
}

// Insert sample user if not exists
$check_sql = "SELECT * FROM users WHERE email='dhanasri@gmail.com'";
$result = $conn->query($check_sql);

if ($result->num_rows == 0) {
    $insert_sql = "INSERT INTO users (name, email, password, phone, education, experience, skills, favourite_cricketer) 
                   VALUES ('Dhanasri', 'dhanasri@gmail.com', '123456', '9876543210', 'B.Tech', '1', 'Python, Java', 'MS Dhoni')";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "<p style='color: green;'>✅ Sample user 'Dhanasri' added successfully</p>";
    } else {
        echo "<p style='color: red;'>❌ Error adding sample user: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: blue;'>ℹ️ Sample user already exists</p>";
}

// Show all users in the database
echo "<h3>Current Users in Database:</h3>";
$show_sql = "SELECT id, name, email, created_at FROM users";
$result = $conn->query($show_sql);

if ($result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["created_at"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No users found in database</p>";
}

$conn->close();
echo "<h3 style='color: green;'>🎉 Database setup completed successfully!</h3>";
echo "<p><a href='index.html'>Go to Login Page</a></p>";
?>