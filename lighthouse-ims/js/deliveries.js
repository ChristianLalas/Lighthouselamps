var items = [];
var units = [];
var SelItemName, previousDate, nextDate, newDate, intDate, intTime, tzoffset, dateReceived, currentDate ,currentTime;
var site_url = document.getElementById("route").value;
var currentUser = document.getElementById("currentUser").value;

var app = angular.module('deliveries', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

app.controller('deliveriesCtrl', function($scope, $http, $uibModal, $log, $filter){
	
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

	/*main javaScript*/
	/*get ite from the database*/
	$http.get(site_url + "/Deliveries/getItems")
	.success(function(data,status,headers,config){
		$scope.dataItems = data;
	})
	.error(function(data,status,headers,config){
		$uibModal.open({
			templateUrl: 'warning.html',
			controller: 'warningCtrl',
			size: 'md',
			resolve: {
				ErrorMsg : function () {
					return "Server Error Unable To Connect The Database";
				}
			}	
		});
	});

	/*fill's up the input flieds*/
	$scope.onSelect = function($item, $model, $label){
		$scope.proType 		= $item.itemTypeName;
		$scope.itemCode 	= $item.itemCode;
		$scope.category	    = $item.categoryName;
		$scope.categoryID   = $item.categoryID;
		$scope.supplier     = $item.supID;
		$scope.supName		= $item.supCompany;
	}


	/*add item/s to the ITEM ARRAY*/
	$scope.addItem = function(itemCode, itemName, qty, curQty,category, proType,supName){
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
						return "Item Not Found In The Inventory List";
					}
				}
			});
		} else if( qty < 0){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Enter a Valid Quantity";
					}
				}
			});
		} else if( Number.isInteger(qty) === false){
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
						return "Please Enter The Right Quantity";
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
						size: 'md',
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
						"qty" :qty, 
						"cat" :category,
						"sup" :supName,
						"type":proType
					});	
					$scope.items = items;
				}
			} else {
				items.push({
						"itemCode":itemCode, 
						"name":SelItemName, 
						"qty" :qty, 
						"cat" :category,
						"sup" :supName,
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
			$scope.supName 	    = "";
			$scope.supplier		= "";
		}
	}


	/*Check if item already in the ITEMS ARRAY*/
	function checkItem(item, unit){
		for (var i = 0; i <= items.length; i++) {
			if(items[i] !== undefined ){
				if(item === items[i].name && unit.unitID === items[i].unit[0].unitID){
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
		$scope.proType 		= items[index].type;
		$scope.category 	= items[index].cat;
		$scope.supName 		= items[index].sup;
		items.splice(index, 1);
	}

	/*Removes the selected Item from the table and ITEMS ARRAY*/
	$scope.remove = function(index){
		items.splice(index, 1);
	}

	$scope.clearFlieds = function(){
		$scope.itemCode 	= "";
		$scope.unit 		= "";
		$scope.currentQty	= "";
		$scope.proType 		= "";	
		$scope.bCValue 		= "";	
		$scope.supName		= "";
		$scope.category		= "";
	}

	/*calls the clear all the Data*/
	$scope.clear = function(){
		$scope.itemName 		= "";
		$scope.itemCode 		= "";
		$scope.unit 			= "";
		$scope.qty 				= null;
		$scope.currentQty		= "";
		$scope.proType 			= "";
		$scope.receiptNo 		= "";
		$scope.selectedSupplier = "null";
		$scope.selectedUser 	= "null";
		items.splice(0,items.length);

		$scope.dt = new Date();
		$scope.time = new Date();
	}


	/*insert data to the database*/
	$scope.save = function(){
		currentDate = $filter('date')(new Date(), "yyyy-MM-dd");
		currentTime =  $filter('date')(new Date(), "HH:mm:ss");
		intDate = $filter('date')($scope.dt, "yyyy-MM-dd");
		intTime = $filter('date')($scope.time, "HH:mm:ss");
		tzoffset = (new Date()).getTimezoneOffset() * 60000;
		dateReceived = new Date(new Date(intDate +" "+ intTime) - tzoffset);

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
		}else if ($scope.selectedUser == "null") {
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Select Receiver";
					}
				}
			});
		} else if ($scope.receiptNo === "" || $scope.receiptNo === undefined || parseInt($scope.receiptNo) <= 0) {
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Enter Receipt Number";
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
						return "Please Set The Proper Time Of Delivery";
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
						return "Are You Sure You Want To Save Deliveries?"
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

/*load the warning modal */
app.controller('warningCtrl', function ($scope, $http, $uibModal, $uibModalInstance, ErrorMsg) {
	$scope.ErrorMsg = ErrorMsg;
});

/*load the warning modal */
app.controller('confirmationCtrl', function ($scope, $http, $uibModal, $uibModalInstance, confMsg, passData) {
	$scope.confMsg = confMsg;

	$scope.yes = function(){
		$http.post(site_url + "/Deliveries/insertDelData", {
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
/*end main javaScript*/