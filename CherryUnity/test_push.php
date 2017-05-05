 <span id="update"></span>
<script>
function recieveData(){
  var ajaxObject = new XMLHttpRequest();
  ajaxObject.open("GET", "data.php");
  ajaxObject.onload = function(){
     if(ajaxObject.readyState == 4 || ajaxObject.status == 200)
     {
         document.getElementById("update").innerHTML = ajaxObject.responseText;
         recieveData();
     }
  }
  ajaxObject.send();
}
recieveData();
</script>