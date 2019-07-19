

<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: login page
Copyright 2019 :)
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
  <h1>DiamondCloud</h1>
  <div class="main">
    <nav>
      <a href="./../index.php"><img id="logo" src="../images/Logo.png" alt="logo"></a>
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
          <td><label for="">Email</label></td>
          <td><input type="text" placeholder="username" name="email" id="email" class="invoerveld"></td>
        </tr>
<br>
<br>
        <tr>
          <td><label for="">password</label></td>
          <td><input type="password" placeholder="password" name="password" id="password" class="invoerveld"></td>
        </tr>
      </table>
      <br><br><br>
        <input type="submit" value="Login" class="btn">
    </form>
      <a href="register.php" id="registerlink"> create an account</a>
    </div>
    <footer>

    </footer>
  </div>
</body>
</html>
