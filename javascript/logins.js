document.addEventListener('DOMContentLoaded', function() {
  let errors = document.getElementById("errorbox");
  if(typeof(errors) != 'undefined' && errors != null) {
    document.getElementById("loginformbody").classList.add("hidden");
    document.getElementById("errorboxclose").addEventListener('click', function(e) {
      document.getElementById("errorbox").classList.add("hidden");
      document.getElementById("loginformbody").classList.remove("hidden");
    });
  }
}, false, true);
