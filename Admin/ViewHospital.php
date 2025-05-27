<?php
// Database connection
$servername = "localhost"; // Change to your server
$username = "root";        // Change to your DB username
$password = "";            // Change to your DB password
$dbname = "dev";           // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching hospital details
$hospital_id = $_GET['hospital_id'];

// Prepare the query to get hospital details
$hospital_sql = $conn->prepare("SELECT `Hospital ID`, `Name`, `Address`, `sector`, `Grade`, `Image` FROM `hospital` WHERE `Hospital ID` = ?");
$hospital_sql->bind_param("s", $hospital_id);  // 's' indicates the parameter is a string
$hospital_sql->execute();
$hospital_result = $hospital_sql->get_result();

// Prepare the query to get doctors assigned to the selected hospital
$doctors_sql = $conn->prepare("SELECT d.`FirstName`, d.`LastName` FROM `doctor-hospital` dh JOIN `doctors` d ON dh.`Hospital ID` = d.`DoctorID` WHERE dh.`Hospital ID` = ?");
$doctors_sql->bind_param("s", $hospital_id);  // 's' for string
$doctors_sql->execute();
$doctors_result = $doctors_sql->get_result();

// Prepare the query to get labs assigned to the selected hospital
$labs_sql = $conn->prepare("SELECT `UserID`, `Name`, `Location`, `Contact No` FROM `hospital-users` WHERE `Hospital ID` = ? AND `Type` = 'Laboratory'");
$labs_sql->bind_param("s", $hospital_id);  // 's' for string
$labs_sql->execute();
$labs_result = $labs_sql->get_result();

// Prepare the query to get pharmacists assigned to the selected hospital
$pharmacists_sql = $conn->prepare("SELECT `UserID`, `Name`, `Location`, `Contact No`, `Password` FROM `hospital-users` WHERE `Hospital ID` = ? AND `Type` = 'Pharmacist'");
$pharmacists_sql->bind_param("s", $hospital_id);  // 's' for string
$pharmacists_sql->execute();
$pharmacists_result = $pharmacists_sql->get_result();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Details</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        color: #333;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px;
    }

    h1 {
        text-align: center;
        color: #0056b3;
        font-size: 36px;
        margin-bottom: 20px;
    }

    .hospital-details, .doctors-list, .labs-list, .pharmacists-list {
        background-color: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hospital-details img {
        max-width: 200px;
        border-radius: 8px;
        display: block;
        margin-top: 15px;
    }

    .hospital-details p, .doctor, .lab, .pharmacist {
        font-size: 18px;
        color: #555;
        margin: 5px 0;
    }

    .hospital-details h2 {
        font-size: 28px;
        color: #333;
        margin-bottom: 10px;
    }

    .hospital-details p strong {
        font-weight: bold;
        color: #0056b3;
    }

    .hospital-details:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .doctor + .doctor, .lab + .lab, .pharmacist + .pharmacist {
        margin-top: 12px;
    }

    .add-buttons {
        text-align: right;
        margin-bottom: 20px;
    }

    .button {
        background-color: #0056b3;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .button:hover {
        background-color: #004085;
    }

    .button:active {
        transform: translateY(2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            width: 95%;
        }

        .hospital-details img {
            max-width: 100%;
        }

        .add-buttons {
            text-align: center;
            margin-top: 15px;
        }
    }

    /* Section Headers */
    h3 {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
    }

    /* Styling for Lists (Doctors, Labs, Pharmacists) */
    .doctor, .lab, .pharmacist {
        padding-left: 10px;
        line-height: 1.6;
    }

    .doctor:before, .lab:before, .pharmacist:before {
        content: "\2022"; /* Bullet points */
        color: #0056b3;
        font-size: 22px;
        padding-right: 10px;
    }

    .doctor, .lab, .pharmacist {
        font-size: 18px;
        color: #444;
    }

    /* Add subtle line separators */
    .doctors-list, .labs-list, .pharmacists-list {
        border-top: 2px solid #f4f4f4;
        margin-top: 20px;
        padding-top: 20px;
    }

</style>

</head>
<body>

<div class="container">
    <h1>Hospital Details</h1>

    <?php if ($hospital_result->num_rows > 0): ?>
        <?php while($row = $hospital_result->fetch_assoc()): ?>
            <div class="hospital-details">
                <h2><?php echo $row['Name']; ?></h2>
                <p><strong>Address:</strong> <?php echo $row['Address']; ?></p>
                <p><strong>Sector:</strong> <?php echo $row['sector']; ?></p>
                <p><strong>Grade:</strong> <?php echo $row['Grade']; ?></p>
                <?php if (!empty($row['Image'])): ?>
                    <img src="<?php echo $row['Image']; ?>" alt="Hospital Image">
                <?php else: ?>
                    <p>No image available for this hospital.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hospital found with the given ID.</p>
    <?php endif; ?>

    <div class="doctors-list">
        <h3>Assigned Doctors</h3>
        <?php if ($doctors_result->num_rows > 0): ?>
            <?php while($doctor = $doctors_result->fetch_assoc()): ?>
                <p class="doctor"><?php echo $doctor['FirstName'] . " " . $doctor['LastName']; ?></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No doctors assigned to this hospital.</p>
        <?php endif; ?>
    </div>

    <div class="labs-list">
        <h3>Assigned Laboratories</h3>
        <div class="add-buttons">
            <button class="button" onclick="window.location.href='add_lab.php?hospital_id=<?php echo $hospital_id; ?>'">Add Laboratory</button>
        </div>
        <?php if ($labs_result->num_rows > 0): ?>
            <?php while($lab = $labs_result->fetch_assoc()): ?>
                <p class="lab"><?php echo $lab['Name'] . " (Location: " . $lab['Location'] . ", Contact: " . $lab['Contact No'] . ")"; ?></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No laboratories assigned to this hospital.</p>
        <?php endif; ?>
    </div>

    <div class="pharmacists-list">
        <h3>Assigned Pharmacists</h3>
        <div class="add-buttons">
            <button class="button" onclick="window.location.href='add_pharmacist.php?hospital_id=<?php echo $hospital_id; ?>'">Add Pharmacist</button>
        </div>
        <?php if ($pharmacists_result->num_rows > 0): ?>
            <?php while($pharmacist = $pharmacists_result->fetch_assoc()): ?>
                <p class="pharmacist"><?php echo $pharmacist['Name'] . " (Location: " . $pharmacist['Location'] . ", Contact: " . $pharmacist['Contact No'] . ")"; ?></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No pharmacists assigned to this hospital.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
