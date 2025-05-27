<?php 
include_once('../DBConnection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $Uname = isset($_POST['UN']) ? trim($_POST['UN']) : "";
    $Pass = isset($_POST['Pass']) ? trim($_POST['Pass']) : "";

    // Check if the user provided credentials
    if ($Uname && $Pass) {
        $sql1 = "SELECT * FROM patient WHERE Patient_Id=? OR Email=?";

        // Prepare the SQL statement
        if ($stmt = $con->prepare($sql1)) {
            $stmt->bind_param("ss", $Uname, $Uname);
            
            // Execute the query
            $stmt->execute();
            $result1 = $stmt->get_result();
            
            if ($result1->num_rows > 0) {
                // Fetch the result
                $DBUserName = $result1->fetch_assoc();
                $hashedPassword = $DBUserName["Password"];
                
                 
                if ($Pass== $hashedPassword) {   
                     
                    
                        header("Location:Patientpage.php?PatientID=" . urlencode($Uname)); 
                    
                    exit;  // Ensure no further code is executed
                } else {
                    $error_message = "Incorrect password. Please try again.";  // Error message if password doesn't match
                }
            } else {
                $error_message = "No record found for the provided NIC No/Email.";  // Error if no record found
            }
            $stmt->close();
        } else {
            $error_message = "Database query failed.";  // Error if query fails
        }
    } else {
        $error_message = "Please fill in both fields.";  // Error if input is missing
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Lanka: Doctor Login</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
             
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

        /* Form container styling */
        .form-container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-top: 10px;
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
            background-color: #8cc342;
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

        /* Error Message Styling */
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Logo Styling */
        .Healthnet {
            height: 250px;
            width:250px;
            
        }

        /* Responsive design for mobile */
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
        <img src="../Essentials/MainLogo.png" class="Healthnet" alt="HealthNet Logo"><br>
        
        <!-- Login Form -->
        <form action="" class="form-container" method="POST">
            <h1>Health Lanka</h1>
            <h5>Powered By Inno Minds</h5>

            <!-- Error message display -->
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <label for="username">NIC No/Email</label>
            <input type="text" id="username" name="UN" placeholder="Licence No/Email" value="" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="Pass" placeholder="Enter your password" value="" required>
            
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>
