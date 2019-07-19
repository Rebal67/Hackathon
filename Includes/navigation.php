<?php
  if(!isset($_SESSION)) {
    session_start();
  }
  
  echo '<div id="nav">';
  echo '<img id="logo" src="./images/Logo.png">';
  echo '<div class="user">';
  if(isset($_SESSION["email"])) {
    echo '<a href="#" onclick="dropdown()">'.$_SESSION["email"].'</a>';
    echo '<div id="accountdropdown"  class="hidden">';
    echo "<a href=\"./logins/logout.php\">Logout</a>";
    echo '</div>';
  }
  echo '</div>';
  echo '</div>';
?>