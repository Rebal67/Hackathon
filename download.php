<?php
if(!isset($_SESSION)){
  session_start();
}
if(isset($_SESSION["id"]) && isset($_GET["filename"]) && isset($_GET["fileid"])) {
  $filename = str_replace('"', "", $_GET["filename"]);
  $fileid = $_GET["fileid"];
  $target_file = "./UserData/u".$_SESSION["id"]."/f".$fileid.".dat";
  if(file_exists($target_file)) {
    header('Content-Length: '.filesize($target_file));
    header('Content-Type: application/octet-stream'); // Type for binary data.
    header('Content-Disposition: attachment; filename="'.$filename.'"'); // Changes filename to the right filename.
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    
    readfile($target_file);
  }
}
?>