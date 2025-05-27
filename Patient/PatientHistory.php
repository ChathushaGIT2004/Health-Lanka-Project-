<?php 
// Get PatientID from URL
$PatientID = $_GET['PatientID'];

// Include DB connection
include "../DBConnection.php";
include "patientnarbar.php";

// Query to get Patient-Doctor Meetups with required details
$query = "
    SELECT 
        `MeetUp ID`, 
        `Doctor ID`, 
        `Diagnoze Name`, 
        `Rate`, 
        CONCAT(`doctors`.`FirstName`, ' ', `doctors`.`LastName`) AS `DoctorName`
    FROM `patient-doctor meetups`
    LEFT JOIN `doctors` ON `doctors`.`DoctorID` = `patient-doctor meetups`.`Doctor ID`
    WHERE `Patient ID` = ?";
    
$stmt = $con->prepare($query);
$stmt->bind_param("i", $PatientID);
$stmt->execute();
$meetups = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient History - Meetups</title>
    <style>
        /* Basic styles for table */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 30px;
            color: #009879;
            margin-bottom: 20px;
        }

        .meetup-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            cursor: pointer; /* Make the table rows clickable */
        }

        .meetup-table th, .meetup-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .meetup-table th {
            background-color: #009879;
            color: white;
        }

        .meetup-table tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }

        .btn-rate {
            background-color: #009879;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-rate:hover {
            background-color: #007c60;
        }
    </style>
    <script>
        // JavaScript to handle row click and redirect to detail page
        function viewMeetupDetails(meetupId) {
            window.location.href = 'meetup_details.php?PatientID=' + <?php echo $PatientID; ?> + '&MeetUpID=' + meetupId;

        }
    </script>
</head>
<body>

    <div class="container">
        <h1>Patient History - Meetups</h1>

        <!-- Patient Doctor Meetups Table -->
        <table class="meetup-table">
            <thead>
                <tr>
                    <th>MeetUp ID</th>
                    <th>Doctor ID</th>
                    <th>Doctor Name</th>
                    <th>Diagnosis Name</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($meetup = $meetups->fetch_assoc()) { ?>
                    <tr onclick="viewMeetupDetails(<?= $meetup['MeetUp ID']; ?>)">
                        <td><?= htmlspecialchars($meetup['MeetUp ID']); ?></td>
                        <td><?= htmlspecialchars($meetup['Doctor ID']); ?></td>
                        <td><?= htmlspecialchars($meetup['DoctorName']); ?></td>
                        <td><?= htmlspecialchars($meetup['Diagnoze Name']); ?></td>
                        <td>
                            <?php if ($meetup['Rate'] == 0) { ?>
                                <button class="btn-rate" onclick="window.location.href='rate.php?MeetUpID=<?= $meetup['MeetUp ID']; ?>'">Rate</button>
                            <?php } else { ?>
                                <?= htmlspecialchars($meetup['Rate']); ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
