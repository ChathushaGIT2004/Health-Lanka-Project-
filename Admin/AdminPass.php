<?php 

 
  $Pass=isset($_POST['Pass'])?trim($_POST['Pass']) :"";
 if($pass=="Admin"){
    echo"Welcome";
    header("Location:Admin/Admin_page.php");
    exit;
 }
 else{
    header("Location:Admin/Admin_login.php");
 }












?>