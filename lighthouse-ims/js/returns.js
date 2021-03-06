var items = [];
var actLogID, SelItemName, previousDate,nextDate, newDate, intDate, intTime, tzoffset, dateReceived, currentDate ,currentTime;
var site_url = document.getElementById("route").value;
var currentUser = document.getElementById("currentUser").value;
var trackID = document.getElementById("trackID").value;

var app = angular.module('return', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

app.controller('returnCtrl', function($scope, $http, $uibModal, $log, $filter){

	/*sets the SUPPLIER to default*/
	$scope.selectedSupplier = "null";

	/*sets the RECIEVER to default*/
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

	/*main javaScript*/
	/*get item from the database*/
	$http.get(site_url + "/Returns/getItems")
	.success(function(data,status,headers,config){
		$scope.dataItems = data;
	}).error(function(data,status,headers,config){
		$uibModal.open({
			templateUrl: 'warning.html',
			controller: 'warningCtrl',
			size: 'lg',
			resolve: {
				ErrorMsg : function () {
					return "Server Error Unable To Connet The DataBase";
				}
			}	
		});
	});

	/*fill's up the input flieds*/
	$scope.onSelect = function($item, $model, $label){
		$scope.proType 		= $item.itemTypeName;
		$scope.itemCode 	= $item.itemCode;
		$scope.category	    = $item.categoryName;
		$scope.itemQty 		= $item.itemQty;
		$scope.supplier     = $item.supID;

	}

	/*add item/s to the ITEM ARRAY*/
	$scope.addItem = function(itemCode, itemName, qty, category, proType, itemQty, supplier){
		if(itemName === undefined || itemName == ""){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Select An Item";
					}
				}
			});
		} else if(itemCode === undefined || itemCode == ""){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Item Not Found Or Not Yet In The Database";
					}
				}
			});
			} else if(supplier != $scope.selectedSupplier ){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "The Item is not from the selected supplier";
					}
				}
			});


		} else if( itemQty.itemQty == 0){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return " No Quantity in the Master List. Need to Order now. ";
					}
				}
			});

		} else if( itemQty == 0){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return " No Quantity in the Master List. Need to Order now. ";
					}
				}
			});


		} else if( itemQty.itemQty < qty){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return " Error branch quantity is higher than quantity in the masterlist ";
					}
				}
			});

		} else if(supplier != $scope.selectedSupplier ){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "The Item is not from the selected supplier";
					}
				}
			});

		} else if( itemQty < qty){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
					return " Error branch quantity is higher than quantity in the masterlist ";
					}
				}
			});

		} else if( qty <= 0){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Invalid Quantity";
					}
				}
			});




		}  else if( Number.isInteger(qty) === false){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Invalid Quantity";
					}
				}
			});
		
		} else if( qty === undefined || qty == null){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Enter Quantity";
					}
				}
			});
		} else {
			if(itemName.itemName === undefined){
				SelItemName = itemName;
			} else {
				SelItemName = itemName.itemName;
			}

			if(items.length != 0){
				if (checkItem(SelItemName) == true){
					$uibModal.open({
						templateUrl: 'warning.html',
						controller: 'warningCtrl',
						size: 'lg',
						resolve: {
							ErrorMsg : function () {
								return "Item Is Already In The Table";
							}
						}
					});
				} else {
					items.push({	
						"itemCode":itemCode, 
						"name":SelItemName, 
						"qty":qty, 
						"cat" :category,
						"type":proType
					});	
					$scope.items = items;
				}
			} else {
				items.push({
						"itemCode":itemCode, 
						"name":SelItemName, 
						"qty":qty, 
						"cat" :category,
						"type":proType
					});
				$scope.items = items;
			}

		

			$scope.itemCode 	= "";
			$scope.itemName 	= "";
			$scope.qty 			= null;
			$scope.currentQty	= "";
			$scope.category     = "";
			$scope.proType 		= "";	
			$scope.bCValue 		= "";	
			window.onbeforeunload = function(){
			  return 'Are you sure you want to leave?';
			};
		}
	}

	/*Check if item already in the ITEMS ARRAY*/
	function checkItem(item){
		for (var i = 0; i <= items.length; i++) {
			if(items[i] !== undefined ){
				if(item === items[i].name){
					return true;
					break;
				}
			} 
		}
	}

	/*edit the selected Item in the table*/
	$scope.edit = function(index){
		$scope.itemName 	= items[index].name;
		$scope.itemCode		= items[index].itemCode;
		$scope.qty			= parseInt(items[index].qty);
		$scope.currentQty	= parseInt(items[index].curQty);
		$scope.category     = items[index].cat;
		$scope.proType 		= items[index].type;
		items.splice(index, 1);
	}

	/*Removes the selected Item from the table and ITEMS ARRAY*/
	$scope.remove = function(index){
		window.onbeforeunload = null;
		items.splice(index, 1);
	}

	/*Removes all data*/
	function clearData(){
		$scope.itemName 	= "";
		$scope.itemCode 	= "";
		$scope.unit 		= "";
		$scope.qty 			= null;
		$scope.currentQty	= "";
		$scope.proType 		= "";
		$scope.selectedSupplier = "null";
		$scope.desc 		="";
        $scope.catID		= "";
		items.splice(0,items.length);

		$scope.dt = new Date();
		$scope.time = new Date();
	}

	$scope.clearFlieds = function(){
		$scope.itemCode 	= "";
		$scope.qty 			= null;
		$scope.unit 		= "";
		$scope.currentQty	= "";
		$scope.proType 		= "";
		$scope.desc 		= "";
        $scope.catID		= "";
	}

	/*calls the clearData() function*/
	$scope.clear = function(){
		clearData();
	}

	/*insert data to the database*/
	$scope.save = function(){
		
		currentDate = $filter('date')(new Date(), "yyyy-MM-dd");
		currentTime =  $filter('date')(new Date(), "HH:mm:ss");

		intDate = $filter('date')($scope.dt, "yyyy-MM-dd");
		intTime = $filter('date')($scope.time, "HH:mm:ss");

		tzoffset = (new Date()).getTimezoneOffset() * 60000;
		dateIssued = new Date(new Date(intDate +" "+ intTime) - tzoffset);
		

		if(items.length === 0){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "You Have Not Yet Entered Any Data";
					}
				}
			});
		} else if ($scope.selectedUser == "null") {
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Select Issuer";
					}
				}
			});
		} else if ($scope.selectedSupplier === "null") {
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Select A Supplier";
					}
				}
			});
		} else if(currentDate == intDate && intTime > currentTime){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Set The Proper Time Of Transaction";
					}
				}
			});
		} else {
			$uibModal.open({
			templateUrl: 'confirmation.html',
			controller: 'confirmationCtrl',
			size: 'md',
			resolve: {
				confMsg : function (){
					return "Are You Sure You Want To Save Return From Supplier?"
				},
				passData : function() {
					return data = [
							currentUser,
							items,
							trackID,
							$scope.selectedUser,
							$scope.selectedSupplier,
							dateIssued
						]
					}
				}
			});
			
		}
	}
});

/*load the warning modal */
app.controller('warningCtrl', function ($scope, $http, $uibModal, $uibModalInstance, ErrorMsg) {
	$scope.ErrorMsg = ErrorMsg;
});
/*end main javaScript*/
app.controller('confirmationCtrl', function($scope, $http, $uibModal, $uibModalInstance, confMsg, passData) {
	
	$scope.confMsg = confMsg;

	$scope.yes = function(){
		$http.post(site_url + "/Returns/insertGivROtnsData", {
			"accoutID" 		: passData[0],
			"itemData" 		: passData[1],
			"trackID"		: passData[2],
			"issuer"		: passData[3],
			"supplierID"	: passData[4],
			"dateTime"		: passData[5]
		}).success(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'success.html',
				controller: 'successCtrl',
				size: 'md',
				resolve: {
					msg : function () {
						return "Data Has Been Save";
					}
				}

			});
			window.location.assign(site_url + "/Returns");
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
	$scope.cancel =function(){
		$uibModalInstance.dismiss('cancel');

	};

});

app.controller('successCtrl', function ($scope, $http, $uibModal, $uibModalInstance, msg) {
	$scope.msg = msg;

	$scope.ok = function () {
		$uibModalInstance.dismiss('cancel');
	};
});