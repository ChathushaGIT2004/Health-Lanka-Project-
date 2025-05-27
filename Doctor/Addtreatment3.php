<?php
include_once "../DBConnection.php";

// Start session if needed for doctor information
session_start();

// Get DoctorID and PatientID from GET parameters
$DoctorID = $_GET['DoctorID'];
$patientId = $_GET['patientId'];
$HospitalID=$_GET['HospitalID'];

// Initialize variables for Diagnosis Form
$DiagnosisName = $DiagnosisDescription = $TreatmentDescription = $ImportantNotes = '';

// Fetch medicines for dispensing
$query = "SELECT * FROM medicinedetails";
$stmt = $con->prepare($query);
$stmt->execute();
$medicineList = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Diagnosis and Dispense Medicine</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Modern and Clean CSS Design */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #007BFF;
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            color: #333;
            background-color: #f7f7f7;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #007bff;
            background-color: #ffffff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        button:hover {
            background: linear-gradient(90deg, #00c6ff, #007bff);
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.6rem;
            }

            input, textarea, select {
                font-size: 0.95rem;
            }

            button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Diagnosis and Dispense Medicine</h2>

    <!-- Diagnosis Form (No Save button) -->
    <form method="POST" action="AddTreatment5.php" id="addMedicineForm">
        <input type="hidden" name="DoctorID" value="<?= $DoctorID; ?>">
        <input type="hidden" name="patientId" value="<?= $patientId; ?>">
        <input type="hidden" name="HospitalID"  value="<?=$HospitalID;?>">

        <div class="form-section">
            <label for="DiagnosisName">Diagnosis Name</label>
            <input type="text" id="DiagnosisName" name="DiagnosisName" value="<?= $DiagnosisName; ?>" required>
        </div>

        <div class="form-section">
            <label for="DiagnosisDescription">Diagnosis Description</label>
            <textarea id="DiagnosisDescription" name="DiagnosisDescription" rows="4"  ><?= $DiagnosisDescription; ?></textarea>
        </div>

        <div class="form-section">
            <label for="TreatmentDescription">Treatment Description</label>
            <textarea id="TreatmentDescription" name="TreatmentDescription" rows="4"  ><?= $TreatmentDescription; ?></textarea>
        </div>

        <div class="form-section">
            <label for="ImportantNotes">Important Notes</label>
            <textarea id="ImportantNotes" name="ImportantNotes" rows="4"  ><?= $ImportantNotes; ?></textarea>
        </div>

        <h3>Select Medicine to Dispense</h3>
        <label for="MedicineID">Select Medicine</label>
        <select id="MedicineID" name="MedicineID" onchange="selectMedicine()"  >
            <option value="" disabled selected>Select a Medicine</option>
            <?php foreach ($medicineList as $medicine): ?>
                <option value="<?= $medicine['MedicineID']; ?>" data-name="<?= $medicine['MedicineName']; ?>" data-category="<?= $medicine['CategoryOfMedicine']; ?>">
                    <?= $medicine['MedicineName']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <h3>Add Medicine to Dispense List</h3>
        <label for="MedicineName">Medicine Name</label>
        <input type="text" id="MedicineName" name="MedicineName"  >

        <label for="times">Number of Times Per Day</label>
        <input type="number" id="times" name="times"  >

        <label for="perTime">Quantity Per Time</label>
        <input type="number" step="0.01" id="perTime" name="perTime" >

        <label for="Notes">Notes</label>
        <textarea id="Notes" name="Notes" rows="4"></textarea>

        <button type="button" onclick="addToTable()">Add to List</button>

        <h3>Dispensed Medicine List</h3>
        <table id="dispensedMedicineTable">
            <thead>
                <tr>
                    <th>Medicine ID</th>
                    <th>Medicine Name</th>
                    <th>Times Per Day</th>
                    <th>Quantity Per Time</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <!-- Hidden Input to Store Dispensed Medicines -->
        <input type="hidden" id="dispense_medicines" name="dispense_medicines">

        <button type="submit">Submit All Data</button>
    </form>
</div>

<script>
    const dispensedMedicines = [];

    // This function will be triggered when a medicine is selected from the dropdown
    function selectMedicine() {
        const selectedOption = document.getElementById('MedicineID').selectedOptions[0];
        
        // Get the medicine name from the selected option
        const medicineName = selectedOption.getAttribute('data-name');
        
        // Set the value of the Medicine Name input field
        document.getElementById('MedicineName').value = medicineName;
    }

    function addToTable() {
        const medicineName = document.getElementById('MedicineName').value;
        const times = document.getElementById('times').value;
        const perTime = document.getElementById('perTime').value;
        const notes = document.getElementById('Notes').value;

        const medicineID = document.getElementById('MedicineID').value;

        // Validate input
        if (!medicineName || !times || !perTime) {
            alert('Please fill out all fields.');
            return;
        }

        // Add to table
        const table = document.getElementById('dispensedMedicineTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.innerHTML = `
            <td>${medicineID}</td>
            <td>${medicineName}</td>
            <td>${times}</td>
            <td>${perTime}</td>
            <td>${notes}</td>
            <td><button type="button" onclick="removeRow(this)">Remove</button></td>
        `;

        // Save to the dispensedMedicines array
        dispensedMedicines.push({
            MedicineID: medicineID,
            MedicineName: medicineName,
            TimesPerDay: times,
            QuantityPerTime: perTime,
            Notes: notes
        });

        // Store in hidden input for submission
        document.getElementById('dispense_medicines').value = JSON.stringify(dispensedMedicines);

        // Clear the form
        document.getElementById('MedicineName').value = '';
        document.getElementById('times').value = '';
        document.getElementById('perTime').value = '';
        document.getElementById('Notes').value = '';
    }

    function removeRow(button) {
        const row = button.parentNode.parentNode;
        const medicineID = row.cells[0].textContent;

        // Remove from array
        const index = dispensedMedicines.findIndex(medicine => medicine.MedicineID == medicineID);
        if (index > -1) {
            dispensedMedicines.splice(index, 1);
        }

        // Update hidden input
        document.getElementById('dispense_medicines').value = JSON.stringify(dispensedMedicines);

        // Remove row from table
        row.remove();
    }
</script>

</body>
</html>
