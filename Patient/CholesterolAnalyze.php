<?php
$PatientID = $_GET['PatientID'];

include "../DBConnection.php";
include "patientnarbar.php";

// Fetch all Patient Cholesterol Data (Date, Level, and Report)
$query1 = "SELECT * FROM `patient-cholesterol` WHERE `Patient ID` = ? ORDER BY `Date` DESC";
$stmt1 = $con->prepare($query1);
$stmt1->bind_param("s", $PatientID);
$stmt1->execute();
$result = $stmt1->get_result();

// Prepare data for the chart and table
$dates = [];
$levels = [];
$reports = [];
$raw_data = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['Date'];  // Date of the cholesterol reading
    $levels[] = $row['Cholesterol Level'];  // Cholesterol level
    $reports[] = $row['Report'];  // Report file path or name
    $raw_data[] = $row;  // Save raw data for filtering later
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Cholesterol Levels</title>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100%;
            background: #f4f7fc; /* Light background for a modern, clean look */
            color: #333; /* Darker text for better readability */
        }

        /* Main content area */
        .content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        h1 {
            font-size: 2.5rem;
            color: #1E2A47; /* Darker color for the title */
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Section Styling */
        .section {
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e0e5ec;
        }

        /* Section Titles */
        .section h2 {
            font-size: 1.8rem;
            color: #2C3E50; /* Slightly lighter shade of blue */
            margin-bottom: 15px;
            font-weight: 500;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 1rem;
        }

        th {
            background-color: #f8f8f8;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        td {
            background-color: #ffffff;
            color: #555;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        /* Table Hover Effects */
        tr:hover td {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Button Styling */
        .view-button {
            padding: 8px 20px;
            background-color: #34db85;
            border: none;
            border-radius: 20px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-button:hover {
            background-color: #1b9d48;
        }

        .view-button:focus {
            outline: none;
        }

        /* Chart Container */
        #chart-container {
            width: 100%;
            height: 400px;
            margin: 30px auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content {
                margin: 20px;
                padding: 15px;
            }

            h1 {
                font-size: 2rem;
            }

            .section {
                padding: 20px;
            }

            .view-button {
                padding: 6px 18px;
                font-size: 12px;
            }

            table th, table td {
                font-size: 0.9rem;
                padding: 12px;
            }

            /* Adjust Chart size */
            #chart-container {
                height: 300px;
            }
        }

        /* Additional Breakpoint for Small Devices */
        @media (max-width: 480px) {
            h1 {
                font-size: 1.8rem;
            }

            .section {
                padding: 15px;
            }

            .view-button {
                padding: 5px 16px;
                font-size: 11px;
            }

            table th, table td {
                font-size: 0.8rem;
                padding: 10px;
            }

            /* Adjust Chart size further */
            #chart-container {
                height: 250px;
            }
        }

    </style>
</head>
<body>

<!-- Main Content -->
<div class="content">
    <h1>Patient Dashboard: Cholesterol Levels</h1>

    <!-- Cholesterol Levels Chart Section -->
    <div class="section">
        <h2>Cholesterol Levels Over Time</h2>
        <div id="chart-container">
            <canvas id="cholesterolChart"></canvas>
        </div>
    </div>

    <!-- Table for Cholesterol Levels and Reports -->
    <div class="section">
        <h2>Cholesterol Levels Data</h2>
        <table id="cholesterolTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Cholesterol Level (mg/dL)</th>
                    <th>Report</th> <!-- Added Report Column -->
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Data will be inserted here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add FontAwesome icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    // Get the PHP arrays and convert them into JavaScript arrays
    const rawData = <?php echo json_encode($raw_data); ?>;
    const reports = <?php echo json_encode($reports); ?>;
    let dates = <?php echo json_encode($dates); ?>;
    let levels = <?php echo json_encode($levels); ?>;

    // Create a chart using Chart.js for Cholesterol Levels
    const ctx = document.getElementById('cholesterolChart').getContext('2d');
    let cholesterolChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Cholesterol Level (mg/dL)',
                data: levels,
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: false,
                tension: 0.1,
                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `Level: ${tooltipItem.raw} mg/dL`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Date' },
                    ticks: { autoSkip: true, maxRotation: 45, minRotation: 45 }
                },
                y: {
                    title: { display: true, text: 'Cholesterol Level (mg/dL)' },
                    suggestedMin: 0,
                    suggestedMax: 300
                }
            }
        }
    });

    // Function to update the table with data
    function updateTable(data) {
        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = ''; // Clear existing table rows

        data.forEach((row, index) => {
            const tr = document.createElement('tr');
            const tdDate = document.createElement('td');
            tdDate.textContent = row['Date'];
            const tdLevel = document.createElement('td');
            tdLevel.textContent = row['Cholesterol Level'];
            const tdReport = document.createElement('td');
            const reportLink = document.createElement('a');
            reportLink.href = `../path/to/reports/${reports[index]}`;  // Assuming reports are stored in a folder called 'reports'
            reportLink.download = reports[index];  // This will trigger a download
            reportLink.textContent = 'View';
            const viewButton = document.createElement('button');
            viewButton.classList.add('view-button');
            viewButton.appendChild(reportLink);
            tdReport.appendChild(viewButton);
            tr.appendChild(tdDate);
            tr.appendChild(tdLevel);
            tr.appendChild(tdReport);
            tableBody.appendChild(tr);
        });
    }

    // Initialize table with all data on page load
    updateTable(rawData);
</script>

</body>
</html>
