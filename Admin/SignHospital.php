<?php
include "../DBConnection.php";

// Fetching the doctor_id from the query string
$doctor_id = $_GET["DoctorID"]; 

// Fetching doctors and hospitals from the database
$doctorQuery = "SELECT DoctorID, FirstName FROM doctors"; 
$hospitalQuery = "SELECT `Hospital ID`, Name, Address, Sector, Grade, Image FROM hospital";

$doctorResult = $con->query($doctorQuery);
$hospitalResult = $con->query($hospitalQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $hospital_id = $_POST['hospital_id'];
    $signed_date = $_POST['signed_date'];

    // Use backticks for column names that contain spaces
    $assignQuery = "INSERT INTO `doctor-hospital` (`Doctor  ID`, `Hospital ID`, `Signed date`) 
                    VALUES ('$doctor_id', '$hospital_id', '$signed_date')";

    if ($con->query($assignQuery)) {
        echo "<div class='success-message'>Doctor assigned to hospital successfully!</div>";
    } else {
        echo "<div class='error-message'>Error: " . $con->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Hospital to Doctor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #4C6A92;
            margin-bottom: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 500;
            color: #4C6A92;
            display: block;
            margin-bottom: 8px;
        }

        select, input[type="date"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        select:focus, input[type="date"]:focus {
            border-color: #4C6A92;
            outline: none;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: #4C6A92;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #3f5585;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            font-size: 16px;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
        }

        .error-message {
            background-color: #f44336;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Assign Doctor to Hospital</h1>
        
        <form method="POST" action="">
            <!-- Hospital Selection -->
            <div class="form-group">
                <label for="hospital_id">Select Hospital:</label>
                <select name="hospital_id" id="hospital_id" required>
                    <option value="">--Select Hospital--</option>
                    <?php while ($hospital = $hospitalResult->fetch_assoc()) { ?>
                        <option value="<?= $hospital['Hospital ID']; ?>">
                            <?= $hospital['Name']; ?> - <?= $hospital['Address']; ?> (<?= $hospital['Sector']; ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Signed Date -->
            <div class="form-group">
                <label for="signed_date">Signed Date:</label>
                <input type="date" name="signed_date" id="signed_date" required>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn-submit">Assign Doctor to Hospital</button>
            </div>
        </form>

        <!-- Success/Error Messages -->
        <?php if (isset($assignQuery)) { ?>
            <div class="message">
                <?= isset($successMessage)  ?>
            </div>
        <?php } ?>
    </div>

</body>
</html>
