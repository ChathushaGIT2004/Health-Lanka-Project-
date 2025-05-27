<?php
// Start session for possible session usage
session_start();

// Database connection setup
try {
    $host = 'localhost';
    $dbname = 'dev';
    $username = 'root';
    $password = '';
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$message = "";

// Handle form submission for adding a new patient
if (isset($_POST['NIC'])) {
    $NIC = $_POST['NIC'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob']; // Date of birth
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $address = $_POST['Address'];
    $em_contact_no = $_POST['em_contact_no'];
    $blood_type = $_POST['Blood_type'];
    $diabetic_type = $_POST['diabetic_type'];
    $diabetic_level = $_POST['diabetic_level'];
    $cholesterol_level = $_POST['cholesterol_level'];
    $blood_pressure = $_POST['blood_pressure'];
    $password = "1234";  // Default password
    $login_count = 0;  // Starting login count

    // Handle image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $targetDir = "../Patient Images/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $targetFileName = $NIC . '.' . $imageFileType;
        $targetFilePath = $targetDir . $targetFileName;

        $uploadOk = true;

        // Check if file is an image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = false;
            $message = "<p class='error-message'>File is not an image.</p>";
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            $uploadOk = false;
            $message = "<p class='error-message'>Sorry, your file is too large.</p>";
        }

        // Allow only specific formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $uploadOk = false;
            $message = "<p class='error-message'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        }

        // Upload image if no errors
        if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            // Proceed with database insert logic
            $stmt = $conn->prepare("INSERT INTO patient 
                (`Patient_Id`, `First_name`, `Last_Name`, `Gender`, `Date of birth`, `Contact_No`, `Email`, `Address`, `Emergency_Contact`, `Blood_Type`, `Diabetic_Type`, `Diabetic_level(Mg/DL)`, `Cholosterol_Level(Mg/DL)`, `Blood_Presure`, `Password`, `Login_count`, `Image`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt->execute([ 
                $NIC, 
                $first_name, 
                $last_name, 
                $gender, 
                $dob, 
                $contact_no, 
                $email, 
                $address, 
                $em_contact_no, 
                $blood_type, 
                $diabetic_type, 
                $diabetic_level, 
                $cholesterol_level, 
                $blood_pressure, 
                $password, 
                $login_count, 
                $targetFilePath
            ])) {
                $message = "<p class='success-message'>Patient added successfully!</p>";
            } else {
                $message = "<p class='error-message'>Error adding patient. Please try again.</p>";
            }
        } else {
            $message = "<p class='error-message'>Sorry, there was an error uploading your file.</p>";
        }
    } else {
        $message = "<p class='error-message'>No file uploaded or there was an error with the upload.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <style>
        body, h1, form, input, select, textarea, button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin-top: 150px;
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        hr {
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .view-patients-button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .view-patients-button:hover {
            background-color: #2980b9;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #2c3e50;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fafafa;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            margin-top: 15px;
            font-size: 14px;
        }

        .success-message {
            color: #2ecc71;
            margin-top: 15px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            button, .view-patients-button {
                width: 100%;
            }

            .view-patients-button {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- View Patients Button -->
        <a href="Patients.php" class="view-patients-button">View Patients</a>
        <h1>Add New Patient</h1>
        <hr>
        <div class="message">
            <?php echo $message; ?>
        </div>
        <form method="POST" action="Add_PAtient.php" enctype="multipart/form-data">
            <label for="NIC">Patient NIC</label>
            <input type="text" id="NIC" name="NIC" required><br>

            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" required><br>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" required><br>

            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required><br>

            <label for="contact_no">Contact No</label>
            <input type="text" id="contact_no" name="contact_no" required><br>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required><br>

            <label for="Address">Address</label>
            <textarea id="Address" name="Address" required></textarea><br>

            <label for="em_contact_no">Emergency Contact No</label>
            <input type="text" id="em_contact_no" name="em_contact_no" required><br>

            <label for="Blood_type">Blood Type</label>
            <input type="text" id="Blood_type" name="Blood_type" required><br>

            <label for="diabetic_type">Diabetic Type</label>
            <input type="text" id="diabetic_type" name="diabetic_type" required><br>

            <label for="diabetic_level">Diabetic Level (Mg/DL)</label>
            <input type="number" id="diabetic_level" name="diabetic_level" required><br>

            <label for="cholesterol_level">Cholesterol Level (Mg/DL)</label>
            <input type="number" id="cholesterol_level" name="cholesterol_level" required><br>

            <label for="blood_pressure">Blood Pressure</label>
            <input type="text" id="blood_pressure" name="blood_pressure" required><br>

            <label for="image">Patient Image</label>
            <input type="file" id="image" name="image" accept="image/*"><br>

            <button type="submit">Add Patient</button>
        </form>
    </div>
</body>
</html>
