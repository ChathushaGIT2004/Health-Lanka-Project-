<?php
 
include "admin_navbar.php";

// Database connection
try {
    $conn = new PDO('mysql:host=localhost;dbname=dev', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Set the number of doctors per page
$doctors_per_page = 15;

// Get the current page from the URL (default to 1 if not set)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $doctors_per_page;

// Fetch doctors from the database with pagination
$stmt = $conn->prepare("SELECT * FROM doctors LIMIT :offset, :limit");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $doctors_per_page, PDO::PARAM_INT);
$stmt->execute();
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of doctors
$stmt_total = $conn->query("SELECT COUNT(*) FROM doctors");
$total_doctors = $stmt_total->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_doctors / $doctors_per_page);

// Check if 'action' is set to 'addDoctor' in the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthnet Doctors</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        /* Logo Styles */
        .ImgHeath {
            margin: 20px auto;
            max-width: 120px;
            display: block;
        }

        /* Page Titles */
        h1 {
            font-size: 36px;
            color: #003366;
            text-align: center;
            margin: 10px 0;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }

        /* Search Bar Styles */
        .searchbar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .searchbar h3 {
            font-size: 20px;
            color: #00509e;
            margin-right: 10px;
        }

        .searchbar input[type="text"] {
            width: 40%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
        }

        .searchbar button {
            padding: 10px 20px;
            background-color: #00509e;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            margin-left: 10px;
        }

        .searchbar button:hover {
            background-color: #003366;
        }

        /* List View Styles */
        .doctors-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 800px;
            margin: 0 auto;
        }

        .doctor-item {
            display: flex;
            gap: 15px;
            padding: 10px;
            border: 1px solid #34db85;
            border-radius: 8px;
            background-color: #fff;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            font-size: 14px;
        }

        .doctor-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
        }

        .doctor-image {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
        }

        .doctor-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .doctor-details {
            flex-grow: 1;
        }

        .doctor-details h3 {
            font-size: 16px;
            color: #003366;
            margin: 0;
        }

        .doctor-details p {
            font-size: 12px;
            margin: 5px 0;
            color: #555;
        }

        .doctor-link {
            color: #34db85;
            text-decoration: none;
            font-weight: bold;
        }

        .doctor-link:hover {
            text-decoration: underline;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 12px;
            background-color: #00509e;
            color: #fff;
            text-decoration: none;
            border-radius: 25px;
            font-size: 14px;
        }

        .pagination a:hover {
            background-color: #003366;
        }

        .pagination a.disabled {
            background-color: #ddd;
            color: #aaa;
            pointer-events: none;
        }

        .FunctionContainer {
            display:inline-block;
           
            margin: 20px 0;
            width: 350px;
            height: 50px;
            flex-direction: row;
            
        }

        .FunctionContainer a {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            text-decoration: none;
            background-color: #3ef57e;
            color: white;
            width: 300px;
            height: 50px;
            border-radius: 25px;
            padding: 0 15px;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .FunctionContainer a:hover {
            background-color: #3ea57e;
        }

        .FunctionContainer img {
            border-radius: 100%;
            height: 40px;
            width: 40px;
            margin-right: 15px;
        }

        .FunctionContainer h1 {
            font-size: 18px;
            margin: 0;
        }
        .option{
            color: #000;
        }

        /* Add Doctor Form */
        form {
            display: flex;
            flex-direction: column;
            align-items:left;
            gap: 15px;
            margin-top: 20px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 25px;
            padding: 20px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        form input, form button {
            padding: 10px;
            font-size: 14px;
            width: 80%;
            border-radius: 25px;
            border: 1px solid #ddd;
        }

        form button {
            background-color: #34db85;
            color: white;
            cursor: pointer;
        }

        form button:hover {
            background-color: #28a745;
        }

        

    </style>
</head>
<body>
    <?php

    
    ?>
    <!-- Logo -->
    <div>
        
        <h1>Doctors</h1>
    </div>

    <hr>

    <div class="FunctionContainer" >
        <a href="?action=addDoctor">
            <img src="Images/7.png" alt="Add Doctor Icon">
            <h1>Add Doctor</h1>
        </a>
    </div>
    <div class="FunctionContainer">
        <a href="?action=searchDoctor">
            <img src="Images/7.png" alt="Add Doctor Icon">
            <h1> View Doctors</h1>
        </a>
    </div>
    <hr>

    <!-- Check if action is 'addDoctor' to show the form -->
    <?php if ($action == 'addDoctor'): ?>
        <h2>Add New Doctor</h2>
        <form action="add_doctor.php" method="POST" enctype="multipart/form-data">
        <label for="name">Licence No:</label>
        <input type="text" name="Licence" required><br><br>
        
            <label for="name">First Name:</label>
            <input type="text" name="FN" required><br><br>

            <label for="name">Last Name:</label>
            <input type="text" name="LN" required><br><br>

            

            <label for="name">Specilization:</label>
            <select name="options" id="options" >
            <option value="">-- Select --</option>
            <?php
            
            $host = "localhost";
            $username = "root";
            $password = "";
            $dbname = "dev";

            $conn = new mysqli($host, $username, $password, $dbname);

            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            
            $sql = "SELECT * FROM specialization";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                
                while ($row = $result->fetch_assoc()) {
                    echo "<option  value='" . $row['id'] . "'>" . $row['Name'] . "</option>";
                }
            } else {
                echo "<option value=''>No options available</option>";
            }

            $conn->close();
            ?>
        </select><br>

            <label for="name">Contact No:</label>
            <input type="text" name="Contact" required><br><br>

            <label for="name">Email:</label>
            <input type="text" name="Email" required><br><br>

            <label for="image">Doctor Image:</label>
            <input type="file" name="image" accept="image/*" required><br><br>

            <button type="submit">Add Doctor</button>
        </form>
    <?php else: ?>

        <!-- Search Bar -->
        

        <!-- Doctors List -->
        <div class="doctors-container">
            <?php foreach ($doctors as $doctor):
                
                $rate = 0;

               // Check if 'Treatment Count' is not zero and then calculate the rate
            if (!empty($doctor['TreatmentCount']) && $doctor['TreatmentCount'] > 0) {
            $rate = $doctor['TreatmentRate'] / $doctor['TreatmentCount'];
            } else {
            $rate = 0; // Safe fallback if Treatment Count is zero or not set
            }
                ?>

                <div class="doctor-item">
                    <div class="doctor-image">
                        <img src="<?= htmlspecialchars($doctor['Image']); ?>" alt="<?= htmlspecialchars($doctor['FirstName']); ?>">
                    </div>
                    <div class="doctor-details">
                        <h3>Dr. <?= htmlspecialchars($doctor['FirstName']); ?> <?= htmlspecialchars($doctor['LastName']); ?> </h3>
                        <p>Rating: <?= htmlspecialchars($rate); ?></p>
                        <a href="Doctor.php?id=<?= urlencode($doctor['DoctorID']); ?>" class="doctor-link">View Profile</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <a href="?page=<?= $page - 1 ?>" class="<?= $page <= 1 ? 'disabled' : '' ?>">Previous</a>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'disabled' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <a href="?page=<?= $page + 1 ?>" class="<?= $page >= $total_pages ? 'disabled' : '' ?>">Next</a>
        </div>

    <?php endif; ?>
</body>
</html>
