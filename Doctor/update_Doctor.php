<?php
 
include"../DBConnection.php";

 
session_start();
$doctorID = $_GET['$DoctorID']; // Get the DoctorID from the URL
$HospitalID=$_GET['HospitalID']  ;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
     
    $password = $_POST['password'];
    
    // Image upload logic
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../Doc Images/"; // Directory where the image will be stored
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL to update patient details
    $sql = "UPDATE doctors SET 
            Email = ?, 
            ContactNo = ?, 
            Password = ?, 
            Image = ? 
            WHERE `DoctorID` = ?";

    // Prepare statement and execute the query
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param('ssssi', $email, $contact_no , $password, $image, $doctorID);
        if ($stmt->execute()) {
            echo "Details updated successfully!";
            header("Location: Doctor_Page.php?DoctorID=" . $doctorID . "&HospitalID=" . $HospitalID);
exit();

        } else {
            echo "Error updating details: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the SQL statement: " . $conn->error;
    }
}
?>
