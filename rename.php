<!--
Date: 19-06-2019
Author: Rebal Alhaqash/ naoh kastelijn/ joost bakker/ mark den hartogh
Description: main page
Copyright 2019 :)
-->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href= "./css/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>Rename</title>
  </head>
  <body>
    <div id="createFile" style="display:block;">
      <div id="rename-advanced-btn">
        <a href="#" onclick="showextension();">Advanced</a>
      </div>
      <div>
        <form action="rename-handler.php" method="post" autocomplete="off" id="createfolderform" onsubmit="return checkFileName();">
          <?php
            if(isset($_GET["id"])) {
              $file = (int) $_GET["id"];
              
              echo '<input type="text" name="name" id="folderinput" onfocusin="folderInputFocusIn();" onfocusout="folderInputFocusOut();" ';
              if(isset($_GET["name"])) {
                echo 'value="'.$_GET["name"].'"';
              }
              echo ">";
              
              echo '<input type="hidden" id="fileextension" name="extension" ';
              if(isset($_GET["extension"])) {
                echo 'value=".'.$_GET["extension"].'">';
              } else {
                echo 'value="">';
              }
              
              if(isset($_GET["returndir"])) {
                echo '<input type="hidden" name="returndir" value="'.$_GET["returndir"].'">';
              }
              
              echo '<input type="hidden" name="targetfile" value="'.$file.'">';
            } else {
              header("Location: ./index.php");
            }
          ?>
          <input type="submit" value="rename">
        </form>
      </div>
    </div>
    <script>
      function folderInputFocusIn() {
        var form = document.getElementById("createfolderform");
        if(!form.classList.contains("active")) {
          form.classList.add("active");
        }
      }
      
      function folderInputFocusOut() {
        var form = document.getElementById("createfolderform");
        if(form.classList.contains("active")) {
          form.classList.remove("active");
        }
      }
      
      function checkFileName() {
        let value = document.getElementById("folderinput").value;
        if(value.length == 0) {
          alert("Please enter a name.");
          return false;
        }
        let test = value.match(/[^A-Za-zàÀáÁâÂãÃäÄåāÅæèÈéÉêÊëËìÌí@ÍîÎïÏòÒóÓöÖôÔõÕøØùÙúÚûÛüÜýÝÿçÇñÑ 0-9.,_-]/);
        if(test !== null) {
          alert("Character " + test[0] + " is not allowed!");
          return false;
        }
        return true;
      }
      
      function showextension() {
        document.getElementById("rename-advanced-btn").classList.add("hidden");
        let filename = document.getElementById("folderinput");
        let extension = document.getElementById("fileextension");
        filename.value += extension.value;
        extension.value = "";
      }
      
      if(document.getElementById("fileextension").value == "") {
        document.getElementById("rename-advanced-btn").classList.add("hidden");
      }
    </script>
    <script src="./javascript/main.js"></script>
  </body>
</html>
