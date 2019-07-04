<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: login handler
Copyright 2019 :)
-->

<?php



include('./../database/config.php');// getting databse info
include('./../database/opendb.php'); // database handler: dbaselink


if( (isset($_POST["username"]))  and  (isset($_POST["password"])) ){
$username=$_POST["username"];       // checking if every input is set
$password=$_POST["password"];
}else{
  echo "nope, fill the username and password please";
  exit;
}
  $pattren = "/[^A-Za-zàÀáÁâÂãÃäÄåāÅæèÈéÉêÊëËìÌíÍîÎïÏòÒóÓöÖôÔõÕøØùÙúÚûÛüÜýÝÿçÇñÑ 0-9]/"; // setting pattern
  $username= preg_replace($pattren,"",substr(trim($username),0,20));// triming the username and setting 20 charcter limit
  $password= preg_replace($pattren,"",substr(trim($password),0,20));
  if($username==""){
    echo "error, username is empty";
    exit;
  }
  if($username!==$_POST["username"]){
    echo "error, username doesn't match the pattern";
    exit;
  }
  if(($password=="")or($password!==$_POST["password"])){
    echo "error, password doesn't match the pattern";
    exit;
  }


 $query= "SELECT password,password_salt from users "; // query to get password and salt
 $query.="WHERE username= ?";

  $preparedquery=$dbaselink->prepare($query);
  $preparedquery->bind_param("s",$username);
  $result=$preparedquery->execute(); 


  if($preparedquery->errno){
    echo "query error";
  }else{
    $result=$preparedquery->get_result();
    if($result->num_rows===0){
      header("location: admin-login.php?status=usernotfound");
      exit;
    }else{
      $row=$result->fetch_assoc();
      if(password_verify($password.$row['password_salt'],$row['password'])){ // checking the password+slt match the hash
        session_start();
        $_SESSION['admin']=$username;
        header("location: admin-index.php");
      }else{
        header("location: admin-login.php?status=passnomatch");
      }
    }
  }
  $preparedquery->close();
  include('./../database/closedb.php');
?>