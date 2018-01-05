$scope.print = function(divName){
		var printContents = document.getElementById(divName).outerHTML;
		newWin = window.open("");	
		newWin.document.write(printContents);
		newWin.print();
	}