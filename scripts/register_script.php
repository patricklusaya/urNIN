<?php
include '../includes/db.php'; // Include database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      
        $_SESSION['error'] = "Username or email already exists.";

    } else {
        // **Hash the password before storing it**
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user with hashed password
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        if ($stmt->execute()) {
            
            header("Location: login.php");
            // Redirect or do something after success
        } else {
            $_SESSION['error'] = "Registration failed.";
           
        }
    }

    $stmt->close();
    $conn->close();
}
?>
