

<!--
Date: 19-06-2019
Author: Rebal Alhaqash
Description: admin main page
Copyright 2019 :)
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./../CSS/main.css">
  <link rel="stylesheet" href="./../CSS/login.css">
  <title>Document</title>
</head>
<body>
  <div class="main">
    <nav>
      <a href="./../index.php"><img src="./../img/DTT logo.png" alt="logo"></a>
    </nav>

    <!--register-box-->
    <div class="box">
    <form action="login-handler.php" method="POST">
    <?php
      if(isset($_GET["status"])){
        if($_GET['status']=="regsuccess"){
      echo "<div class='errorbox' style='background-color:green;'>";   // success register msg.
      echo "<p>Register complete please login</p>";
      echo "</div>";
      }
      if($_GET['status']=="passnomatch"){
        echo "<div class='errorbox'>"; 
        echo "<p>password or username does not match</p>"; // error msg box if passwords dont match
        echo "</div>";
        }
        if($_GET['status']=="usernotfound"){
          echo "<div class='errorbox'>";
          echo "<p>username not found</p>"; // error msg if user isn't  found
          echo "</div>";
          }
      } 
      
      ?>
      <table>
        <tr>
          <td><label for="">username</label></td>
          <td><input type="text" placeholder="your admin username" name="username"></td>
        </tr>

        <tr>
          <td><label for="">password</label></td>
          <td><input type="password" placeholder="your admin password" name="password"></td>
        </tr>
      </table>
        <input type="submit" value="Login" class="btn">
    </form>
    </div>
    <footer>
      DTT multi media &copy;2019, <a href="./admin-index.php">Site Admin</a>
    </footer>
  </div>
</body>
</html>