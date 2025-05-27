<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dev";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = isset($_GET['UserId']) ? $_GET['UserId'] : 0;

// If the user_id is not provided or is invalid, show an error message
if ($user_id == 0) {
    die("User ID is missing or invalid.");
}

// Fetch the current user data
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

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get new values from form
    $new_name = isset($_POST['name']) ? $_POST['name'] : $user['Name'];
    $new_password = isset($_POST['password']) ? $_POST['password'] : null;
    $new_contact = isset($_POST['contact_no']) ? $_POST['contact_no'] : $user['Contact No'];

    // Hash the new password if provided
    if ($new_password) {
        
    } else {
        $new_password = $user['Password']; // Keep the current password if no new password is entered
    }

    // Update the user data in the database
    $update_sql = "UPDATE `hospital-users` SET `Name` = ?, `Password` = ?, `Contact No` = ? WHERE `UserID` = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $new_name, $new_password, $new_contact, $user_id);
    
    if ($update_stmt->execute()) {
        $message = "Details updated successfully!";
    } else {
        $message = "Failed to update details.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Page</title>
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

        .form-container {
            width: 60%;
            margin: 0 auto;
        }

        .form-container input[type="text"], .form-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-container button:hover {
            background-color: #45a049;
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
        <h1>Settings</h1>
        <h1>Update User Credentials</h1>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password (leave empty to keep current)">

                <label for="contact_no">Contact No:</label>
                <input type="text" id="contact_no" name="contact_no" value="<?php echo htmlspecialchars($user['Contact No']); ?>" required>

                <button type="submit">Update Details</button>
            </form>
        </div>

    </div>

</body>
</html>
