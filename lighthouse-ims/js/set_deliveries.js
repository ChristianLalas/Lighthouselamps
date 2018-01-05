
var site_url = document.getElementById("route").value;
var item_code = document.getElementById("itemcode").value;

var app = angular.module('Sdeliveries', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

app.controller('SdeliveriesCtrl', function($scope, $http, $uibModal, $log, $filter){

	$scope.itemCode = item_code;

	/*main javaScript*/

	/*insert data to the database*/
	$scope.save = function(){
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
							item_code,	
							$scope.qty
						];
					}
				}	
			});
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
		$http.post(site_url + "/Set_Deliveries/insertSDelData", {
				"itemCode"		: passData[0],
				"SdDQty"		: passData[1]		
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