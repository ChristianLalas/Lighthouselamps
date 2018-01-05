var site_url = document.getElementById("route").value;
var currentUser = document.getElementById("currentUser").value;

var app = angular.module('notifications', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

app.controller('notificationsCtrl', function($scope, $http, $uibModal, $log, $filter){

	$scope.accept = function(id){
		$uibModal.open({
			templateUrl: 'confirmation.html',
			controller: 'confirmationCtrl',
			size: 'md',
			resolve: {
				status: function() {
					return "APPROVE"
				},
				id: function() {
					return id
				}
			}

		});

	}

	$scope.decline = function(id){
		$uibModal.open({
			templateUrl: 'confirmation.html',
			controller: 'confirmationCtrl',
			size: 'md',
			resolve: {
				status: function() {
					return "DECLINE"
				},
				id: function() {
					return id
				}
			}

		});
	}
});

app.controller('confirmationCtrl', function ($scope, $http, $uibModal, $uibModalInstance, status, id) {
	$scope.status = status;
	$scope.yes = function() {
		$http.post(site_url + "/Requests/updateStatus", {
			'accountID' :currentUser,
			'status' : status+"D",
			'id' 	 : id
		}).success(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'success.html',
				size: 'md'
			});
			$uibModalInstance.close();
			window.location.assign(site_url + "/Requests");
		}).error(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {	
					ErrorMsg : function () {
						return "Server Error Unable To Process Request";
					}
				}
			});
		});	
	}
	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	}
});

/*load the warning modal */
app.controller('warningCtrl', function ($scope, $http, $uibModal, $uibModalInstance, ErrorMsg) {
	$scope.ErrorMsg = ErrorMsg;
});