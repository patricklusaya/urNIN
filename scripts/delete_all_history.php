<?php 
// Include the database connection
include("../includes/db.php");

// Check if the 'id' is passed in the POST request
if (isset($_POST["id"])) {
    $id = $_POST["id"];  // Get the 'id' value from the POST request

    // Prepare the SQL query to fetch the search history based on 'id'
    $sql = "DELETE * FROM search_history";
    $result = mysqli_query($conn, $sql);


  
    } else {
        echo '<p>No details provided</p>';
    }

?>
