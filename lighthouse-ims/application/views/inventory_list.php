<?php include('includes/meta.php');?>
<?php include('includes/header-script.php'); ?>
<body ng-app = "itemList" ng-controller = "itemListCtrl">
    <input type="hidden" id="route" value="<?php echo site_url();?>">
     <div id="wrapper">
        <!-- Navigation -->
        <?php include('includes/main-nav.php'); ?>
        <!--Content-->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" align="center">MASTER LIST
                    <br><span>All items</span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
                 <div class="col-lg-12">
                     <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                    <div class="add-new-item" align="center">
                            <button type="button" class="btn btn-default" data-toggle="modal" ng-click='addItem()'>
                                <i class="fa fa-plus"></i> Add New Item
                            </button>
                            <?php } } endforeach; ?>
                    </div>
            <div class="row">
                <div align="center">
                     <input type="hidden"  id = "itemCodeID" value = "<?php echo $ItemCodeTrack?>"/>
                </div>
            </div>
         <?php foreach($accounts as $rows):
                if($rows->accID == $accountUN){
                if($rows->accType == "MANAGER"){ ?>
            <div class="col-lg-13">
                <div class="panel panel-default">
                        <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th><center>Image</th>
                                    <th><center>Item Name</th>
                                    <th><center>Item Category</th>
                                    <?php if ($header == "(All)") { ?> 
                                    <th><center>Item Type</th>
                                    <th><center>Item Description</th>
                                <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                                    <th><center>Price</th>
                                    <th><center>Supplier</th>
                                        <?php } } endforeach; ?>
                                    <th><center>Quantity</center></th>
                                    <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER" || $rows->accType == "WAREHOUSE"){ ?>

                                    <th><center>Re-Order Level</th>
                                    <th><center>Action</th>
                                        <?php } } endforeach; ?>
                                    <?php } else { ?>
                                    <th><center>Ledger</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($inventory == null){?>
                                    <tr>
                                        <td>NO DATA FOUND</td>
                                        <td></td>
                                        <?php if ($header == "(All)") { ?>
                                        <td></td>
                                        <td></td>
                                        <?php } else { ?>
                                        <td></td>
                                        <?php } ?>
                                    </tr>
                                    
                                <?php }  else { foreach ($inventory as $row): ?>
                                    <tr>
                                        <td><?php echo "<img src=html_escape($row->images); style=width:150px;height:150px;"; ?></th></center></td>
                                        <td><center><?php echo html_escape($row->itemName)?></th></center></td>
                                        <td><center><?php echo $row->categoryName?></th>
                                        <td><center><?php echo $row->itemTypeName?></th>
                                        <td><center><?php echo $row->description?></th>
                                            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>

                                        <td><center><?php echo $row->price?></th>
                                        <td><center><?php echo $row->supCompany?></th>
                                            <?php } } endforeach; ?>
                                        <td><center><?php echo $row->baseQty?></th>
                                        <?php if ($header == "(All)") { ?> 

                                        <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER" ){ ?>

                                        <td><center><?php echo $row->itemRLvl?></th>
                                            <?php } } endforeach; ?>
                                        <td>
                                            <center>
                                                <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                                               <label class="fa fa-pencil fa-lg" ng-click='editItem(<?php echo $row->itemCode?>)'>
                                                 </label>

                                            <button  type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Inventory/setCurrerntLedger/').$row->itemCode;?>'">
                                                   
                                                    <i class="fa fa-list-ol fa-lg"></i>
                                            </button> 

                                            <button  type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Inventory/addImage1/').$row->itemCode;?>'">
                                                    <i class="fa fa-picture-o fa-lg"></i>
                                            </button> 
                                            
                                            <?php } } endforeach; ?>

                                        <?php foreach($accounts as $rows):
                                              if($rows->accID == $accountUN){
                                              if($rows->accType == "MANAGER"){ ?>
                                          
                                            <?php if($row->itemStat == "ENABLED"){ ?> 
                                                <button  type="button" class="btn btn-default">
                                                    <a href="<?php echo site_url('Item_List/itemDisable/').$accountUN.'/'.$row->itemCode;?>" style = "color: #000000;"><?php echo "Unvailable";?></a>
                                                </button>
                                            <?php } else if($row->itemStat == "DISABLED") {  ?>
                                                <button  type="button" class="btn btn-default">
                                                    <a href="<?php echo site_url('Item_List/itemEnable/').$accountUN.'/'.$row->itemCode;?>" style = "color: #000000;"><?php echo "Available";?></a>
                                                </button>
                                            <?php } } else { 
                                                
                                                
                                             } }endforeach; ?>
                                        </td>
                                        <?php } else { ?>
                                          <td>
                                            <center>
                                            <button  type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Inventory/setCurrerntLedger/').$row->itemCode;?>'">
                                                   
                                                    <i class="fa fa-list-ol"></i>
                                            </button> 
                                        </td>
                                        <?php } ?>
                                    </tr>
                                <?php  endforeach; }  ?>       
                                <?php } } endforeach; ?>                               
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->

             <?php foreach($accounts as $rows):
                if($rows->accID == $accountUN){
                if($rows->accType == "WAREHOUSE EMPLOYEE" || $rows->accType == "BRANCH EMPLOYEE" ){ ?>
            <div class="col-lg-13">
                <div class="panel panel-default">
                        <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th><center>Item Name</th>
                                    <th><center>Item Category</th>
                                    <th><center>Item Type</th>
                                    <th><center>Item Description</th>
                                    <th><center>Quantity</center></th>
                   
           
        
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($inventory1 == null){?>
                                    <tr>
                                        <td>NO DATA FOUND</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                <?php }  else { foreach ($inventory1 as $row): ?>
                                    <tr>
                                        <td><center><?php echo html_escape($row->itemName)?></th>
                                        <td><center><?php echo $row->categoryName?></th>
                                        <td><center><?php echo $row->itemTypeName?></th>
                                        <td><center><?php echo $row->description?></th>
                                        <td><center><?php echo $row->baseQty?></th>
                                <?php  endforeach; }  ?>
                                    </tr>                                  
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <?php } } endforeach; ?>
        </div>
        <!-- /#page-wrapper -->
</div>
    </div>
    <!-- /#wrapper -->
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
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
                        <label>Item Category</label>
                        <input type="text" name="name" class="form-control" ng-model="name" ng-minlength="1" ng-maxlength="50" required>
                        <p ng-show="categoryFlieds.name.$invalid && !categoryFlieds.name.$pristine" class="help-block">*Please Enter Item Category*</p>
                        <p class="text-danger" ng-show="unitWarning">*Category Is Already Listed*</p>
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
                        <label>Item Type</label>
                        <input type="text" name="name" class="form-control" ng-model="name" ng-minlength="1" ng-maxlength="50" required>
                        <p ng-show="itemtypeFlieds.name.$invalid && !itemtypeFlieds.name.$pristine" class="help-block">*Please Enter Item Type*</p>
                        <p class="text-danger" ng-show="unitWarning">*Item Type Is Already Listed*</p>
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

                    <div class="form-group" >
                        <label>Item Description</label>
                        <input type="text" name="description" class="form-control" ng-model="description" ng-minlength="1" ng-maxlength="50" required>
                        <p ng-show="itemFlieds.Name.$invalid && !itemFlieds.Name.$pristine" class="help-block">*Please Enter Item Description*</p>
                        <p class="text-danger" ng-show="itemWarning">*Item Is Already In The Inventory List*</p>
                    </div>

                    <div class="form-group" ng-class="{ 'has-error' : itemFlieds.price.$invalid && !itemFlieds.price.$pristine }">
                        <label>Item Price</label>
                        <input type="number" name="price" class="form-control" ng-model="price" ng-min="1" ng-max="100000" required>
                        <p ng-show="itemFlieds.price.$invalid && !itemFlieds.price.$pristine" class="help-block">*Please Enter Price*</p>
                    </div>

                    <div class="form-group" ng-class="{ 'has-error' : itemFlieds.ReorderLvl.$invalid && !itemFlieds.ReorderLvl.$pristine }">
                        <label>Item Re-order Level</label>
                        <input type="number" name="ReorderLvl" class="form-control" ng-model="ReorderLvl" ng-min="1" ng-max="999" required>
                        <p ng-show="itemFlieds.ReorderLvl.$invalid && !itemFlieds.ReorderLvl.$pristine" class="help-block">*Please Enter Reorder Level*</p>
                    </div>


                    <div class="form-group">
                        <label>Category</label>
                        <select ng-model="selectedCategory" class="form-control">
                            <option value="NULL">-Select Category-</option>
                            <option ng-repeat="c in category" value="{{c.categoryID}}">{{c.categoryName}}</option>
                        </select>
                        <p class="text-danger" ng-show="categoryWarning">*Please Select Category*</p>
                    </div> 


                    <div class="form-group">
                        <label>Item Type</label>
                        <select ng-model="selectedItemType" class="form-control">
                            <option value="NULL">-Select Item Type-</option>
                            <option ng-repeat="t in type" value="{{t.itemTypeID}}">{{t.itemTypeName}}</option>
                        </select>
                        <p class="text-danger" ng-show="itemTypeWarnning">*Please Select Item Type*</p>
                    </div>

                    <div class="form-group">
                        <label>Supplier</label>
                        <select ng-model="selectedSupplier" class="form-control">
                            <option value = "NULL">-Select Supplier-</option>
                            <?php foreach($supplier as $rows): ?>
                                <option value = '<?php echo $rows->supID?>'><?php echo $rows->supCompany?></option>
                            <?php endforeach ?>
                        </select>
                        <p class="text-danger" ng-show="supplierWarning">*Please Select Supplier*</p>
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Save</button>  
                    <input type="button" value = "Cancel" ng-click="cancel()" class="btn btn-default"/> 
           </form>
            </div>
        </div>
    </script>


      <script type="text/ng-template" id="itemFlieds1.html">
        <div class="itemFlieds">
            <div class="modal-header"> 
                <h4>{{header}}</h4>
            </div>
            <div class="modal-body">
                <form name="itemFlieds" ng-submit="submitForm(itemFlieds.$valid)" novalidate>

                    <div class="form-group" ng-class="{ 'has-error' : itemFlieds.Name.$invalid && !itemFlieds.Name.$pristine }">
                        <label>Item Name</label>
                        <input type="text" name="Name" class="form-control"  disabled ng-model="Name" ng-minlength="2" ng-maxlength="150" ng-change="checkItemName()" required>
                        <p ng-show="itemFlieds.Name.$invalid && !itemFlieds.Name.$pristine" class="help-block">*Please Enter Item Name*</p>
                        <p class="text-danger" ng-show="itemWarning">*Item Is Already In The Inventory List*</p>
                    </div>

                    <div class="form-group" >
                        <label>Item Description</label>
                        <input type="text" name="description"  disabled class="form-control" ng-model="description" ng-minlength="1" ng-maxlength="50" required>
                        <p ng-show="itemFlieds.Name.$invalid && !itemFlieds.Name.$pristine" class="help-block">*Please Enter Item Name*</p>
                        <p class="text-danger" ng-show="itemWarning">*Item Is Already In The Inventory List*</p>
                    </div>

                    <div class="form-group" ng-class="{ 'has-error' : itemFlieds.price.$invalid && !itemFlieds.price.$pristine }">
                        <label>Item Price</label>
                        <input type="number" name="price" class="form-control"  ng-model="price" ng-min="1" ng-max="100000" required>
                        <p ng-show="itemFlieds.price.$invalid && !itemFlieds.price.$pristine" class="help-block">*Please Enter Price*</p>
                    </div>

                    <div class="form-group" ng-class="{ 'has-error' : itemFlieds.ReorderLvl.$invalid && !itemFlieds.ReorderLvl.$pristine }">
                        <label>Item Re-order Level</label>
                        <input type="number" name="ReorderLvl" class="form-control" ng-model="ReorderLvl" ng-min="1" ng-max="999" required>
                        <p ng-show="itemFlieds.ReorderLvl.$invalid && !itemFlieds.ReorderLvl.$pristine" class="help-block">*Please Enter Reorder Level*</p>
                    </div>


                    <div class="form-group">
                        <label>Category</label>
                        <select ng-model="selectedCategory"   disabled class="form-control">
                            <option   disabled value="NULL">Select Category</option>
                            <option ng-repeat="c in category" value="{{c.categoryID}}">{{c.categoryName}}</option>
                        </select>
                        <p class="text-danger" ng-show="categoryWarning">*Please Select Category*</p>
                    </div> 


                    <div class="form-group">
                        <label>Item Type</label>
                        <select ng-model="selectedItemType"  disabled class="form-control">
                            <option value="NULL"  disabled>Select Item Type</option>
                            <option ng-repeat="t in type" value="{{t.itemTypeID}}">{{t.itemTypeName}}</option>
                        </select>
                        <p class="text-danger" ng-show="itemTypeWarnning">*Please Select Item Type*</p>
                    </div>

                    <div class="form-group">
                        <label>Supplier</label>
                        <select ng-model="selectedSupplier" disabled class="form-control">
                            <option value = 'null'  disabled>-Select Supplier-</option>
                            <?php foreach($supplier as $rows): ?>
                                <option value = '<?php echo $rows->supID?>'><?php echo $rows->supCompany?></option>
                            <?php endforeach ?>
                        </select>
                        <p class="text-danger" ng-show="itemTypeWarnning">*Please Select Item Type*</p>
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Save</button>  
                    <input type="button" value = "Cancel" ng-click="cancel()" class="btn btn-default"/> 
           </form>
            </div>
        </div>
    </script>
    <div class="modal fade" id="add-modal" role="dialog">
  <div class="modal-dialog modal-lg">  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="fa fa-plus-circle"> Add Product</span></h4>
      </div>
      <form action="<?php echo base_url(); ?>create_product" method="POST" enctype='multipart/form-data'>
        <div class="modal-body">
          <div class='alert alert-danger' id='product_exist_warning' style='display: none;'>
            <p><i class='material-icons' style='float: left;'>priority_high</i> &nbsp; <span style='line-height: 1.8;'>Product already exist</span></p>
          </div> 
          <div class='row'>
            <div class='col-md-5'>
              <h4 style="text-align: center;">Upload Image</h4>
              <img class='temp-img' src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uploads/default.jpg" width='100%'>
              <input class='img' type='file' name='image' style='margin-top: 20px;'>
            </div>
            <div class='col-md-7'>
              <table width="100%">
                <tr>
                  <td colspan='2'><label>Supplier</label></td>
                </tr>
                <tr>
                  <td colspan="2" style='padding-bottom: 20px;'>
                      <select id='select-supplier' name='suppID' class="form-control show-tick" data-live-search="true" required>
                          <option value=""></option>
                          <?php 
                              foreach ($suppliers as $key => $value) {
                                echo "<option suppID='$value->suppID' name='$value->suppName' person='$value->personToContact' number='$value->contactNum' address='$value->suppAddress' value='$value->suppID'>$value->suppName</option>";
                                
                              }
                          ?>
                      </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input name="pname" type="text" class="form-control" required>
                              <label class="form-label">Product Name</label>
                          </div>
                      </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input name="brand" type="text" class="form-control" required>
                            <label class="form-label">Brand</label>
                        </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div class="form-group">
                      <div class="form-line">
                        <textarea name="desc" rows="4" class="form-control no-resize" placeholder="Description here..."></textarea>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="form-group form-float">
                      <div class="form-line">
                          <input name="qty" type="number" name="qty" step='1' min="0" max="1000" name="qty" class="form-control" required>
                          <label class="form-label">Initial Inventory</label>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="form-group form-float">
                      <div class="form-line">
                          <input name="relvl" type="number" name="qty" step='1' min="1" max="1000" name="qty" class="form-control" required>
                          <label class="form-label">Re-order Level</label>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input name="price" type="number" step='0.01' class="form-control" min='1' required>
                            <label class="form-label">Price per unit</label>
                        </div>
                    </div>
                  </td>
                </tr>
              </table>
              <input type='hidden' name='user' id='addProdUser'>
            </div>
          </div>
          <div class='row'>
            <div class='col-md-12' style='text-align: center; padding-top: 15px;'>
              <button type="submit" class="btn btn-primary btn-block">SAVE</button>
            </div>
          </div>
        </div>
      </form>
    </div>   
  </div>
</div>
 
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
            <p>LIGHTHOUSE LAMPS<?php echo date('Y'); ?>. All Rights Reserved</p>
</footer>
</body>

</html>
