<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: logout
Copyright 2019 :)
-->

<?php
if(!isset($_SESSION)){
  session_start();
}
session_unset(); // unset the admin
  session_destroy();
header("location: ./../index.php");

?>