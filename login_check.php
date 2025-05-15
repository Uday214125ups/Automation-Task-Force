<?php
session_start();


include 'db.php';


$sql = "SELECT * FROM users where username='".$_POST['username']."' and password='".$_POST['password']."'"; 
echo $sql;
$result = $conn->query($sql);


  if ($result->num_rows > 0) {
            while($rows = $result->fetch_assoc()) 
            { 
                
                $_SESSION['login']=$rows['username'];
                // echo $_SESSION['login'];
                header("Location:login_products.php");
            }
  }
  else
  {
      $_SESSION['invalid']=true;
      header("Location:index.php");
  }
                
                
?>
