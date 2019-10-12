<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: the page to create a acount
Copyright 2019 :)
-->


<!--
Date: 19-06-2019
Author: Rebal Alhaqash
Description: admin register from page
Copyright 2019 :)
*/
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./../css/main.css">
  <link rel="stylesheet" href="./../css/login.css">
  <title>Document</title>
</head>
<body>
  <?php
    if(isset($_GET["status"])){
      echo "<div id='errorbox'>"; // if password doesn't match make error box
      switch($_GET["status"]) {
        case "passnomatch":
          echo "<p>Passwords do not match please enter password again</p>";
          break;
        case "emailalreadyused":
          echo "<p>User already exists!</p>";
          break;
        case "emailpattern":
          echo "<p>Invalid email address!</p>";
          break;
        case "userpattern":
          echo "<p>Invalid username!</p>";
          break;
        case "emptyvalues":
          echo "<p>Incomplete form!</p>";
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
    <form action="register-handler.php" method="POST">
      <table>
        <tr>
          <td><label for="">username</label></td>
          <td><input type="text" placeholder="your admin username" name="username" class="invoerveld"></td>
        </tr>
        <tr>
          <td><label for="">Email</label></td>
          <td><input type="text" placeholder="your Email" name="email" class="invoerveld"></td>
        </tr>

        <tr>
          <td><label for="">password</label></td>
          <td><input type="password" placeholder="your admin password" name="password" class="invoerveld"></td>
        </tr>

        <tr>
          <td><label for="">retype&nbsp;password</label></td>
          <td><input type="password" placeholder="retype your password" name="passwordconf" class="invoerveld"></td>
        </tr>
      </table>

        <input type="submit" value="Register" class="btn">
    </form>
      <a href="login.php" id="loginlink"> i already have an account</a>
    </div>
    <footer>

    </footer>
    <script src="../javascript/logins.js"></script>
  </div>
</body>
</html>
