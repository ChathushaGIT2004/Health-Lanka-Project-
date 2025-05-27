<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "dev");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch doctors, specializations, and hospitals
$query_doctors ="SELECT 
d.DoctorID, 
d.FirstName, 
d.LastName, 
d.ContactNo, 
d.Email, 
d.Password, 
d.LoginCount, 
d.Image, 
s.SpecializationName,
ds.Proof
FROM 
doctors d
JOIN 
doctor_specialization ds ON d.DoctorID = ds.DoctorID
JOIN 
specializations s ON ds.SpecializationID = s.SpecializationID;";
// Ordering by name instead of rate
$result_doctors = mysqli_query($con, $query_doctors);

// Fetch specializations
$query_specializations = "SELECT SpecilizationID, Name FROM specialization";
$result_specializations = mysqli_query($con, $query_specializations);

// Fetch hospitals for each doctor
$query_hospitals = "SELECT dh.DoctorID, h.Name as HospitalName 
                    FROM doctor-hospital dh 
                    JOIN hospital h ON dh.HospitalID = h.HospitalID";
$result_hospitals = mysqli_query($con, $query_hospitals);

// Function to search doctors
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $search_query = "SELECT * FROM doctors WHERE FirstName LIKE '%$search_term%' OR LastName LIKE '%$search_term%' OR DoctorID LIKE '%$search_term%'";
    $result_doctors = mysqli_query($con, $search_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        .doctor-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }
        .doctor-card {
            background-color: white;
            border: 1px solid #ddd;
            padding: 15px;
            width: 200px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .doctor-card:hover {
            background-color: #f0f0f0;
        }
        .doctor-card h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .doctor-card p {
            font-size: 14px;
            color: #555;
        }
        .search-bar {
            text-align: center;
            margin-top: 20px;
        }
        .search-bar input {
            padding: 8px;
            width: 300px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-bar button {
            padding: 8px 16px;
            margin-left: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #444;
        }
    </style>
</head>
<body>

<header>
    <h1>Doctors List</h1>
</header>

<!-- Search Bar -->
<div class="search-bar">
    <form method="POST">
        <input type="text" name="search_term" placeholder="Search by name, specialization, or doctor ID">
        <button type="submit" name="search">Search</button>
    </form>
</div>

<div class="doctor-list">
    <?php while ($doctor = mysqli_fetch_assoc($result_doctors)): ?>
        <div class="doctor-card" onclick="window.location.href='doctor_details.php?doctorID=<?php echo $doctor['DoctorID']; ?>'">
            <h3><?php echo $doctor['FirstName'] . ' ' . $doctor['LastName']; ?></h3>
            <p>Doctor ID: <?php echo $doctor['DoctorID']; ?></p>
            <p>Specialization: 
                <?php
                    // Find the specialization for this doctor
                    $specialization_name = "";
                    mysqli_data_seek($result_specializations, 0); // Reset specializations result pointer
                    while ($specialization = mysqli_fetch_assoc($result_specializations)) {
                        if ($specialization['SpecilizationID'] == $doctor['SpecilizationID']) {
                            $specialization_name = $specialization['Name'];
                            break;
                        }
                    }
                    echo $specialization_name;
                ?>
            </p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
