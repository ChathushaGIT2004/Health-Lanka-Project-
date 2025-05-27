<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <style>
       
        .navbar {
             
            width: 90%;
            background-color: #ffffff;
            padding: 10px 20px;
            border-bottom: 2px solid #34db85;
            border-left:2px solid #34db85;
            border-right: 2px solid #34db85; 
            border-bottom-left-radius:10px ;
            border-bottom-right-radius: 10px;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }

        .navbar ul li {
            margin: 0;
            position: relative; 
        }

        .navbar ul li a {
            color: #000000;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            transition: background-color 0.3s;
        }

        .navbar ul li a:hover {
            background-color: #34dbd1;
            border-radius: 5px;
            color: #ffffff;
        }

        
        .navbar ul li ul {
            display: none; 
            position: absolute;
            top: 100%; 
            left: 0;
            background-color: #ffffff;
            padding: 10px 0;
            border: 1px solid #34db85;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .navbar ul li ul li {
            margin: 0;
        }

        .navbar ul li ul li a {
            padding: 8px 20px;
            display: block;
            color: #000000;
            text-align: left;
        }

        .navbar ul li ul li a:hover {
            background-color:#34db85;
            border-radius: 5px;
            color: #ffffff;
        }

        /* Show dropdown on hover */
        .navbar ul li:hover ul {
            display: block;
        }

    
        .ser {
            background-color: #ffffff00;
            border-radius: 5px;
            color: #000000;
            padding: 4%;
        }

        .ser:hover {
            background-color: #ce0808;
            border-radius: 5px;
            color: #ffffff;
        }


        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #000000;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li>
                <a  class="ser">Services</a>
                <ul>
                    <li><a href="doctors.php">Doctors</a></li>
                    <li><a href="medicines.php">Medicines</a></li>
                    <li><a href="hospitals.php">Hospitals</a></li>
                </ul>
            </li>
            <li><a href="about.php">About Us</a></li>
            <li><a >Login</a>
            <ul>
                    <li><a href="Admin/Admin_login.php">Admin</a></li>
                    <li><a href="Doctor/Doctor_login.php">Doctor</a></li>
                    <li><a href="hospitals.php">Hospitals</a></li>
                    <li><a href="Patient/PatientLogin.php">Patient</a></li>
                </ul>
        </li>
           
        </ul>
    </nav>
</body>
</html>
