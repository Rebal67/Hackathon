<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: login handler
Copyright 2019 :)
-->

<?php



include('./../database/config.php');// getting databse info
include('./../database/opendb.php'); // database handler: dbaselink


if( (isset($_POST["email"]))  and  (isset($_POST["password"])) ){
$email=$_POST["email"];       // checking if every input is set
$password=$_POST["password"];
}else{
  header("location: login.php?status=emptyvalues");
  exit;
}
  $pattren = "/[^A-Za-zàÀáÁâÂãÃäÄåāÅæèÈéÉêÊëËìÌíÍîÎïÏòÒóÓöÖôÔõÕøØùÙúÚûÛüÜýÝÿçÇñÑ@ 0-9.]/"; // setting pattern
  $email= preg_replace($pattren,"",substr(trim($email),0,50));// triming the email and setting 20 charcter limit
  if($email=="" && strpos($email, "@") !== false){
    header("location: login.php?status=emailpattern");
    exit;
  }
  echo $email;
  if($email!==$_POST["email"] || strpos($email, "@") === false){
    header("location: login.php?status=emailpattern");
    exit;
  }


 $query= "SELECT password,password_salt,id from users "; // query to get password and salt
 $query.="WHERE email= ?";

  $preparedquery=$dbaselink->prepare($query);
  $preparedquery->bind_param("s",$email);
  $result=$preparedquery->execute(); 


  if($preparedquery->errno){
    echo "query error";
  }else{
    $result=$preparedquery->get_result();
    if($result->num_rows===0){
      header("location: login.php?status=usernotfound");
      exit;
    }else{
      $row=$result->fetch_assoc();
      if(password_verify($password.$row['password_salt'],$row['password'])){ // checking the password+slt match the hash
        session_start();
        $_SESSION['email']=$email;
        $_SESSION['id']=$row['id'];
        header("location: ./../index.php");
      }else{
        header("location: login.php?status=passnomatch");
      }
    }
  }
  $preparedquery->close();
  include('./../database/closedb.php');
?>