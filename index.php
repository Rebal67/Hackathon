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
    <script src="./javascript/main.js">
    </script>
  </head>
  <body>
  
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
          $folder = $row["folder"];
          if($folder) {
            echo '<div class="folder" onclick="fileClicked('.$row["id"].', true)">';
            echo '<img src="./images/folder.png">'; // Should be a folder or file logo.
          } else {
            echo '<div class="file" onclick="fileClicked('.$row["id"].', false)">';
            echo '<img src="./images/file.png">'; // Should be a folder or file logo.
          }
          echo '<div class="filename">'.$row["filename"].'</div>';
          echo '</div>';
        }
      }
      
      echo '</div>';
      
      $preparedquery->close();
      echo "<p>".$max." files in total.</p>";
    ?>
  </body>
</html>
<?php include "./database/closedb.php";
