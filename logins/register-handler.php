<?php
include('./../database/config.php'); // getting databse info
include('./../database/opendb.php'); // database handler: dbaselink

//picking an id without auto increament *

/*$query="SELECT max(id) AS id FROM events";
$preparedquery=$dbaselink->prepare($query); 
$result=$preparedquery->execute(); 
  
  if(($preparedquery->errno)or($result===false)){ 
    echo "query error";
  }else{
      $result=$preparedquery->get_result();
    if($result->num_rows===0){
      echo "no";
  
    }else{
        while($row=$result->fetch_assoc()){
        $id=$row['id'];
        $id++;
      };
    }
    
  }
  $preparedquery->close();*/

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

if( (isset($_POST["username"]))  and  (isset($_POST["password"])) and  (isset($_POST["passwordconf"]))   ){
$username=$_POST["username"];         // checking if every input is set
$password=$_POST["password"];
$passwordconf=$_POST["passwordconf"];
}else{
  echo "nope, fill the username and password please";
  exit;
}
  $pattren = "/[^A-Za-zàÀáÁâÂãÃäÄåāÅæèÈéÉêÊëËìÌíÍîÎïÏòÒóÓöÖôÔõÕøØùÙúÚûÛüÜýÝÿçÇñÑ 0-9]/"; // setting pattern
  $username= preg_replace($pattren,"",substr(trim($username),0,20));// triming the username and setting 20 charcter limit
  $password= preg_replace($pattren,"",substr(trim($password),0,20));// triming the password and setting 20 charcter limit
  $passwordconf= preg_replace($pattren,"",substr(trim($passwordconf),0,20));
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
  if(($passwordconf=="")or($passwordconf!==$_POST["passwordconf"])){
    echo "error, passwordconf doesn't match the pattern";
    exit;
  }

  if($password!==$passwordconf){
    header("location: admin-register.php?status=passnomatch");
    exit;
  }
  $salt= randomString(); // making salt

  $password=$password.$salt; // adding salt
  $password =password_hash($password,PASSWORD_DEFAULT); // hashing the pass with salt

  $query="INSERT INTO users (username,password,password_salt) "; 
  $query.="VALUES (?, ?, ?)";
  
  $preparedquery=$dbaselink->prepare($query);
  $preparedquery->bind_param("sss", $username, $password,$salt); // prepared query to protect page 
  $result=$preparedquery->execute(); 

  if(($preparedquery->errno)or($result===false)){  // checking for error in the result
    echo "query error";
  }else{
    header("location: admin-login.php?status=regsuccess"); // return if status success
  }
  
$preparedquery->close();
include('./database/closedb.php'); // closing database
?>