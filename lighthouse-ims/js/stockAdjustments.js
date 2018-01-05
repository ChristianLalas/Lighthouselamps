var actLogID, newQty, stat;
var site_url = document.getElementById("route").value;
var currentUser = document.getElementById("currentUser").value;
var currentUserType = document.getElementById("currentUserType").value;
var units = [];
var items = [];
var app = angular.module('stockAdjustments', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

app.controller('stockAdjustmentsCtrl', function($scope, $http, $uibModal, $log){
	$scope.sign = "null";
	/*get item from the database*/
	$http.get(site_url + "/Stock_Adjustments/getItems")
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
					return "Server Error Unable To Connet The DataBase";
				}
			}	
		});
	});

	/*fill's up the input flieds*/
	$scope.onSelect = function($item, $model, $label){
		$scope.proType 		= $item.itemTypeName;
		$scope.itemCode 	= $item.itemCode;
		units.splice(0, units.length);
		units.push({"unitID":$item.unitID, "unitName" : $item.unitName});
		if($item.convUnitName !== $item.unitName){
			units.push({"unitID":$item.convUnitID, "unitName" : $item.convUnitName});
		}
		$scope.units = units; 
		$scope.unit = JSON.stringify(units[0]);
	}

	$scope.addItem = function(itemCode, itemName, qty, desc, sign){
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
		} else if( qty < 1){
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
		
		} else if( sign == "null"){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Select ACTION";
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
		} else if( desc === undefined || desc == ""){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Fill-up The DESCRIPTION Properly";
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
				if (checkItem(SelItemName, desc) == true){
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
						"itemCode"	: itemCode, 
						"name"		: SelItemName, 
						"qty"		: qty, 
						"sign"		: sign, 
						"desc"		: desc, 
			
					});	
					$scope.items = items;
				}
			} else {
				items.push({
					"itemCode"	: itemCode, 
					"name"		: SelItemName, 
					"qty"		: qty, 
					"sign"		: sign, 
					"desc"		: desc, 
	
				});	
			}

			$scope.items 	= items;
			$scope.itemCode = "";
			$scope.itemName = "";
			$scope.qty 		= null;
			$scope.sign 	= 'null';
			$scope.desc 	= "";
			window.onbeforeunload = function(){
			  return 'Are you sure you want to leave?';
			};
		}
	}

	function checkItem(item, desc){
		for (var i = 0; i <= items.length; i++) {
			if(items[i] !== undefined ){
				if(item === items[i].name  && desc === items[i].desc){
					return true;
					break;
				}
			} 
		}
	}

	$scope.edit = function(index){
		$scope.sign 		= items[index].sign;
		$scope.itemName 	= items[index].name;
		$scope.itemCode		= items[index].itemCode;
		$scope.qty			= parseInt(items[index].qty);
		$scope.desc 		= items[index].desc;
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
		$scope.qty 			= null;
		$scope.currentQty	= "";
		$scope.proType 		= null;
		$scope.desc 		= "";
		$scope.sign 		= "null";
	}

	$scope.clearFlieds = function(){
		$scope.itemCode 	= "";
		$scope.currentQty	= "";
		$scope.proType 		= null;
		$scope.desc 		= "";
		$scope.sign 		= "null";
	}

	/*insert data to the database*/
		$scope.save = function(){
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
		} else {
			$uibModal.open({
				templateUrl: 'confirmation.html',
				controller: 'confirmationCtrl',
				size: 'md',
				resolve: {
					confMsg : function (){
						return "Are You Sure You Want To Continue Your Request?"
					},

					passData : function() {
						return data = [
							currentUser,
							items
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
		
	if (currentUserType === "MANAGER") {
		stat = "APPROVED";
	} else if (currentUserType !== "MANAGER"){
		stat = "PENDING";
	}
	$scope.yes = function(){
		$http.post(site_url + "/Stock_Adjustments/insertCorrectionData", {
			"accoutID"	: passData[0],
			"itemData" 	: passData[1],
			"stat" 		: stat
		}).success(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'success.html',
				size: 'md',
				resolve: {
					msg : function () {
						return "Request Has Been Sent";
					}
				}
			});
			$uibModalInstance.close();
			window.location.assign(site_url + "/Stock_Adjustments");
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