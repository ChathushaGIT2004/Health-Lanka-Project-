<?php
include "DBConnection.php";
// Handle search query
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Pagination logic
$limit = 50;  // number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query for medicines list
$sql = "SELECT `MedicineName`, `MedicineID`, `PictureOfMedicine` 
        FROM `medicinedetails`
        WHERE `MedicineName` LIKE '%$searchQuery%' OR `MedicineID` LIKE '%$searchQuery%' OR `CategoryOfMedicine` LIKE '%$searchQuery%'
        LIMIT $limit OFFSET $offset";

$result = $con->query($sql);
$medicines = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $medicines[] = $row;
    }
}

// Calculate total pages
$totalResult = $con->query("SELECT COUNT(*) AS total FROM `medicinedetails` WHERE `MedicineName` LIKE '%$searchQuery%' OR `MedicineID` LIKE '%$searchQuery%' OR `CategoryOfMedicine` LIKE '%$searchQuery%'");
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine List</title>
    <style>
 /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f2f5;
    color: #333;
}

h1 {
    text-align: center;
    color: #333;
    margin: 20px 0;
}

/* Search Form */
.search-form {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.search-form input[type="text"] {
    padding: 10px;
    width: 300px;
    font-size: 16px;
    border: 2px solid #ddd;
    border-radius: 5px;
    margin-right: 10px;
    transition: border-color 0.3s ease;
}

.search-form input[type="text"]:focus {
    border-color: #4CAF50;
    outline: none;
}

.search-form button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.search-form button:hover {
    background-color: #45a049;
}

/* Medicine Cards */
.medicine-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.medicine-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 250px;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease;
}

.medicine-card:hover {
    transform: translateY(-5px);
}

.medicine-card img {
    border-radius: 50%;
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-bottom: 10px;
}

.medicine-card h3 {
    margin: 10px 0;
    font-size: 18px;
    color: #333;
}

.medicine-card p {
    font-size: 14px;
    color: #777;
    margin: 5px 0;
}

.medicine-card a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: bold;
}

.medicine-card a:hover {
    text-decoration: underline;
}

/* Pagination Styles */
.pagination {
    text-align: center;
    margin-top: 20px;
}

.pagination a {
    margin: 0 5px;
    padding: 8px 16px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.pagination a:hover {
    background-color: #45a049;
}

.pagination a:active {
    background-color: #3e8e41;
}

/* Responsive Styles (Media Queries) */
@media (max-width: 768px) {
    /* For tablets and smaller screens */
    .search-form input[type="text"] {
        width: 80%;
    }

    .medicine-cards {
        gap: 15px;
    }

    .medicine-card {
        width: 220px;
    }
}

@media (max-width: 480px) {
    /* For mobile phones */
    h1 {
        font-size: 24px;
        margin: 10px 0;
    }

    .search-form input[type="text"] {
        width: 70%;
    }

    .search-form button {
        width: 100%;
        padding: 12px 0;
    }

    .medicine-cards {
        gap: 10px;
        justify-content: flex-start;
    }

    .medicine-card {
        width: 180px;
        padding: 15px;
    }

    .pagination a {
        padding: 6px 12px;
    }
}

    </style>
</head>
<body>
    <header>
        <img src="Essentials/MainLogo.png" style="display: block; margin: 0 auto; width: 200px;">
        <h1>Medicine List</h1>
    </header>

    <!-- Search Form for Medicine List -->
    <div class="search-form">
        <form action="" method="GET">
            <input type="text" name="search" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Search by Name, ID, or Category">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Medicine Cards Display -->
    <div class="medicine-cards">
        <?php foreach ($medicines as $medicine): ?>
            <div class="medicine-card">
                <img src="images/<?= $medicine['PictureOfMedicine'] ?>" alt="<?= $medicine['MedicineName'] ?>" class="medicine-image">
                <h3><a href="medicine_details.php?id=<?= $medicine['MedicineID'] ?>" ><?= $medicine['MedicineName'] ?></a></h3>
                <p>Medicine ID: <?= $medicine['MedicineID'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= htmlspecialchars($searchQuery) ?>" class="pagination-link <?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>
