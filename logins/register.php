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
  <div class="main">
    <nav>
      <a href="./../index.php"><img id="logo" src="../images/Logo.png" alt="logo"></a>
    </nav>

    <!--register-box-->
    <div class="box">
    <form action="register-handler.php" method="POST">
      <?php
      if(isset($_GET["status"])){
        if($_GET['status']=="passnomatch"){
      echo "<div class='errorbox'>"; // if password doesn't match make error box
      echo "<p>passwords do not match please enter password again</p>";
      echo "</div>";
      }
      }

      ?>

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
          <td><label for="">retype password</label></td>
          <td><input type="password" placeholder="retype your password" name="passwordconf" class="invoerveld"></td>
        </tr>
      </table>

        <input type="submit" value="Register" class="btn">
    </form>
      <a href="login.php" id="loginlink"> i already have an account</a>
    </div>
    <footer>

    </footer>
  </div>
</body>
</html>
