<?php
include 'Admin_navbar.php';
// Database connection
$conn = new PDO('mysql:host=localhost;dbname=dev', 'root', '');

// Function to fetch medicines based on search term
function getMedicines($conn, $searchTerm = '') {
    if ($searchTerm) {
        $stmt = $conn->prepare("SELECT `MedicineName`, `MedicineID`, `UsageOfMedicine`, `CategoryOfMedicine`, `PictureOfMedicine` 
                                FROM medicinedetails 
                                WHERE `MedicineName` LIKE :searchTerm OR `UsageOfMedicine` LIKE :searchTerm OR `CategoryOfMedicine` LIKE :searchTerm");
        $searchTerm = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchTerm);
    } else {
        $stmt = $conn->prepare("SELECT `MedicineName`, `MedicineID`, `UsageOfMedicine`, `CategoryOfMedicine`, `PictureOfMedicine` FROM medicinedetails");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if the form to add a new medicine is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_medicine'])) {
    // Collect medicine data from the form
    $medicineName = $_POST['medicine_name'];
    $usageOfMedicine = $_POST['usage_of_medicine'];
    $categoryOfMedicine = $_POST['category_of_medicine'];

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

    // Insert the new medicine into the database
    if ($imagePath) {
        $stmt = $conn->prepare("INSERT INTO medicinedetails (`MedicineName`, `UsageOfMedicine`, `CategoryOfMedicine`, `PictureOfMedicine`) VALUES (?, ?, ?, ?)");
        $stmt->execute([$medicineName, $usageOfMedicine, $categoryOfMedicine, $imagePath]);
        echo "<p class='success'>Medicine added successfully.</p>";
    } else {
        echo "<p class='error'>Failed to upload image.</p>";
    }
}

// Check if there's a search term
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Get medicines based on the search term
$medicines = getMedicines($conn, $searchTerm);

?>

<html>
<head>
    <title>All Medicines</title>
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

        /* Container for Add Medicine Form */
        .add-medicine-form {
            margin-top: 40px;
            width: 80%;
            max-width: 600px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .add-medicine-form h2 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .add-medicine-form input, .add-micine-form textarea, .add-medicine-form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .add-medicine-form input[type="file"] {
            border: none;
            padding: 12px;
        }

        .add-medicine-form button {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-medicine-form button:hover {
            background-color: #2ecc71;
        }

        /* Container for Medicine List */
        .medicine-list-container {
            margin-top: 40px;
            width: 90%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .medicine-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 320px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .medicine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .medicine-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .medicine-card h3 {
            font-size: 22px;
            color: #34495e;
            margin-bottom: 10px;
        }

        .medicine-card p {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .medicine-card .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }

        .medicine-card .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <div>
        <img src="../Essentials/MainLogo.png" class="ImgHeath" alt="Healthnet Logo">
    </div>

    <!-- Search Form -->
    

    <!-- Add Medicine Form -->
    <div class="add-medicine-form">
        <h2>Add New Medicine</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="medicine_name" placeholder="Medicine Name" required>
            <textarea name="usage_of_medicine" placeholder="Usage of Medicine" rows="4" required></textarea>
            <input type="text" name="category_of_medicine" placeholder="Category of Medicine" required>
            <input type="file" name="image" required>
            <button type="submit" name="add_medicine">Add Medicine</button>
        </form>
    </div>

    <!-- Display Medicines -->
    <h1>All Medicines</h1>

    <div class="search-form">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search medicines..." value="<?= htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="medicine-list-container">
        <?php foreach ($medicines as $medicine): ?>
            <div class="medicine-card">
                <img src="<?= $medicine['PictureOfMedicine']; ?>" alt="<?= htmlspecialchars($medicine['MedicineName']); ?>">
                <h3><?= htmlspecialchars($medicine['MedicineName']); ?></h3>
                <p><strong>Usage:</strong> <?= htmlspecialchars($medicine['UsageOfMedicine']); ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($medicine['CategoryOfMedicine']); ?></p>
                <a href="#" class="btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
