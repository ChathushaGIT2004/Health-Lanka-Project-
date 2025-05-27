<?php
// Get Hospital ID from URL (assuming it's passed as a GET parameter)
$hospitalId = isset($_GET['hospital_id']) ? $_GET['hospital_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $Hosid = $_POST['hosid'];
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $contactNo = $_POST['contact_no'];
    
    // Database connection (update with your credentials)
    $servername = "localhost";
    $username = "root";
    $password_db = "";  // Use a different variable name to avoid conflict with form field
    $dbname = "dev";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert type is hardcoded as 'Pharmacist'
    $type = 'Labotary';
  $password="1234";
    // Prepare and execute the insert query
    $sql = "INSERT INTO `hospital-users`(`UserID`, `Name`, `Hospital ID`, `Type`, `Location`, `Contact No`, `Password`) 
            VALUES ('$userId', '$name', '$Hosid', '$type', '$location', '$contactNo', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Success: Display alert and redirect to ViewHospital.php
        echo "<script>
                alert('Pharmacist added successfully!');
                window.location.href = 'ViewHospital.php?hospital_id=" . htmlspecialchars($hospitalId) . "';
              </script>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pharmacist</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        /* Form Styles */
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            form {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 24px;
            }
            form {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<h1>Add Pharmacist</h1>

<!-- Form to add a new pharmacist -->
<form action="" method="POST">
    <label for="user_id">UserID:</label>
    <input type="text" id="user_id" name="user_id" required><br>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required><br>

    <label for="contact_no">Contact No:</label>
    <input type="text" id="contact_no" name="contact_no" required><br>

    <!-- New password field -->
     

    <!-- Hidden field to pass the HospitalId -->
    <input type="hidden" name="hosid" value="<?php echo $hospitalId; ?>">

    <button type="submit">Add Lab</button>
</form>

</body>
</html>
