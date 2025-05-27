<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthNet: Admin Login</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
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
        }

        /* Form container styling */
        .form-container {
            background: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .form-container h1 {
            color: #333;
        }

        .form-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-container input[type="submit"] {
            width: 100%;
            background-color: #007bff00;
            color: #3ef57e;
            border-color: #3ef57e;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .form-container input[type="submit"]:hover {
            color: #ffffff;
            background-color: #92c342;
        }

        .Healthnet {
            height: 175px;
            width: 175px;
        }
    </style>
</head>
<body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the password from the form
            $Pass = isset($_POST['Pass']) ? trim($_POST['Pass']) : "";

            // Check password
            if ($Pass === "Admin") {
                // Redirect to the admin page
                header("Location:Admin_page.php");
                exit;
            } else {
                // Redirect back to the login page (this file)
                echo "<script>alert('Incorrect password. Please try again.');</script>";
            }
        }
    ?>

    <div class="container">
        <img src="../Essentials/MainLogo.png" class="Healthnet" alt="HealthNet Logo"><br>
        <form action="" class="form-container" method="POST">
            
            <h1>Admin Login</h1>

            <label for="password">Password</label>
            <input type="password" id="password" name="Pass" placeholder="Enter your password" required>

            <input type="submit" name="submit" value="Login">

            <h5>Powered By Inno Minds</h5>
        </form>
    </div>
</body>
</html>
