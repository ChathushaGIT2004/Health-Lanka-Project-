<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Progress Bar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f8;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .progress-container {
            width: 80%;
            max-width: 900px;
            padding: 20px;
            background: wheat;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            text-align: center;
        }

        .circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .completed .circle {
            background-color: #4caf50;
        }

        .active .circle {
            background-color: #4caf50;
            transform: scale(1.2);
        }

        .line {
            height: 4px;
            width: 100%;
            background-color: #e0e0e0;
            position: relative;
            top: -20px;
            z-index: -1;
        }

        .step.completed ~ .line {
            background-color: #4caf50;
        }

        .label {
            font-size: 14px;
            color: #333;
        }

        /* This section styles the completed progress bar line */
        .progress-line-completed {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 80%; /* Adjust this for dynamic progress: 20%, 40%, 60%, etc. */
            background-color: #5dc13b;
            z-index: 1;
            transition: width 0.3s ease;
        }

        .line-container {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            width: 100%;
            height: 4px;
            background-color: #e0e0e0;
        }

    </style>
</head>
<body>
    <div class="progress-container">
        <div class="progress-bar">
            <!-- Step 1 -->
            <div class="step completed">
                <div class="circle">1</div>
                <span class="label">Select Patient</span>
            </div>

            <!-- Line -->
            <div class="line-container">
                <div class="line"></div>
            </div>

            <!-- Step 2 -->
            <div class="step completed">
                <div class="circle">2</div>
                <span class="label">View Details</span>
            </div>

            <!-- Line -->
            <div class="line-container">
                <div class="line"></div>
            </div>

            <!-- Step 3 (Active) -->
            <div class="step active">
                <div class="circle">3</div>
                <span class="label">Diagnose</span>
            </div>

            <!-- Line -->
            <div class="line-container">
                <div class="line"></div>
            </div>

            <!-- Step 4 -->
            <div class="step">
                <div class="circle">4</div>
                <span class="label">Dispense Medicine</span>
            </div>

            <!-- Line -->
            <div class="line-container">
                <div class="line"></div>
            </div>

            <!-- Step 5 -->
            <div class="step">
                <div class="circle">5</div>
                <span class="label">Confirm</span>
            </div>
    </div>
    <div class="progress-line-completed"></div>
    </div>

            <!-- Completed Progress Line -->
    
        
    
</body>
</html>
