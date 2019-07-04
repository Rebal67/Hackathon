


function dragdrop(event) {
  console.log(event);
  event.preventDefault();
  var file=event.dataTransfer.files[0];

  formdata = new FormData();
  formdata.append("file",file);
  formdata.append("parent",parent);
  
  var random = Math.floor(Math.random() * 1000);  
  var url = "upload-handler.php";


  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      
      // var array = xhttp.responseText.split(",");

      
    }
  };
  xhttp.open("POST", url,false);
  xhttp.send(formdata);
}


