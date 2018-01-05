<?php include('includes/meta.php'); ?>
<?php include('includes/header-script.php'); ?>
<body ng-app = "notifications"  ng-controller = "notificationsCtrl">
    <input type="hidden" id="route" value="<?php echo site_url();?>">
	<div id="wrapper">
		<?php include('includes/main-nav.php'); ?>

        <!--Content-->
        <div id="page-wrapper">

            <div class="row">
            	<div class="col-lg-12">
                    <h1 class="page-header wsub" align="center">REQUESTS
                    <br><span>STOCK ADJUSTMENT REQUEST</span></h1>
                </div>
            </div>
            <br />
            <div class="row">
            <?php foreach($accounts as $rows):
                    if($rows->accID == $accountUN){
                    if($rows->accType == "MANAGER" ){ ?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><center>Issuer</th>
                                        <th><center>Item Name</th>
                                        <th><center>Sign</th>
                                        <th><center>Quantity</th>
                                        <th><center>Description</th>
                                        <th><center>Date and Time</th>
                                        <th><center>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($request == null){?>
                                        <td>No New Requests</td>
                                    <?php } else {
                                     foreach($accounts as $row):
                                              if($row->accID == $accountUN){
                                              if($row->accType == "MANAGER"){ 
                                                foreach($request as $object):?>
                                        <tr>
                                            <td><center><?php echo html_escape($object->accLN .", ". $object->accFN) ;?></td>
                                            <td><center><?php echo html_escape($object->itemName);?></td>
                                            <td><center><?php echo $object->saSign;?></td>
                                            <td><center><?php echo $object->saQty;?></td>
                                            <td><center><?php echo html_escape($object->saDesc);?></td>
                                            <td><center><?php echo $object->saDateTime;?></td>
                                            <td><center>
                                                <input type="button" value ="APPROVE" ng-click='accept(<?php echo  $object->saID; ?>)' class="btn btn-default">
                                                <input type="button" value ="DECLINE" ng-click='decline(<?php echo  $object->saID; ?>)' class="btn btn-default">
                                            </td>
                                        </tr>
                                    <?php endforeach; } else {
                                        foreach($requestChc as $objects):?>
                                    <tr> 
                                        <td><center><?php echo html_escape($objects->accLN .", ". $objects->accFN) ;?></td>
                                            <td><center><?php echo html_escape($objects->itemName);?></td>
                                            <td><center><?php echo $objects->saSign;?></td>
                                            <td><center><?php echo $objects->saQty;?></td>
                                            <td><center><?php echo html_escape($objects->saDesc);?></td>
                                            <td><center><?php echo $objects->saDateTime;?></td>
                                            <td><center><?php echo $objects->saStat;?></td>
                                        </tr>
                                    <?php endforeach; } } endforeach;} ?>
                                </tbody>                                      
                            </table>
                        </div>
                    </div>
                 </div>
                 <?php } } endforeach; ?>
             </div>
        </div>
	    
    <?php include('includes/footer-script.php'); ?>
    <?php include('includes/modals.php'); ?>
    
    <script type="text/ng-template" id="confirmation.html">
        <div class="modal-header">
            <h3>Are You Sure You Want To {{status}} Request?</h3>
        </div>  
        <div class="modal-footer">
            <input type="button" value="Yes" ng-click="yes()"  class="btn btn-default"/>
            <input type="button" value = "Cancel" ng-click="cancel()" class="btn btn-default"/>
        </div>
    </script>  
    
    <script src="<?php echo base_url();?>/js/requests.js"></script>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
 <footer align="center">
            <p><?php echo date("M/d/Y"); ?></p>
            <p>Lighthouse Lamps<?php echo date('Y'); ?>. All Rights Reserved</p>
        </footer>
</body>

</html>
