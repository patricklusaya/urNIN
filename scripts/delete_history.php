<?php 
// Include the database connection
include("../includes/db.php");

// Check if the 'id' is passed in the POST request
if (isset($_POST["id"])) {
    $id = $_POST["id"];  // Get the 'id' value from the POST request

    // Prepare the SQL query to fetch the search history based on 'id'
    $sql = "DELETE * FROM search_history WHERE id= ?";
    $stmt = $conn->prepare($sql);  // Use prepared statements to prevent SQL injection
    $stmt->bind_param("i", $id);  // Bind the 'id' parameter as an integer to the query
    $stmt->execute();  // Execute the query
 if ($stmt->execute() === TRUE) {

    echo"deleted";
    # code...
 }

  
    } else {
        echo '<p>No details provided</p>';
    }

?>
