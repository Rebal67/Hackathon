<?php
  function getNewFileId($dbhandle, $user) {
    $query = "SELECT max(id) as maxid FROM files ";
    $query .= "WHERE userid=? ";
    $prepared_query = $dbhandle->prepare($query);
    $prepared_query->bind_param("i", $_SESSION["id"]);
    $prepared_query->execute();
    
    $fileID = 0;
    if($prepared_query->errno) {
      $prepared_query->close();
      return false;
    } else {
      $result = $prepared_query->get_result();
      if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fileID = (int) $row["maxid"];
        $fileID++;
      }
    }
    $prepared_query->close();
    return $fileID;
  }
  
  /**
    returns false if file does not exists.
    returns 1 if the file is a file.
    returns 2 if the file is a folder.
  **/
  function fileExists($dbhandle, $user, $file) {
    $query = "SELECT folder FROM files ";
    $query .= "WHERE id=? AND userid=?";
    
    $exists = false;
    $folder = false;
    
    $prepared_query = $dbhandle->prepare($query);
    $prepared_query->bind_param("ii", $file, $user);
    $prepared_query->execute();
    
    if($prepared_query->errno) {
      $prepared_query->close();
      return false;
    } else {
      $result = $prepared_query->get_result();
      if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        var_dump($row);
        if($row["folder"] == 1) {
          $folder = true;
        }
        $exists = true;
      }
    }
    $prepared_query->close();
    
    echo "<br>Folder=".$folder."<br>".$file."<br>";
    
    if(!$exists) return false;
    if($folder == 1) {
      echo "Meow";
      return 2;
    } else {
      echo "Woof";
      return 1;
    }
  }
  
  function deleteRecursive($dbhandle, $user, $file) {
    $fileStatus = fileExists($dbhandle, $user, $file);
    if($fileStatus === false) return true;
    if($fileStatus == 2) {
      $query = "SELECT id FROM files WHERE id=? ";
      $prepared_query = $dbhandle->prepare($query);
      $prepared_query->bind_param("i", $file);
      $prepared_query->execute();
      
      if($dbhandle->errno) {
        $prepared_query->close();
        return false;
      } else {
        $result = $prepared_query->get_result();
        for($i = 0; $i < $result->num_rows; $i++) {
          $row = $result->fetch_assoc();
          deleteRecursive($dbhandle, $user, $row["id"]);
        }
      }
      $prepared_query->close();
    }
    $targetFile = "./UserData/u".$user."/f".$file.".dat";
    if($fileStatus == 1) {
      unlink($targetFile);
    }
    
    $query = "DELETE FROM files WHERE id=? LIMIT 1";
    $prepared_query = $dbhandle->prepare($query);
    $prepared_query->bind_param("i", $file);
    $prepared_query->execute();
    
    $ret = false;
    if(!$prepared_query->errno) {
      $ret = true;
    }
    
    $prepared_query->close();
    return $ret;
  }
?>