<?php
// Include database connection
include "../DBConnection.php";

if (isset($_GET['patient_id'])) {
    $patientId = $_GET['patient_id'];

    // Prepare SQL query to fetch medical history
    $sql = "SELECT `MeetUp ID`, `Patient ID`, `Doctor ID`, `Host`, `Date`, `Diagnoze Name`, 
            `Diagnoze Description`, `Treatment Description`, `Important Notes`, `Rate`
            FROM `patient-doctor meetups`
            WHERE `Patient ID` = ?
            ORDER BY `Date` DESC"; // Corrected ORDER BY

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $patientId); // 'i' for integer
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        td a {
            color: #4CAF50;
            text-decoration: none;
        }
        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<img src="Essentials/MainLogo.png" class="Healthnet" alt="HealthNet Logo"><br>

    <div class="container">
        <h1>Medical History for Patient ID: <?php echo htmlspecialchars($patientId); ?></h1>
        
        <table>
            <thead>
                <tr>
                    <th>MeetUp ID</th>
                    <th>Doctor ID</th>
                    <th>Date</th>
                    <th>Diagnosis</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($result) && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['MeetUp ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Doctor ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Diagnoze Name']); ?></td>
                            <td><a href="medicine_details.php?meetup_id=<?php echo $row['MeetUp ID']; ?>">View Medicine Details</a></td>
                        </tr>
                <?php endwhile; 
                } else {
                    echo '<tr><td colspan="5" style="text-align:center;">No medical history found for this patient.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
