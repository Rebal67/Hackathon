<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: main page 
Copyright 2019 :)
-->

<?php
if(!isset($_SESSION)){
  session_start();
}
?>

<!--styling -->


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href= "./css/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>Home</title>
    <script>
      function input(){
        document.getElementById('container').style.display="block";
      }
    </script>
  </head>
  <body>
    <div id="container">
      <form action="">
        <input type="file" name="" id="upload" value="&plus;">
      </form>
    </div>
    <?php
      include "./Includes/navigation.php";
      
      if(!isset($_SESSION['email'])){
        header("location:./logins/login.php");
        exit;
      } //checking if logged in

      $folder = -1;
      if(isset($_GET["folder"])) {
        $folder = (int) $_GET["folder"];
      }

      include("./database/config.php"); // database info 
      include("./database/opendb.php"); // database handler : $dbaselink

      $query= "SELECT id, filename, folder FROM files ";
      $query.="WHERE userid = ? ";
      $query.="AND parent=? ";

      $preparedquery=$dbaselink->prepare($query);
      $preparedquery->bind_param("ii", $_SESSION['id'], $folder);
      $preparedquery->execute();
      
      echo '<div id="folderbody">';
      
      if($preparedquery->errno){
        echo "query is not working ";
        exit;
      } else {
        $result=$preparedquery->get_result();
        $max = $result->num_rows;
        if($max == 0) {
          // Uncomment echo after style testing.
          //echo "<p>there is not any result found</p>";
        }
        if($folder!==-1){
          echo "a href='index.php?='$folder-1";
        }
        while($row=$result->fetch_assoc()) {
          // Leave this empty for now.
        }
      }
      // Style test ----------------------------------------------------------
      echo '<div class="folder">';
      echo '<img src="./images/Logo.png">'; // Should be a folder or file logo.
      echo '<div class="filename">Testfolder</div>';
      echo '</div>';
      
      echo '<div class="file">';
      echo '<img src="./images/Logo.png">'; // Should be a folder or file logo.
      echo '<div class="filename">Testfile</div>';
      echo '</div>';
      
      echo '<div class="file">';
      echo '<img src="./images/Logo.png">'; // Should be a folder or file logo.
      echo '<div class="filename">Testfile2</div>';
      echo '</div>';
      
      // End style test ---------------------------------------------------------
      
      echo '</div>';
      
      $preparedquery->close();
      echo "<p>".$max." files in total.</p>";
    ?>
  </body>
</html>
<?php include "./database/closedb.php";
