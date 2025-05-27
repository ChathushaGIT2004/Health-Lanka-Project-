<?php 
// Get MeetUp ID from URL
$MeetUpID = $_GET['MeetUpID'];
$PatientID = $_GET['PatientID'];

// Include DB connection
include "../DBConnection.php";
include "patientnarbar.php";

// Query to get the details of the selected MeetUp
$query_meetup = "
    SELECT 
        `MeetUp ID`, 
        `Patient ID`, 
        `Doctor ID`, 
        CONCAT(`doctors`.`FirstName`, ' ', `doctors`.`LastName`) AS `DoctorName`,
        `Diagnoze Name`, 
        `Diagnoze Description`, 
        `Treatment Description`, 
        `Important Notes`, 
        `Rate`
    FROM `patient-doctor meetups`
    LEFT JOIN `doctors` ON `doctors`.`DoctorID` = `patient-doctor meetups`.`Doctor ID`
    WHERE `MeetUp ID` = ?";

$stmt_meetup = $con->prepare($query_meetup);
$stmt_meetup->bind_param("i", $MeetUpID);
$stmt_meetup->execute();
$meetup = $stmt_meetup->get_result()->fetch_assoc();

// Query to get dispensed medicines for the selected MeetUp
$query_medicines = "
    SELECT 
        `dispence-medicine`.`Medicine ID`, 
        `dispence-medicine`.`times`, 
        `dispence-medicine`.`per time`, 
        `dispence-medicine`.`Notes`,
        `medicinedetails`.`MedicineName`, 
        `medicinedetails`.`PictureOfMedicine`
    FROM `dispence-medicine`
    LEFT JOIN `medicinedetails` ON `medicinedetails`.`MedicineID` = `dispence-medicine`.`Medicine ID`
    WHERE `dispence-medicine`.`MeetUp ID` = ?";

$stmt_medicines = $con->prepare($query_medicines);
$stmt_medicines->bind_param("i", $MeetUpID);
$stmt_medicines->execute();
$medicines = $stmt_medicines->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meetup Details</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .details-section {
            margin-bottom: 20px;
        }

        .details-section h2 {
            font-size: 24px;
            color: #009879;
            margin-bottom: 10px;
        }

        .details-section p {
            font-size: 18px;
            color: #555;
        }

        .medicines-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .medicines-section th, .medicines-section td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .medicines-section th {
            background-color: #009879;
            color: white;
        }

        .medicines-section tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .medicine-image {
            max-width: 100px;
            max-height: 100px;
        }

        .rating-container {
            display: flex;
            gap: 10px;
            cursor: pointer;
        }

        .star {
            font-size: 30px;
            color: #ddd;
        }

        .star.selected {
            color: #ffcc00;
        }

        .action-button {
            background-color: #009879;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
        }

        .action-button:hover {
            background-color: #007c64;
        }

        #submit-rating {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Meetup Details</h1>

    <div class="details-section">
        <h2>MeetUp ID: <?= htmlspecialchars($meetup['MeetUp ID']); ?></h2>
        <p><strong>Doctor Name:</strong> <?= htmlspecialchars($meetup['DoctorName']); ?></p>
        <p><strong>Diagnosis Name:</strong> <?= htmlspecialchars($meetup['Diagnoze Name']); ?></p>
        <p><strong>Diagnosis Description:</strong> <?= htmlspecialchars($meetup['Diagnoze Description']); ?></p>
        <p><strong>Treatment Description:</strong> <?= htmlspecialchars($meetup['Treatment Description']); ?></p>
        <p><strong>Important Notes:</strong> <?= htmlspecialchars($meetup['Important Notes']); ?></p>
        <p><strong>Rate:</strong> 
            <?= $meetup['Rate'] == 0 ? 'Not Rated' : htmlspecialchars($meetup['Rate']); ?>
        </p>
    </div>

    <div class="medicines-section">
        <h2>Dispensed Medicines</h2>
        <?php if ($medicines->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Medicine Picture</th>
                        <th>Times</th>
                        <th>Per Time</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($medicine = $medicines->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($medicine['MedicineName']); ?></td>
                            <td>
                                <?php if ($medicine['PictureOfMedicine']) { ?>
                                    <img src="<?= htmlspecialchars($medicine['PictureOfMedicine']); ?>" class="medicine-image" alt="Medicine Image">
                                <?php } else { ?>
                                    No Image Available
                                <?php } ?>
                            </td>
                            <td><?= htmlspecialchars($medicine['times']); ?></td>
                            <td><?= htmlspecialchars($medicine['per time']); ?></td>
                            <td><?= htmlspecialchars($medicine['Notes']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No medicines dispensed for this meetup.</p>
        <?php } ?>
    </div>

    <!-- Rating System -->
    <?php if ($meetup['Rate'] == 0) { ?>
        <div class="rating-container">
            <span class="star" data-value="1">&#9733;</span>
            <span class="star" data-value="2">&#9733;</span>
            <span class="star" data-value="3">&#9733;</span>
            <span class="star" data-value="4">&#9733;</span>
            <span class="star" data-value="5">&#9733;</span>
        </div>
        <form id="rating-form">
            <input type="hidden" name="MeetUpID" value="<?= $meetup['MeetUp ID']; ?>">
            <input type="hidden" name="rating" id="rating-value">
        </form>
        <a href="#" id="submit-rating" class="action-button">Submit Rating</a>
    <?php } ?>

</div>

<script>
    $(document).ready(function() {
        // Star rating click event
        $('.star').on('click', function() {
            var rating = $(this).data('value');
            $('#rating-value').val(rating);

            // Highlight the selected stars
            $('.star').removeClass('selected');
            $(this).prevAll().addClass('selected');
            $(this).addClass('selected');

            // Show submit button
            $('#submit-rating').show();
        });

        // Submit the rating via AJAX
        $('#submit-rating').on('click', function() {
            var formData = $('#rating-form').serialize();

            $.ajax({
                url: '',  // The same file to handle the update
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Rating saved successfully!');
                    $('#submit-rating').hide();
                    $('.rating-container').hide();
                },
                error: function() {
                    alert('An error occurred while saving the rating.');
                }
            });
        });
    });
</script>

<?php
// Handle the rating update if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $MeetUpID = $_POST['MeetUpID'];
    $rating = $_POST['rating'];

    // Update the rating in the database
    $query = "UPDATE `patient-doctor meetups` SET `Rate` = ? WHERE `MeetUp ID` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $rating, $MeetUpID);
    if ($stmt->execute()) {
        echo "Rating saved successfully!";
    } else {
        echo "Failed to save rating.";
    }
}
?>

</body>
</html>
