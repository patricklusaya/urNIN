<?php 
// Include the database connection
include("../includes/db.php");

// Check if the 'id' is passed in the POST request
if (isset($_POST["nin"])) {
    $id = $_POST["nin"];  // Get the 'id' value from the POST request

    // Prepare the SQL query to fetch the search history based on 'id'
    $sql = "SELECT * FROM search_history WHERE nin = ?";
    $stmt = $conn->prepare($sql);  // Use prepared statements to prevent SQL injection
    $stmt->bind_param("i", $id);  // Bind the 'id' parameter as an integer to the query
    $stmt->execute();  // Execute the query
    $result = $stmt->get_result();  // Get the result of the query

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Fetch the result row
        $row = $result->fetch_assoc();

        // Return the details of the search history as HTML
        echo '
        <div class="id-card-holder">
            <div class="id-card">
                <div class="id-card-header">
                    <div class="id-card-emblem"><img src="../assets/images/emb.png" alt="Photo" class="embem-img"></div>
                    <div class="id-card-title">
                        <p class="tag1">JAMHURI YA MUUNGANO WA TANZANIA</p>
                        <h3 class="tag2">KITAMBULISHO CHA TAIFA</h3>
                        <p class="tag1">THE UNITED REPUBLIC OF TANZANIA</p>
                        <h3 class="tag3">CITIZEN IDENTITY CARD</h3>
                    </div>
                    <div class="id-card-flag"><img src="../assets/images/tz.png" alt="Photo" class="flag-img"></div>
                </div>

                <div class="photo">
                    <div class="details">
                        <p class="nin">' . htmlspecialchars($row["nin"]) . '</p>
                        <p class="info">JINA LA KWANZA: <span class="bold-text">' . htmlspecialchars($row["firstname"]) . '</span></p>
                        <p class="info2">First Name</p>
                        <p class="info">MAJINA YA KATI: <span class="bold-text">' . htmlspecialchars($row["middlename"]) . '</span></p>
                        <p class="info2">Middle Name</p>
                        <p class="info">JINA LA MWISHO: <span class="bold-text">' . htmlspecialchars($row["lastname"]) . '</span></p>
                        <p class="info2">Last Name</p>
                       
                    </div>
                    <div class="id-image">
                        <img src="../assets/images/woman.png" alt="Photo" class="info-img">
                    </div>
                </div>
            </div>

            <div class="download-btn" style="background-color: #f4f4f4; padding: 10px; border-radius: 5px;">
                <button class="download-btn2" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer;">
                    Download
                </button>
            </div>
        </div>
        ';
    } else {
        echo '<p>No details found for this search history entry.</p>';
    }
} else {
    echo '<p>Error: ID not passed.</p>';
}
?>
