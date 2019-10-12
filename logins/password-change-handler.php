<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: login handler
Copyright 2019 :)
-->

<?php



include('./../database/config.php');// getting databse info
include('./../database/opendb.php'); // database handler: dbaselink

session_start();

if(!isset($_SESSION['id'])){
  header("location:./logins/login.php?status=mustbeloggedin");
  exit;
} //checking if logged in

// checking if every input is set
if(isset($_POST["password"]) && isset($_POST["passwordnew"]) && isset($_POST["passwordrepeat"])){
  $password=$_POST["password"];
  $passwordnew=$_POST["passwordnew"];
  $passwordrepeat=$_POST["passwordrepeat"];
}else{
  header("location: password-change.php?status=emptyvalues");
  exit;
}
if($passwordnew !== $passwordrepeat) {
  header("location: password-change.php?status=passnotequal");
  exit;
}

$query= "SELECT password,password_salt,id FROM users "; // query to get password and salt
$query.="WHERE id = ?";

$preparedquery=$dbaselink->prepare($query);
$preparedquery->bind_param("s", $_SESSION['id']);
$result=$preparedquery->execute(); 

if($preparedquery->errno){
  echo "query error";
}else{
  $result=$preparedquery->get_result();
  if($result->num_rows < 1){
    header("location: login.php?status=usernotfound");
    exit;
  }else{
    $row=$result->fetch_assoc();
    if(password_verify($password.$row['password_salt'],$row['password'])){ // checking the password+slt match the hash
      $passwordnew=$passwordnew.$row['password_salt']; // adding salt
      $passwordnew =password_hash($passwordnew,PASSWORD_DEFAULT); // hashing the pass with salt
      
      $query = "UPDATE users SET password = ? "; // query to get password and salt
      $query .= "WHERE id = ? ";
      $query .= "LIMIT 1";
      
      $preparedquery2=$dbaselink->prepare($query);
      $preparedquery2->bind_param("ss", $passwordnew, $_SESSION['id']);
      $result2 = $preparedquery2->execute();
      
      if($result2->errno) {
        header("location: password-change.php?status=generalerror");
      } else {
        header("location: logout.php");
      }
      
      $preparedquery2->close();
    }else{
      header("location: password-change.php?status=passnomatch");
    }
  }
}
$preparedquery->close();
include('./../database/closedb.php');
?>