<?php 
include 'Admin_navbar.php';
?>
<?php
    // Database connection
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "dev"; 
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to count doctors
    $sql = "SELECT COUNT(*) AS doctor_count FROM doctors";
    $result = $conn->query($sql);
    $doctor_count = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $doctor_count = $row['doctor_count'];
    }

    // Query to count patients
    $patient_sql = "SELECT COUNT(*) AS patient_count FROM patient";
    $patient_result = $conn->query($patient_sql);
    $patient_count = 0;

    if ($patient_result->num_rows > 0) {
        $row = $patient_result->fetch_assoc();
        $patient_count = $row['patient_count'];
    }

    // Query to count hospitals
    $hospital_sql = "SELECT COUNT(*) AS hospital_count FROM hospital";
    $hospital_result = $conn->query($hospital_sql);
    $hospital_count = 0;

    if ($hospital_result->num_rows > 0) {
        $row = $hospital_result->fetch_assoc();
        $hospital_count = $row['hospital_count'];
    }

    // Query to count medicines
    $medicine_sql = "SELECT COUNT(*) AS medicine_count FROM medicinedetails";
    $medicine_result = $conn->query($medicine_sql);
    $medicine_count = 0;

    if ($medicine_result->num_rows > 0) {
        $row = $medicine_result->fetch_assoc();
        $medicine_count = $row['medicine_count'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthNet: Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 200px;
            padding: 0;
            display: flex;
            flex-direction:column;
            align-items: center;

        }

        .FunctionContainer {

            margin-top: 200px;
            display: flex;
            justify-content: center;
            margin: 20px 0;
            width: 350px;
            height: 50px;
        }

        .FunctionContainer a {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            text-decoration: none;
            background-color: #3ef57e;
            color: white;
            width: 300px;
            height: 50px;
            border-radius: 25px;
            padding: 0 15px;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .FunctionContainer a:hover {
            background-color: #3ea57e;
        }

        .FunctionContainer img {
            border-radius: 100%;
            height: 40px;
            width: 40px;
            margin-right: 15px;
        }

        .FunctionContainer h1 {
            font-size: 18px;
            margin: 0;
        }

        .Healthnet {
            margin: 20px 0;
            width: 150px;
            height: auto;
        }

        .summaryContainer {
            margin-top: 300px;
            margin-left: 15%;
            margin-right: 15%;
            width: 70%;
            background-color: aqua;
        }

        .Summary {
            margin-top: 200px;
            background-color: #ffffff;
            margin: 20px;
            padding: 20px;
            width:150px;
            height: 250px;
            border-color: #3ef57e;
            border-radius: 15px;
            display: inline-block;
            align-items: center;
            justify-content: flex-start;
            box-shadow: 0 4px 6px rgba(62, 245, 126, 0.5);
        }

        .Summary img {
            border-radius: 50%;
            height:150px;  
            width: 150px;
            margin-right: 0px;
        }

        .Summary h1 {
            font-size: 22px;
            color:#3ef57e;
            margin: 0;
            text-align: center;
        }

        .Summary h2 {
            color: rgba(0, 0, 0, 0.6);
            font-size: 14px;
            align-self: center;
            text-shadow: #3ea57e;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .FunctionContainer a {
                width: 250px;
                padding: 0 10px;
            }

            .FunctionContainer img {
                height: 30px;
                width: 30px;
            }

            .FunctionContainer h1 {
                font-size: 16px;
            }

            .Summary {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .Summary img {
                margin: 0 0 15px 0;
            }

            .Summary h1 {
                font-size: 18px;
                align-self: center;
            }

            .Summary h2 {
                color: blue;
                font-size: 14px;
                align-self: center;
                text-shadow: #3ea57e;
            }
        }
    </style>
</head>
<body>
     
    <div class="SummaryContainer">
        <!-- Doctors Count -->
        <div class="Summary">
            <img src="Images/1.png" alt="Doctors Icon">
            <h1><?php echo $doctor_count; ?></h1>
            <h2>Registered Doctors</h2>
        </div>

        <!-- Patients Count -->
        <div class="Summary">
            <img src="Images/3.png" alt="Patients Icon">
            <h1><?php echo $patient_count; ?></h1>
            <h2>Registered Patients</h2>
        </div>

        <!-- Hospitals Count -->
        <div class="Summary">
            <img src="Images/5.png" alt="Hospitals Icon">
            <h1><?php echo $hospital_count; ?></h1>
            <h2>Registered Hospitals</h2>
        </div>

        <!-- Medicines Count -->
        <div class="Summary">
            <img src="Images/4.png" alt="Medicines Icon">
            <h1><?php echo $medicine_count; ?></h1>
            <h2>Registered Medicines</h2>
        </div>
    </div>

</body>
</html>
