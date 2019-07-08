class progressBar {
  constructor() {
    this.canvas = document.getElementById("progressBar");
    this.context = this.canvas.getContext("2d");
    this.visible = false;
  }
  
  set(percent) {
    if(!this.visible) return;
    this.context.fillStyle = "#FFFFFF";
    this.context.fillRect(0, 0, this.canvas.width, this.canvas.height);
    this.context.fillStyle = "#0000AA";
    this.context.fillRect(0, 0, this.canvas.width*percent, this.canvas.height);
  }
  
  setVisible(b) {
    this.visible = b;
    if(b) {
      if(this.canvas.classList.contains("hidden")) {
        this.canvas.classList.remove("hidden");
      }
    } else {
      if(!this.canvas.classList.contains("hidden")) {
        this.canvas.classList.add("hidden");
      }
    }
  }
}

var uploadProgressBar = new progressBar();

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
  if(event.type != "drop") return;
  var files = event.dataTransfer.files;
  

  formdata = new FormData();
  for(let i = 0; i < files.length; i++) {
    formdata.append("file"+i,files[i]);
  }
  formdata.append("parent",currentdirectory);
  
  var random = Math.floor(Math.random() * 1000);  
  var url = "upload-handler.php";


  var xhttp = new XMLHttpRequest();
  
  xhttp.upload.addEventListener("progress", function(e) {
    let percent = e.loaded/e.total;
    uploadProgressBar.set(percent);
  }, false);
  
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      uploadProgressBar.setVisible(false);
      location.reload();
    }
  };
  
  uploadProgressBar.setVisible(true);
  xhttp.open("POST", url,true);
  xhttp.send(formdata);
}


function createNewFolder(){
  var modal = document.getElementById('createFile');
  modal.style.display="block";
}

function dropdown(){
  var dropdown=document.getElementById('accountdropdown');
  dropdown.classList.toggle("hidden");
}
window.onrightclick = function(){
  event.preventDefault();
}




function upload() {
  var file=document.getElementById('file').files;
  // file = file.files[0]; one file upload
  console.log(file);
  

 

  formdata = new FormData();
  formdata.append("file",file);
  formdata.append("parent",currentdirectory);
  
  var random = Math.floor(Math.random() * 1000);  
  var url = "upload-handler.php?random="+random;


  var xhttp = new XMLHttpRequest();
  
  xhttp.upload.addEventListener("progress", function(e) {
    let percent = e.loaded/e.total;
    uploadProgressBar.set(percent);
  }, false);
  
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      uploadProgressBar.setVisible(false);
      location.reload();
    }
  };
  uploadProgressBar.setVisible(true);
  xhttp.open("POST", url,true);
  xhttp.send(formdata);
}