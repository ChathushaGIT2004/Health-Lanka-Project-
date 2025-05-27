<?php 
 include_once('DBConnection.php');  ?>
 <?php  
  $Uname=isset($_POST['UN'])?trim($_POST['UN']) :"";
  $Pass=isset($_POST['Pass'])?trim($_POST['Pass']) :"";
 
$sql1 = "SELECT password FROM users WHERE UserName=?";

 $stmt=$con->prepare($sql1);
 $stmt->bind_param("s",$Uname);
 $stmt->execute();
 $result1 = $stmt->get_result();
 




if($result1->num_rows >0){
    $DBUserName=$result1->fetch_assoc();
    $P=$DBUserName["password"]; 
   // $s=$DBUserName['Password'];
        echo "<br>";
        if($P==$Pass){
            echo"Welcome";
            header("Location:index.php");
            exit;
                    
        }
        else{
            echo"try again";  
        }  
    
}



else{
    echo"record Not found";
}






?>