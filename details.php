<link rel="stylesheet" href= "../css/detail.css">
<?php
include("./database/config.php");
include("./database/opendb.php");

if(!isset($_SESSION)){
  session_start();
}

if(!isset($_SESSION["id"])) {
  echo "error";
  exit();
}

if(isset($_GET["file"])){
  $id=$_GET['file'];
}else{
  echo "error";
}
$pattren = "/[^0-9]/";
  $id= preg_replace($pattren,"",substr(trim($id),0,40));
  if($id==""){
    echo "error 205";
    exit;
  }
  if($id!==$_GET["file"]){
    echo "error 205";
    exit;
  }
  $query="SELECT * FROM files WHERE id = ? AND userid=? ";

$preparedquery=$dbaselink->prepare($query);
$preparedquery->bind_param("ii",$id, $_SESSION["id"]);
$preparedquery->execute();

if($preparedquery->errno){
  echo "query error";
}else{
  $result=$preparedquery->get_result();
  if($result->num_rows===0){
    echo " no result found";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/index.css">
  <title>Document</title>
</head>
<body>
  <?php
  include "./includes/navigation.php";
  while($row=$result->fetch_assoc()){
      if($row['folder']==true){
        echo "it is a folder";
        exit;
      }
      echo"id = ".$id."<br>";
      echo "filename: ". $row["filename"]."<br>";
      echo '<a href="deleteconfirm.php?id=' . $row["id"] . '">'."  verwijderen</a><br>";
      $target_file = "./UserData/u".$_SESSION["id"]."/f".$row["id"].".dat";
      echo "<a download='".$row["filename"]."' href='".$target_file."'>Download</a>";
    };
  ?>
</body>
</html>
<?php

$preparedquery->close();

include("./database/closedb.php");

 echo "<div>";
 echo '<a href="addevent.php?id=' . $id . '">'."  add event</a><br>";
 echo "</div>";
 echo "<a href='./index.php'>HOME</a>";
?>
