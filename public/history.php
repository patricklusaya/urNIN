<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}



include '../includes/header.php';
include("../includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/styles.css">
      <!-- Add Font Awesome for icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Main layout */
        .history-container {
            display: flex;
            min-height: 100vh;
            margin-top: 60px;
        }

        /* Left Sidebar */
        .sidebar {
            width: 30%;
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #ddd;
            margin: 0 -20px;
        }

        .sidebar h4 {
            margin-bottom: 20px;
        }

        .nav-link.active {
            background-color: #007bff;
            color: white !important;
            border-radius: 5px;
        }

        .nav-link {
            padding: 10px 15px;
            font-weight: 500;
            color: #007bff;
        }

        /* Main Content */
        .content {
            width: 70%;
            padding: 20px;
            margin-left: 20px;
        }

        .history-card {
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Search History Item */
        .history-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-item .time {
            width: 100px;
        }

        .history-item .query {
            flex-grow: 1;
            padding-left: 20px;
        }

        /* Icons */
        .history-icons {
            display: flex;
            gap: 10px;
        }

        .history-icons i {
            font-size: 18px;
            cursor: pointer;
        }

        .history-icons i:hover {
            color: #007bff;
        }

        /* Checkbox */
        .history-checkbox {
            margin-right: 10px;
        }

    </style>
</head>

<body>

    <div class="container-fluid history-container">
        <!-- Left Sidebar -->
        <div class="sidebar">
           
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Your History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="delete-all-history">Delete All History</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="history-card">
                <h5>Your Search History</h5>
                <ul class="list-group">
    <?php
    $username = $_SESSION['username'];

    // SQL query to fetch search history
    $sql = "SELECT * FROM search_history WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Loop through each search history entry and display it
    foreach ($rows as $row) {
        echo '
        <li class="list-group-item history-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <input type="checkbox" class="history-checkbox">
                <span class="time ml-2">' . htmlspecialchars($row["search_date"]) . '</span>
                <span class="query ml-4">' . htmlspecialchars($row["nin"]) . '</span>
            </div>
            <div class="history-icons">
                <i class="fas fa-eye" title="View" data-toggle="modal" data-target="#viewModal" data-id="' . $row['nin'] . '"></i>
                <i class="fas fa-times cancel-icon" title="Delete" data-id="' . $row['id'] . '"></i>
            </div>
        </li>';
    }
    ?>
</ul>

            </div>
            <!-- Bootstrap Modal Structure -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">Search History Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalContent">
        <!-- Search History details will be loaded here dynamically -->
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>

        </div>

    </div>

    <!-- Scripts for Bootstrap, jQuery, and Font Awesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <script src="../assets/pop_modal.js"></script>
    <script src="../assets/show_pdf.js"></script>

    <script>
        $(document).ready(function () {
            // Handle delete single history click
            $('.cancel-icon').on('click', function () {
                const historyId = $(this).data('id');
                const $item = $(this).closest('li');

                if (confirm('Are you sure you want to delete this history?')) {
                    $.ajax({
                        url: '/nida/scripts/delete_history.php',
                        method: 'POST',
                        data: { id: historyId },
                        success: function (response) {
                            $item.remove();
                        },
                        error: function () {
                            alert('Error deleting history.');
                        }
                    });
                }
            });

            // Handle delete all history click
            $('#delete-all-history').on('click', function () {
                if (confirm('Are you sure you want to delete all search history?')) {
                    // AJAX request to delete all history
                    $.ajax({
                        url: 'nida/scripts/delete_all_history.php',
                        method: 'POST',
                        success: function (response) {
                            $('.history-item').remove();
                        },
                        error: function () {
                            alert('Error deleting all history.');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
