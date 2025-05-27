<?php
include 'Admin_navbar.php';
// Database connection
$conn = new PDO('mysql:host=localhost;dbname=dev', 'root', '');

// Function to fetch labs based on search term
function getLabs($conn, $searchTerm = '') {
    if ($searchTerm) {
        $stmt = $conn->prepare("SELECT `Lab ID`, `Name`, `Hospital ID`, `Location`, `Password` 
                                FROM lab 
                                WHERE `Name` LIKE :searchTerm OR `Location` LIKE :searchTerm OR `Hospital ID` LIKE :searchTerm");
        $searchTerm = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchTerm);
    } else {
        $stmt = $conn->prepare("SELECT `Lab ID`, `Name`, `Hospital ID`, `Location`, `Password` FROM lab");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if the form to add a new lab is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_lab'])) {
    // Collect lab data from the form
    $labName = $_POST['lab_name'];
    $hospitalID = $_POST['hospital_id'];
    $location = $_POST['location'];
    $password = $_POST['password']; // For security, hash the password

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new lab into the database
    $stmt = $conn->prepare("INSERT INTO lab (`Name`, `Hospital ID`, `Location`, `Password`) VALUES (?, ?, ?, ?)");
    $stmt->execute([$labName, $hospitalID, $location, $hashedPassword]);
    echo "<p class='success'>Lab added successfully.</p>";
}

// Check if there's a search term
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Get labs based on the search term
$labs = getLabs($conn, $searchTerm);

?>

<html>
<head>
    <title>All Labs</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        /* Logo Styles */
        .ImgHeath {
            margin: 20px;
            max-width: 120px;
            align-self: center;
        }

        h1 {
            font-size: 36px;
            color: #003366;
            margin-top: 20px;
            text-align: center;
        }

        /* Search Form */
        .search-form {
            width: 80%;
            max-width: 600px;
            padding: 10px;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .search-form input {
            width: 80%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-right: 10px;
        }

        .search-form button {
            padding: 12px;
            background-color: #3498db;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #2980b9;
        }

        /* Container for Add Lab Form */
        .add-lab-form {
            margin-top: 40px;
            width: 80%;
            max-width: 600px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .add-lab-form h2 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .add-lab-form input, .add-lab-form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .add-lab-form button {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-lab-form button:hover {
            background-color: #2ecc71;
        }

        /* Container for Lab List */
        .lab-list-container {
            margin-top: 40px;
            width: 90%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .lab-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 320px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .lab-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .lab-card h3 {
            font-size: 22px;
            color: #34495e;
            margin-bottom: 10px;
        }

        .lab-card p {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .lab-card .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }

        .lab-card .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <div>
        <img src="Healthnet.png" class="ImgHeath" alt="Healthnet Logo">
    </div>

    <!-- Search Form -->
    <div class="search-form">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search labs..." value="<?= htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Add Lab Form -->
    <div class="add-lab-form">
        <h2>Add New Lab</h2>
        <form method="POST">
            <input type="text" name="lab_name" placeholder="Lab Name" required>
            <input type="text" name="hospital_id" placeholder="Hospital ID" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="add_lab">Add Lab</button>
        </form>
    </div>

    <!-- Display Labs -->
    <h1>All Labs</h1>
    <div class="lab-list-container">
        <?php foreach ($labs as $lab): ?>
            <div class="lab-card">
                <h3><?= htmlspecialchars($lab['Name']); ?></h3>
                <p><strong>Lab ID:</strong> <?= htmlspecialchars($lab['Lab ID']); ?></p>
                <p><strong>Hospital ID:</strong> <?= htmlspecialchars($lab['Hospital ID']); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($lab['Location']); ?></p>
                <!-- Don't display password for security reasons -->
                <a href="#" class="btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
