<?php
include "admin_navbar.php";

// Database connection setup
try {
    // Replace with your actual database credentials
    $host = 'localhost';
    $dbname = 'dev';
    $username = 'root';
    $password = '';

    // Create a PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Fetch all patients for displaying in a list
$patients = [];
$stmt = $conn->prepare("SELECT `Patient_Id`, `First_name`, `Last_name`, `Contact_No`, `Email`, `Image` FROM patient");
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management</title>
    <style>
        /* General Layout */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        .ImgHeath {
            margin: 20px auto;
            max-width: 120px;
            display: block;
        }

        h1 {
            font-size: 36px;
            color: #003366;
            text-align: center;
            margin: 10px 0;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        .patient-list {
            margin-top: 30px;
            padding: 0;
            list-style-type: none;
        }

        .patient-list li {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .patient-list li strong {
            display: block;
            margin-bottom: 5px;
        }

        .patient-list li:hover {
            background-color: #f1f1f1;
        }

        .FunctionContainer {
            display: inline-block;
            margin: 20px 0;
            width: 350px;
            height: 50px;
            flex-direction: row;
        }

        button, .add-patient-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background-color: #3ef57e;
            color: white;
            width: 200px;
            height: 50px;
            border-radius: 25px;
            padding: 0 15px;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            border: none;
        }

        .add-patient-btn:hover {
            background-color: #32d96b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Patient Management</h1>
        <hr>

        <!-- Add Patient Button -->
        <a href="Add_PAtient.php" class="add-patient-btn">Add  Patient</a>

        <h2>Patient List</h2>
        <ul class="patient-list">
            <?php
            foreach ($patients as $patient) {
                $patientId = $patient['Patient_Id'];
                $firstName = $patient['First_name'];
                $lastName = $patient['Last_name'];
                $contactNo = $patient['Contact_No'];
                $email = $patient['Email'];
                $image = $patient['Image'];

                // Creating a link to the patient details page
                echo "<li>
                        <a href='patient_details.php?patient_id=$patientId'>
                            <strong>$firstName $lastName</strong>
                            <span>Contact: $contactNo</span>
                            <span>Email: $email</span>
                            <img src='$image' alt='Patient Image' class='ImgHeath'>
                        </a>
                      </li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
