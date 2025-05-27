<?php
$PatientID = $_GET['PatientID'];
include "patientnarbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How to Use the Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 30px;
            color: #009879;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 40px;
        }

        .section h2 {
            font-size: 24px;
            color: #009879;
            margin-bottom: 10px;
        }

        .section p {
            font-size: 18px;
            color: #555;
        }

        .list {
            list-style-type: none;
            padding-left: 0;
        }

        .list li {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .highlight {
            font-weight: bold;
            color: #009879;
        }

        .back-link {
            background-color: #009879;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }

        .back-link:hover {
            background-color: #007c64;
        }

        .video-container {
            margin: 20px 0;
        }

        video {
            width: 100%;
            height: 500px;
            border-radius: 8px;
            background-color: #000;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>How to Use the Site</h1>

        <div class="section">
            <h2>Welcome!</h2>
            <p>Welcome to our site! This site helps you manage patient-doctor meetups and track dispensed medicines. Follow the instructions below to learn how to use each feature of the site.</p>
        </div>

        <div class="section">
            <h2>1. View Your MeetUp History</h2>
            <p>To view the details of a specific meet-up between a patient and doctor, follow these steps:</p>
            <ul class="list">
                <li>Click on the "MeetUp History" link in the main menu.</li>
                
                <li>You will see detailed information about the meet-up, including the diagnosis, treatment, notes, and the doctor's name.</li>
            </ul>

            <!-- Local Video Tutorial for View MeetUp History -->
            <div class="video-container">
                <h3>Watch a Video Tutorial</h3>
                <video controls>
                    <source src="../Help/history.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <div class="section">
            <h2>2. Rate Your MeetUp</h2>
            <p>If the meet-up hasn't been rated yet, you can rate it:</p>
            <ul class="list">
                <li>After viewing the meet-up details, look for the "Rate this MeetUp" button.</li>
                <li>Click the button to rate the meet-up (from 1 to 5 stars).</li>
                <li>Your rating will help improve the quality of care and treatment recommendations.</li>
            </ul>

            <!-- Local Video Tutorial for Rate MeetUp -->
            <div class="video-container">
                <h3>Watch a Video Tutorial</h3>
                <video controls>
                    <source src="../Help//rating.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <div class="section">
            <h2>3. View Dispensed Medicines</h2>
            <p>For each meet-up, you can also view the dispensed medicines:</p>
            <ul class="list">
                <li>On the meet-up details page, scroll down to see a table with all dispensed medicines for that meet-up.</li>
                <li>Each row will display the medicine name, dosage details, and any associated notes from the doctor.</li>
                <li>If the medicine has a picture, it will be shown next to the name for better identification.</li>
            </ul>

            

        <div class="section">
            <h2>4. Contact Us</h2>
            <p>If you have any questions, feel free to <a href="contact.php" class="back-link">contact us</a> for more information or assistance.</p>
        </div>

         
    </div>

</body>
</html>
