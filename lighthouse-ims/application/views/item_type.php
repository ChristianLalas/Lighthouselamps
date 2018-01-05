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
                    <h1 class="page-header wsub" align="center">INVENTORY
                    <br><span>ITEM TYPE <?php echo $header;?></span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <input type= "hidden" id="itemCodeID" value="<?php echo $ItemCodeTrack?>">
            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
             <div class="col-lg-12">
                    <div class="add-new-item" align="center">
                            <button type="button" class="btn btn-default" data-toggle="modal" ng-click='additemtype()'>
                                <i class="fa fa-plus"></i> Add Item Type
                            </button>
                           
                            <?php } } endforeach; ?>

               			</div>
            <div class="row">
                <div align="center">
                </div>
            </div>

<table width="100%" class="table table-striped table-hover" id="dataTables-example">

  <thead>
                                <tr>
                                    <th><center>Item Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($itemtype == null){?>
                                    <tr>
                                        <td>NO DATA FOUND</td>
                                        <td></td>
                                    </tr>
                                    
                                <?php }  else { foreach ($itemtype as $row): ?>
                                    <tr>
                                        <td><center><?php echo html_escape($row->itemTypeName)?></th>
                                    </tr>
                                <?php  endforeach; }  ?>                                      
                            </tbody>
                        </table>

  </div>
</div>
            
                <!-- /.col-lg-6
            </div>
            <!-- /.row 

            <div class="col-lg-13">
                <div class="panel panel-default">
                       /.panel-heading 
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th><center>Item Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($inventory == null){?>
                                    <tr>
                                        <td>NO DATA FOUND</td>
                                        <td></td>
                                    </tr>
                                    
                                <?php }  else { foreach ($itemtype as $row): ?>
                                    <tr>
                                        <td><center><?php echo html_escape($row->itemTypeName)?></th>
                                    </tr>
                                <?php  endforeach; }  ?>                                      
                            </tbody>
                        </table>
                    </div>
                    < /.panel-body ->
                    - /.panel 
                </div>
                <!-- /.col-lg-6 -->
            </div>
        </div>
        <!-- /#page-wrapper -->


    </div>
    <!-- /#wrapper -->
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <!-- Custom Theme JavaScript -->
    

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
                        <p class="text-danger" ng-show="unitWarning">*Item Type Is Already Is Listed*</p>
                    </div>
                        <button type="submit" class="btn btn-primary">Save</button>  
                        <input type="button" value = "Cancel" ng-click="cancel()" class="btn btn-default"/>
                </form>
            </div>
        </div>
    </script>
    
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