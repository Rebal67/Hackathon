<?php
if(!isset($_SESSION)){
  session_start();
}
session_unset(); // unset the admin
  session_destroy();
header("location: admin-index.php");

?>