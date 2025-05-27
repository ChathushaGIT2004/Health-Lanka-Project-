<?php
include_once "../DBConnection.php";

$Doc = $_GET['DoctorID'];  // Get the DoctorID from the URL
$HospitalID = $_GET['HospitalID'];  // Get the HospitalID from the URL
include "Doctor_navbar.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['search'] ?? '';

    // Fetch matching patients
    $query = "SELECT * FROM `patient` WHERE `Last_Name` LIKE ? OR `Patient_Id` LIKE ? OR `First_name` LIKE ? OR `Email` LIKE ?";
    $stmt = $con->prepare($query);
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}

// Function to calculate age
function calculateAge($dob) {
    $birthDate = new DateTime($dob);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y; // Calculate difference in years
    return $age;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Patient</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            color: #00509e;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        input[type="text"] {
            width: 70%;
            padding: 12px;
            font-size: 1rem;
            border: 2px solid #007bff;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #00509e;
        }

        button {
            padding: 12px 24px;
            font-size: 1rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #00509e;
        }

        .patient-results {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .patient-card {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s;
            cursor: pointer;
            padding: 20px;
        }

        .patient-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.15);
            border: 2px solid #007bff;
        }

        .patient-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 20px;
        }

        .patient-card .details {
            flex-grow: 1;
            text-align: left;
        }

        .patient-card h3 {
            font-size: 1.4rem;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .patient-card p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 8px;
        }

        .patient-card .age {
            font-weight: 600;
            color: #007bff;
        }

        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .loading::after {
            content: '';
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .patient-card img {
                width: 100px;
                height: 100px;
            }

            .patient-card {
                flex-direction: column;
                text-align: center;
            }

            .patient-card img {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .patient-card h3 {
                font-size: 1.2rem;
            }

            .patient-card .details {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search Patient</h2>
        <form method="POST">
            <input type="text" name="search" placeholder="Search by Name, Email, or ID" required>
            <button type="submit">Search</button>
        </form>

        <div class="patient-results">
            <?php if (isset($result)): ?>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="patient-card" onclick="viewPatientDetails(<?php echo $row['Patient_Id']; ?>)">
                            <img src="<?php echo $row['Image']; ?>" alt="Patient Image">
                            <div class="details">
                                <h3><?php echo $row['First_name']; ?> <?php echo $row['Last_Name']; ?></h3>
                                <p>Patient ID: <?php echo $row['Patient_Id']; ?></p>
                                <p>Email: <?php echo $row['Email']; ?></p>
                                <p class="age">Age: <?php echo calculateAge($row['Date of birth']); ?> years</p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No patients found matching your search.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function viewPatientDetails(patientId) {
            var doctorId = <?php echo json_encode($Doc); ?>;
            var hospitalId = <?php echo json_encode($HospitalID); ?>;
            window.location.href = `AddTreatment2.php?patientId=${patientId}&DoctorID=${doctorId}&HospitalID=${hospitalId}`;
        }
    </script>
</body>
</html>
