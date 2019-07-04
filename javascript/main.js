


function dragdrop(event) {
  console.log(event);
  event.preventDefault();
  // alert(event.dataTransfer.files[0]);
  var file=event.dataTransfer.files[0];
  // alert(event.dataTransfer.files[0].name);
  // alert(event.dataTransfer.files[0].size+" bytes");
  formdata = new FormData();
  formdata.append("file",file);
  formdata.append("parent",parent);
  
  var random = Math.floor(Math.random() * 1000);  
  var url = "upload-handler.php";


  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      // var mealname = document.getElementById('sortmeal');
      
      // var array = xhttp.responseText.split(",");
      // mealname.innerHTML = "";
      

      
    }
  };
  xhttp.open("POST", url,true);
  xhttp.send();
}


