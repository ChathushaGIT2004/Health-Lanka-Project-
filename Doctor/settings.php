<?php

$doctorID = $_GET['DoctorID'];
$HospitalID=$_GET['HospitalID']  ; 
include "Doctor_navbar.php";


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Settings Page</title>
    <style>
        /* General body styling */
        body {
            margin-top: 150px;
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container to center the form */
        .settings-container {
            margin-top: 300px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            margin: 20px;
        }

        /* Header styling */
        h1 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        /* Form group styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Labels for inputs */
        label {
            font-size: 1rem;
            color: #555;
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
        }

        /* Input fields styling */
        input[type="email"],
        input[type="text"],
        input[type="password"],
        input[type="file"],
        button {
            width: 100%;
            padding: 0.8rem;
            margin-top: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f7f9fb;
            color: #333;
        }

        input[type="email"]:focus,
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0066cc;
            outline: none;
        }

        input[type="file"] {
            padding: 5px;
        }

        /* Button styling */
        button {
            background-color: #00b6a8;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 5px;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #009780;
        }

        /* Error or success message styling */
        .success,
        .error {
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
            border-radius: 5px;
            font-size: 1rem;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Media query for responsiveness */
        @media (max-width: 768px) {
            .settings-container {
                padding: 2rem;
                width: 90%;
            }

            h1 {
                font-size: 1.25rem;
            }

            label {
                font-size: 0.9rem;
            }

            input[type="email"],
            input[type="text"],
            input[type="password"],
            input[type="file"],
            button {
                font-size: 0.9rem;
            }

            button {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .settings-container {
                padding: 1.5rem;
                width: 95%;
            }

            h1 {
                font-size: 1.1rem;
            }

            input[type="email"],
            input[type="text"],
            input[type="password"],
            input[type="file"],
            button {
                font-size: 0.85rem;
            }

            button {
                padding: 0.8rem;
            }
        }

    </style>
</head>
<body>
    <div class="settings-container">
        <h1>Update Your Details</h1>
        <form action="update_Doctor.php?$DoctorID=<?= urlencode($doctorID); ?>&HospitalID=<?= urlencode($HospitalID); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="" required>
            </div>

            <div class="form-group">
                <label for="contact_no">Contact Number:</label>
                <input type="text" name="contact_no" id="contact_no" value="" required>
            </div>

            

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="" required>
            </div>

            <div class="form-group">
                <label for="image">Profile Image:</label>
                <input type="file" name="image" id="image">
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
