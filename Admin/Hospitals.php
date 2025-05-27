<?php
include 'Admin_navbar.php';
// Database connection
$conn = new PDO('mysql:host=localhost;dbname=dev', 'root', '');

// Function to fetch all hospitals
function getAllHospitals($conn) {
    $stmt = $conn->prepare("SELECT `Hospital ID`, `Name`, `Address`, `sector`, `Grade`, `Image` FROM hospital");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if the form to add a new hospital is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_hospital'])) {
    // Collect hospital data from the form
    $name = $_POST['name'];
    $address = $_POST['address'];
    $sector = $_POST['sector'];
    $grade = $_POST['grade'];

    // Handle file upload for image
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Validate file type (only images)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowedTypes)) {
            $imagePath = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            echo "Invalid image type.";
        }
    }

    // Insert the new hospital into the database
    if ($imagePath) {
        $stmt = $conn->prepare("INSERT INTO hospital (`Hospital ID`,`Name`, `Address`, `sector`, `Grade`, `Image`) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $address, $sector, $grade, $imagePath]);
        echo "<p class='success'>Hospital added successfully.</p>";
    } else {
        echo "<p class='error'>Failed to upload image.</p>";
    }
}

// Get all hospitals
$hospitals = getAllHospitals($conn);

?>

<html>
<head>
    <title>All Hospitals</title>
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

        /* Container for Add Hospital Form */
        .add-hospital-form {
            margin-top: 40px;
            width: 80%;
            max-width: 600px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .add-hospital-form h2 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .add-hospital-form input, .add-hospital-form textarea, .add-hospital-form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .add-hospital-form input[type="file"] {
            border: none;
            padding: 12px;
        }

        .add-hospital-form button {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-hospital-form button:hover {
            background-color: #2ecc71;
        }

        /* Container for Hospital List */
        .hospital-list-container {
            margin-top: 40px;
            width: 90%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .hospital-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 320px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hospital-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .hospital-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .hospital-card h3 {
            font-size: 22px;
            color: #34495e;
            margin-bottom: 10px;
        }

        .hospital-card p {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .hospital-card .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }

        .hospital-card .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <div>
        <img src="Healthnet.png" class="ImgHeath" alt="Healthnet Logo">
    </div>

    <!-- Add Hospital Form -->
    <div class="add-hospital-form">
        <h2>Add New Hospital</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Hospital Name" required>
            <textarea name="address" placeholder="Hospital Address" rows="4" required></textarea>
            <input type="text" name="sector" placeholder="Sector" required>
            <input type="text" name="grade" placeholder="Grade" required>
            <input type="file" name="image" required>
            <button type="submit" name="add_hospital">Add Hospital</button>
        </form>
    </div>

    <!-- Display Hospitals -->
    <h1>All Hospitals</h1>
    <div class="hospital-list-container">
        <?php foreach ($hospitals as $hospital): ?>
            <div class="hospital-card">
                <img src="<?= $hospital['Image']; ?>" alt="<?= htmlspecialchars($hospital['Name']); ?>">
                <h3><?= htmlspecialchars($hospital['Name']); ?></h3>
                <p><strong>Address:</strong> <?= htmlspecialchars($hospital['Address']); ?></p>
                <p><strong>Sector:</strong> <?= htmlspecialchars($hospital['sector']); ?></p>
                <p><strong>Grade:</strong> <?= htmlspecialchars($hospital['Grade']); ?></p>
                <a href="ViewHospital.php?hospital_id=<?= htmlspecialchars($hospital['Hospital ID']); ?>" class="btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
