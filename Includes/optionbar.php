<?php
  if(!isset($_SESSION)) {
    session_start();
  }

  echo '<div id="fileoptionbar">';
  if(isset($_SESSION["id"])) {
    echo '<a href="./index.php" class="button">Home</a>';
    echo '<a href="#" onclick="createNewFolder()" class="button">Create new folder</a>';
    echo '<form method="POST">';
    echo '<input type="file" name="file" id="file" class="upload" multiple size="50" onchange="upload()">';
    echo '<label for="file" class="label">Upload</label>';
    echo '</form>';
    if($parent > 0) {
      echo '<a href="./goback.php?id='.$parent.'" class="button">Back</a>';
    }
  }
  echo '</div>';
?>
