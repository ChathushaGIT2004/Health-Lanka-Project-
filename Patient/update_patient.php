<?php
// update_patient.php

// Assuming the database connection is already established
include"../DBConnection.php";

// Get the patient ID from the session or other means
session_start();
$PatientID= $_GET['PatientID']; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $emergency_contact = $_POST['emergency_contact'];
    $password = $_POST['password'];
    
    // Image upload logic
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "Patients Images/"; // Directory where the image will be stored
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL to update patient details
    $sql = "UPDATE patient SET 
            Email = ?, 
            Contact_No = ?, 
            Emergency_Contact = ?, 
            Password = ?, 
            Image = ? 
            WHERE Patient_Id = ?";

    // Prepare statement and execute the query
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param('sssssi', $email, $contact_no, $emergency_contact, $password, $image, $patient_id);
        if ($stmt->execute()) {
            echo "Details updated successfully!";
            header("Location: Patientpage.php?PatientID=" . $PatientID);

        } else {
            echo "Error updating details: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the SQL statement: " . $conn->error;
    }
}
?>
