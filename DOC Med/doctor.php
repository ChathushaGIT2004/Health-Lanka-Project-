<?php 
$doctorID = $_GET['doctor_id'];
 
include '../DBConnection.php';

// Query to fetch doctor details
$query = "SELECT * FROM doctors WHERE DoctorID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $doctorID); 
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

if (!$doctor) {
    echo "Doctor not found.";
    exit;
}

$sql = "SELECT SUM(`Rate`) AS total_rate, COUNT(`Rate`) AS total_meetups FROM `patient-doctor meetups` WHERE `Doctor ID` = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $doctorID); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["total_meetups"] > 0) {
            $average_rate = $row["total_rate"] / $row["total_meetups"];
            $Rat = number_format($average_rate, 2);
        } else {
            $Rat = "No ratings available";
        }
    }
} else {
    $Rat = "No ratings available";
}

// Query to fetch specializations of the doctor
$query_specializations = "SELECT s.Name AS Specialization_Name
                          FROM `doctor-specialization` ds
                          JOIN `specialization` s ON ds.`Specilization ID` = s.`Specilizaton ID`
                          WHERE ds.`Doctor  ID` = ?";
$stmt = $con->prepare($query_specializations);
$stmt->bind_param("i", $doctorID);  
$stmt->execute();
$result_specializations = $stmt->get_result();

// Check if there are any specializations
$specializations = [];
if ($result_specializations->num_rows > 0) {
    while ($row = $result_specializations->fetch_assoc()) {
        $specializations[] = htmlspecialchars($row['Specialization_Name']);
    }
} else {
    $specializations[] = "None"; // If no specializations found, set as "None"
}

// Query to fetch Assigned Hospitals
$query_Hospitals = "SELECT h.`Name` AS Hospital_Name
                    FROM `doctor-hospital` dh
                    JOIN `hospital` h ON h.`Hospital ID` = dh.`Hospital ID`
                    WHERE dh.`Doctor  ID` = ?";
$stmt = $con->prepare($query_Hospitals);
$stmt->bind_param("i", $doctorID);  
$stmt->execute();
$result_hospitals = $stmt->get_result();

// Check if there are any assigned hospitals
$HospitalsName = [];
if ($result_hospitals->num_rows > 0) {
    while ($row = $result_hospitals->fetch_assoc()) {
        $HospitalsName[] = htmlspecialchars($row['Hospital_Name']);
    }
} else {
    $HospitalsName[] = "None";
}

$stmt->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin-top:150px;
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: auto;
        }

        /* Header Section */
        .header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
            margin-bottom: 20px;
        }

        .header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px; /* Reduced the gap between image and text */
        }

        .doctor-info {
            display: flex;
            flex-direction: column;
            gap: 5px; /* Reduced the gap between text elements */
        }

        .doctor-info h1 {
            font-size: 28px;
            font-weight: 600;
            color: #00509e;
        }

        .doctor-info p {
            font-size: 16px;
            color: #555;
        }

        .doctor-info .rating {
            font-size: 18px;
            color: #f4b400;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }

        .specialization-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .specialization-section h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #00509e;
        }

        .specialization-section ul {
            list-style: none;
            padding-left: 0;
            margin-top: 10px;
        }

        .specialization-section li {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            background-color: #e4f2ff;
            padding: 8px;
            border-radius: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }

            .doctor-info {
                text-align: center;
            }
        }
    </style>
</head>
<body>
<img src="../Essentials/MainLogo.png" style="display: block; margin: 10px; width: 200px;">

    <div class="container">
        <!-- Doctor Header Section -->
        <div class="header">
            <img src="<?= htmlspecialchars($doctor['Image']) ? htmlspecialchars($doctor['Image']) : 'default-image.jpg'; ?>" alt="Doctor Image">
            <div class="doctor-info">
                <h1>Dr. <?= htmlspecialchars($doctor['FirstName']); ?> <?= htmlspecialchars($doctor['LastName']); ?></h1>
                <p><strong>License No:</strong> <?= htmlspecialchars($doctor['DoctorID']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($doctor['Email']); ?></p>
                <p class="rating"><?= htmlspecialchars($Rat); ?></p>
            </div>
        </div>

        <!-- Specialization Section -->
        <div class="specialization-section">
            <h2>Specializations:</h2>
            <ul>
                <?php
                foreach ($specializations as $specialization) {
                    echo "<li>" . $specialization . "</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Hospital Section -->
        <div class="specialization-section">
            <h2>Available  Hospitals:</h2>
            <ul>
                <?php
                foreach ($HospitalsName as $HospitalsName1) {
                    echo "<li>" . $HospitalsName1 . "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
