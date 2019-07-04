<?php
include("./database/config.php");
include("./database/opendb.php");

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
  $query="SELECT * FROM files WHERE id = ?";

$preparedquery=$dbaselink->prepare($query);
$preparedquery->bind_param("i",$id);
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
      echo "parent = ". $row["parent"]."<br>";
      echo '<a class="detailbuttons" href="deleteconfirm.php?id=' . $row["id"] . '">'."  Verwijderen</a><br>";
      echo '<a href=open';
      echo "<a class=\"detailbuttons\" href='#'>Download</a>";
        
    };
  ?>
</body>
</html>
<?php

$preparedquery->close();

include("./database/closedb.php");

 echo "<div>";
 echo '<a class="detailbuttons" href="addevent.php?id=' . $id . '">'."  add event</a><br>";
 echo "</div>";
 echo "<a class=\"detailbuttons\" href='./index.php'>Home</a>";
?>
