<?php
  if(!isset($_SESSION)) {
    session_start();
  }
  
  echo '<div id="nav">';
  echo '<div class="user">';
  if(isset($_SESSION["email"])) {
    echo '<a href="#">'.$_SESSION["email"].'</a>';
    echo '<div id="accountdropdown" class="hidden">';
    echo "Settings here...";
    echo '</div>';
  }
  echo '</div>';
  echo '</div>';
?>