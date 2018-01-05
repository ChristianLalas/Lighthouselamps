<?php include('includes/meta.php'); ?>
<?php include('includes/header-script.php'); ?>

<body ng-app="badOrder" ng-controller="badOrderCtrl">
    <input type="hidden" id="route" value="<?php echo site_url();?>">
    <div id="wrapper"> 
        <?php include('includes/main-nav.php'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" align="center">RETURN FROM BRANCH
                    <br><span>All Broken Items Coming From Branch</span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

             <div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-2">
                            <div class="panel panel-default" align="center">
                                <label> Bad Order ID </label> 
                                    <div>
                                        <h4>BO <input type="hidden"  id = "trackID" value = "<?php echo $GRtrackID?>"/><?php echo $GRtrackID?></h4>
                                    </div> 
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="panel panel-default" align="center">
                                <label>Select branch</label>
                                    <select ng-model="selectedBranch" class="form-control">
                                    <option value = 'null'>-Select Branch-</option>
                                    <option value = 'Session'>Session</option>
                                    <option value = 'Marcos'>Marcos</option>
                                    </select>
                            </div>
                        </div>  

                     
                    
                        <div class="col-sm-3">
                            <div class="panel panel-default" align="center">
                                <label>Time Issued</label>
                                <div uib-timepicker ng-model="time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>
                            </div>
                        </div>

                        <div class="col-sm-3 ">
                            <div class="panel panel-default" align="center">
                                <label>Date Issued</label>
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
            <div class="row">
                    <div class="col-lg-12">
                    <div class="panel panel-default">
                            <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <div class="col-lg-3">
                                            <div class="panel panel-default" align="center">
                                            <label>Item Name</label>
                                            <input type="text" ng-change="clearFlieds()" name="itemNameTyhead" id="itemNameTyhead" class="form-control" ng-model="itemName" uib-typeahead="items as items.itemName for items in dataItems | filter:$viewValue" typeahead-on-select='onSelect($item, $model, $label)' typeahead-no-results="noResults" />
                                            <div ng-show="noResults">
                                                <i class="glyphicon glyphicon-remove"></i> No Item Found
                                            </div>
                                            </div>
                                        </div>

                                        <input type="hidden"  ng-model="itemCode" />

                                        <div class="col-lg-2">
                                            <div class="panel panel-default" align="center">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" ng-model="qty" min="1" >
                                            </div>
                                        </div>
                                            
                                        
                                         <div class="col-lg-4">
                                            <div class="panel panel-default" align="center">
                                            <label>Item Category</label>
                                            <input type="text" class="form-control" ng-model="category" disabled />
                                           </div>
                                        </div>

                                       <div class="col-lg-4">
                                            <div class="panel panel-default" align="center">
                                            <label>Item Type</label>
                                            <input type="text" class="form-control" ng-model="proType" disabled />
                                           </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel panel-default" align="center">
                                            <label>Reason</label>
                                            <input type="text" class="form-control" ng-model="reason"  />
                                           </div>
                                        </div>
                                           

                                        
                                         <div class="buttona-add">
                                             <button ng-click='addItem(itemCode, itemName, qty, unit, proType, category, itemQty, reason)' class="btn btn-default">Add</button>
                                        </div>

                                        <th>ITEM</th>
                                        <th>QUANTITY</th>
                                        <th>ITEM CATEGORY</th>
                                        <th>ITEM TYPE</th>
                                        <th>DESCRIPTION</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <tr ng-repeat="i in items">
                                        <th>{{i.name}}</th>
                                        <th>{{i.qty}}</th>
                                        <th>{{i.cat}}</th>
                                        <th>{{i.type}}</th>
                                        <th>{{i.res}}</th>
                                        
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

                            </table>
                            <!-- /.table-responsive -->

                            <input type="button" value="Save" ng-click="save()"  class="btn btn-default"/>
                            <input type="button" value="Clear" ng-click="clear()"  class="btn btn-default"/>
                    </div>
                        <!-- /.panel-body -->
                    </div>

            </div>
            
        </div>
     </div>

    <?php include('includes/footer-script.php'); ?>
    <?php include('includes/modals.php'); ?>
    <script src="<?php echo base_url();?>/js/bad_order.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
                saveState:true

            });
        });


$('#dataTables-example').dataTable( {
  stateSave: true,
  stateSaveCallback: function(settings,data) {
      localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
    },
  stateLoadCallback: function(settings) {
    return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
    }
} );
</script>

    <footer align="center">
        <p><?php echo date("M/d/Y"); ?></p>
        <p>Lighthouse Lamps <?php echo date('Y'); ?>. All Rights Reserved</p>
    </footer>
</body>

</html>
