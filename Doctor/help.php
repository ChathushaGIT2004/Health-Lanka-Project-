<?php
   // Assuming your navigation bar is included
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Page for Doctors</title>
    <link rel="stylesheet" href="styles.css">  <!-- Make sure to link your styles -->
    <style>
        /* Add custom style for space after h2 and video container */
        h2 + .video-container {
            margin-top: 30px;  /* Adds space after h2 */
        }

        .video-container {
            padding: 20px;
            background-color: #f4f7fa;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .video-container video {
            width: 100%;
            max-width: 800px;  /* Limit the width of the video */
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
         
        
        <!-- Introduction Section -->
        <section>
            <h2>Welcome to the Doctor's Portal</h2>
            <p>Welcome to the help page for using the doctor’s portal. This page will guide you through the various features of the system, including how to manage patient information, view medical reports, and add new treatments and diagnoses.</p>
        </section>

        <!-- Navigation Overview -->
        <section>
            <h2>1. Navigating the Site</h2>
            <p>The site is organized into several sections, which you can easily access through the navigation bar at the top of the page.</p>
            <ul>
                <li><strong>Dashboard:</strong> View patient records and access their treatment history.</li>
                <li><strong>Specialization:</strong> View and update Your Specialization details.</li>
                <li><strong>Settings:</strong> Update your profile and account settings.</li>
                <li><strong>help:</strong>Gain Help .</li>
                <li><strong>About Us:</strong> View  Program details And Developer Note.</li>
                <li><strong>Log Out:</strong> Log Out Prom System</li>
                <video controls>
                <source src="../Help/NavbarDoc.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            </ul>
        </section>

        <!-- Using the Patient Dashboard -->
  

        <!-- Adding Treatment & Diagnosis -->
        <section>
            <h2>2. Adding Treatment & Diagnosis</h2>
            <p>To diagnose a patient and add treatment details, follow these steps:</p>
            <ol>
                <li>Go to the patient's <strong>treatment history</strong> section.</li>
                <li>Click on the <strong>Diagnose</strong> button to add a new diagnosis.</li>
                <li>Fill in the diagnosis details, including treatment description and any necessary notes.</li>
                <li>Click <strong>Save</strong> to add the treatment to the patient's history.</li>
            </ol>
            <video controls>
                <source src="../Help/Add Treatment.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            
        </section>

        <!-- Viewing Reports -->
        <section  class="video-container">
            <h2>4. Viewing Reports</h2>
            <p>Medical reports can be accessed from the <strong>Reports</strong> tab. Here’s how to view them:</p>
            <ol>
                <li>Click on the <strong>Reports</strong> tab in the patient's dashboard.</li>
                <li>You can view reports such as blood tests, cholesterol levels, blood pressure, etc.</li>
                <li>Click on any report name to open it. Some reports may have downloadable files that you can view in your preferred format.</li>
            </ol>
            
        </section>

 
        <!-- Adding Video Section with Space after h2 -->
       

        <!-- Contact Support -->
        <section>
            <h2>7. Contacting Support</h2>
            <p>If you encounter any technical issues or need further assistance, please contact support:</p>
            <ul>
                <li>Email: <strong>Chathushadewmin@gmail.com</strong></li>
                <li>Phone: <strong>+94 76739 0095</strong></li>
                <li>Or use the <strong>Contact Us</strong> form available under the 'Help' section on your dashboard.</li>
            </ul>
        </section>
    </div>
</body>
</html>
