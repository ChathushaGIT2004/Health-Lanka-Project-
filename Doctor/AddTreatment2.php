<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once "../DBConnection.php";

$patientId = $_GET['patientId'] ?? 0;
$DoctorID = $_GET["DoctorID"];
$HospitalID=$_GET['HospitalID'];
include "Doctor_navbar.php";

// Fetch patient details
$query = "SELECT * FROM `patient` WHERE `Patient_Id` = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $patientId);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();


 
// Fetch patient allergies
$query3 = "SELECT a.Name FROM `patient-allergy` AS p
           JOIN allergy AS a ON a.`Allergy ID` = p.`Allergy ID`
           WHERE p.`Patient ID` = ?";
$stmt3 = $con->prepare($query3);
$stmt3->bind_param("s", $patientId);
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

// Fetch treatment history with doctor details
$historyQuery = "SELECT `pdm`.`MeetUp ID`, `pdm`.`Date`, `pdm`.`Diagnoze Name`, `pdm`.`Treatment Description`, `d`.`DoctorID`, `d`.`FirstName` AS doctor_first_name, `d`.`LastName` AS doctor_last_name 
                 FROM `patient-doctor meetups` AS pdm
                 JOIN `doctors` AS d ON pdm.`Doctor ID` = d.`DoctorID`
                 WHERE `pdm`.`Patient ID` = ?";
$historyStmt = $con->prepare($historyQuery);
$historyStmt->bind_param("i", $patientId);
$historyStmt->execute();
$treatmentHistory = $historyStmt->get_result();

// Fetch Cholesterol data
$cholesterolQuery = "SELECT * FROM `patient-cholesterol` WHERE `Patient ID` = ? ORDER BY `Date` ASC";
$cholesterolStmt = $con->prepare($cholesterolQuery);
$cholesterolStmt->bind_param("i", $patientId);
$cholesterolStmt->execute();
$cholesterolResult = $cholesterolStmt->get_result();

$cholesterolData = [];
$dates = [];
$cholLevels = [];
$cholReports = [];

while ($row = $cholesterolResult->fetch_assoc()) {
    $cholesterolData[] = $row;
    $dates[] = $row['Date'];
    $cholLevels[] = $row['Cholesterol Level'];
    $cholReports[] = $row['Report'];  // Assuming report is a file path or name
}

// Fetch Blood Pressure data
$bpQuery = "SELECT * FROM `patient-blood-pressure` WHERE `Patient ID` = ? ORDER BY `Date`ASC";
$bpStmt = $con->prepare($bpQuery);
$bpStmt->bind_param("i", $patientId);
$bpStmt->execute();
$bpResult = $bpStmt->get_result();

$bpData = [];
$bpDates = [];
$systolicLevels = [];
$diastolicLevels = [];
$bpReports = [];

while ($row = $bpResult->fetch_assoc()) {
    $bpData[] = $row;
    $bpDates[] = $row['Date'];
    $systolicLevels[] = $row['Systolic'];
    $diastolicLevels[] = $row['Diastolic'];
    $bpReports[] = $row['Report'];  // Assuming report is a file path or name
}

// Fetch Diabetic data
$query1 = "SELECT * FROM `patient-diabetic` WHERE `Patient ID` = ? ORDER BY `Date` ASC";
$stmt1 = $con->prepare($query1);
$stmt1->bind_param("i", $patientId);
$stmt1->execute();
$result = $stmt1->get_result();

// Prepare data for the chart and table
$diabeticData = [];
$diabeticDates = [];
$diabeticLevels = [];
$diabeticReports = [];
while ($row = $result->fetch_assoc()) {
    $diabeticData[] = $row;
    $diabeticDates[] = $row['Date'];
    $diabeticLevels[] = $row['Diabetic Level'];
    $diabeticReports[] = $row['Report'];
}

function getColor($value, $low, $high) {
    if ($value < $low) {
        return "yellow";
    } elseif ($value > $high) {
        return "red";
    } else {
        return "green";
    }
}

function getPercentage($value, $min, $max) {
    $percentage = (($value - $min) / ($max - $min)) * 100;
    return max(0, min($percentage, 100)); // Ensure percentage is within 0-100%
}

//get reports details

$query4 = "SELECT * FROM  `patient-report` WHERE `Patient ID` = ? ORDER BY `Date` DESC";
$stmt4 = $con->prepare($query4);
$stmt4->bind_param("i", $patientId);
$stmt4->execute();
$result4 = $stmt4->get_result();






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details and Treatment History</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      /* Body and general styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #4f4f4f;
    line-height: 1.6;
    padding: 0;
}

/* Container */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

/* Header and Title */
h2 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    text-align: left ;
}

h3 {
    font-size: 1.3rem;
    font-weight: 500;
    color: #007bff;
    margin-bottom: 15px;
}

/* Button Styling */
.button {
    background: linear-gradient(90deg, #00aaff, #00c6ff);
    color: white;
    padding: 14px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    text-align: right;
     
    right: 200px;
}

.button:hover {
    background: linear-gradient(90deg, #00c6ff, #00aaff);
    transform: scale(1.05);
}

/* Section styling */
.section {
    margin-top: 40px;
    padding: 25px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.section h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #007bff;
    margin-bottom: 20px;
}

/* Health information section */
ul {
    list-style-type: square;
    padding-left: 20px;
}

/* Table Styling */
table {
    width: 100%;
    margin-top: 30px;
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #f0f0f0;
}

table th {
    background-color: #007bff;
    color: white;
}

table td {
    background-color: #f9f9f9;
}
tr:hover {
    background-color:#00c6ff;  
    cursor:pointer;  
}

tr:hover td {
    color: red;  
    font-weight: bold;  
}

/* Optional: Focus effect for accessibility */
tr:focus-within {
    background-color: rgba(0,0,0,0.4);
}

/* Progress Bar Styling */
.progress-bar {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.progress {
    width: 100%;
    height: 12px;
    background-color: #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    margin-right: 15px;
}

.progress-bar span {
    font-size: 1rem;
    color: #333;
    margin-right: 15px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .container {
        width: 95%;
        padding: 20px;
    }

    h2 {
        font-size: 1.8rem;
    }

    h3 {
        font-size: 1.1rem;
    }

    .button {
        padding: 12px 24px;
        font-size: 1rem;
        position: absolute;
    }

    .section h2 {
        font-size: 1.4rem;
    }

    table th, table td {
        font-size: 0.9rem;
    }

    .progress-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .progress {
        width: 100%;
        margin-bottom: 10px;
    }
}

@media (max-width: 768px) {
    .container {
        width: 100%;
        padding: 15px;
    }

    h2 {
        font-size: 1.6rem;
    }

    .button {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
    }

    .section {
        padding: 20px;
    }

    .section h2 {
        font-size: 1.3rem;
    }

    table {
        font-size: 0.9rem;
    }

    .progress-bar {
        flex-direction: column;
    }

    .progress {
        width: 100%;
        margin-bottom: 10px;
    }
}

@media (max-width: 480px) {
    .container {
        width: 100%;
        padding: 10px;
    }

    h2 {
        font-size: 1.4rem;
    }

    .button {
        padding: 10px 20px;
        font-size: 0.9rem;
    }

    .section h2 {
        font-size: 1.2rem;
    }

    table {
        font-size: 0.85rem;
    }

    .progress-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .progress {
        width: 100%;
        margin-bottom: 10px;
    }
}

/* Chart Section */
canvas {
    width: 100%;
    height: 400px;
    max-height: 400px;
}

/* Modal or Popup */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    border-radius: 8px;
}

.modal-close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.modal-close:hover,
.modal-close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

    </style>
</head>
<body>
    <div class="container">
        <button class="button" onclick="window.location.href='AddTreatment3.php?patientId=<?php echo $patientId; ?>&DoctorID=<?php echo $DoctorID; ?>&HospitalID=<?php echo $HospitalID?>';">Diagnose</button>
        
        <h2>Patient Details</h2><br>

        <div class="section">
        <img src="<?php echo $patient['Image']; ?>">
            <h2>Personal Information</h2>
            <p><strong>Name:</strong> <?php echo $patient['First_name'] . ' ' . $patient['Last_Name']; ?></p>
            <p><strong>Email:</strong> <?php echo $patient['Email']; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $patient['Date of birth']; ?></p>
            
            <p><strong>Address:</strong> <?php echo $patient['Address']; ?></p>
            <p><strong>Phone:</strong> <?php echo $patient['Contact_No']; ?></p>
        </div>

        <div class="section">
            <h2>Health Information</h2>
            <p><strong>Blood Type:</strong> <?php echo $patient['Blood_Type']; ?></p>
            <p><strong>Diabetic Type:</strong> <?php echo $patient['Diabetic_Type']; ?></p>
            <p><strong>Allergies:</strong><?php  
                echo "<ul>";
                foreach ($patientAllergies as $allergy) {
                    echo "<li>" . htmlspecialchars($allergy) . "</li>";
                }
                echo "</ul>";
            ?>
        </div>

        <div class="section">
            <h2>Treatment History</h2>
            <table>
                <thead>
                    <tr>
                        <th>MeetUp Date</th>
                        <th>Diagnosis</th>
                        <th>Treatment Description</th>
                        <th>Doctor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($historyRow = $treatmentHistory->fetch_assoc()) { ?>
                    <tr onclick="window.location.href='MeetupDetails.php?patientId=<?php echo $patientId; ?>&MeetupID=<?php echo  $historyRow['MeetUp ID']; ?>';">Diagnose</button>
                        <td><?php echo $historyRow['Date']; ?></td>
                        <td><?php echo $historyRow['Diagnoze Name']; ?></td>
                        <td><?php echo $historyRow['Treatment Description']; ?></td>
                        <td><?php echo $historyRow['doctor_first_name'] . ' ' . $historyRow['doctor_last_name']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Medical Data Overview</h2>
            <h3>Diabetic Level</h3>
            <div>
                <canvas id="diabeticChart"></canvas>
            </div>
            <br><br>
            <H3>Cholesterol Level</H3>
            <div>
                <canvas id="cholesterolChart"></canvas>
            </div>
            <br><br>
            <H3>Blood Pressure</H3>
            <div>
                <canvas id="bloodPressureChart"></canvas>
            </div>
        </div>
        <div class="section">
            <h2>Reports</h2>
            <Table>
            <thead>
                    <tr>
                        <th>Report Name </th>
                        <th>Issued By </th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Report</th>
                    </tr>
                </thead>
                <tbody>
                <?php
        // Assuming $result4 is the result object from the database query
        while ($row4 = $result4->fetch_assoc()) {
            echo "<tr>";
echo "<td>" . htmlspecialchars($row4['Report Name'] ?? 'No Report Name') . "</td>";  
echo "<td>" . htmlspecialchars($row4['Issued By'] ?? 'No Issuer') . "</td>";  
echo "<td>" . htmlspecialchars($row4['Report Descrtiotion'] ?? 'No Description') . "</td>";  
echo "<td>" . htmlspecialchars($row4['Date'] ?? 'No Date') . "</td>";  
echo "<td><a href='" . htmlspecialchars($row4['Report File'] ?? '#') . "'>View Report</a></td>";  
echo "</tr>";

        }
        ?>
                </tbody>
            </Table>

    </div>

    <script>
        var diabeticDates = <?php echo json_encode($diabeticDates); ?>;
        var diabeticLevels = <?php echo json_encode($diabeticLevels); ?>;

        var cholesterolDates = <?php echo json_encode($dates); ?>;
        var cholesterolLevels = <?php echo json_encode($cholLevels); ?>;

        var bloodPressureDates = <?php echo json_encode($bpDates); ?>;
        var systolicLevels = <?php echo json_encode($systolicLevels); ?>;
        var diastolicLevels = <?php echo json_encode($diastolicLevels); ?>;

        // Diabetic Chart
        var ctx = document.getElementById('diabeticChart').getContext('2d');
        var diabeticChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: diabeticDates,
                datasets: [{
                    label: 'Diabetic Level',
                    data: diabeticLevels,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });

        // Cholesterol Chart
        var ctx2 = document.getElementById('cholesterolChart').getContext('2d');
        var cholesterolChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: cholesterolDates,
                datasets: [{
                    label: 'Cholesterol Level',
                    data: cholesterolLevels,
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }]
            }
        });

        // Blood Pressure Chart
        var ctx3 = document.getElementById('bloodPressureChart').getContext('2d');
        var bloodPressureChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: bloodPressureDates,
                datasets: [{
                    label: 'Systolic Blood Pressure',
                    data: systolicLevels,
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.1
                }, {
                    label: 'Diastolic Blood Pressure',
                    data: diastolicLevels,
                    borderColor: 'rgb(153, 102, 255)',
                    tension: 0.1
                }]
            }
        });
    </script>
</body>
</html>
