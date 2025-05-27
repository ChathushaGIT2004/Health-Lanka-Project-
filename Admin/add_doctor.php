<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dev";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $licence = $conn->real_escape_string($_POST['Licence']);
    $firstName = $conn->real_escape_string($_POST['FN']);
    $lastName = $conn->real_escape_string($_POST['LN']);
    $specialization = $conn->real_escape_string($_POST['options']);
    $contactNo = $conn->real_escape_string($_POST['Contact']);
    $email = $conn->real_escape_string($_POST['Email']);
    
     // Handle image upload
     $targetDir = "../DOC Images/"; // Directory to save images
     $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)); // Get file extension
     $targetFileName = $licence . '.' . $imageFileType; // Save image as DoctorID.extension
     $targetFilePath = $targetDir . $targetFileName;
 
    $uploadOk = true;

    // Check if file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = false;
        echo "File is not an image.";
    }

    // Check file size (limit to 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        $uploadOk = false;
        echo "Sorry, your file is too large.";
    }

    // Allow only specific formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $uploadOk = false;
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // Prepare query
        $sql = "INSERT INTO doctors 
                (DoctorID, Firstname, LastName, ContactNo, Email, Image, Password)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $doctorID = uniqid('DOC-'); // Generate a unique ID for DoctorID
            $defaultPassword = "1234"; // Default password
            $loginCount = 0; // Default login count
            $treatmentCount = 0; // Default treatment count
            $treatmentRate = 0; // Default treatment rate
    
            // Bind parameters: "sssssssiii"
            $stmt->bind_param(
                "sssssss",
                $licence,        // String
                $firstName,        // String
                $lastName,         // String
                $contactNo,        // String
                $email,            // String
                $targetFilePath,       // String
                $defaultPassword,  // String
                 
            );

            if ($stmt->execute()) {
                echo "New doctor added successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
