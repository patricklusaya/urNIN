<?php
session_start();
include("../includes/db.php");

if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Prepare the SQL query
    $query = 'SELECT COUNT(*) AS search_count FROM search_history WHERE search_date BETWEEN ? AND ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $startDate, $endDate);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if query was successful
    if ($result) {
        $row = $result->fetch_assoc();
        echo json_encode(['search_count' => $row['search_count']]);
    } else {
        echo json_encode(['error' => 'Error: ' . $conn->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
