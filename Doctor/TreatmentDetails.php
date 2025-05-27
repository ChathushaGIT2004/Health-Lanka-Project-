<?php
include_once "../DBConnection.php";

$ID = $_GET['ID'] ?? null; // Get MeetUp ID from URL
if (!$ID) {
    die("Invalid request. MeetUp ID is missing.");
}

// Fetch treatment details
$query1 = "SELECT * FROM `patient-doctor meetups` WHERE `MeetUp ID` = ?";
$stmt1 = $con->prepare($query1);
$stmt1->bind_param("i", $ID);
$stmt1->execute();
$result1 = $stmt1->get_result();
$rs1 = $result1->fetch_assoc();

if (!$rs1) {
    die("No treatment details found for the given MeetUp ID.");
}

$PatientID = $rs1['Patient ID'];

// Fetch patient information
$query2 = "SELECT * FROM `patient` WHERE `Patient_Id` = ?";
$stmt2 = $con->prepare($query2);
$stmt2->bind_param("i", $PatientID);
$stmt2->execute();
$result2 = $stmt2->get_result();
$rs2 = $result2->fetch_assoc();

$PatientName = $rs2['First_name'] . " " . $rs2['Last_Name'];

// Fetch dispensed medicines
$query3 = "SELECT * FROM `dispence-medicine` WHERE `MeetUp ID` = ?";
$stmt3 = $con->prepare($query3);
$stmt3->bind_param("i", $ID);
$stmt3->execute();
$result3 = $stmt3->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Treatment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #009879;
            color: white;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        .details p {
            margin: 10px 0;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #009879;
            color: white;
        }
        table tbody tr:nth-of-type(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="../Healthnet.png" alt="Healthnet Logo" style="max-width: 120px;">
        <h1>Treatment History</h1>
    </div>
    <div class="container">
        <!-- Patient Information -->
        <h2>Patient Information</h2>
        <div class="details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($PatientName ?? "N/A"); ?></p>
            <p><strong>Patient ID:</strong> <?php echo htmlspecialchars($PatientID ?? "N/A"); ?></p>
        </div>

        <!-- Treatment Details -->
        <h2>Treatment Details</h2>
        <div class="details">
            <p><strong>MeetUp ID:</strong> <?php echo htmlspecialchars($rs1['MeetUp ID'] ?? "N/A"); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($rs1['Date'] ?? "N/A"); ?></p>
            <p><strong>Diagnosis Name:</strong> <?php echo htmlspecialchars($rs1['Diagnoze Name'] ?? "N/A"); ?></p>
            <p><strong>Diagnosis Description:</strong> <?php echo htmlspecialchars($rs1['Diagnoze Description'] ?? "N/A"); ?></p>
            <p><strong>Treatment Description:</strong> <?php echo htmlspecialchars($rs1['Treatment Description'] ?? "N/A"); ?></p>
            <p><strong>Important Notes:</strong> <?php echo htmlspecialchars($rs1['Important Notes'] ?? "N/A"); ?></p>
        </div>

                <!-- Dispensed Medicines -->
                <h2>Dispensed Medicines</h2>
        <?php if ($result3 && $result3->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Times</th>
                        <th>Per Time</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row3 = $result3->fetch_assoc()): ?>
                        <tr>
                            <?php
                            // Fetch medicine name from `medicinedetails` table
                            $MEDID = $row3['Medicine ID'];
                            $query4 = "SELECT MedicineName FROM `medicinedetails` WHERE `MedicineID` = ?";
                            $stmt4 = $con->prepare($query4);
                            $stmt4->bind_param("i", $MEDID);
                            $stmt4->execute();
                            $result4 = $stmt4->get_result();
                            $rs4 = $result4->fetch_assoc();
                            $MedicineName = $rs4['MedicineName'] ?? "Unknown Medicine";
                            ?>
                            <td><?php echo htmlspecialchars($MedicineName); ?></td>
                            <td><?php echo htmlspecialchars($row3['times'] ?? "N/A"); ?></td>
                            <td><?php echo htmlspecialchars($row3['per time'] ?? "N/A"); ?></td>
                            <td><?php echo htmlspecialchars($row3['Notes'] ?? "N/A"); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No medicines were dispensed for this treatment.</p>
        <?php endif; ?>

    </div>
</body>
</html>
