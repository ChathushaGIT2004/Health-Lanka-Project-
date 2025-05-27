<?php
// Include database connection
include '../DBConnection.php';

// Check if DoctorID is passed in the URL
$DoctorID = $_GET['DoctorID'];

// Prepare and execute the query to fetch hospitals assigned to the doctor
$query = "
    SELECT h.`Hospital ID`, h.`Name`, h.`Address`, h.`sector`, h.`Grade`, h.`Image`
    FROM `hospital` h
    JOIN `doctor-hospital` dh ON h.`Hospital ID` = dh.`Hospital ID`
    WHERE dh.`Doctor  ID` = ?";  // Fixed typo in column name "Doctor  ID" to "Doctor ID"
$stmt = $con->prepare($query);
$stmt->bind_param("s", $DoctorID);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all hospitals into an array
$hospitals = [];
while ($row = $result->fetch_assoc()) {
    $hospitals[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Hospital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Base Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
            color: #2d3e50;
            font-weight: 600;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-top: 20px;
        }

        /* Card Styles */
        .card {
            width: 270px;
            background-color: #fff;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: #333;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }
        .card img:hover {
            transform: scale(1.05);
        }
        .card h3 {
            font-size: 20px;
            font-weight: 600;
            color: #2d3e50;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 14px;
            color: #777;
            margin: 5px 0;
        }
        .card p strong {
            color: #2d3e50;
        }

        /* Private Card Styling */
        .card.private {
            background-color: #e9f7fc;
            border-color: #4a90e2;
        }
        .card.private h3 {
            color: #4a90e2;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .card-container {
                gap: 20px;
            }
            .card {
                width: 230px;
                padding: 15px;
            }
            h1 {
                font-size: 24px;
            }
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Select Hospital for Login</h1>

        <!-- Hospital Selection Cards -->
        <div class="card-container">
            <?php
            // Check if there are hospitals and display them as cards
            if (count($hospitals) > 0) {
                foreach ($hospitals as $hospital) {
                    echo "
                    <a href='Doctor_Page.php?HospitalID=" . htmlspecialchars($hospital['Hospital ID']) . "&DoctorID=" . htmlspecialchars($DoctorID) . "' class='card'>
                        <img src='" . htmlspecialchars($hospital['Image']) . "' alt='Hospital Image'>
                        <h3>" . htmlspecialchars($hospital['Name']) . "</h3>
                        <p><strong>Sector:</strong> " . htmlspecialchars($hospital['sector']) . "</p>
                        <p><strong>Grade:</strong> " . htmlspecialchars($hospital['Grade']) . "</p>
                    </a>";
                }
            } else {
                echo "<p>No hospitals assigned to this doctor.</p>";
            }
            ?>
            <!-- Private Hospital Option -->
            <a href='Doctor_Page.php?HospitalID=private&DoctorID=<?php echo htmlspecialchars($DoctorID); ?>' class='card private'>
                <h3>Prersonal</h3>
                <p><strong>Access Without Hospital</strong></p>
            </a>
        </div>

    </div>

</body>
</html>
