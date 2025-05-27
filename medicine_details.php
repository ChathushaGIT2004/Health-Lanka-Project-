<?php
$medicineID = $_GET['id'];

include 'DBConnection.php';

// Query to fetch medicine details
$query = "SELECT * FROM medicinedetails WHERE MedicineID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $medicineID); 
$stmt->execute();
$result = $stmt->get_result();
$medicine = $result->fetch_assoc();

if (!$medicine) {
    echo "Medicine not found.";
    exit;
}

$stmt->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 950px;
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .header img {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .medicine-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            width: 100%;
        }

        .medicine-info h1 {
            font-size: 34px;
            font-weight: 700;
            color: #00509e;
            margin-bottom: 10px;
            text-align: center;
        }

        .medicine-info p {
            font-size: 18px;
            color: #555;
            margin-bottom: 8px;
        }

        .medicine-info .category {
            font-size: 20px;
            color: #009688;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* About Medicine Section */
        .additional-info {
            margin-top: 30px;
            border-top: 2px solid #e0e0e0;
            padding-top: 20px;
        }

        .additional-info h2 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #00509e;
        }

        .additional-info p {
            font-size: 18px;
            color: #555;
            margin-bottom: 12px;
        }

        /* Logo Section */
        img.logo {
            display: block;
            margin: 0 auto 30px;
            width: 180px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }

            .medicine-info h1 {
                font-size: 28px;
            }

            .medicine-info p {
                font-size: 16px;
            }

            .medicine-info .category {
                font-size: 18px;
            }

            .additional-info h2 {
                font-size: 22px;
            }

            .additional-info p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <img src="Essentials/MainLogo.png" class="logo" alt="Logo">

    <div class="container">
        <!-- Medicine Header Section -->
        <div class="header">
            <img src="images/<?= htmlspecialchars($medicine['PictureOfMedicine']); ?>" alt="Medicine Image">
            <div class="medicine-info">
                <h1><?= htmlspecialchars($medicine['MedicineName']); ?></h1>
                <p><strong>Medicine ID:</strong> <?= htmlspecialchars($medicine['MedicineID']); ?></p>
                <p class="category"><strong>Category:</strong> <?= htmlspecialchars($medicine['CategoryOfMedicine']); ?></p>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="additional-info">
            <h2>About this Medicine:</h2>
            <p><strong>Usage Instructions:</strong> <?= htmlspecialchars($medicine['UsageOfMedicine']); ?></p>
            <p><strong>Category:</strong> <?= htmlspecialchars($medicine['CategoryOfMedicine']); ?></p>
        </div>
    </div>

</body>
</html>
