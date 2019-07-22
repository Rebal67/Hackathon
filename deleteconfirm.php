<?php
if(!isset($_SESSION)){
  session_start();
}
 if(!isset($_SESSION['email'])){
  header("location:./logins/login.php");
  exit;
} //checking if logged in
include("./database/config.php");
include("./database/opendb.php");

if(isset($_GET['id'])){
  $id=$_GET['id'];
}else{
  echo "error";
}
$pattren = "/[^0-9]/";
  $id= preg_replace($pattren,"",substr(trim($id),0,40));
  if($id==""){
    echo "error 205";
    exit;
  }
  if($id!==$_GET["id"]){
    echo "error 205";
    exit;
  }
  
  $query="SELECT filename FROM files WHERE id = ?";

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
  <link rel="stylesheet" href="./css/delete.css">
  <title>Delete</title>
</head>
<body>
  <?php include "./includes/navigation.php"; ?>
  <div id="folderbody">
    <div>
    <?php
    while($row=$result->fetch_assoc()){
        echo "<p>are you sure you want to delete ";
        echo  "<span>".$row["filename"]."</span>?<br>";
        echo "</p>";
        echo '<a href="./delete.php?id='.$id.'">YES</a>';
        echo "<a href='index.php'>No</a>";
      };
      ?>
    </div>
  </div>
</body>
</html>
<?php
$preparedquery->close();

include("./database/closedb.php");

?>