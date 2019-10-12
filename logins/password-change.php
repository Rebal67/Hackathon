

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
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <?php
    session_start();
    if(!isset($_SESSION['id'])){
      header("location:./login.php?status=mustbeloggedin");
      exit;
    } //checking if logged in
    
    if(isset($_GET["status"])){
      echo "<div id='errorbox'>";
      switch($_GET["status"]) {
        case "regsuccess":
          echo "<p>Register complete please login</p>";
          break;
        case "passnomatch":
          echo "<p>Incorrect password</p>";
          break;
        case "emailpattern":
          echo "<p>Invalid email address!</p>";
          break;
        case "userpattern":
          echo "<p>Invalid username!</p>";
          break;
        case "usernotfound":
          echo "<p>User not found</p>";
          break;
        case "emptyvalues":
          echo "<p>Incomplete form!</p>";
          break;
        case "passnotequal":
          echo "<p>Passwords are not the same!</p>";
          break;
        default:
          echo "<p>Something went wrong!</p>";
          break;
      }
      echo "<button id='errorboxclose'>OK</button>";
      echo "</div>";
    }
  ?>
  <div class="main" id="loginformbody">
    <nav>
      <a href="./../index.php"><img id="logo" src="../images/Logo.png" alt="logo"></a>
    </nav>

    <!--register-box-->
    <div class="box">
    <form action="password-change-handler.php" method="POST">
      <table>
        <tr>
          <td><label for="">Old&nbsp;password</label></td>
          <td><input type="password" placeholder="password" name="password" id="password" class="invoerveld"></td>
        </tr>
        <tr>
          <td><label for="">New&nbsp;password</label></td>
          <td><input type="password" placeholder="New password" name="passwordnew" id="password" class="invoerveld"></td>
        </tr>
        <tr>
          <td><label for="">Repeat&nbsp;new&nbsp;password</label></td>
          <td><input type="password" placeholder="New password" name="passwordrepeat" id="password" class="invoerveld"></td>
        </tr>
      </table>
        <input type="submit" value="Change password" class="btn">
    </form>
      <a href="../index.php" id="registerlink">Back</a>
    </div>
    <footer>

    </footer>
  </div>
  <script src="../javascript/logins.js"></script>
</body>
</html>
