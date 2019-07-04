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
  if(!isset($_SESSION['admin'])){
    header("location:admin-login.php");
    exit;
  } //checking if logged in



include("./database/config.php"); // database info 
include("./database/opendb.php"); // database handler : $dbaselink


$qeury= "SELECT id,filename,folder FROM files ";
$qeury.="where userid = ?";

$preparedquery=$dbaselink->prepare($qeury);
$preparedquery->bind_param("i",$_SESSION['id']);
$preparedquery->execute();

if($preparedquery->errno){
  echo "query is not working ";
  exit;
}else{
  $result=$preparedquery->get_result();
  if($result->num_rows===0){
    echo "there is not any result found";
  }
}
$preparedquery->close();

$max=0;//to see how many files are there
  ?>


<!--styling -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="style.css" href= "./css/index.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
   integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <title>Home</title>
</head>
<body>
<div class="main">
    <nav>
      <a href="./../index.php"><img src="./../img/DTT logo.png" alt="logo"></a>
    </nav>

    <nav>
      <h2>Widget News Admin</h2>
      you are logged in as admin. <a href="logout.php">log out</a>
    </nav>

    <h1>ALL Articles</h1>
    <table>
      <tr>
        <th>Publication Date</th>
        <th>Article</th>
        <th></th>
      </tr>
    <?php
      while($row=$result->fetch_assoc()){ // table with the articles.
        echo "<tr>";
        echo  "<td>".$row['']."</td>"; 
        echo  "<td>".$row['']."</td>";
        echo  "<td><a href='updateform.php?id=".$row['id']."'><i class=\"far fa-edit\"></i></a>";
        echo "</tr>";
        $max++;


      };


    ?>
    </table>
      <?php echo "<p>".$max." articles in total.</p>";?>
      <a href="add-articleform.php">add new article</a>
    
    <footer>
    </footer>
</body>
</html>
<?php include "./database/closedb.php";