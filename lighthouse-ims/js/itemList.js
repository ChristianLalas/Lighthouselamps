var site_url = document.getElementById("route").value;
var newItemName = "";
var previousDate, nextDate, newDate, intDate, intTime, tzoffset, dateReceived, currentDate ,currentTime;
var site_url = document.getElementById("route").value;
var trackID = document.getElementById("itemCodeID").value;
var app = angular.module('itemList', ['ui.bootstrap', 'ngAnimate', 'ngSanitize']);

app.controller('itemListCtrl', function($scope, $http, $uibModal, $log, $filter){

	

	/*main javaScript*/
	$scope.addItem = function(){
		var modalInstance = $uibModal.open({
			templateUrl: 'itemFlieds.html',
			controller: 'addItemCtrl',
			size: 'md'
		});
	}

	$scope.additemtype = function(){
		var modalInstance = $uibModal.open({
			templateUrl: 'itemtypeFlieds.html',
			controller: 'additemtypeCtrl',
			size: 'sm'
		});
	}

	$scope.addcategory = function(){
		var modalInstance = $uibModal.open({
			templateUrl: 'categoryFlieds.html',
			controller: 'addCategoryCtrl',
			size: 'sm'
		});
	}

	$scope.addUnit = function(){
		var modalInstance = $uibModal.open({
			templateUrl: 'unitFlieds.html',
			controller: 'addUnitCtrl',
			size: 'sm'
		});
	}

	$scope.editItem = function(code){
		var modalInstance = $uibModal.open({
			templateUrl: 'itemFlieds1.html',
			controller: 'editItemCtrl',
			size: 'md',
			resolve: {
				code : function () {
					return code;
				}
			}
		});
	}
});

app.controller('addCategoryCtrl', function ($scope, $http, $uibModal, $uibModalInstance) {
	$scope.header = "Add Category";
	$scope.unitWarning = false;
	$scope.submitForm = function(valid){
		$http.post(site_url + "/Item_List/checkNewCategoryName",{
			"categoryName": $scope.name
		}).success(function(data,status,headers,config){
			if(data == "TRUE"){
				$scope.unitWarning = true;
			}else if(valid == true && data == "FALSE"){
				$http.post(site_url + "/Item_List/insertCategory",{
					"categoryName": $scope.name
				}).success(function(data,status,headers,config){
					$uibModal.open({
						templateUrl: 'success.html',
						controller: 'successCtrl',
						size: 'md',
						resolve: {
							msg : function () {
								return "Category Has Been Added";
							}
						}
					});
					$uibModalInstance.close();
					window.location.assign(site_url + "/Categorylist");
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
	};

	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
	};
});

app.controller('additemtypeCtrl', function ($scope, $http, $uibModal, $uibModalInstance) {
	$scope.header = "Add New type";
	$scope.unitWarning = false;
	$scope.submitForm = function(valid){
		$http.post(site_url + "/Item_List/checkNewTypeName",{
			"itemTypeName": $scope.name
		}).success(function(data,status,headers,config){
			if(data == "TRUE"){
				$scope.unitWarning = true;
			}else if(valid == true && data == "FALSE"){
				$http.post(site_url + "/Item_List/insertItemtype",{
					"itemTypeName": $scope.name
				}).success(function(data,status,headers,config){
					$uibModal.open({
						templateUrl: 'success.html',
						controller: 'successCtrl',
						size: 'md',
						resolve: {
							msg : function () {
								return "Item Type Has Been Added";
							}
						}
					});
					$uibModalInstance.close();
					window.location.assign(site_url + "/Itemtype");
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
	};

	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
	};
});

app.controller('addUnitCtrl', function ($scope, $http, $uibModal, $uibModalInstance) {
	$scope.header = "Add New Unit";
	$scope.unitWarning = false;
	$scope.submitForm = function(valid){
		$http.post(site_url + "/Item_List/checkNewUnitName",{
			"unitName": $scope.name
		}).success(function(data,status,headers,config){
			if(data == "TRUE"){
				$scope.unitWarning = true;
			}else if(valid == true && data == "FALSE"){
				$http.post(site_url + "/Item_List/insertUnit",{
					"unitName": $scope.name
				}).success(function(data,status,headers,config){
					$uibModal.open({
						templateUrl: 'success.html',
						controller: 'successCtrl',
						size: 'md',
						resolve: {
							msg : function () {
								return "Unit Has Been Added";
							}
						}
					});
					$uibModalInstance.close();
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
	};

	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
	};
});

app.controller('addItemCtrl', function ($scope, $http, $uibModal, $uibModalInstance) {
	$scope.selectedItemType = "NULL";
	$scope.selectedCategory = "NULL";
	$scope.selectedSupplier = "NULL";
	$scope.selectedtrackID	= 1;

	$scope.selectUnit = "NULL";

	
	$scope.header = "Add New Item";


	$http.post(site_url + "/Item_List/getUnits",{})
	.success(function(data,status,headers,config){
		
		$scope.units = data;
		$scope.convUnits = data;
	});

	$http.post(site_url + "/Item_List/getItemType",{})
	.success(function(data,status,headers,config){
		$scope.type = data;
	});

	$http.post(site_url + "/Item_List/getCategory",{})
	.success(function(data,status,headers,config){
		$scope.category = data;
	});

	$http.post(site_url + "/Item_List/getSuppliers",{})
	.success(function(data,status,headers,config){
		$scope.supplier = data;
	});

	$scope.checkItemName = function(){
		$http.post(site_url + "/Item_List/checkNewItem", {
			"newItemName":$scope.Name
		}).success(function(data,status,headers,config){
			if(data == "TRUE"){
				$scope.itemWarning = true;
			} else if(data == "FALSE"){
				$scope.itemWarning = false;
			}
		}).error(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Server Error Unable To Connect To Database";
					}
				}
			});
		});
	}

	$scope.submitForm = function(valid){

		$http.post(site_url + "/Item_List/checkNewItem", {
			"newItemName":$scope.Name
		}).success(function(data,data1,status,headers,config){
			if( $scope.selectedCategory == "NULL" || $scope.selectedItemType == "NULL" || $scope.selectedSupplier == "NULL" ||  data == "TRUE"){
				if($scope.selectedCategory != "NULL"){
					$scope.categoryWarning = false;
				} else {
					$scope.categoryWarning = true;
				}

				if($scope.selectedItemType != "NULL") {
					$scope.itemTypeWarnning = false;
				} else {
					$scope.itemTypeWarnning = true;
				}
				if($scope.selectedSupplier != "NULL"){
					$scope.supplierWarning = false;
				} else {
					$scope.supplierWarning = true;
				}

				if(data == "TRUE"){
					$scope.itemWarning = true;
				} else if(data == "FALSE"){
					$scope.itemWarning = false;
				}

			} else if(valid === true && $scope.selectedCategory != "NULL" && $scope.selectedItemType != "NULL"  && $scope.selectedSupplier != "NULL"  && data == "FALSE"){ 
				$scope.categoryWarning 	= false;
				$scope.itemTypeWarnning = false;
				$scope.supplierWarning 	= false;
				$http.post(site_url + "/Item_List/insertItem", {
					"code"			: trackID,
					"name" 			: $scope.Name,
					"reorderLvl" 	: $scope.ReorderLvl,
					"type"			: $scope.selectedItemType,
					"category"		: $scope.selectedCategory,
					"description"	: $scope.description,
					"supplier"		: $scope.selectedSupplier,
					"price"			: $scope.price,
					"supplier"		: $scope.selectedSupplier,
				}).success(function(data,data1,status,headers,config){
					$uibModal.open({
						templateUrl: 'success.html',
						controller: 'successCtrl',
						size: 'md',
						resolve: {
							msg : function () {
								return "Item Has Been Added";
							}
						}
					});
					$uibModalInstance.close();
					window.location.assign(site_url + "/Item_List");
				}).error(function(data,data1,status,headers,config){
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
		});
	}

	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
	};

});

app.controller('editItemCtrl', function ($scope, $http, $uibModal, $uibModalInstance, code) {


	

	$scope.header = "Edit Item";
	$http.post(site_url + "/Item_List/getSuppliers",{})
	.success(function(data,status,headers,config){
		$scope.supplier= data;
	});

	$http.post(site_url + "/Item_List/getcategory",{})
	.success(function(data,status,headers,config){
		$scope.category = data;
	});

	$http.post(site_url + "/Item_List/getItemType",{})
	.success(function(data,status,headers,config){
		$scope.type = data;
	});

	$http.post(site_url + "/Item_List/searchItem", {
		"code":code
	}).success(function(data,status,headers,config){
		$scope.Name 			= data[0].itemName;
		$scope.ReorderLvl		= parseInt(data[0].itemRLvl);
		$scope.selectedItemType	= data[0].itemTypeID;
		$scope.BCValue			= parseInt(data[0].bCValue);
		$scope.selectedCategory	= data[0].categoryID;
		$scope.selectedSupplier	= data[0].supID;
		$scope.description		= data[0].description;
		$scope.price	= parseInt(data[0].price);

	});

	$scope.checkItemName = function(){
		$http.post(site_url + "/Item_List/checkEditItemName", {
			"itemCode":code,
			"itemName":$scope.Name
		}).success(function(data,status,headers,config){
			if(data === "TRUE"){
				$scope.itemWarning = true;
			} else if(data === "FALSE"){
				$scope.itemWarning = false;
			}
		}).error(function(data,status,headers,config){
			$uibModal.open({
				templateUrl: 'warning.html',
				controller: 'warningCtrl',
				size: 'md',
				resolve: {
					ErrorMsg : function () {
						return "Server Error Unable To Connect To Database";
					}
				}
			});
		});
		
	}

	$scope.submitForm = function(valid){

		$http.post(site_url + "/Item_List/checkEditItemName", {
			"itemCode":code,
			"itemName":$scope.Name
		}).success(function(data,status,headers,config){
			if( $scope.selectedUnit == "NULL" || $scope.selectedItemType == "NULL" || $scope.selectConvUnit == "NULL" || data === "TRUE"){
				if($scope.selectedUnit != "NULL"){
					$scope.unitWarning = false;
				} else {
					$scope.unitWarning = true;
				}

				if(data === "TRUE"){
					$scope.itemWarning = true;
				} else if(data === "FALSE"){
					$scope.itemWarning = false;
				}

				if($scope.selectConvUnit != "NULL"){
					$scope.convUnitWarning = false;
				} else {
					$scope.convUnitWarning = true;
				}

				if($scope.selectedItemType != "NULL") {
					$scope.itemTypeWarnning = false;
				} else {
					$scope.itemTypeWarnning = true;
				}

			} else if(valid === true && $scope.selectedUnit != "NULL" && $scope.selectedItemType != "NULL" && $scope.selectConvUnit != "NULL" && data == "FALSE"){ 
				$scope.unitWarning 		= false;
				$scope.convUnitWarning 	= false;
				$scope.itemTypeWarnning = false;
				$http.post(site_url + "/Item_List/updateItem", {
					"id"			: code, 
					"name" 			: $scope.Name,
					"reorderLvl" 	: $scope.ReorderLvl,
					"type"			: $scope.selectedItemType,
					"supplier" 		: $scope.selectedSupplier,
					"category"		: $scope.selectedCategory,
					"description"	: $scope.description,
					"bCValue"		: $scope.BCValue, 
					"price"			: $scope.price

				}).success(function(data,status,headers,config){
					$uibModal.open({
						templateUrl: 'success.html',
						size: 'md',
					});
					$uibModalInstance.close();
					window.location.assign(site_url + "/Item_List");
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

/*load the warning modal */
app.controller('warningCtrl', function ($scope, $http, $uibModal, $uibModalInstance, ErrorMsg) {
	$scope.ErrorMsg = ErrorMsg;
});

app.controller('successCtrl', function ($scope, $http, $uibModal, $uibModalInstance, msg) {
	$scope.msg = msg;

	$scope.ok = function () {
		$uibModalInstance.dismiss('cancel');
	};
});