<?php
include "./Includes/filetools.php";

if(!isset($_SESSION)){
  session_start();
}

if(!isset($_SESSION["id"])) {
  echo "You must be logged in to upload a file!";
  exit();
}

include("./database/config.php"); // database info 
include("./database/opendb.php"); // database handler : $dbaselink

mysqli_autocommit($dbaselink, false);

$parent = -1;
if(!isset($_POST["parent"]) || $_POST["parent"] == -1) {
  echo "Main directory.";
} else {
  // fileExists returns 2 if file is folder.
  // fileExists is a function in Includes/fileTools
  if(fileExists($dbaselink, $_SESSION["id"], (int)$_POST["parent"]) == 2) {
    $parent = (int) $_POST["parent"];
  } else {
    echo "Invalid parent!";
    mysqli_rollback($dbaselink);
    include "./database/closedb.php";
    exit();
  }
}

if(isset($_POST["name"])) {
  $fileID = getNewFileId($dbaselink, $_SESSION["id"]);
  
  $query = "INSERT INTO files ";
  $query .= "(id, userid, folder, filename, parent) ";
  $query .= "VALUES (?, ?, 1, ?, ?) ";
  $prepared_query = $dbaselink->prepare($query);
  $filename = $_POST["name"];
  $prepared_query->bind_param("iisi", $fileID, $_SESSION["id"], $filename, $parent);
  $prepared_query->execute();
  
  if($prepared_query->errno) {
    echo "Something went wrong while trying to add a file record.";
    $prepared_query->close();
    mysqli_rollback($dbaselink);
    include "./database/closedb.php";
    exit();
  } else {
    if($parent == -1) {
      header("location: ./index.php?");
    } else {
      header("location: ./index.php?folder=".$parent);
    }
  }
  
  $prepared_query->close();
  
  mysqli_commit($dbaselink);
} else {
  echo "Error, name not set!";
}

include "./database/closedb.php";
?>