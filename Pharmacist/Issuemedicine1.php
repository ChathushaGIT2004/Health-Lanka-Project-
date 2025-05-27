<?php
// Assuming the user ID is stored in a session or passed as part of the form
$user_id = $_GET['UserId']; // Example user ID. You can fetch it from session or other logic

// Process the form submissions based on the user's choice
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['method_type'])) {
        $method_type = $_POST['method_type'];

        // Redirect to the appropriate page based on method type and pass the user_id in the URL
        if ($method_type == 'without_meetup') {
            header("Location: withoutmeetup.php?user_id=$user_id");
            exit;
        } elseif ($method_type == 'with_meetup') {
            header("Location: withmeetup.php?user_id=$user_id");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Method</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 30px;
        }

        .btn {
            padding: 15px 30px;
            font-size: 18px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 200px;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .btn:nth-child(1) {
            background-color: #4CAF50;
            color: white;
        }

        .btn:nth-child(1):hover {
            background-color: #45a049;
        }

        .btn:nth-child(2) {
            background-color: #2196F3;
            color: white;
        }

        .btn:nth-child(2):hover {
            background-color: #0b7dda;
        }

        .message {
            font-size: 18px;
            color: #f44336;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Choose Issue Method</h1>

        <?php if (!isset($method_type)) : ?>
            <!-- Initial form to choose the method type -->
            <form method="POST" action="">
                <button type="submit" name="method_type" value="without_meetup" class="btn">Without Meetup ID</button>
                <button type="submit" name="method_type" value="with_meetup" class="btn">With Meetup ID</button>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>
