<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* Reset default margin and padding */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f7;
        }

        /* Navbar Styling */
        .navbar {
            position: fixed;
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            z-index: 1000;
        }

        .navbar .logo, .navbar .logo img {
            font-size: 26px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-decoration: none;
            height: 75px;
            width: auto;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .navbar ul li {
            margin: 0 20px;
            position: relative;
        }

        .navbar ul li a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #92c342;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .navbar ul li a i {
            margin-right: 10px;
        }

        .navbar ul li a:hover {
            background-color: #92c342;
            transform: scale(1.05);
            color: #ffffff;
        }

        /* Side Navigation Styling */
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
        }

        .sidenav a {
            padding: 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            background-color: #ddd;
            color: black;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            color: #818181;
            padding: 16px;
            cursor: pointer;
        }

        /* Main content area */
        .content {
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            margin-top: 80px; /* Space for fixed navbar */
        }

        /* Hamburger menu for side nav */
        .hamburger {
            display: none;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar ul {
                display: none; /* Hide default navbar on small screens */
            }

            .hamburger {
                display: block;
            }

            .navbar {
                padding: 10px 15px;
            }
        }

        /* Adjusting navbar for smaller screens */
        @media (max-width: 480px) {
            .navbar ul li a {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>

<!-- Horizontal Navbar -->
<nav class="navbar">
    <div class="logo">
        <img src="../Essentials/WhiteBG.png" alt="Admin Dashboard">
    </div>

    <div class="hamburger" onclick="openNav()">
        &#9776; <!-- Hamburger Icon -->
    </div>

    <ul>
        <!-- Home link -->
        <li><a href="Admin_page.php"><i class="fas fa-tachometer-alt"></i>Home</a></li>

        <!-- Patients link -->
        <li><a href="Patients.php"><i class="fas fa-users"></i>Patients</a></li>

        <!-- Doctors link -->
        <li><a href="Doctors.php"><i class="fas fa-user-md"></i>Doctors</a></li>

        <!-- Hospitals link -->
        <li><a href="Hospitals.php"><i class="fas fa-hospital"></i>Hospitals</a></li>

        <!-- Medicines link -->
        <li><a href="Medicines.php"><i class="fas fa-pills"></i>Medicines</a></li>
       
        <!-- About Us link -->
        <li><a href="../About.html"><i class="fas fa-info-circle"></i>About Us</a></li>
        
        <!-- Logout link -->
        <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i>Log out</a></li>
    </ul>
</nav>

<!-- Side Navigation -->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="Admin_page.php"><i class="fas fa-tachometer-alt"></i>Home</a>
    <a href="Patients.php"><i class="fas fa-users"></i>Patients</a>
    <a href="Doctors.php"><i class="fas fa-user-md"></i>Doctors</a>
    <a href="Hospitals.php"><i class="fas fa-hospital"></i>Hospitals</a>
     
    <a href="Medicines.php"><i class="fas fa-pills"></i>Medicines</a>
 <a href="../About.html"><i class="fas fa-info-circle"></i>About Us</a>
    <a href="../index.php"><i class="fas fa-sign-out-alt"></i>Log out</a>
</div>

<!-- Add FontAwesome icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<!-- JavaScript for the side navigation -->
<script>
    // Function to open the side navigation
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    // Function to close the side navigation
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>

</body>
</html>
