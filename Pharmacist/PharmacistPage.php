<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dev";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = isset($_GET['UserId']) ? $_GET['UserId'] : 0;

if ($user_id == 0) {
    die("User ID is missing or invalid.");
}

$sql = "SELECT `UserID`, `Name`, `Hospital ID`, `Type`, `Location`, `Contact No`, `Password` FROM `hospital-users` WHERE `UserID` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .contact-card {
            background-color: #e0f7fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .contact-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .contact-card h2 {
            margin: 10px 0;
            font-size: 24px;
            color: #00796b;
        }

        .contact-card p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn:active {
            background-color: #388e3c;
        }

        .btn:focus {
            outline: none;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php if ($user): ?>
            <div class="contact-card">
                <h2><?php echo $user['Name']; ?></h2>
                <p><strong>Hospital ID:</strong> <?php echo $user['Hospital ID']; ?></p>
                <p><strong>Type:</strong> <?php echo $user['Type']; ?></p>
                <p><strong>Location:</strong> <?php echo $user['Location']; ?></p>
                <p><strong>Contact No:</strong> <?php echo $user['Contact No']; ?></p>
            </div>

            <div class="button-container">
                <button class="btn" onclick="viewHistory()">View History</button>
                <button class="btn" onclick="issueMedicine()">Issue Medicine</button>
                <button class="btn" onclick="settings()">Settings</button>
            </div>

            <div class="message" id="message"></div>

        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>

    <script>
        function viewHistory() {
            document.getElementById('message').textContent = "Viewing History...";
            document.getElementById('message').style.color = "#00796b";
        }

        function issueMedicine() {
            // Redirecting to issuemedicine1.php and passing UserID as a query parameter
            var userId = "<?php echo $user['UserID']; ?>"; // Getting the UserID from PHP
            window.location.href = "issuemedicine1.php?UserId=" + userId; // Append UserID to the URL
        }

        function settings() {

            var userId = "<?php echo $user['UserID']; ?>";
            window.location.href = "settings.php?UserId=" + userId;
            
        }
    </script>

</body>
</html>
