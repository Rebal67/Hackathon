<?php
if(!isset($_SESSION)){
  session_start();
}
if(isset($_SESSION["id"]) && isset($_GET["filename"]) && isset($_GET["fileid"])) {
  $fileid = $_GET["fileid"];
  $target_file = "./UserData/u".$_SESSION["id"]."/".$fileid.".dat";
  if(file_exists($target_file)) {
    include $target_file;
  }
}
?>