<?php
include "./Includes/filetools.php"; // Because we need to path to the userData directory.
if(!isset($_SESSION)){
  session_start();
}
if(isset($_SESSION["id"]) && isset($_GET["extension"]) && isset($_GET["fileid"])) {
  $extension = str_replace('"', "", $_GET["extension"]);
  if($extension != "png" && $extension != "jpg" && $extension != "jpeg") {
    echo "not a valid image.";
    exit();
  }
  $fileid = $_GET["fileid"];
  $target_file = userData."/u".$_SESSION["id"]."/f".$fileid.".dat";
  if(file_exists($target_file)) {
    header('Content-Length: '.filesize($target_file));
    header('Content-Type: image/'.$extension);
    
    header('Cache-Control: must-revalidate'); // Images can be cached but must be revalidated.
    
    if(ob_get_level() != 0) { // This will make sure that large files won't be buffered, to prevent a memory error.
      ob_flush();
      ob_end_clean();
    }
    
    readfile($target_file);
  }
}
?>