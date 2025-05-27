<?php 
// Get PatientID from URL
$PatientID = $_GET['PatientID'];

// Include DB connection
include "../DBConnection.php";
include "patientnarbar.php";

// Fetch Patient Data
$query1 = "SELECT * FROM patient WHERE Patient_Id = ?";
$stmt1 = $con->prepare($query1);
$stmt1->bind_param("i", $PatientID);
$stmt1->execute();
$patient1 = $stmt1->get_result()->fetch_assoc();

// Define Normal Levels (standard or reference levels)
$normalDiabeticLevel = 100;  // Normal range for Diabetic level (in Mg/DL)
$normalCholesterolLevel = 200;  // Normal range for Cholesterol (in Mg/DL)
$normalBloodPressure = 120;  // Normal range for Blood Pressure (in mmHg)

$query2 = "
    SELECT * 
    FROM `patient-doctor meetups` PDM
    WHERE PDM.`Patient ID` = ?
    ORDER BY PDM.`Date` DESC
    LIMIT 5
";

$stmt2 = $con->prepare($query2);
$stmt2->bind_param("i", $PatientID);
$stmt2->execute();
$patient2 = $stmt2->get_result();

// Fetch patient allergies
$query3 = "SELECT a.Name FROM `patient-allergy` AS p
           JOIN allergy AS a ON a.`Allergy ID` = p.`Allergy ID`
           WHERE p.`Patient ID` = ?";
$stmt3 = $con->prepare($query3);
$stmt3->bind_param("i", $PatientID);
$stmt3->execute();
$result3 = $stmt3->get_result();

if ($result3->num_rows > 0) {
    $patientAllergies = [];
    while ($row3 = $result3->fetch_assoc()) {
        $patientAllergies[] = $row3['Name'];
    }
} else {
    $patientAllergies = []; // No allergies found
}

// Get report details
$query4 = "SELECT * FROM  `patient-report` WHERE `Patient ID` = ? ORDER BY `Date` DESC";
$stmt4 = $con->prepare($query4);
$stmt4->bind_param("s", $PatientID);
$stmt4->execute();
$result4 = $stmt4->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patient Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100%;
            background: #f4f7fc; /* Light background for a modern, clean look */
            color: #333; /* Darker text for better readability */
            box-sizing: border-box;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 0px; /* Removed margin-left for navbar */
            padding: 20px;
            max-width: 100%;  /* Ensure the content doesn't exceed the screen width */
            width: 100%;  /* Adjusted width */
            background-color: #f4f4f9;
            flex-grow: 1; /* Allow the content area to grow when screen size changes */
        }

        /* Section Layout */
        .section {
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #009879;
        }

        .section .detail {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
        }

        /* Patient Image and Name */
        .patient-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .patient-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover; /* Ensures the image fits properly within the circle */
        }

        .patient-header h1 {
            font-size: 28px;
            color: #333;
        }

        /* Health Information */
        .health-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap; /* Allows wrapping for smaller screens */
        }

        .health-info .info {
            width: 48%;
            margin-bottom: 20px; /* Adding space between sections on smaller screens */
        }

        .health-info .info h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #009879;
        }

        /* Progress Bar Container */
        .progress-container {
            width: 100%;
            height: 20px;
            background-color: #ddd;
            border-radius: 10px;
            margin-top: 5px;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            border-radius: 10px;
            text-align: center;
            line-height: 20px;
            color: white;
            font-size: 12px;
            padding-right: 5px;
        }

        /* Recent Activities Section */
        .activities {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .activities h2 {
            font-size: 24px;
            color: #009879;
        }

        .activity-item {
            padding: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #009879;
            background-color: #f9f9f9;
        }

        .activity-item h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }

        .activity-item p {
            font-size: 16px;
            color: #555;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-content {
                width: calc(100%);  /* Adjust content width for smaller screens */
            }

            .health-info .info {
                width: 100%;  /* Full width on smaller screens */
            }
        }

        @media (max-width: 900px) {
            .main-content {
                width: calc(100%);  /* Adjust content width for smaller screens */
            }

            .health-info .info {
                width: 100%;
            }

            .section h2 {
                font-size: 22px;
            }

            .section .detail {
                font-size: 16px;
            }

            .progress-bar {
                font-size: 10px;
            }
        }

        @media (max-width: 600px) {
            body {
                flex-direction: column;  /* Stack navbar and content vertically on very small screens */
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .health-info {
                flex-direction: column;
            }

            .health-info .info {
                width: 100%;
                margin-bottom: 20px;
            }

            .main-content h1 {
                font-size: 24px;
            }

            .section h2 {
                font-size: 20px;
            }

            .section .detail {
                font-size: 14px;
            }
        }

        @media (max-width: 400px) {
            .main-content h1 {
                font-size: 20px;
            }

            .section h2 {
                font-size: 18px;
            }

            .section .detail {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Patient Header Section -->
        <div class="patient-header">
            <!-- Patient Image -->
            <?php 
            // Check if there is an image, else display a placeholder
            $patientImage = !empty($patient1['Image']) ? $patient1['Image'] : '../Patient Images/default.jpg';
            ?>
            <img src="<?= htmlspecialchars($patientImage); ?>" alt="Patient Image">
            <h1>Patient: <?= htmlspecialchars($patient1['Name']); ?></h1>
        </div>

        <!-- Health Information Section -->
        <div class="health-info">
            <div class="info">
                <h3>Diabetic Level</h3>
                <p>Current Level: <?= htmlspecialchars($patient1['Diabetic_Level']); ?> mg/dL</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?= min(100, ($patient1['Diabetic_Level'] / $normalDiabeticLevel) * 100); ?>%; background-color: <?= ($patient1['Diabetic_Level'] > $normalDiabeticLevel) ? 'red' : 'green'; ?>;">
                        <?= htmlspecialchars($patient1['Diabetic_Level']); ?> mg/dL
                    </div>
                </div>
            </div>

            <div class="info">
                <h3>Cholesterol Level</h3>
                <p>Current Level: <?= htmlspecialchars($patient1['Cholesterol_Level']); ?> mg/dL</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?= min(100, ($patient1['Cholesterol_Level'] / $normalCholesterolLevel) * 100); ?>%; background-color: <?= ($patient1['Cholesterol_Level'] > $normalCholesterolLevel) ? 'red' : 'green'; ?>;">
                        <?= htmlspecialchars($patient1['Cholesterol_Level']); ?> mg/dL
                    </div>
                </div>
            </div>
        </div>

        <!-- Allergies Section -->
        <div class="section">
            <h2>Allergies</h2>
            <ul>
                <?php if (count($patientAllergies) > 0): ?>
                    <?php foreach ($patientAllergies as $allergy): ?>
                        <li><?= htmlspecialchars($allergy); ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No known allergies.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Doctor Visits Section -->
        <div class="activities">
            <h2>Recent Doctor Visits</h2>
            <?php while ($row2 = $patient2->fetch_assoc()): ?>
                <div class="activity-item">
                    <h3>Visit to Dr. <?= htmlspecialchars($row2['Doctor Name']); ?></h3>
                    <p><strong>Visit Date:</strong> <?= htmlspecialchars($row2['Date']); ?></p>
                    <p><strong>Symptoms:</strong> <?= htmlspecialchars($row2['Symptoms']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

     <!-- Reports Section -->
<div class="section">
    <h2>Recent Reports</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Report Type</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Make sure $result4 contains the query result
            while ($row4 = $result4->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row4['Date']); ?></td>
                    <td><?= htmlspecialchars($row4['Report_Type']); ?></td>
                    <td><?= htmlspecialchars($row4['Details']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


    </div>

</body>
</html>
