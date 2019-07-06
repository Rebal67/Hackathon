<?php
include "./Includes/fileTools.php";
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
  echo fileExists($dbaselink, $_SESSION["id"], (int)$_POST["parent"]);
  if(fileExists($dbaselink, $_SESSION["id"], (int)$_POST["parent"]) == 2) {
    $parent = (int) $_POST["parent"];
  } else {
    echo "Invalid parent!";
    mysqli_rollback($dbaselink);
    include "./database/closedb.php";
    exit();
  }
}

if(isset($_FILES) && isset($_FILES["file"]) &&
  isset($_FILES["file"]["name"]) &&
  isset($_FILES["file"]["tmp_name"])
) {
  $fileID = getNewFileId($dbaselink, $_SESSION["id"]);
  $query = "INSERT INTO files ";
  $query .= "(id, userid, folder, filename, parent) ";
  $query .= "VALUES (?, ?, 0, ?, ?) ";
  $prepared_query = $dbaselink->prepare($query);
  $filename = $_FILES["file"]["name"];
  $prepared_query->bind_param("iisi", $fileID, $_SESSION["id"], $filename, $parent);
  $prepared_query->execute();
  
  if($prepared_query->errno) {
    echo "Something went wrong while trying to add a file record.";
    $prepared_query->close();
    mysqli_rollback($dbaselink);
    include "./database/closedb.php";
    exit();
  }
  
  $targetFolder = userData."/u".$_SESSION["id"];
  if(!file_exists($targetFolder)) {
    mkdir($targetFolder, 0777, true);
  }
  
  if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFolder."/f".$fileID.".dat")) {
    echo 'File uploaded!';
  } else {
    echo "Something went wrong while saving file data.<br>Removing file record!";
    $prepared_query->close();
    mysqli_rollback($dbaselink);
    include "./database/closedb.php";
    exit();
  }
  
  $prepared_query->close();
  
  mysqli_commit($dbaselink);
} else {
  echo "Error, file not set!";
}

include "./database/closedb.php";
?>