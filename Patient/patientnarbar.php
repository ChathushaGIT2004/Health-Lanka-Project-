<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>

    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fb;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Horizontal Navigation Bar Styles */
        .navbar {
            width: 100%;
            /*background: linear-gradient(45deg, #000000, #8cc342); /* Modern gradient */
            color: white;
            background-color: #f7f9fb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        /* Logo Section */
        .navbar .logo,.navbar .logo img {
            
            font-size: 26px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-decoration: none;
            height: fit-content;
            width: auto;
        }

         

        /* Navigation Links */
        .navbar .nav-links {
            display: flex;
            list-style: none;
            margin-right: 20px;
            gap: 20px;
        }

        .navbar .nav-links a {
            color:  #92c342;
            font-weight: bolder;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
        }

        .navbar .nav-links a:hover {
            background-color:#92c342;
            color:white; 
            transform: scale(1.1);
        }

        .navbar .nav-links a:focus {
            outline: none;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            color: #92c342;
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            border-radius: 8px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px);
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
        }

        .dropdown:hover .dropdown-content {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-content a {
            padding: 12px 20px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #007c6c;
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background-color: #007c6c;
        }

        /* Hamburger menu styles for mobile */
        .navbar .menu-icon {
            display: none;
            flex-direction: column;
            cursor: pointer;
            margin-right: 20px;
        }

        .navbar .menu-icon div {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 4px 0;
            transition: 0.3s ease;
        }

        /* Main content styles */
        .content {
            flex-grow: 1;
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        /* Media Queries for responsiveness */
        @media screen and (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 10px;
            }

            .navbar .logo {
                font-size: 22px;
                margin-bottom: 10px;
            }

            .navbar .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                text-align: center;
                gap: 0;
            }

            .navbar .nav-links a {
                padding: 15px;
                font-size: 16px;
            }

            .navbar .nav-links.active {
                display: flex;
            }

            .navbar .menu-icon {
                display: flex;
            }

            .dropdown-content {
                position: relative;
                width: 100%;
                box-shadow: none;
            }

            .dropdown:hover .dropdown-content {
                display: block;
                transform: translateY(0);
            }

            .dropdown-content a {
                font-size: 14px;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>

<!-- Horizontal Navigation Bar -->
<div class="navbar">
    <!-- Logo Section -->
    <a href="Patientpage.php?PatientID=<?= urlencode($PatientID); ?>" class="logo"><img src="../Essentials/WhiteBG.png" alt="HealthLANKA"></a>
    
    <!-- Navigation Links -->
    <div class="nav-links">
        <!-- Analyze Dropdown -->
        <div class="dropdown">
            <a href="#" class="dropbtn">Analyze</a>
            <div class="dropdown-content">
                <a href="DiabeticAnalyze.php?PatientID=<?= urlencode($PatientID); ?>">Diabetic Info</a>
                <a href="CholesterolAnalyze.php?PatientID=<?= urlencode($PatientID); ?>">Cholesterol Info</a>
                <a href="BloodPressureAnalyze.php?PatientID=<?= urlencode($PatientID); ?>">Blood Pressure Info</a>
            </div>
        </div>

        <!-- Other Links -->
        <a href="PatientHistory.php?PatientID=<?= urlencode($PatientID); ?>">Recent Activities</a>
        <a href="settings.php?PatientID=<?= urlencode($PatientID); ?>">Settings</a>
        <a href="help.php?PatientID=<?= urlencode($PatientID); ?>">Help</a>
        <a href="../About.html">About Us</a>
        <a href="../index.php">Logout</a>
    </div>
    
    <!-- Hamburger Menu Icon (for mobile) -->
    <div class="menu-icon" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <h1>Welcome to your Dashboard</h1>
    <!-- Content will go here -->
</div>

<!-- Script to toggle the navigation menu on mobile -->
<script>
    function toggleMenu() {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.toggle('active');
    }
</script>

</body>
</html>
