<?php
session_start(); 
// Include login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../scripts/login_script.php';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
        a {
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
         
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3 text-center"><a href="register.php">Don't have an account? Register</a></p>
        <?php
            // Display error message if it exists
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']); // Clear the error message after displaying
            }
            ?>
    </div>
    
</body>
</html>
