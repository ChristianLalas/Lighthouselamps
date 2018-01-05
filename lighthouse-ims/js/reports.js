var site_url = document.getElementById("route").value;
var currentUser = document.getElementById("currentUser").value;



$scope.print = function(divName){
    var printContents = document.getElementById(divName).outerHTML;
    newWin = window.open(""); 
    newWin.document.write(printContents);
    newWin.print();
  }

$('#endBalTable').dataTable({
    "paging":   false,
    "bFilter": false,
    "ordering": false,
    "info":     false
});