<?php
// Start the session to store user details after login
session_start();

// Database connection
$servername = "localhost"; // Change to your server
$username = "root";        // Change to your DB username
$password = "";            // Change to your DB password
$dbname = "dev";           // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables for login error and success message
$login_error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to check if the username and password match
    $sql = "SELECT `UserID`, `Name`, `Hospital ID`, `Type`, `Location`, `Contact No` FROM `hospital-users` WHERE UserID='$username' AND `Password` = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, get the details
        $user = $result->fetch_assoc();

        // Store user details in session
        $_SESSION['userID'] = $user['UserID'];  // Store userID in session
        $_SESSION['username'] = $user['Name'];  // Store user name
        $_SESSION['type'] = $user['Type'];      // Store user type

        // Redirect based on user type
        if ($user['Type'] == 'Pharmacist') {
            header('Location:Pharmacist/pharmacistPage.php?UserId=' . urlencode($user['UserID']));
            exit();
        } elseif ($user['Type'] == 'Labotary') {
            header('Location:Lab/LabPage.php?UserId=' . urlencode($user['UserID']));
            exit();
        }
    } else {
        // Invalid login
        $login_error = "Invalid username or password.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            align-items: center;
        }

        h5 {
            color: #3ef57e;
            font-weight: 600;
            box-shadow: 1px 1px 1px #d41414;
        }

        .form-container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-top: 20px;
            border: 1px solid #f0f0f0;
        }

        .form-container h1 {
            color: #333333;
            margin-bottom: 15px;
        }

        .form-container label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="password"]:focus {
            border-color: #3ef57e;
            outline: none;
        }

        .form-container input[type="submit"] {
            width: 100%;
            background-color: #3ef57e;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .form-container input[type="submit"]:hover {
            background-color: #28a745;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .Healthnet {
            height: 150px;
            width: 150px;
            margin-bottom: 20px;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }

            .Healthnet {
                height: 120px;
                width: 120px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <img src="Essentials/MainLogo.png" class="Healthnet" alt="HealthNet Logo"><br>

    <!-- Login Form -->
    <form action="HosLogin.php" class="form-container" method="POST">
        <h1>Health Lanka</h1>
        <h5>Powered By Inno Minds</h5>

        <!-- Error message display -->
        <?php if (!empty($login_error)): ?>
            <div class="error-message"><?php echo $login_error; ?></div>
        <?php endif; ?>
        
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>
