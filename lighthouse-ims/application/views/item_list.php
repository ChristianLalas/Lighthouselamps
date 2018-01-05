<?php include('includes/meta.php');?>
<?php include('includes/header-script.php'); ?>

<body ng-app = "itemList" ng-controller = "itemListCtrl">
    <input type="hidden" id="route" value="<?php echo site_url();?>">
     <div id="wrapper">
        <!-- Navigation -->
        <?php include('includes/main-nav.php');?>

        <!--Content-->
        <div id="page-wrapper">
             <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" align="center">INVENTORY
                    <br><span>ITEM MASTER LIST <?php echo $header; ?></span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
                    
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
                <div class="col-lg-12">
                	<div class="add-new-item" align="right">
                            <button type="button" class="btn btn-default" data-toggle="modal" ng-click='addItem()'>
                                <i class="fa fa-plus"></i> Add New Item
                            </button>
                            <button type="button" class="btn btn-default" data-toggle="modal" ng-click='additemtype()'>
                                <i class="fa fa-plus"></i> Add Item Type
                            </button>
                            <button type="button" class="btn btn-default" data-toggle="modal" ng-click='addcategory()'>
                                <i class="fa fa-plus"></i> Add Category
                            </button>

                        </div>
                        <br>
                    <div class="panel panel-default">
                        
                            <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><center>Product Code</th>
                                        <th><center>Product Name</th>
                                        <th><center>Product Unit</th>
                                        <th><center>Product Type</th>
                                        <th><center>Re-Order Level</th>
                                         <?php foreach($accounts as $row):
                                              if($row->accID == $accountUN){
                                              if($row->accType == "MANAGER"){ ?>
                                        <th><center>Actions</th>
                                                <?php } else { ?>
                                        <th><center>Item Status</th>
                                                <?php }} endforeach; ?>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php if($inventory == null){?>
                                    <tr>
                                        <td>NO DATA FOUND</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                <?php }  else { foreach ($inventory as $row): 
                                    $itemCodes = sprintf('%04d',$row->itemCode); ?>
                                    <tr>
                                        <td><center><?php echo $itemCodes?></th>
                                        <td><center><?php echo html_escape($row->itemName)?></th>
                                        <td><center><?php echo $row->convUnitName?></th>
                                        <td><center><?php echo $row->itemTypeName?></th>
                                        <td><center><?php echo $row->itemRLvl?></th>
                                             <?php foreach($accounts as $rows):
                                              if($rows->accID == $accountUN){
                                              if($rows->accType == "MANAGER"){ ?>
                                       <td><center><button  type="button" class="btn btn-default" ng-click='editItem(<?php echo $row->itemCode?>)'> EDIT
                                                  </button> 

                                            <?php if($row->itemStat == "ENABLED"){ ?> 
                                                <button  type="button" class="btn btn-default">
                                                    <a href="<?php echo site_url('Item_List/itemDisable/').$accountUN.'/'.$row->itemCode;?>"><?php echo "DISABLE";?></a>
                                                </button>
                                            <?php } else if($row->itemStat == "DISABLED") {  ?>
                                                <button  type="button" class="btn btn-default">
                                                    <a href="<?php echo site_url('Item_List/itemEnable/').$accountUN.'/'.$row->itemCode;?>"><?php echo "ENABLE";?></a>
                                                </button>
                                            <?php } ?>
                                        </td>    
                                        <?php } else { ?>
                                             <td><center><?php echo $row->itemStat; ?></center></td> 
                                             <?php } } endforeach; ?>       
                                    </tr>
                                <?php endforeach; }?>     
                                <!-- Add New Item content pop-up-->                                                                                              
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    <!-- /#wrapper -->

    <!-- Modals -->

    <script type="text/ng-template" id= "success.html">
        <div class="uibModal-body">
            <h3>Item Has Bean Updated</h3>
        </div>
    </script>

    <script type="text/ng-template" id= "categoryFlieds.html">
        <div class="uibModal-body">
            <div class="modal-header"> 
                <h4>{{header}}</h4>
            </div>
            <div class="modal-body">
                <form name="categoryFlieds" ng-submit="submitForm(categoryFlieds.$valid)" novalidate>
                    <div class="form-group" ng-class="{ 'has-error' : categoryFlieds.name.$invalid && !categoryFlieds.name.$pristine }">
                        <label>Item Name</label>
                        <input type="text" name="name" class="form-control" ng-model="name" ng-minlength="1" ng-maxlength="50" required>
                        <p ng-show="categoryFlieds.name.$invalid && !categoryFlieds.name.$pristine" class="help-block">*Please Enter Item Unit*</p>
                        <p class="text-danger" ng-show="unitWarning">*Unit Is Already Is Listed*</p>
                    </div>
                        <button type="submit" class="btn btn-primary">Save</button>  
                        <input type="button" value = "Cancel" ng-click="cancel()" class="btn btn-default"/>
                </form>
            </div>
        </div>
    </script>

    <script type="text/ng-template" id= "itemtypeFlieds.html">
        <div class="uibModal-body">
            <div class="modal-header"> 
                <h4>{{header}}</h4>
            </div>
            <div class="modal-body">
                <form name="itemtypeFlieds" ng-submit="submitForm(itemtypeFlieds.$valid)" novalidate>
                    <div class="form-group" ng-class="{ 'has-error' : itemtypeFlieds.name.$invalid && !itemtypeFlieds.name.$pristine }">
                        <label>Item Name</label>
                        <input type="text" name="name" class="form-control" ng-model="name" ng-minlength="1" ng-maxlength="50" required>
                        <p ng-show="itemtypeFlieds.name.$invalid && !itemtypeFlieds.name.$pristine" class="help-block">*Please Enter Item Unit*</p>
                        <p class="text-danger" ng-show="unitWarning">*Unit Is Already Is Listed*</p>
                    </div>
                        <button type="submit" class="btn btn-primary">Save</button>  
                        <input type="button" value = "Cancel" ng-click="cancel()" class="btn btn-default"/>
                </form>
            </div>
        </div>
    </script>

    <script type="text/ng-template" id="itemFlieds.html">
        <div class="itemFlieds">
            <div class="modal-header"> 
                <h4>{{header}}</h4>
            </div>
            <div class="modal-body">
                <form name="itemFlieds" ng-submit="submitForm(itemFlieds.$valid)" novalidate>
                    <div class="form-group" ng-class="{ 'has-error' : itemFlieds.Name.$invalid && !itemFlieds.Name.$pristine }">
                        <label>Item Name</label>
                        <input type="text" name="Name" class="form-control" ng-model="Name" ng-minlength="2" ng-maxlength="150" ng-change="checkItemName()" required>
                        <p ng-show="itemFlieds.Name.$invalid && !itemFlieds.Name.$pristine" class="help-block">*Please Enter Item Name*</p>
                        <p class="text-danger" ng-show="itemWarning">*Item Is Already In The Inventory List*</p>
                    </div>

                    <div class="form-group" ng-class="{ 'has-error' : itemFlieds.ReorderLvl.$invalid && !itemFlieds.ReorderLvl.$pristine }">
                        <label>Item Re-order Level</label>
                        <input type="number" name="ReorderLvl" class="form-control" ng-model="ReorderLvl" ng-min="1" ng-max="999" required>
                        <p ng-show="itemFlieds.ReorderLvl.$invalid && !itemFlieds.ReorderLvl.$pristine" class="help-block">*Please Enter Reorder Level*</p>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select ng-model="selectedCategory" class="form-control">
                            <option value="NULL">Select Category</option>
                            <option ng-repeat="c in category" value="{{c.categoryID}}">{{c.categoryName}}</option>
                        </select>
                        <p class="text-danger" ng-show="categoryWarning">*Please Select Category*</p>
                    </div> 

                    <div class="form-group">
                        <label>Item Type</label>
                        <select ng-model="selectedItemType" class="form-control">
                            <option value="NULL">Select Item Type</option>
                            <option ng-repeat="t in type" value="{{t.itemTypeID}}">{{t.itemTypeName}}</option>
                        </select>
                        <p class="text-danger" ng-show="itemTypeWarnning">*Please Select Item Type*</p>
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Save</button>  
                    <input type="button" value = "Cancel" ng-click="cancel()" class="btn btn-default"/> 
           </form>
            </div>
        </div>
    </script>
 
    <!-- Custom Theme JavaScript -->
    
    <?php include('includes/footer-script.php'); ?>
    <?php include('includes/modals.php'); ?>
    
    <script src="<?php echo base_url();?>/js/itemList.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
 <footer align="center">
            <p><?php echo date("M/d/Y"); ?></p>
            <p>Danes Bakeshop <?php echo date('Y'); ?>. All Rights Reserved</p>
</footer>
</body>

</html>
