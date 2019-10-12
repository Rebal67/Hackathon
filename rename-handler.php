<?php
if(!isset($_SESSION)){
  session_start();
}
if(!isset($_SESSION['email'])){
  header("location:./logins/login.php?status=mustbeloggedin");
  exit;
} //checking if logged in
if(!isset($_POST["name"]) || !isset($_POST["extension"]) || !isset($_POST["targetfile"])){
  echo "Missing values!";
  exit;
}

$pattern = "[^A-Za-zàÀáÁâÂãÃäÄåāÅæèÈéÉêÊëËìÌí@ÍîÎïÏòÒóÓöÖôÔõÕøØùÙúÚûÛüÜýÝÿçÇñÑ 0-9.,_-]";
$pattern_num = "[^0-9]";
$filename = preg_replace($pattern,"",substr(trim($_POST["name"].$_POST["extension"]),0,255));;
$targetfile = preg_replace($pattern_num,"",substr(trim($_POST["targetfile"]),0,9));;
if($filename != $_POST["name"].$_POST["extension"] || $filename == "") {
  echo "Invalid filename!";
  exit();
}
if($targetfile != $_POST["targetfile"] || $targetfile == "") {
  echo "Invalid file!";
  exit();
}

include("./database/config.php");
include("./database/opendb.php");

$query = "UPDATE files ";
$query .= "SET filename=? ";
$query .= "WHERE id=? AND userid=? ";
$prepared_query = $dbaselink->prepare($query);
$prepared_query->bind_param("sii", $filename, $targetfile, $_SESSION["id"]);
$prepared_query->execute();

if(!$prepared_query->errno) {
  $returnURL = "./index.php";
  if(isset($_POST["returndir"])) {
    $returnURL .= "?folder=".$_POST["returndir"];
  }
  header("location: ".$returnURL);
} else {
  echo "Something went wrong while trying to update file.";
}

$prepared_query->close();

include("./database/closedb.php");
?>