<?php
include_once "../DBConnection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $DoctorID = $_POST['DoctorID'];
    $PatientID = $_POST['patientId'];
    $DiagnosisName = $_POST['DiagnosisName'];
    $DiagnosisDescription = $_POST['DiagnosisDescription'];
    $TreatmentDescription = $_POST['TreatmentDescription'];
    $ImportantNotes = $_POST['ImportantNotes'] ?? null;
    $Medicines = $_POST['dispense_medicines'] ?? []; 
}

date_default_timezone_set('Asia/Colombo');  
$localDate = date('Y-m-d'); 

// Insert record into the database
$query1 = "INSERT INTO `patient-doctor meetups` (`Patient ID`, `Doctor ID`, `Date`, `Diagnoze Name`, `Diagnoze Description`, `Treatment Description`, `Important Notes`)
VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $con->prepare($query1);
$stmt1->bind_param("sssssss", $PatientID, $DoctorID, $localDate, $DiagnosisName, $DiagnosisDescription, $TreatmentDescription, $ImportantNotes);
$stmt1->execute();

if ($stmt1->affected_rows > 0) {
    echo "Record inserted successfully.";
} else {
    echo "Error: " . $stmt1->error;
}

// Fetch the most recent MeetUp ID
$sql = "SELECT `MeetUp ID` FROM `patient-doctor meetups` WHERE `Patient ID` = ? AND `Doctor ID` = ? AND `Date` = ? AND `Diagnoze Name` = ? AND `Diagnoze Description` = ? AND `Treatment Description` = ? AND `Important Notes` = ?";
$stmt2 = $con->prepare($sql);  // Use the correct SELECT query here
$stmt2->bind_param("sssssss", $PatientID, $DoctorID, $localDate, $DiagnosisName, $DiagnosisDescription, $TreatmentDescription, $ImportantNotes);
$stmt2->execute();

$resultx = $stmt2->get_result();  // Get the result set
if ($resultx->num_rows > 0) {
    while ($row = $resultx->fetch_assoc()) {
        $s = $row["MeetUp ID"];
    }
} else {
    echo "0 results";
}

if (isset($s)) {
    echo "Most recent MeetUp ID: " . $s;
} else {
    echo "Meetup ID not found.";
}


foreach ($Medicines as $medicine) {
    $MedicineID = $medicine['MedicineID'];
    $Times = $medicine['Times'];
    $PerTime = $medicine['PerTime'];
    $Notes = $medicine['Notes'] ?? '';

    $query3 = "INSERT INTO `dispense-medicine` (`MeetUp ID`, `Medicine ID`, `times`, `per time`, `Notes`)
               VALUES (?, ?, ?, ?, ?)";
    $stmt3 = $con->prepare($query3);
    $stmt3->bind_param("iisss", $s, $MedicineID, $Times, $PerTime, $Notes);
    $stmt3->execute();
}

echo "<script>alert('Treatment added successfully!'); window.location.href = 'Doctor_Page.php';</script>";
exit;
?>
