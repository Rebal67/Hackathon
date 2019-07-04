<?php
  if(!isset($_SESSION)) {
    session_start();
  }
  
  echo '<div id="nav">';
  echo '<img id="logo" src="./images/logo.png">';
  echo '<div class="user">';
  if(isset($_SESSION["email"])) {
    echo '<a href="#">'.$_SESSION["email"].'</a>';
    echo '<div onclick="dropdown()"  class="hidden">';
    echo '<div id="accountdropdown">';
    echo "<a href=\"./logins/logout.php\">Logout</a>";
    echo '</div>';
    echo '</div>';
  }
  echo '</div>';
  echo '</div>';
?>