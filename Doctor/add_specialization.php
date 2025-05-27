<?php
// Include database connection
include('../DBConnection.php');

$doctorID = isset($_GET['DoctorID']) ? $_GET['DoctorID'] : null;
$HospitalID = isset($_GET['HospitalID']) ? $_GET['HospitalID'] : null;

$specializationID = $proof = "";

// Query to get all specializations
$query = "SELECT `Specilizaton ID`, `Name`, `Description` FROM `specialization`";
$result = $con->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctorID = $_POST['DoctorID'];
    $specializationID = $_POST['specializationID'];

    // Handle file upload for proof
    $fileTmpName = $_FILES['proof']['tmp_name'];
    $fileName = $_FILES['proof']['name'];

    $uploadDir = __DIR__ . '../Doctor/Doctor Spec';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        echo "File Cannot Insert Because It is Already there";
    }

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $customFileName = $doctorID . '_' . $specializationID . '.' . $fileExtension;

    $proof = $uploadDir . $customFileName;

    // Move the uploaded file to the directory
    if (!move_uploaded_file($fileTmpName, $proof)) {
        echo "<div class='error'>Error uploading the file. Ensure the directory is writable.</div>";
        exit();
    }

    // Insert specialization details into the database
    $query = "INSERT INTO `doctor-specialization` (`Doctor  ID`, `Specilization ID`, `Proof`) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss", $doctorID, $specializationID, $proof);

    if ($stmt->execute()) {
        echo "<div class='success'>Specialization added successfully!</div>";
        header("Location:special.php?DoctorID=".$doctorID."&HospitalID=".$HospitalID);
    } else {
        echo "<div class='error'>Error: " . $stmt->error . "</div>";
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Specialization to Doctor</title>
    <style>
      /* General body styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    flex-direction: column;
}

/* Container for the content */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 400px;
    max-width: 100%;
    margin: 20px auto;
}

form label {
    font-size: 14px;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

form input[type="file"], form select, form input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* Input submit button style */
form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    font-weight: bold;
}

form input[type="submit"]:hover {
    background-color: #45a049;
}

/* Specialization details section styling */
.specialization-details {
    margin-top: 10px;
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #e0e0e0;
}

.specialization-details p {
    margin: 5px 0;
    font-size: 14px;
}

/* Error and success message styling */
div.error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    margin: 15px 0;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
}

div.success {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    margin: 15px 0;
    border: 1px solid #c3e6cb;
    border-radius: 4px;
}
    </style>
</head>
<body>

<h2>Add Specialization to Doctor</h2>

<!-- Form to add a specialization for a doctor -->
<form action="" method="POST" enctype="multipart/form-data">
    <!-- Hidden field for doctor ID -->
    <input type="hidden" name="DoctorID" value="<?php echo $doctorID; ?>" />

    <!-- Specialization selection -->
    <label for="specialization">Select Specialization:</label>
    <select name="specializationID" id="specialization" required onchange="fetchSpecializationDetails()">
        <option value="">Select a Specialization</option>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['Specilizaton ID'] . "'>" . $row['Name'] . "</option>";
        }
        ?>
    </select>

    <!-- Specialization details display -->
    <div id="specializationDetails" class="specialization-details" style="display:none;">
        <p><strong>Specialization Details:</strong></p>
        <p><strong>Description:</strong> <span id="specializationDescription"></span></p>
    </div>

    <!-- Proof file upload -->
    <label for="proof">Upload Proof (optional):</label>
    <input type="file" name="proof" id="proof" accept="image/*,application/pdf" />

    <!-- Submit button -->
    <input type="submit" name="submit" value="Add Specialization">
</form>

<script>
    // Function to fetch and display specialization details
    function fetchSpecializationDetails() {
        var specializationID = document.getElementById('specialization').value;
        var specializationDescription = document.getElementById('specializationDescription');
        var detailsDiv = document.getElementById('specializationDetails');

        if (specializationID !== "") {
            // Create an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_specialization_details.php?SpecID=' + specializationID, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        specializationDescription.textContent = response.description;
                        detailsDiv.style.display = 'block';
                    } else {
                        detailsDiv.style.display = 'none';
                        alert(response.message); // Display the message from the server
                    }
                }
            };
            xhr.send();
        } else {
            detailsDiv.style.display = 'none';
        }
    }
</script>

</body>
</html>
