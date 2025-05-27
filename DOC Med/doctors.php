<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dev"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the number of doctors to display per page
$doctors_per_page = 10;

// Get the current page number from the URL, default to 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $doctors_per_page;

// Get the search term if it's provided
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Query to get doctors' details with pagination and optional search
$sql_doctors = "SELECT DoctorID, FirstName, LastName, ContactNo, Email, Password, Image 
                FROM doctors 
                WHERE FirstName LIKE '%$search_term%' OR LastName LIKE '%$search_term%' 
                LIMIT $offset, $doctors_per_page";
$result_doctors = $conn->query($sql_doctors);

// Query to get the total number of doctors for pagination
$sql_total_doctors = "SELECT COUNT(DoctorID) AS total 
                      FROM doctors 
                      WHERE FirstName LIKE '%$search_term%' OR LastName LIKE '%$search_term%'";
$result_total = $conn->query($sql_total_doctors);
$total_row = $result_total->fetch_assoc();
$total_doctors = $total_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_doctors / $doctors_per_page);

// Get specialization search term if it's provided
$specialization_search_term = isset($_GET['specialization_search']) ? $_GET['specialization_search'] : '';

// Query to get the specializations, with optional search
$sql_specializations = "SELECT DISTINCT `Specilization ID` 
                        FROM `doctor-specialization`
                        JOIN `specialization` ON `doctor-specialization`.`Specilization ID` = `specialization`.`Specilizaton ID`
                        WHERE `specialization`.`Name` LIKE '%$specialization_search_term%'";

$result_specializations = $conn->query($sql_specializations);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List</title>
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

        /* Doctor Cards */
        .doctor-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .doctor-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
        }

        .doctor-card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .doctor-card h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }

        .doctor-card p {
            font-size: 14px;
            color: #777;
            margin: 5px 0;
        }

        .doctor-card a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .doctor-card a:hover {
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

        /* Specialization Section */
        h2 {
            text-align: center;
            margin-top: 40px;
            color: #333;
            font-size: 24px;
        }

        .specialization-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            gap: 20px;
        }

        .specialization-item {
            width: 80%;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .specialization-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        /* Contact Cards under Specializations */
        .contact-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .contact-card {
            background: white;
            border-radius: 10px;
            width: 250px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
        }

        .contact-card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .contact-card h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }

        .contact-card p {
            font-size: 14px;
            color: #777;
            margin: 5px 0;
        }

        .contact-card a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .contact-card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<img src="../Essentials/MainLogo.png" style="display: block; margin: 0 auto; width: 200px;">

<!-- Search Form for Doctor List -->
<div class="search-form">
    <form action="" method="GET">
        <input type="text" name="search" value="<?php echo $search_term; ?>" placeholder="Search by doctor name...">
        <button type="submit">Search</button>
    </form>
</div>

<?php
// Display the doctor list
if ($result_doctors->num_rows > 0) {
    echo "<h1>Doctor List</h1>";
    echo "<div class='doctor-cards'>";

    // Output each doctor's data as a card
    while($row = $result_doctors->fetch_assoc()) {
        echo "<div class='doctor-card'>
                <img src='".$row['Image']."' alt='".$row['FirstName']." ".$row['LastName']."'>
                <h3>Dr. ".$row['FirstName']." ".$row['LastName']."</h3>
                <p>Contact: ".$row['ContactNo']."</p>
                <p>Email: ".$row['Email']."</p>
                <a href='doctor.php?doctor_id=".$row['DoctorID']."'>View Details</a>
              </div>";
    }

    echo "</div>";

    // Pagination
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?search=$search_term&page=$i'>$i</a>";
    }
    echo "</div>";

} else {
    echo "<p>No doctors found.</p>";
}
?>

<!-- Search Form for Specializations -->
<div class="search-form">
    <form action="" method="GET">
        <input type="text" name="specialization_search" value="<?php echo $specialization_search_term; ?>" placeholder="Search specializations...">
        <button type="submit">Search</button>
    </form>
</div>

<?php
// Display Specializations and Doctors
if ($result_specializations->num_rows > 0) {
    echo "<h2>Specializations</h2>";
    echo "<div class='specialization-list'>";

    while ($row = $result_specializations->fetch_assoc()) {
        $specialization_id = $row['Specilization ID'];

        // Query to get the specialization name
        $sql_specialization_name = "SELECT `Name` FROM `specialization` WHERE `Specilizaton ID` = '$specialization_id'";
        $result_specialization_name = $conn->query($sql_specialization_name);
        $specialization_name = "";

        if ($result_specialization_name->num_rows > 0) {
            $specialization_row = $result_specialization_name->fetch_assoc();
            $specialization_name = $specialization_row['Name'];
        }

        // Query to get doctors for this specialization
        $sql_doctors_specialization = "SELECT d.DoctorID, d.FirstName, d.LastName, d.ContactNo, d.Email, d.Image
                                       FROM doctors d
                                       JOIN `doctor-specialization` ds ON d.DoctorID = ds.`Doctor  ID`
                                       WHERE ds.`Specilization ID` = '$specialization_id'";

        $result_doctors_specialization = $conn->query($sql_doctors_specialization);

        echo "<div class='specialization-item'>
                <div class='specialization-name'>$specialization_name</div>
                <div class='contact-cards'>";

        if ($result_doctors_specialization->num_rows > 0) {
            while ($doctor_row = $result_doctors_specialization->fetch_assoc()) {
                echo "<div class='contact-card'>
                        <img src='".$doctor_row['Image']."' alt='".$doctor_row['FirstName']." ".$doctor_row['LastName']."'>
                        <h3>Dr. ".$doctor_row['FirstName']." ".$doctor_row['LastName']."</h3>
                        <p>Contact: ".$doctor_row['ContactNo']."</p>
                        <p>Email: ".$doctor_row['Email']."</p>
                        <a href='doctor.php?doctor_id=".$doctor_row['DoctorID']."'>View Details</a>
                      </div>";
            }
        } else {
            echo "<p>No doctors found for this specialization.</p>";
        }

        echo "</div></div>";
    }

    echo "</div>";
} else {
    echo "<p>No specializations found.</p>";
}

$conn->close();
?>

</body>
</html>
