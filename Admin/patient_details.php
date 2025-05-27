<?php
include "../DBConnection.php"; // Assuming your MySQLi connection is initialized in this file

// Initialize message variable
$message = "";

// Check if 'patient_id' is set in the URL
if (isset($_GET['patient_id'])) {
    $patientId = $_GET['patient_id'];

    // Prepare the SQL statement with MySQLi
    $stmt = $con->prepare("SELECT * FROM patient WHERE Patient_Id = ?");
    $stmt->bind_param("i", $patientId);  // Bind the patient_id parameter (assuming it's an integer)
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result of the query
    $patient = $result->fetch_assoc(); // Fetch the patient data as an associative array

    // If no patient found, show an error message
    if (!$patient) {
        $message = "Patient not found.";
    }

    // Handle the delete action
    if (isset($_POST['delete'])) {
        // Prepare the delete statement using MySQLi
        $deleteStmt = $con->prepare("DELETE FROM patient WHERE Patient_Id = ?");
        $deleteStmt->bind_param("i", $patientId); // Bind parameter
        if ($deleteStmt->execute()) {
            $message = "Patient deleted successfully.";
            // Redirect to the Admin page after deletion
            header("Location:Patients.php");
            exit(); // Ensure the script stops after the redirect
        } else {
            $message = "Error deleting patient. Please try again.";
        }
    }
} else {
    $message = "No patient selected.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #003366;
        }
        .patient-details {
            margin-top: 20px;
        }
        .patient-details img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .patient-details p {
            font-size: 18px;
        }
        .delete-btn {
            display: block;
            margin-top: 20px;
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            width: 100px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Patient Details</h1>

    <!-- Display success or error message -->
    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($patient) : ?>
        <div class="patient-details">
            <img src="<?php echo $patient['Image']; ?>" alt="Patient Image">
            <p><strong>Name:</strong> <?php echo $patient['First_name'] . ' ' . $patient['Last_Name']; ?></p>
            <p><strong>NIC:</strong> <?php echo $patient['Patient_Id']; ?></p>
            <p><strong>Contact No:</strong> <?php echo $patient['Contact_No']; ?></p>
            <p><strong>Email:</strong> <?php echo $patient['Email']; ?></p>
            <p><strong>Address:</strong> <?php echo $patient['Address']; ?></p>
            <p><strong>Blood Type:</strong> <?php echo $patient['Blood_Type']; ?></p>
            <p><strong>Diabetic Type:</strong> <?php echo $patient['Diabetic_Type']; ?></p>
            <p><strong>Diabetic Level:</strong> <?php echo $patient['Diabetic_level(Mg/DL)']; ?></p>
            <p><strong>Cholesterol Level:</strong> <?php echo $patient['Cholosterol_Level(Mg/DL)']; ?></p>
            <p><strong>Blood Pressure:</strong> <?php echo $patient['Blood_Presure']; ?></p>
            <p><strong>Emergency Contact No:</strong> <?php echo $patient['Emergency_Contact']; ?></p>
        </div>

        <!-- Delete button -->
        <form method="POST">
            <button class="delete-btn" type="submit" name="delete">Delete Patient</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
