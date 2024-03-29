<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: sets new users into the database
Copyright 2019 :)
-->

<?php
include('./../database/config.php'); // getting databse info
include('./../database/opendb.php'); // database handler: dbaselink

// random string funcion
function randomString() {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < 24; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

if(!empty($_POST["username"]) ||
  !empty($_POST["password"]) ||
  !empty($_POST["passwordconf"]) ||
  !empty($_POST["email"])
){
  $username=$_POST["username"];         // checking if every input is set
  $password=$_POST["password"];
  $passwordconf=$_POST["passwordconf"];
  $email = $_POST["email"];
}else{
  header("location: register.php?status=emptyvalues");
  exit;
}

$pattren = "/[^A-Za-zàÀáÁâÂãÃäÄåāÅæèÈéÉêÊëËìÌí@ÍîÎïÏòÒóÓöÖôÔõÕøØùÙúÚûÛüÜýÝÿçÇñÑ 0-9.]/"; // setting pattern
$passwordconf= preg_replace($pattren,"",substr(trim($passwordconf),0,50));
$username= preg_replace($pattren,"",substr(trim($username),0,20));// triming the username and setting 20 charcter limit
$email= preg_replace($pattren,"",substr(trim($email),0,50));// triming the email and setting 50 charcter limit

if($email!==$_POST["email"] && strpos($email, "@") !== false) {
  header("location: register.php?status=emailpattern");
  exit;
}
if($username!==$_POST["username"]){
  header("location: register.php?status=userpattern");
  exit;
}

if($password!==$passwordconf){
  header("location: register.php?status=passnomatch");
  exit;
}
$salt= randomString(); // making salt

$password=$password.$salt; // adding salt
$password =password_hash($password,PASSWORD_DEFAULT); // hashing the pass with salt

$query="INSERT INTO users ";
$query.= "(email, name, password, password_salt) "; 
$query.="VALUES (?, ?, ?, ?) ";

$preparedquery=$dbaselink->prepare($query);
$preparedquery->bind_param("ssss", $email, $username, $password, $salt); // prepared query to protect page 
$result=$preparedquery->execute(); 

if(($preparedquery->errno)or($result===false)){  // checking for error in the result
  // When query fails, it's most likely because that email is already taken.
  header("location: register.php?status=emailalreadyused");
}else{
  header("location: login.php?status=regsuccess"); // return if status success
}
  
$preparedquery->close();
include('./../database/closedb.php'); // closing database
?>