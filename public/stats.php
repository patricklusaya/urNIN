
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
include '../includes/db.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      

        .container {
            max-width: 1200px;
            margin: 50px auto;
        }

        .header {
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .card h2 {
            font-size: 0.85rem;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .stat {
            font-size: 1rem;
            color: #007bff;
        }

        /* Chart Container */
        .chart-container {
            width: 100%;
            height: 200px;
            position: relative;
        }

        /* Search Frequency Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
        }

        /* Date Range Selector */
        .date-range {
            margin-top: 15px;
        }

        .date-range input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Search Statistics Overview</h1>
    </div>

    <!-- Grid Container -->
    <div class="grid">

        <!-- Card 1: Total Searches -->
        <div class="card">
            <h2>Total Searches</h2>
            <div class="stat">
                
         <?php

         $username = $_SESSION['username'];
         $stmt = $conn->prepare('SELECT COUNT(*) AS total_searches FROM search_history WHERE username = ?');
         $stmt->bind_param('s', $username);  // Bind the username to the query
         
         // Execute the query
         $stmt->execute();
         
         // Get the result
         $result = $stmt->get_result();
         $row = $result->fetch_assoc();

         echo $row['total_searches'];

         
         
         ?>
        
        </div>
        </div>

        <!-- Card 2: Most Searched Terms -->
        <div class="card">
            <h2>Most Searched Terms</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>NIN/Name</th>
                    <th>Search Frequency</th>
                </tr>
                </thead>
                <tbody>
                <?php
// Prepare the SQL query
                $query = 'SELECT nin, COUNT(*) AS frequency FROM search_history GROUP BY nin ORDER BY frequency DESC';
                $result = $conn->query($query);

                // Check if query was successful
                if ($result) {
                    // Fetch and display the results
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . htmlspecialchars($row['nin']) . '</td>
                            <td>' . $row['frequency'] . '</td>
                        </tr>
                        ';
                    }
                } else {
                    echo 'Error: ' . $conn->error;
                }

                // Close the result set
                $result->free();
                ?>


                
              
                </tbody>
            </table>
        </div>

        <!-- Card 3: Search Frequency (Bar Chart) -->
        <div class="card">
            <h2>Search Frequency</h2>
            <div class="chart-container" id="searchFrequencyChart"></div>
        </div>

        <!-- Card 4: Searches by Date Range -->
        <div class="card">
            <h2>Searches by Date Range</h2>
            <div class="date-range">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate">
                <label for="endDate" style="margin-top: 10px;">End Date:</label>
                <input type="date" id="endDate">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/fetch_searches_by_date.js"></script>
<script>
    // Search Frequency Chart Example
    const ctx = document.getElementById('searchFrequencyChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['John Doe', 'Jane Smith', 'NIN: 123456789'],
            datasets: [{
                label: 'Search Frequency',
                data: [153, 145, 120],
                backgroundColor: ['#007bff', '#28a745', '#ffc107']
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
