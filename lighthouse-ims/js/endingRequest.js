var site_url = document.getElementById("route").value;
var currentUser = document.getElementById("currentUser").value;
var items = [], desc, physCnt, logCnt, itemCode,arrayCount1, arrayCount, physCntBaseQty, physCntCovQty, bCValue;
var total = $('#diff');
var app = angular.module('endingBalance', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

$('#endBalTable').dataTable({
    "paging":   false,
    "bFilter": false,
    "ordering": false,
    "info":     false
});



app.controller('endingBalanceCtrl', function($scope, $http, $uibModal, $log, $filter){
	
	$scope.checkInputs =  function(index){
		logicalCount 	= parseInt(document.getElementById("logCnt"+index).value);
		physCntBaseQty 	= parseInt(document.getElementById("physCntBaseQty"+index).value);
		physCntCovQty 	= parseInt(document.getElementById("physCntCovQty"+index).value);
		bCValue 	= parseInt(document.getElementById("bCValue"+index).value);
		physicalCount = (physCntBaseQty * bCValue) + physCntCovQty;
		if(logicalCount !== physicalCount){
			document.getElementById("desc"+index).disabled = false;
		} else{
			document.getElementById("desc"+index).disabled = true;
		}	
	}

	$scope.start =  function(index){
		$uibModal.open({
				templateUrl: 'confirmation.html',
				controller: 'startCtrl',
				size: 'md',
				resolve: {
					confMsg : function (){
						return "START RECONCILIATION?"
					}
				}
			});
	}

	$scope.clearArray = function(){
		items.splice(0,items.length);
	}	

	function itemVal(){
		arrayCount = parseInt(document.getElementById("arrayCount").value);
		
		for (var i = 0; i < arrayCount; i++) {
			
			itemCode 		= document.getElementById("itemCode"+i).value;
			bCValue 		= document.getElementById("bCValue"+i).value;
			physCntBaseQty 	= parseInt(document.getElementById("physCntBaseQty"+i).value);
			physCntCovQty 	= parseInt(document.getElementById("physCntCovQty"+i).value);
			logCnt 			= parseInt(document.getElementById("logCnt"+i).value);

			physCnt = (physCntBaseQty * bCValue) + physCntCovQty;

			if(checkItem(itemCode) !== true){
				items.push({
					"itemCode"	: itemCode,
					"logCnt"	: logCnt,
					"physCnt"	: physCnt,
					"desc"		: null
				});
			}
		
		}	
	}

	function itemVal1(){
		arrayCount = parseInt(document.getElementById("arrayCount1").value);
		
		for (var i = 0; i < arrayCount; i++) {
			
			itemCode 		= document.getElementById("itemCode"+i).value;
			logCnt 			= parseInt(document.getElementById("logCnt"+i).value);
			physCnt 		= document.getElementById("physCnt"+i).value;

			items.push({
				"itemCode"	: itemCode,
				"logCnt"	: logCnt,
				"physCnt"	: physCnt,
				"desc"		: null
			});
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
	
	$scope.print = function(divName){
		var printContents = document.getElementById(divName).outerHTML;
		newWin = window.open("");	
		newWin.document.write(printContents);
		newWin.print();
	}

	$scope.saveReq = function(){
		console.log(itemVal());

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
		} else if(itemVal() === "qtyError"){
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
		} else if(itemVal() === "physCntError"){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Please Enter Proper Value. It Must Be Equal Or Greater Than 0";
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
						return "Are You Sure You Want To Record Reconciliation?"
					},

					passData : function () {
						return data = [
							currentUser,
							items
						];
					}
				}	
			});
		}
	}

	$scope.save = function(){
		console.log(itemVal1());

		if(items.length <=  1){
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
		} else {
			$uibModal.open({
				templateUrl: 'confirmation.html',
				controller: 'confirmationCtrlBal',
				size: 'md',
				resolve: {
					confMsg : function (){
						return "Are You Sure You Want To Record Reconciliation?"
					},

					passData : function () {
						return data = [
							currentUser,
							items
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
		$http.post(site_url + "/Ending_Request/insertEndBalData", {
				"accountID" : passData[0],
				"itemData" 	: passData[1]	
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
			window.location.assign(site_url + "/Ending_Request");
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

app.controller('confirmationCtrlBal', function ($scope, $http, $uibModal, $uibModalInstance, confMsg, passData) {
	$scope.confMsg = confMsg;

	$scope.yes = function(){
		$http.post(site_url + "/Ending_Balance/insertEndBalData", {
				"accountID" : passData[0],
				"itemData" 	: passData[1]	
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
			window.location.assign(site_url + "/Ending_Request");
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

app.controller('startCtrl', function ($scope, $http, $uibModal, $uibModalInstance, confMsg) {
	$scope.confMsg = confMsg;

	$scope.yes = function(){
		$http.post(site_url + "/Ending_Request/start_reconciliation")
		.success(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'success.html',
				controller: 'successCtrl',
				size: 'md',
				resolve: {
					msg : function () {
						return "STARTING ";
					}
				}
			});
			$uibModalInstance.close();
			window.location.assign(site_url + "/Ending_Request");
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