<?php
  if(!isset($_SESSION)) {
    session_start();
  }

  echo '<div id="fileoptionbar">';
  if(isset($_SESSION["id"])) {
    echo '<a href="./index.php" class="button">Home</a>';
    echo '<a href="#" onclick="createNewFolder()" class="button">Create new folder</a>';
    if($folder > 0) {
      echo '<a href="./goback.php?id='.$folder.'" class="button">Back</a>';
    }
  }
  echo '</div>';
?>
