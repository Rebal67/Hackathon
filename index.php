<?php
if(!isset($_SESSION)){
  session_start();
}
  if(!isset($_SESSION['admin'])){
    header("location:admin-login.php");
    exit;
  } //checking if logged in
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home</title>
</head>
<body>
  
</body>
</html>