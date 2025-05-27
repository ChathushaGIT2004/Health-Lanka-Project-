<?php
// Database connection setup
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'dev';

// Create a connection to the MySQL database
$db = new mysqli($host, $user, $pass, $dbname);

// Check if the connection was successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to search for a patient by name or email
function searchPatient($searchTerm) {
    global $db;
    $stmt = $db->prepare("SELECT `Patient_Id`, `First_name`, `Last_Name`, `Email` FROM `patient` WHERE `First_name` LIKE ? OR `Last_Name` LIKE ? OR `Email` LIKE ?");
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Handle the form submission for uploading the report
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['patient_search'])) {
        // Search for the patient by name or email
        $searchTerm = $_POST['search_term'];
        $patients = searchPatient($searchTerm);
    }

    if (isset($_POST['upload_report'])) {
        // Handle file upload
        $patient_id = $_POST['patient_id'];
        $file = $_FILES['report_file'];

        // Generate file name based on the current date and Patient ID
        $date_str = date('Y-m-d');
        $filename = 'patient-cholesterol-report-' . $date_str . '-' . $patient_id . '.pdf';

        // Directory to store the reports
        $upload_dir = '../CholesterolReports/'; // Directory for cholesterol reports
        $file_path = $upload_dir . $filename;

        // Move the uploaded file to the CholesterolReports folder
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Insert the report details into the database
            $cholesterol_level = $_POST['cholesterol_level']; // Assuming the cholesterol level is passed in the form
            $stmt = $db->prepare("INSERT INTO `patient-cholesterol` (`Patient ID`, `Cholesterol Level`, `Date`, `Report`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $patient_id, $cholesterol_level, $date_str, $filename);
            if ($stmt->execute()) {
                // Redirect to Lab page with LabID passed as a parameter
                $lab_id = isset($_POST['lab_id']) ? $_POST['lab_id'] : ''; // Retrieve LabID (can be from hidden input or session)
                header("Location: LabPage.php?LabID=" . urlencode($lab_id)); // Redirect to LabPage with LabID
                exit(); // Make sure the script stops after the redirect
            } else {
                echo "<p class='error'>Error saving report: " . $stmt->error . "</p>";
            }
        } else {
            echo "<p class='error'>Error uploading file.</p>";
        }
    }
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Cholesterol Report Upload</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and container styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            line-height: 1.6;
            padding: 30px;
        }

        .container {
            width: 70%;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        /* Search form styling */
        .search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .search-form input[type="text"] {
            width: 60%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-form .search-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 12px 20px;
            margin-left: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-form .search-button:hover {
            background-color: #2980b9;
        }

        /* Patient list and form styling */
        .patient-list {
            list-style-type: none;
            padding-left: 0;
        }

        .patient-item {
            background-color: #ecf0f1;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .patient-item strong {
            color: #2c3e50;
        }

        /* Upload form styling */
        .upload-form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .upload-form input[type="text"],
        .upload-form input[type="file"] {
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .upload-form .upload-button {
            background-color: #2ecc71;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .upload-form .upload-button:hover {
            background-color: #27ae60;
        }

        .success {
            color: green;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search for a Patient</h1>
        <form method="POST" action="" class="search-form">
            <input type="text" name="search_term" placeholder="Enter patient name or email" required>
            <button type="submit" name="patient_search" class="search-button">Search</button>
        </form>

        <h2>Search Results</h2>
        <?php if (isset($patients)): ?>
            <?php if ($patients->num_rows > 0): ?>
                <ul class="patient-list">
                    <?php while ($row = $patients->fetch_assoc()): ?>
                        <li class="patient-item">
                            <strong>Patient ID:</strong> <?= $row['Patient_Id'] ?>, 
                            <strong>Name:</strong> <?= $row['First_name'] ?> <?= $row['Last_Name'] ?>, 
                            <strong>Email:</strong> <?= $row['Email'] ?>
                            <form method="POST" enctype="multipart/form-data" class="upload-form">
                                <!-- Hidden field to pass LabID -->
                                <input type="hidden" name="lab_id" value="YOUR_LAB_ID_HERE">
                                <input type="hidden" name="patient_id" value="<?= $row['Patient_Id'] ?>">
                                <input type="text" name="cholesterol_level" placeholder="Enter Cholesterol Level (mg/dL)" required>
                                <input type="file" name="report_file" required>
                                <button type="submit" name="upload_report" class="upload-button">Upload Cholesterol Report</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="error">No patients found. Try searching again.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
