var site_url = document.getElementById("route").value;
var currentUser = document.getElementById("currentUser").value;
var items = [], desc, physCnt, logCnt, itemCode, arrayCount, physCntBaseQty, physCntCovQty, bCValue;
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
		physCnt 	= parseInt(document.getElementById("physCnt"+index).value);
		bCValue 	= parseInt(document.getElementById("bCValue"+index).value);
		difference = parseInt(document.getElementById("diff"+index).value);
		physicalCount = (physCntBaseQty * bCValue) + physCntCovQty;
		if(logicalCount !== physicalCount){
			document.getElementById("desc"+index).disabled = false;
		} else{
			document.getElementById("desc"+index).disabled = true;
		}	
	}

	$scope.clearArray = function(){
		items.splice(0,items.length);
	}	

	function itemVal(){
		arrayCount = parseInt(document.getElementById("arrayCount").value);
		
		for (var i = 0; i < arrayCount; i++) {
			
			itemCode 		= document.getElementById("itemCode"+i).value;
			bCValue 		= document.getElementById("bCValue"+i).value;
			logCnt 			= parseInt(document.getElementById("logCnt"+i).value);
			physCnt 		= document.getElementById("physCnt"+i).value;

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

	$scope.save = function(){
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
});

app.controller('warningCtrl', function ($scope, $http, $uibModal, $uibModalInstance, ErrorMsg) {
	$scope.ErrorMsg = ErrorMsg;
});

app.controller('confirmationCtrl', function ($scope, $http, $uibModal, $uibModalInstance, confMsg, passData) {
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
			window.location.assign(site_url + "/Ending_Balance");
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