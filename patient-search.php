<?php
include 'navbar.php';
// Database connection
$conn = new PDO('mysql:host=localhost;dbname=data', 'root', '');

// Retrieve doctor details from the URL parameter
$PatientName = isset($_POST['NIC_no']) ? $_POST['NIC_no'] : '';


// Fetch doctor details from the database
$stmt = $conn->prepare("SELECT * FROM patient WHERE NIC = :NIC_no");
$stmt->bindParam(':NIC_no', $PatientName);

$stmt->execute();
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$doctor) {
    echo "Patient not found.";
    exit;
}


$diabetesLevel = $doctor['Diabeties_level'];
$diabetesColor = '#00FF00'; // Default color (Green)

if ($diabetesLevel > 110) {
    $diabetesColor = '#FF0000'; // Red for high level
} elseif ($diabetesLevel < 72) {
    $diabetesColor = '#FFA500'; // Orange for low level
}
?>

<html>
<head>
    <title>Doctor Details</title>
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            
            align-items: center;
            justify-content: center;
        }

        /* Logo Styles */
        .ImgHeath {
            margin: 20px auto;
            max-width: 120px;
            align-items: center;
            margin-left: 50%;
        }

        /* Title Styles */
        h1 {
            font-size: 36px;
            color: #003366;
            margin: 20px;
        }

        h2 {
            font-size: 24px;
            color: #00509e;
            margin-top: 20px;
        }

        .doctor-container {
            background-color: #fff;
            border-top-LEFT-radius: 75px;
            padding: 20px;
            max-width: 70%;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-top-right-radius: 70px;
            margin-left: 15%;
            margin-right: 15%;
            align-self: center;
        }

        .doctor-container h1{
            margin-left: 25%;
            margin-top: -20%;
            font-size: 40px;
        }
        .doctor-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .doctor-info img {
            width: 200px;
            height: 200px;
            border-radius: 8px;
            object-fit: cover;
        }

        .doctor-details {
            max-width: 60%;
            padding-left: 20px;
            margin-left: 25%;
            margin-top: 0;
        }

        .doctor-details p {
           
            
            font-size: 18px;
            color: #555;
        }

        .doctor-details p span {
            font-weight: bold;
        }
        .imgDoctor{
          border-radius:30%;
          border-bottom-left-radius:0;
          border-top-right-radius:0%;
          display: block;
          box-shadow: 5 5 solid #000000;
          margin-left: -20PX;
          margin-TOP: -20PX;
          width: 250px;
          height:250px;
        }
        .Diabeties {
        color: <?= $diabetesColor; ?>;  
    }

        

    </style>
</head>
<body>
    
    <div>
        <img src="Healthnet.png" class="ImgHeath" alt="Healthnet Logo">
    </div>
   
    <div class="doctor-container">
  <img src="<?= $doctor['Image']; ?>" class="imgDoctor" alt="<?= $doctor['First_Name']; ?>">
        <h1> <?= htmlspecialchars($doctor['First_Name']); ?> <?= htmlspecialchars($doctor['Last_Name']); ?></h1>
        <div class="doctor-info">
            
            <div class="doctor-details">
            
              <p><span>Address:</span> <?= $doctor['Address']; ?></p>
                <p><span>Date Of birth:</span> <?= $doctor['Date_of_birth']; ?></p>
                <p><span>Gender:</span> <?= $doctor['Gender']; ?></p>
                <p><span>Blood type:</span> <?= $doctor['Blood_Type']; ?></p>
                <p><span>Diabeties type:</span> <?= $doctor['Diabeties Type']; ?></p>
                <p><span>Diabeties level:</span> <span class="Diabeties"><?= $doctor['Diabeties_level']; ?></span></p>
                <!--<p><span>Contact:</span> <?= $doctor['contact']; ?></p>-->
               
            </div>
        </div>
        
    </div>

</body>
</html>
