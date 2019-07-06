<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['email'])){
  header("location:./logins/login.php");
  exit;
} //checking if logged in

include "./Includes/filetools.php";

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
  if($id!==$_GET["id"]){
    echo "error 205";
    exit;
  }
  
  $result = deleteRecursive($dbaselink,$_SESSION['id'],$id);
  
  mysqli_commit($dbaselink);
  
  // DO NOT roll back the database on error!
  /**
    deleteRecursive may have deleted children of this file (for folders).
    if you do a rollback, those references will be restored, but since the file data is deleted they can't be used anymore.
  **/
  if($result === false) {
    echo "Something went wrong while trying to delete files...<br>";
    echo "If you where trying to delete a folder. Keep in mind that some files may have been deleted.";
  } else {
    header("location: ./index.php");
  }
  
include('./database/closedb.php');
?>