<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['email'])){
  header("location:./logins/login.php");
  exit;
} //checking if logged in


if(!isset($_SESSION['email'])){
  header("location:./logins/login.php");
  exit;
} //checking if logged in
include "./includes/filetools.php";

include('./database/config.php');
include('./database/opendb.php');

mysqli_autocommit($dbaselink,FALSE);
  $id=$_GET['id'];

  $pattren = "/[^0-9]/";
  $id= preg_replace($pattren,"",substr(trim($id),0,40));
  if($id==""){
    echo "error 205";
    exit;
  }
  if($id!==$_GET["file"]){
    echo "error 205";
    exit;
  }
  deleteRecursive($dbaselink,$_SESSION['id'],$id);
  $query="DELETE FROM files ";
  $query.="WHERE id = ?  ";
  $query.="LIMIT 1";

  $preparedquery=$dbaselink->prepare($query);
  $preparedquery->bind_param("i",$id);
  $result=$preparedquery->execute(); 
    if(($preparedquery->errno)or($result===false)){ 
    echo "member doesn't exist";
    }else{
    header("location: index.php");
    }
  
  
  $preparedquery->close();
  mysqli_commit($dbaselink);
include('./database/closedb.php');
?>