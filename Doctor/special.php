<?php
session_start();
include '../DBConnection.php';

// Get the DoctorID from the URL (if it's passed via GET request)
$doctorID = $_GET['DoctorID'] ?? null;
$HospitalID=$_GET['HospitalID'];
include "Doctor_navbar.php";

// Fetch existing specializations for the doctor
$query = "SELECT ds.`Specilization ID`, s.Name AS specialization_name, ds.Proof 
          FROM `doctor-specialization` ds
          JOIN `specialization` s ON ds.`Specilization ID` = s.`Specilizaton ID`
          WHERE ds.`Doctor  ID` = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $doctorID); // Bind the DoctorID to the query
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any specializations for this doctor
$specializations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $specializations[] = $row;
    }
} else {
    $specializations[] = ['specialization_name' => 'None', 'proof' => 'N/A']; // Default if no specializations found
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Specializations</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            position: inherit;
            margin-top: 80px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            padding: 30px;
        }

        h1 {
            font-size: 28px;
            color: #00509e;
            text-align: center;
            margin-bottom: 20px;
        }

        .specialization-list {
            margin-top: 30px;
        }

        .specialization-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .specialization-list th, .specialization-list td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .specialization-list th {
            background-color: #f4f4f4;
            color: #555;
        }

        .specialization-list td {
            color: #444;
        }

        .specialization-list td .proof {
            font-size: 12px;
            color: #888;
        }

        .add-button {
            margin-top: 30px;
            text-align: center;
        }

        .add-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #00b6a8;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border-radius: 8px;
        }

        .add-button button:hover {
            background-color: #009e8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Doctor Specializations Display -->
        <h1>Doctor Specializations</h1>
        
        <div class="specialization-list">
            <h2>Current Specializations</h2>
            <table>
                <thead>
                    <tr>
                        <th>Specialization</th>
                        <th>Proof</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($specializations as $specialization): ?>
                        <tr>
                            <td><?= htmlspecialchars($specialization['specialization_name']); ?></td>
                            <td class="proof">
                                <?php
                                    if (empty($specialization['Proof']) || $specialization['Proof'] == 'N/A') {
                                        echo "Not Proofed";
                                    } else {
                                        echo "<a href='" . htmlspecialchars($specialization['Proof']) . "' target='_blank'>View Proof</a>";
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add New Specialization Button -->
        <div class="add-button">
            <a href="add_specialization.php?DoctorID=<?= $doctorID ?>&HospitalID=<?=$HospitalID?>">
                <button>Add New Specialization</button>
            </a>
        </div>
    </div>
</body>
</html>
