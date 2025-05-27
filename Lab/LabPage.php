<?php
// Assuming LabID is passed in the URL (this can be used for dynamic content if necessary)
$LabID = isset($_GET['LabID']) ? $_GET['LabID'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Main Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            font-size: 16px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }

        .form-container {
            display: none;
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
        }

        label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Welcome to Lab Main Page</h2>

<div class="container">
    <!-- Buttons for History and Issue Report -->
    <button class="button" id="historyBtn">History</button>
    <button class="button" id="issueReportBtn">Issue Report</button>
</div>

<!-- Issue Report Form (hidden initially) -->
<div class="form-container" id="issueReportForm">
    <h3>Select Issue Type</h3>
    <form action="" method="POST" id="issueReportFormAction">
        <label for="issueType">Select Issue:</label>
        <select name="issueType" id="issueType" required>
            <option value="diabetic">Diabetic</option>
            <option value="cholesterol">Cholesterol</option>
            <option value="blood_pressure">Blood Pressure</option>
            <option value="other">Other</option>
        </select>
        <input type="submit" value="Submit Report">
    </form>
</div>

<!-- History Section (hidden initially) -->
<div class="form-container" id="historyForm">
    <h3>History Section</h3>
    <p>Display patient history or any related records here.</p>
</div>

<script>
    // Event listener for Issue Report button
    document.getElementById('issueReportBtn').addEventListener('click', function() {
        document.getElementById('issueReportForm').style.display = 'block';
        document.getElementById('historyForm').style.display = 'none';
    });

    // Event listener for History button
    document.getElementById('historyBtn').addEventListener('click', function() {
        document.getElementById('historyForm').style.display = 'block';
        document.getElementById('issueReportForm').style.display = 'none';
    });

    // Dynamically update form action based on selected issue type
    document.getElementById('issueType').addEventListener('change', function() {
        var issueType = this.value;
        var formAction = ''; // Initialize empty action

        // Set form action based on selected issue
        switch (issueType) {
            case 'diabetic':
                formAction = 'diabetic_report.php';
                break;
            case 'cholesterol':
                formAction = 'cholesterol_report.php';
                break;
            case 'blood_pressure':
                formAction = 'bloodpressure_report.php';
                break;
            case 'other':
                formAction = 'other_report.php';
                break;
        }

        // Update the form action attribute dynamically
        document.getElementById('issueReportFormAction').action = formAction;
    });

    // Ensure the form action is set initially based on default selected issue
    document.addEventListener('DOMContentLoaded', function() {
        var initialIssueType = document.getElementById('issueType').value;
        var formAction = '';

        switch (initialIssueType) {
            case 'diabetic':
                formAction = 'diabetic_report.php';
                break;
            case 'cholesterol':
                formAction = 'cholesterol_report.php';
                break;
            case 'blood_pressure':
                formAction = 'bloodpressure_report.php';
                break;
            case 'other':
                formAction = 'other_report.php';
                break;
        }

        document.getElementById('issueReportFormAction').action = formAction;
    });
</script>

</body>
</html>
