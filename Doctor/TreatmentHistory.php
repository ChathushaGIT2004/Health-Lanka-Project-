<?php 
include "Doctor_navbar.php";

$doctorID = $_GET['DoctorID'];

include_once "../DBConnection.php";

$query = "SELECT * FROM `patient-doctor meetups` WHERE `Doctor ID` = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $doctorID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No history found.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor: History</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .ImgHeath {
            display: block;
            margin: 20px auto;
            max-width: 120px;
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .History {
            width: 90%;
            max-width: 1100px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        h1 {
            color: #3e8e41;
            font-size: 2.2rem;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #ffffff;
        }

        table thead {
            color: #ffffff;
            background-color: rgba(52, 219, 133, 0.9);
            text-transform: uppercase;
            font-size: 14px;
            font-weight: bold;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
        }

        table tbody tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        table tbody tr:hover {
            background-color: #d1f7d6;
            transform: scale(1.02);
            cursor: pointer;
        }

        table tbody td:first-child {
            font-weight: bold;
        }

        table caption {
            font-size: 1.5rem;
            font-weight: bold;
            color: #3e8e41;
            text-align: center;
            margin: 20px 0;
        }

        button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #3e8e41;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background-color: #2d6b31;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            table th, table td {
                font-size: 12px;
                padding: 10px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .History {
                padding: 20px;
                width: 95%;
            }

            button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="../Essentials/MainLogo.png" class="ImgHeath" alt="Healthnet Logo">
        <h1>Treatment History</h1>
    </div>

    <div class="History">
        <table>
            <caption></caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient ID</th>
                    <th>Date</th>
                    <th>Diagnosis Title</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick=\"window.location.href='TreatmentDetails.php?ID=" . urlencode($row['MeetUp ID']) . "'\">";
                    echo "<td>" . htmlspecialchars($row['MeetUp ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Patient ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Diagnoze Name']) . "</td>";

                    // Display rating or "Not Rated Yet"
                    if ($row['Rate'] != 0) {
                        echo "<td>" . htmlspecialchars($row['Rate']) . "</td>";
                    } else {
                        echo "<td>Not Rated Yet</td>";
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
         
    </div>
</body>
</html>
