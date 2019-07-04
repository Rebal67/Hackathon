function fileClicked(id, folder) {
  if(folder) {
    window.location.href = "./index.php?folder="+id;
  } else {
    window.location.href = "./details.php?file="+id;
  }
}

window.addEventListener("dragover",function(e){
  dragdrop(e);
},false);

window.addEventListener("drop",function(e){
  dragdrop(e);
},false);

function dragdrop(event) {
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
      location.reload();
      
      // var array = xhttp.responseText.split(",");

      
    }
  };
  xhttp.open("POST", url,true);
  xhttp.send(formdata);
}


function createNewFolder(){
  var modal = document.getElementById('createFile');
  modal.style.display="block";
}

function dropdown(){
  var dropdown=document.getElementById('accountdropdown');
  dropdown.style.display="block";
}
