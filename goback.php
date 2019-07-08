<?php
if(!isset($_SESSION)){
  session_start();
}

if(!isset($_SESSION["id"])) {
  echo "You must be logged in to upload a file!";
  exit();
}

if(!isset($_GET["id"])) {
  echo "Error, id is not set.";
  exit();
}

$pattren = "/[^0-9]/";
$id= preg_replace($pattren,"",substr(trim($_GET["id"]),0,40));

if($id != $_GET["id"] || $id == "" || $id == -1) {
  echo "ID is not valid.";
  exit();
}

include("./database/config.php"); // database info 
include("./database/opendb.php"); // database handler : $dbaselink

$query = "SELECT parent FROM files ";
$query .= "WHERE id=? AND userid=? ";

$prepared_query = $dbaselink->prepare($query);
$prepared_query->bind_param("ii", $id, $_SESSION["id"]);
$prepared_query->execute();

if($prepared_query->errno) {
  echo "Something went wrong while talking to the database...";
  $prepared_query->close();
  include "./database/closedb.php";
  exit();
} else {
  $result = $prepared_query->get_result();
  
  if($result->num_rows < 1) {
    echo "Could not find the parent of this folder.";
  } else {
    $row = $result->fetch_assoc();
    header("Location: ./index.php?folder=".$row["parent"]);
  }
  
  $result->free();
}

$prepared_query->close();

include "./database/closedb.php";
?>