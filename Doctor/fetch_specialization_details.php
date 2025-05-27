<?php
// Include database connection
include '../DBConnection.php';

// Check if specialization ID is passed
if (isset($_GET['SpecID'])) {
    $specializationID = $_GET['SpecID'];

    // Query to get specialization details by ID
    $query = "SELECT `Description` FROM `specialization` WHERE `Specilizaton ID` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $specializationID);
    $stmt->execute();
    $stmt->bind_result($description);

    // Fetch the result and return it as JSON
    if ($stmt->fetch()) {
        echo json_encode([
            'success' => true,
            'description' => $description
        ]);
        header("Location:Doctor_page.php?DoctorID=" . urlencode($DoctorID)."&HospitalID=".urlencode($HospitalID)); 
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Specialization not found.'
        ]);
    }

    $stmt->close();
}

$con->close();
?>
