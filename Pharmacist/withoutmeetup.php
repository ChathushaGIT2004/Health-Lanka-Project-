<?php
// Include database connection
include "../DBConnection.php";

if (isset($_POST['search'])) {
    // Get search criteria
    $searchTerm = $_POST['search_term'];

    // Prepare SQL query based on search term
    $sql = "SELECT `Patient_Id`, `First_name`, `Last_Name`, `Gender`, `Date of birth`, `Contact_No`, `Email`, `Address`, 
            `Emergency_Contact`, `Blood_Type`, `Diabetic_Type`, `Diabetic_level(Mg/DL)`, `Cholosterol_Level(Mg/DL)`, 
            `Blood_Presure`, `Password`, `Login_Count`, `Image` 
            FROM `patient` 
            WHERE `Patient_Id` = ? OR `First_name` LIKE ? OR `Last_Name` LIKE ? OR `Email` LIKE ?";

    // Prepare and execute the statement
    if ($stmt = $con->prepare($sql)) {
        $searchWildcard = "%" . $searchTerm . "%";
        $stmt->bind_param("ssss", $searchTerm, $searchWildcard, $searchWildcard, $searchWildcard);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        
        h1 {
            color: #333;
        }
        
        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .patient-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            width: 250px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 20px;
            margin: 10px 0;
            color: #333;
        }

        .card p {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .card a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h1>Search for a Patient</h1>
    <form method="POST" action="withoutmeetup.php">
        <input type="text" name="search_term" placeholder="Enter Patient ID, Name, or Email" required>
        <input type="submit" name="search" value="Search">
    </form>

    <?php if (isset($result) && $result->num_rows > 0): ?>
        <h2>Patient Results</h2>
        <div class="patient-cards">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <?php if (!empty($row['Image'])): ?>
                        <img src="../uploads/<?php echo $row['Image']; ?>" alt="Patient Image">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/100" alt="No Image">
                    <?php endif; ?>
                    <h3><?php echo $row['First_name'] . ' ' . $row['Last_Name']; ?></h3>
                    <p>Email: <?php echo $row['Email']; ?></p>
                    <p>Patient ID: <?php echo $row['Patient_Id']; ?></p>
                    <a href="medical_history.php?patient_id=<?php echo $row['Patient_Id']; ?>">View Medical History</a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No patients found.</p>
    <?php endif; ?>
</body>
</html>
