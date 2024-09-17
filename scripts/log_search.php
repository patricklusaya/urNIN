<?php 

session_start();
include("../includes/db.php");

// Ensure that NIN and user data are available
if (isset($_POST['nin'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_SESSION['username'])) {
    
    $nin = $_POST['nin'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_SESSION['username'];

    // Prepare the SQL statement with explicit column names
    $stmt = $conn->prepare('INSERT INTO search_history (nin, firstname, middlename, lastname, username, search_date) VALUES (?, ?, ?, ?, ?, NOW())');

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind the parameters: four strings (nin, firstname, middlename, lastname) and username
    $stmt->bind_param('sssss', $nin, $firstname, $middlename, $lastname, $username);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo 'History saved';
    } else {
        echo 'Failed to save history: ' . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo 'Incomplete data provided';
}

// Close the database connection
$conn->close();
?>
