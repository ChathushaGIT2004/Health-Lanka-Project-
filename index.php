<?php
?>
<html>
<head>
<title>HealthNet Home</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    background-size: cover;
    background-image: url('Essentials/BG.png'); 
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    transition: background-color 0.3s ease;
    margin-bottom: 300px;
  }

  .NIC {
    font-size: 18px;
    width: calc(100% - 20px); 
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .Healthnet {
    display: block;
    margin: 20px auto;
    max-width: 90%; 
    width: 300px; 
    border-radius: 10px;
  }

  /* Updated buttons container */
  .buttons-container {
    display: flex;
    flex-direction: column;
    align-items: flex-end; /* Align buttons to the right */
    margin-top: 150px; /* Adjust the space from the top */
    margin-right: 50px; /* Right margin to prevent the buttons from touching the edge */
  }

  .button {
    padding: 10px 20px;
    font-size: 18px;
    margin: 10px 0; /* Vertically space the buttons */
    border: none;
    border-radius: 2px;
    background-color: #92c342;
    color: white;
    cursor: pointer;
    width: 200px;  
    border-radius: 40px;
  }

  .button:hover {
    background-color: #45a049;
  }

  .submit {
    font-size: 18px;
  }

  .NIC {
    font-size: 18px;
    margin-bottom: 20px;
  }

  .ImgHeath {
    display: block;
    margin: 20px auto;
    max-width: 200px;
    border-radius: 10px;
  }

  @media (min-width: 768px) {
    body {
    }

    form {
      font-size: 24px;
    }

    .submit {
      font-size: 24px;
    }

    .NIC {
      font-size: 24px;
    }

    .ImgHeath {
      display: block;
      margin: 20px auto;
      max-width: 200px;
      border-radius: 10px;
    }
  }
</style>
</head>
<body>

<div class="buttons-container">
  <button class="button" onclick="window.location.href='LoginOption.php'">Login</button>
  <button class="button" onclick="window.location.href='DOC Med/doctors.php'">Doctors</button>
  
  <button class="button" onclick="window.location.href='MedicineAll.php'">Medicine</button>
  <button class="button" onclick="window.location.href='About.html'">About Us</button>
  

</div>

</body>
</html>
