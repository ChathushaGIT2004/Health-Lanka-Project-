<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dev";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get MeetUp ID from the URL
$meetupId = isset($_GET['meetup_id']) ? intval($_GET['meetup_id']) : 0;

// Fetch details of dispensed medicines for the selected MeetUp
$sql_dispensed_medicine = "
    SELECT md.MedicineName, md.MedicineID, md.UsageOfMedicine, md.CategoryOfMedicine, md.PictureOfMedicine
    FROM medicinedetails md
    INNER JOIN `dispence-medicine` dm ON md.`MedicineID` = dm.`Medicine ID`
    WHERE dm.`MeetUp ID` = $meetupId";
$dispensedMedicineResult = $con->query($sql_dispensed_medicine);

$dispensedMedicines = [];

if ($dispensedMedicineResult->num_rows > 0) {
    while($row = $dispensedMedicineResult->fetch_assoc()) {
        $dispensedMedicines[] = $row;
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispensed Medicine Details for Meetup</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }
        h1 {
            text-align: center;
            padding: 20px;
           
            color: black;
            margin-bottom: 40px;
            border-radius: 8px;
            font-size: 24px;
        }
        h2 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #007bff;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: 500;
        }
        td {
            color: #555;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            max-width: 80px;
            height: auto;
            border-radius: 4px;
        }
        .no-image {
            color: #aaa;
            font-style: italic;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: white;
            margin-top: 40px;
            font-size: 14px;
        }
    </style>
</head>
<body> <img src="../Essentials/MainLogo.png" class="Healthnet" alt="HealthNet Logo"><br>

    <h1>Dispensed Medicine Details for Meetup ID: <?php echo $meetupId; ?></h1>

    <div class="container">
        <h2>Medicines Dispensed for the Meetup</h2>

        <?php if (!empty($dispensedMedicines)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Category</th>
                        <th>Usage</th>
                        <th>Picture</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dispensedMedicines as $medicine): ?>
                        <tr>
                            <td><?php echo $medicine['MedicineName']; ?></td>
                            <td><?php echo $medicine['CategoryOfMedicine']; ?></td>
                            <td><?php echo $medicine['UsageOfMedicine']; ?></td>
                            <td>
                                <?php if (!empty($medicine['PictureOfMedicine'])): ?>
                                    <img src="<?php echo $medicine['PictureOfMedicine']; ?>" alt="<?php echo $medicine['MedicineName']; ?>">
                                <?php else: ?>
                                    <span class="no-image">No image available</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No medicines were dispensed for this meetup.</p>
        <?php endif; ?>
    </div>

     

</body>
</html>
