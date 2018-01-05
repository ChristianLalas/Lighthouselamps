<?php include('includes/meta.php'); ?>
<?php include('includes/header-script.php'); ?>

<body ng-app = "deliveries" ng-controller = "deliveriesCtrl">
    <input type="hidden" id="route" value="<?php echo site_url();?>">
    <div id="wrapper"> 
        <?php include('includes/main-nav.php'); ?>
        <div id="page-wrapper">
        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" align="center">DELIVERIES
                    <br><span>ALL NEW DELIVERIES</span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER" || $rows->accType == "WAREHOUSE EMPLOYEE" ){ ?>
            <!-- /.lighthouse-header-->
             <div class="panel-body">
                <div class="row">
                    <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER" ){ ?>
                    <div class="col-lg-12">
                        <div class="col-sm-4">
                            <div class="panel panel-default" align="center">
                                <label>Delivery Receipt Number</label>
                                <input type="text" class="form-control" ng-model = "receiptNo">
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="panel panel-default" align="center">
                                <label>Time Received</label>
                                <div uib-timepicker ng-model="time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="panel panel-default" align="center">
                                <label>Date Received</label>
                                <p class="input-group">
                                    <input type="text" class="form-control" uib-datepicker-popup ng-model="dt" is-open="popup.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open()">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </button>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-12">
                    <div class="panel panel-default">
                            <!-- /.panel-heading -->
                        <div class="panel-body">
                           
                            <!-- /.table-responsive -->
                            <table width="100%" class="table table-striped table-hover" id="tranTable">
                                <thead>
                                     <tr>
                                         <div class="col-lg-1">
                                         </div>
                                         <div class="col-lg-3">
                                            <div class="panel panel-default" align="center">
                                                <label>Item Name</label>
                                            <input type="text" ng-change="clearFlieds()" name="itemNameTyhead" id="itemNameTyhead" class="form-control" ng-model="itemName" uib-typeahead="items as items.itemName for items in dataItems | filter:$viewValue" typeahead-on-select='onSelect($item, $model, $label)' typeahead-no-results="noResults" />
                                            <div ng-show="noResults">
                                                <i class="glyphicon glyphicon-remove"></i> No Item Found
                                            </div>
                                            </div>
                                        </div>

                                        <input type="hidden" ng-model='itemCode' />
                                        
                                        <div class="col-lg-3">
                                            <div class="panel panel-default" align="center">
                                                <label>Quantity</label>
                                            <input type="number" name="qty" class="form-control" ng-model="qty" min="1" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="panel panel-default" align="center">
                                            <label>Item Category</label>
                                            <input type="text" class="form-control" ng-model="category" disabled />
                                           </div>
                                        </div>
                                       <div class="col-lg-3">
                                         </div>     
                                       <div class="col-lg-3">
                                            <div class="panel panel-default" align="center">
                                            <label>Item Type</label>
                                            <input type="text" class="form-control" ng-model="proType" disabled />
                                           </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="panel panel-default" align="center">
                                            <label>Supplier</label>
                                            <input type="text" class="form-control" ng-model="supName" disabled />
                                           </div>
                                        </div>  

                                        <div class="buttona-add">
                                            <button ng-click='addItem(itemCode, itemName, qty, currentQty,category, proType,supName)' class="btn btn-default">Add</button>
                                        </div>



                                        <th>ITEM</th>
                                        <th>QUANTITY</th>
                                        <th>ITEM CATEGORY</th>
                                        <th>PRODUCT TYPE</th>
                                        <th>SUPPLIER</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>

                                <tbody> 
                                    <tr ng-repeat="i in items" >
                                        <th>{{i.name}}</th>
                                        <th>{{i.qty}}</th>
                                        <th>{{i.cat}}</th>
                                        <th>{{i.type}}</th>
                                        <th>{{i.sup}}</th>                                
                                        <th>



                                            <button type="button" value="Edit" ng-click="edit($index)" class="btn btn-default" >
                                                <i class="fa fa-pencil fa-fw">
                                                </i>
                                            </button>
                                            <button type="button" value="Remove" ng-click="remove($index)" class="btn btn-default">
                                                <i class="fa fa-trash-o fa-fw"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </tbody>                                      

                            </table><br> <br>
                            <input type="button" value="Save" ng-click="save()"  class="btn btn-default"/>
                            <input type="button" value="Clear" ng-click="clear()"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <?php } } endforeach; ?>

                            

                            </div>
                            <!-- /.table-responsive -->
                        </div>

                 <div class="row">
                    <h4 class = "po"><br><span>PURCHASE LIST</span></h4>
        
                    <div class="col-lg-12">
                        <table width="100%" class="table table-striped table-hover" id="suppliersTable">
                            <thead>
                                <tr>
                                    <th><center>Date Purchase</th>
                                    <th><center>Purchase ID </th> 
                                    <th><center>Supplier</th>
                                    <th><center>Status</th>
                                    <th><center>Action</th>
                                    
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($purchase == null){?>
                                    <tr>
                                        <td>NO DATA FOUND</td>
                                        <td></td>
                                    </tr>
                                    
                                <?php }  else { foreach ($purchase as $row): ?>
                                    <tr>
                                        <td><center><?php echo $row->PODateTime?></th>
                                        <td><?php echo "PO"; echo " "; echo ($row->POID);?></td> 
                                        <td><?php echo html_escape($row->supCompany); ?></td>
                                        <td><?php echo html_escape($row->pDStatus); ?></td>
                                        
                                    <td> 


                                            <button  type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Inventory/purchaseOrder/').$row->POID;?>'">
                                                   
                                                    <i class="fa fa-list-ol fa-lg"></i>
                                            </button> 
                                            <button type="button" value="Remove" ng-click="remove($index)" class="btn btn-default">
                                             <i class="fa fa-times"> </i>
                                            </button>
                                           
                                        </td>
                                      
                                    </tr>
                                <?php  endforeach; }  ?>                                      
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php } } endforeach; ?>

    
    <?php include('includes/footer-script.php'); ?>
    <?php include('includes/modals.php'); ?>

    <script src="<?php echo base_url();?>/js/deliveries.js"></script>
          <script>
        $(document).ready(function() {
            $('#suppliersTable').DataTable({
                responsive: true
            });
        });

    </script>
    
    
    <footer align="center">
        <p><?php echo date("M/d/Y"); ?></p>
        <p>Lighthouse Lamps <?php echo date('Y'); ?>. All Rights Reserved</p>
    </footer>
</body>

</html>
