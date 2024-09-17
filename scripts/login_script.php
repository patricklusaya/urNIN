<?php
include '../includes/db.php'; // Include database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Debugging: Show the entered username and password
    echo "Entered username: " . htmlspecialchars($username) . "<br>";
    echo "Entered password: " . htmlspecialchars($password) . "<br>";

    // Prepare and execute SQL statement to fetch the password hash
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($passwordHash);
        $stmt->fetch();

  

        // Check if password hash was fetched (user exists)
        if ($passwordHash) {
            // Verify the provided password against the stored hash
            if (password_verify($password, $passwordHash)) {
                // Debugging: If password is verified
                echo "Password verified!<br>";

                // Start the session and set the username
                session_start();
                $_SESSION['username'] = $username;
                header("Location: ../public/index.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password.";
                header("Location: login.php"); // Redirect to login page
                exit();
            }
        } else {
            $_SESSION['error'] = "Incorrect password or username";
            header("Location: login.php"); // Redirect to login page
            exit();
        }

        $stmt->close();
    } else {
        echo "Database error: " . $conn->error . "<br>";
    }
}
?>
