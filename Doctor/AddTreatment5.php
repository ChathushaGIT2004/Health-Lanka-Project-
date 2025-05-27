<?php
// Include database connection
include_once "../DBConnection.php";

// Initialize variables
$DoctorID = $_POST['DoctorID'] ?? '';
$patientId = $_POST['patientId'] ?? '';
$DiagnosisName = $_POST['DiagnosisName'] ?? '';
$DiagnosisDescription = $_POST['DiagnosisDescription'] ?? '';
$TreatmentDescription = $_POST['TreatmentDescription'] ?? '';
$ImportantNotes = $_POST['ImportantNotes'] ?? '';
$HospitalID = $_POST['HospitalID'] ?? "";
$dispensedMedicines = isset($_POST['dispense_medicines']) ? json_decode($_POST['dispense_medicines'], true) : [];
if (!is_array($dispensedMedicines)) {
    $dispensedMedicines = [];  // Ensure it's an empty array if decoding fails
}

$message = "";
$errorMessage = "";

// Handle form submission

    // Begin database transaction
    $con->begin_transaction();
    date_default_timezone_set('Asia/Colombo');
    $localDate = date('Y-m-d');
    try {
        // Insert treatment details into the database
        $query1 = "INSERT INTO `patient-doctor meetups` (`Patient ID`, `Doctor ID`,`Host`, `Date`, `Diagnoze Name`, `Diagnoze Description`, `Treatment Description`, `Important Notes`)
    VALUES (?, ?, ?,?, ?, ?, ?, ?)";
        $stmt1 = $con->prepare($query1);
        $stmt1->bind_param("ssssssss", $patientId, $DoctorID, $HospitalID, $localDate, $DiagnosisName, $DiagnosisDescription, $TreatmentDescription, $ImportantNotes);
        $stmt1->execute();
        
        // Get the ID of the inserted treatment
        $treatmentID = $con->insert_id;

        // Insert dispensed medicines into the database
        foreach ($dispensedMedicines as $medicine) {
            // Corrected query with backticks around column names
            $stmt3 = $con->prepare("INSERT INTO `dispence-medicine`(`MeetUp ID`, `Medicine ID`, `times`, `per time`, `Notes`)
            VALUES (?, ?, ?, ?, ?)");
            
            $stmt3->bind_param(
                "isiss",
                $treatmentID,
                $medicine['MedicineID'],
                $medicine['TimesPerDay'],
                $medicine['QuantityPerTime'],
                $medicine['Notes']
            );
            $stmt3->execute();
        }

        // Commit the transaction
        $con->commit();

        // Redirect with success message
        
       
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $con->rollback();
        $errorMessage = "Failed to save treatment data: " . $e->getMessage();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
        echo "<script>alert('Successful');</script>";
        header("Location: Doctor_Page.php?DoctorID=" . urlencode($DoctorID) . "&HospitalID=" . urlencode($HospitalID));
        exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Treatment and Medicines</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Modern and Clean CSS Design */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #007BFF;
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            color: #333;
            background-color: #f7f7f7;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #007bff;
            background-color: #ffffff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        button:hover {
            background: linear-gradient(90deg, #00c6ff, #007bff);
            transform: scale(1.05);
        }

        /* Table Design */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 1rem;
            color: #555;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }

        table tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        table tr:hover {
            background-color: #eaeaea;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.6rem;
            }

            input, textarea, select {
                font-size: 0.95rem;
            }

            button {
                font-size: 1rem;
            }

            table th, table td {
                font-size: 0.9rem;
            }

            table {
                font-size: 0.9rem;
                margin-top: 15px;
            }

            .form-section {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Confirm Treatment and Medicines</h2>

    <?php if ($message): ?>
        <div class="alert success"><?= htmlspecialchars($message); ?></div>
    <?php elseif ($errorMessage): ?>
        <div class="alert error"><?= htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="DoctorID" value="<?= htmlspecialchars($DoctorID); ?>">
        <input type="hidden" name="patientId" value="<?= htmlspecialchars($patientId); ?>">
        <input type="hidden" name="HospitalID" value="<?= htmlspecialchars($HospitalID); ?>">

        <div class="form-section">
            <h3>Patient Information</h3>
            <p><strong>Patient ID:</strong> <?= htmlspecialchars($patientId); ?></p>
            <p><strong>Doctor ID:</strong> <?= htmlspecialchars($DoctorID); ?></p>
            <p><strong>Host By:</strong> <?= htmlspecialchars($HospitalID); ?></p>
        </div><br><br>

        <div class="form-section">
            <h3>Treatment Information</h3>
            <p><strong>Diagnosis Name:</strong> <?= htmlspecialchars($DiagnosisName); ?></p>
            <p><strong>Diagnosis Description:</strong> <?= htmlspecialchars($DiagnosisDescription); ?></p>
            <p><strong>Treatment Description:</strong> <?= htmlspecialchars($TreatmentDescription); ?></p>
            <p><strong>Important Notes:</strong> <?= htmlspecialchars($ImportantNotes); ?></p>
        </div><br><br>

        <div class="form-section">
            <h3>Dispensed Medicines</h3>
            <?php if (!empty($dispensedMedicines)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Medicine ID</th>
                            <th>Medicine Name</th>
                            <th>Times Per Day</th>
                            <th>Quantity Per Time</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dispensedMedicines as $medicine): ?>
                            <tr>
                                <td><?= htmlspecialchars($medicine['MedicineID']); ?></td>
                                <td><?= htmlspecialchars($medicine['MedicineName']); ?></td>
                                <td><?= htmlspecialchars($medicine['TimesPerDay']); ?></td>
                                <td><?= htmlspecialchars($medicine['QuantityPerTime']); ?></td>
                                <td><?= htmlspecialchars($medicine['Notes']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No medicines to display.</p>
            <?php endif; ?>
        </div>

        <div class="form-section">
            <label class="checkbox-label" for="confirm">
                <input type="checkbox" name="confirm" id="confirm" value="1" required>
                I confirm that the information is correct.
            </label>
            <button type="submit">Confirm Treatment</button>
        </div>
    </form>
</div>

</body>
</html>
