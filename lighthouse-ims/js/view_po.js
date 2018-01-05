var site_url = document.getElementById("route").value;
var previousDate, nextDate, newDate, intDate, intTime, tzoffset, dateReceived, currentDate ,currentTime;
var currentUser = document.getElementById("currentUser").value;
var items = [], itemCode, arrayCount, rQty, pDqty;

var app = angular.module('view_po', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

$('#endBalTable').dataTable({
    "paging":   false,
    "bFilter": false,
    "ordering": false,
    "info":     false
});

app.controller('view_poCtrl', function($scope, $http, $uibModal, $log, $filter){

	/*sets the RECIEVER to current user*/
	$scope.selectedUser = currentUser;


	/*date and time picker*/
	$scope.ismeridian = true;
	$scope.dt = new Date();	
	$scope.time = new Date();

	$scope.hstep = 1;
	$scope.mstep = 1;

	$scope.options = {
		hstep: [1, 2, 3],
		mstep: [1]
	};

	$scope.update = function() {
		var d = new Date();
		d.setHours( 14 );
		d.setMinutes( 0 );
		$scope.time = d;
	};

	$scope.inlineOptions = {
		customClass: getDayClass,
		minDate: new Date(2000, 01, 01),
		showWeeks: 'false'
	};

	$scope.dateOptions = {
		formatYear: 'yyyy',
		maxDate: new Date(),
		minDate: new Date(2000, 01, 01),
		startingDay: 0,
		showWeeks:  false
	};

	$scope.open = function() {
		$scope.popup.opened = true;
	};

	$scope.setDate = function(year, month, day) {
		$scope.dt = new Date(year, month, day);
	};

	$scope.popup = {
		opened: false
	};

	$scope.previous = function(){
		previousDate = $scope.dt.getDate() - 1;
		newDate = $scope.dt.setDate(previousDate);
		$scope.dt = new Date(newDate);
	}

	$scope.next = function(){
		nextDate = $scope.dt.getDate() + 1;
		newDate = $scope.dt.setDate(nextDate);
		$scope.dt = new Date(newDate);
	}

	function getDayClass(data) {
		var date = data.date,
		mode = data.mode;
		if (mode === 'day') {
			var dayToCheck = new Date(date).setHours(0,0,0,0);

			for (var i = 0; i < $scope.events.length; i++) {
				var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

				if (dayToCheck === currentDay) {
					return $scope.events[i].status;
				}
			}
		}

		return '';
	}
	/*end date and time picker*/

	
	$scope.checkInputs =  function(index){
		rQty 			= parseInt(document.getElementById("rQty"+index).value);
		window.onbeforeunload = function(){
		  return 'Are you sure you want to leave?';
		};
}

	$scope.clearArray = function(){
		items.splice(0,items.length);
	}	

	function itemVal(){
		arrayCount = parseInt(document.getElementById("arrayCount").value);
		
		for (var i = 0; i < arrayCount; i++) {
			itemCode			= document.getElementById("itemCode"+i).value;
			rQty				= parseInt(document.getElementById("rQty"+i).value);
			$scope.itemCode 	= document.getElementById("itemCode"+i).value;
	 		$scope.rQty			= parseInt(document.getElementById("rQty"+i).value);
			$scope.pQty 		= document.getElementById("pQty"+i).value;
	 		if(checkItem(itemCode) !== true){
					items.push({
						"itemCode"	: itemCode,
						"rQty"	    : rQty
					});

				}
			
		}	

	}

	function checkItem(itemCode){
		for (var i = 0; i <= items.length; i++) {
			if(items[i] !== undefined ){
				if(itemCode === items[i].itemCode){
					return true;
					break;
				}
			}  		
		}
	}

	function checkZero(itemCode){
		for (var i = 0; i <= items.length; i++) {
			if(items[i] !== undefined ){
				if(itemCode === items[i].itemCode){
					return true;
					break;
				}
			}  		
		}
	}

	$scope.print = function(divName){
		var printContents = document.getElementById(divName).outerHTML;
		newWin = window.open("");	
		newWin.document.write(printContents);
		newWin.print();
	}

	$scope.save = function(){
		console.log(itemVal());
		currentDate = $filter('date')(new Date(), "yyyy-MM-dd");
		currentTime =  $filter('date')(new Date(), "HH:mm:ss");
		intDate = $filter('date')($scope.dt, "yyyy-MM-dd");
		intTime = $filter('date')($scope.time, "HH:mm:ss");
		tzoffset = (new Date()).getTimezoneOffset() * 60000;
		dateReceived = new Date(new Date(intDate +" "+ intTime) - tzoffset);

		if(items.length < 0){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "There's Noting To Save";
					}
				}
			});
		} else if($scope.rQty > $scope.pQty  ){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "INVALID QUANTITY";
					}
				}
			});
		}else {
			$uibModal.open({
				templateUrl: 'confirmation.html',
				controller: 'confirmationCtrl',
				size: 'md',
				resolve: {
					confMsg : function (){
						return "Are You Sure You Want To Record Balances?"
					},

					passData : function () {
						return data = [
							currentUser,
							items,
							$scope.receiptNo,
							$scope.selectedUser,
							dateReceived
						];
					}
				}	
			});
		}
	}
});

app.controller('warningCtrl', function ($scope, $http, $uibModal, $uibModalInstance, ErrorMsg) {
	$scope.ErrorMsg = ErrorMsg;
});

app.controller('confirmationCtrl', function ($scope, $http, $uibModal, $uibModalInstance, confMsg, passData) {
	$scope.confMsg = confMsg;

	$scope.yes = function(){
		$http.post(site_url + "/Deliveries/insertDelDataVP", {
				"accountID" : passData[0],
				"itemData" 	: passData[1], 
				"trackID"	: passData[2],
				"receiver"	: passData[3],
				"dateTime"	: passData[4]
		}).success(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'success.html',
				controller: 'successCtrl',
				size: 'md',
				resolve: {
					msg : function () {
						return "Data Has Been Save ";
					}
				}
			});
			$uibModalInstance.close();
			window.location.assign(site_url + "/Deliveries");
			window.onbeforeunload = null;
		}).error(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Server Error Unable To Save Data";
					}
				}
			});
		});
	}
	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
	};
});

app.controller('successCtrl', function ($scope, $http, $uibModal, $uibModalInstance, msg) {
	$scope.msg = msg;

	$scope.ok = function () {
		$uibModalInstance.dismiss('cancel');
	};
});