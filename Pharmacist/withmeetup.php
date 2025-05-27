<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dev";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$meetup_id = '';
$dispensed_data = [];

// Check if the MeetUp ID is provided via GET or POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['meetup_id'])) {
    $meetup_id = $_POST['meetup_id'];

    // Fetch the dispense medicine data based on MeetUp ID
    $sql = "SELECT `MeetUp ID`, `Medicine ID`, `times`, `per time`, `Notes` FROM `dispence-medicine` WHERE `MeetUp ID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $meetup_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results and store them
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dispensed_data[] = $row;
        }
    } else {
        $message = "No data found for MeetUp ID: $meetup_id.";
    }
}

// Fetch additional medicine details for each medicine ID in the dispensed data
foreach ($dispensed_data as &$data) {
    $medicine_id = $data['Medicine ID'];

    // Fetch medicine details from medicinedetails table
    $sql_details = "SELECT `MedicineID`, `MedicineName`, `PictureOfMedicine`
                    FROM `medicinedetails` WHERE `MedicineID` = ?";
    $stmt_details = $conn->prepare($sql_details);
    $stmt_details->bind_param("s", $medicine_id);
    $stmt_details->execute();
    $result_details = $stmt_details->get_result();

    if ($result_details->num_rows > 0) {
        $data['medicine_details'] = $result_details->fetch_assoc();
    } else {
        $data['medicine_details'] = null;  // No medicine details found for this ID
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispensed Medicine History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container input {
            padding: 10px;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .table-container {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table-container th, .table-container td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table-container th {
            background-color: #f2f2f2;
        }

        .table-container img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #f44336;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Dispensed Medicine History</h1>

    <!-- Form to enter MeetUp ID -->
    <div class="form-container">
        <form method="POST" action="">
            <input type="text" name="meetup_id" placeholder="Enter MeetUp ID" value="<?php echo $meetup_id; ?>" required>
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Display message if no data is found -->
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Table displaying dispensed medicine data -->
    <?php if (!empty($dispensed_data)): ?>
        <table class="table-container">
            <thead>
                <tr>
                    <th>MeetUp ID</th>
                    <th>Medicine Name</th>
                    <th>Medicine ID</th>
                    <th>Times</th>
                    <th>Per Time</th>
                    <th>Notes</th>
                    <th>Medicine Image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dispensed_data as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['MeetUp ID']); ?></td>
                        <td><?php echo htmlspecialchars($data['medicine_details']['MedicineName'] ?? 'Unknown Medicine'); ?></td>
                        <td><?php echo htmlspecialchars($data['Medicine ID']); ?></td>
                        <td><?php echo htmlspecialchars($data['times']); ?></td>
                        <td><?php echo htmlspecialchars($data['per time']); ?></td>
                        <td><?php echo htmlspecialchars($data['Notes']); ?></td>
                        <td>
                            <?php if ($data['medicine_details'] && $data['medicine_details']['PictureOfMedicine']): ?>
                                <img src="<?php echo htmlspecialchars($data['medicine_details']['PictureOfMedicine']); ?>" alt="Medicine Picture">
                            <?php else: ?>
                                No Image Available
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
