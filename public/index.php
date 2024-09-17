<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NID Search</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <style>
        body {
            background-color: #e9ecef;
          
        }

        .container {
            max-width: 1200px;
            background: #ffffff;
            border-radius: 12px;
          
            padding: 30px;
            margin-top: 70px;
        }

        h1 {
        
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        p {
         
            color: #495057;
            text-align: center;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 12px;
           
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            color: #ffffff;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        #result {
            margin-top: 30px;
            padding: 20px;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }

            .btn-primary {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Main Content -->
    <div class="container">
        <h1>Hey, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Enter the NIN to search</p>
        <form id="searchForm">
            <div class="form-group">
                <label for="ninInput">NIN:</label>
                <input type="text" id="ninInput" class="form-control" placeholder="Enter NIN" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div id="result" class="mt-4"></div>
    </div>

    <!-- Scripts for Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom Script -->
    <script src="../assets/fetch_nin.js"></script>

</body>

</html>
