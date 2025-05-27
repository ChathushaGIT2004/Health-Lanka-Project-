<?php 
// Get PatientID from URL
$PatientID = $_GET['PatientID'];

// Include DB connection
include "../DBConnection.php";
include "patientnarbar.php";

// Fetch Patient Data
$query1 = "SELECT * FROM patient WHERE Patient_Id = ?";
$stmt1 = $con->prepare($query1);
$stmt1->bind_param("s", $PatientID);
$stmt1->execute();
$patient1 = $stmt1->get_result()->fetch_assoc();

// Define Normal Levels (standard or reference levels)
$normalDiabeticLevel = 100;  // Normal range for Diabetic level (in Mg/DL)
$normalCholesterolLevel = 200;  // Normal range for Cholesterol (in Mg/DL)
$normalBloodPressure = 120;  // Normal range for Blood Pressure (in mmHg)

// Fetch Doctor Meetups
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
$stmt3->bind_param("i", $PatientID); // Corrected variable name
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

// Fetch recent reports
$query4 = "SELECT `Patient ID`, `Issued By`, `Report Name`, `Report Descrtiotion`, `Date`, `Report File` 
           FROM `patient-report` WHERE `Patient ID` = ? ORDER BY `Date` DESC";
$stmt4 = $con->prepare($query4);
$stmt4->bind_param("i", $PatientID);
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
            color: #8cc342;
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
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f6f9;
    color: #333;
}

/* Section Styling */
.section {
    margin: 30px auto;
    max-width: 1200px;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h2 {
    font-size: 24px;
    font-weight: bold;
    color: #2980b9;
    margin-bottom: 20px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table thead {
    background-color: #2980b9;
    color: #fff;
}

table th,
table td {
    padding: 15px;
    text-align: left;
    font-size: 16px;
    border-bottom: 1px solid #ddd;
}

table th {
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

 table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

/* Links */
 table a {
    color: #2980b9;
    text-decoration: none;
    font-weight: bold;
}

 table a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    table th,table td {
        padding: 10px;
        font-size: 14px;
    }

    table tbody tr {
        font-size: 14px;
    }
}

@media (max-width: 500px) {
    .section {
        padding: 15px;
    }

    table {
        font-size: 12px;
    }

    h2 {
        font-size: 20px;
    }
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
        <img src="<?php echo $patient1['Image']; ?>" alt="Patient Image">

            <h1>Patient Dashboard: <?= htmlspecialchars($patient1['First_name']); ?> <?= htmlspecialchars($patient1['Last_Name']); ?></h1>
        </div>

        <!-- Personal Information Section -->
        <div class="section">
            <h2>Personal Information</h2>
            <div class="detail"><strong>Patient ID:</strong> <?= htmlspecialchars($patient1['Patient_Id']); ?></div>
            <div class="detail"><strong>First Name:</strong> <?= htmlspecialchars($patient1['First_name']); ?></div>
            <div class="detail"><strong>Last Name:</strong> <?= htmlspecialchars($patient1['Last_Name']); ?></div>
            <div class="detail"><strong>Gender:</strong> <?= htmlspecialchars($patient1['Gender']); ?></div>
            <div class="detail"><strong>Contact No:</strong> <?= htmlspecialchars($patient1['Contact_No']); ?></div>
            <div class="detail"><strong>Email:</strong> <?= htmlspecialchars($patient1['Email']); ?></div>
            <div class="detail"><strong>Address:</strong> <?= htmlspecialchars($patient1['Address']); ?></div>
            <div class="detail"><strong>Emergency Contact:</strong> <?= htmlspecialchars($patient1['Emergency_Contact']); ?></div>
        </div>

        <!-- Health Information Section -->
        <div class="section">
            <h2>Health Information</h2>
            <div class="health-info">
                <div class="info">
                    <h3>Blood Type</h3>
                    <p><?= htmlspecialchars($patient1['Blood_Type']); ?></p>

                    <p><strong>Allergies:</strong>
                        <ul>
                            <?php foreach ($patientAllergies as $allergy) { echo "<li>" . htmlspecialchars($allergy) . "</li>"; } ?>
                        </ul>
                    </p>

                    <br><br>
                    <div class="section" onclick="window.location.href='DiabeticAnalyze.php?PatientID=<?php echo urlencode($PatientID); ?>';" style="cursor: pointer;">
                        <h3>Diabetic Type</h3>
                        <p><?= htmlspecialchars($patient1['Diabetic_Type']); ?></p>

                        <h3>Diabetic Level (Mg/DL)</h3>
                        <p><?= htmlspecialchars($patient1['Diabetic_level(Mg/DL)']); ?> Mg/Dl</p>
                        <?php 
                        $diabeticPercentage = (float)$patient1['Diabetic_level(Mg/DL)'] / $normalDiabeticLevel * 100;
                        ?>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: <?= $diabeticPercentage; ?>%; background-color: rgba(255, 99, 132, 0.6);">
                                <?= number_format($diabeticPercentage, 1); ?>%
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info">
                    <h3>Cholesterol Level (Mg/DL)</h3>
                    <p><?= htmlspecialchars($patient1['Cholosterol_Level(Mg/DL)']); ?> Mg/Dl</p>
                    <?php 
                    $cholesterolPercentage = (float)$patient1['Cholosterol_Level(Mg/DL)'] / $normalCholesterolLevel * 100;
                    ?>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?= $cholesterolPercentage; ?>%; background-color: rgba(54, 162, 235, 0.6);">
                            <?= number_format($cholesterolPercentage, 1); ?>%
                        </div>
                    </div>

                    <h3>Blood Pressure</h3>
                    <p><?= htmlspecialchars($patient1['Blood_Presure']); ?></p>
                    <?php 
                    $bloodPressure = (float)$patient1['Blood_Presure']; 
                    $bloodPressurePercentage = ($bloodPressure / $normalBloodPressure) * 100;
                    ?>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?= $bloodPressurePercentage; ?>%; background-color: rgba(75, 192, 192, 0.6);">
                            <?= number_format($bloodPressurePercentage, 1); ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities Section -->
        <div class="activities" onclick="window.location.href='PatientHistory.php?PatientID=<?php echo urlencode($PatientID); ?>';" style="cursor: pointer;">
            <h2>Recent Doctor Meetups</h2>
            <?php while ($activity = $patient2->fetch_assoc()) { ?>
                <div class="activity-item">
                    <h3><?= htmlspecialchars($activity['Diagnoze Name']); ?> on <?= htmlspecialchars($activity['Date']); ?></h3>
                    <p><?= htmlspecialchars($activity['Important Notes']); ?></p>
                </div>
            <?php } ?>
        </div>

        <!-- Reports Section -->
        <div class="section">
            <h2>Recent Reports</h2>
            <?php if ($result4->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Report Name</th>
                            <th>Issued By</th>
                            <th>Issued On</th>
                            <th>View Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row4 = $result4->fetch_assoc()) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row4['Report Name']); ?></td>
                                <td><?= htmlspecialchars($row4['Issued By']); ?></td>
                                <td><?= htmlspecialchars($row4['Date']); ?></td>
                                <td><a href="../Reports/<?= htmlspecialchars($row4['Report File']); ?>" target="_blank">View Report</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No recent reports available.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
