<?php
if(!isset($_SESSION)){
  session_start();
}

if(!isset($_SESSION["id"])) {
  echo "You must be logged in to upload a file!";
  exit();
}

if(!isset($_POST["parent"]) || $_POST["parent"] != -1) {
  echo "Parent is invalid";
  // Here should be code to check if the parent exists and is a directory.
}

$parent = -1;

include("./database/config.php"); // database info 
include("./database/opendb.php"); // database handler : $dbaselink

mysqli_autocommit($dbaselink, false);

if(isset($_FILES) && isset($_FILES["file"]) &&
  isset($_FILES["file"]["name"]) &&
  isset($_FILES["file"]["tmp_name"])
) {
  $query = "SELECT max(id) as maxid FROM files ";
  $query .= "WHERE userid=? ";
  $prepared_query = $dbaselink->prepare($query);
  $prepared_query->bind_param("i", $_SESSION["id"]);
  $prepared_query->execute();
  
  $fileID = 0;
  if($prepared_query->errno) {
    echo "Something went wrong while trying to find a suitable file ID.";
    $prepared_query->close();
    mysqli_rollback($dbaselink);
    include "./database/closedb.php";
    exit();
  } else {
    $result = $prepared_query->get_result();
    if($result->num_rows() > 0) {
      $row = $result->fetch_assoc();
      $fileID = (int) $row["maxid"];
      $fileID++;
      
      $query = "INSERT INTO files ";
      $query .= "(id, userid, folder, filename, parent) ";
      $query .= "VALUES (?, ?, ?, ?, ?) ";
      $prepared_query2 = $dbaselink->prepare($query);
      $prepared_query2->bind_param("iiisi", $fileID, $_SESSION["id"], 0, $_FILES["file"]["name"], $parent);
      $prepared_query2->execute();
      
      if($prepared_query2->errno) {
        echo "Something went wrong while trying to add a file record.";
        $prepared_query->close();
        $prepared_query2->close();
        mysqli_rollback($dbaselink);
        include "./database/closedb.php";
        exit();
      }
      
      $targetFolder = "./UserData/u".$_SESSION["id"];
      if(!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
      }
      
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFolder."/f".$fileID.".dat")) {
        echo 'File uploaded!';
      } else {
        echo "Something went wrong while saving file data.<br>Removing file record!";
        $prepared_query->close();
        $prepared_query2->close();
        mysqli_rollback($dbaselink);
        include "./database/closedb.php";
        exit();
      }
      
      $prepared_query2->close();
    }
  }
  $prepared_query->close();
  
  mysqli_commit($dbaselink);
} else {
  echo "Error, file not set!";
}

include "./database/closedb.php";
?>