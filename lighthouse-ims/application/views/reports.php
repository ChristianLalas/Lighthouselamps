<?php include('includes/meta.php'); ?>
<?php include('includes/header-script.php'); ?>
<body ng-app = "view_po" ng-controller = "view_poCtrl">
     <div id="wrapper">
        <!-- Navigation -->
        <?php include('includes/main-nav.php');?>

	<div id="page-wrapper">
        <?php foreach($accounts as $rows):
                        if($rows->accID == $accountUN){
                        if($rows->accType == "MANAGER"){ ?>
             <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" align="center">REPORTS <br><span><?php echo $header;?></span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
             <div class="row" class="sub-nav"><center>
                    <input type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Reports');?>'" value="DELIVERY"/>

                    <input type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Reports/reportsIssuance');?>'" value="STOCK ISSUANCE"/>

                    <input type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Reports/reportsBOReturns');?>'" value="RETURN FROM BRANCH"/>

                    <input type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Reports/reportsRecReturns');?>'" value="RETURN TO SUPPLIER"/>

                    <input type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Reports/reportsStockAdj');?>'" value="    STOCK ADJUSTMENT"/>

                    <input type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Reports/reportsEndingBal');?>'" value="RECONCILIATION"/>

                    <input type="button" class="btn btn-default" onclick="location.href='<?php echo site_url('Reports/reportsPurchase');?>'" value="PURCHASE"/>

                    


                </div>
            <!-- /.row -->
            <?php if($header == "Deliveries") { ?>
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1"> 
                                <thead>
                                    <tr>
                                        <th><center>Receipt #</th>
                                        <th><center>Date Received</th>
                                         
                                    </tr>
                                </thead>
                                <tbody>
                                      <tr><?php if($deliveries == null){?>
                                            <td>No Data Found</td>
                                        <?php } else { 
                                            foreach($deliveries as $row):?> 
                                        <td><a href= '<?php echo site_url('Reports/delDelivery/').$row->delRecieptNo;?>' style = "color: #000000;"> <?php echo $row->delRecieptNo; ?></a></td>              
                                        <td><?php echo $row->delDateTime; ?></td>

                                    </tr><?php endforeach; } ?>
                                </tbody>

                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
    <!-- /#wrapper -->
    <?php } else if ($header == "delDelivery") { ?>
                        <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>receipt #</th>
                                        <th><center>Item Name</th>
                                        <th><center>Item Description</center></th>
                                        <th><center>Quantity</th>
                                        <th><center>Supplier</th>
                                        <th><center>Reciever</th>
                                        <th><center>Date Recieved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                      <tr><?php if($deliveries == null){?>
                                            <td>No Data Found</td>
                                        <?php } else { 
                                            foreach($deliveries as $row):?> 
                                        <td><?php echo $row->delRecieptNo; ?></a></td> 
                                        <td><?php echo html_escape($row->itemName); ?></td>
                                        <td><?php echo html_escape($row->description); ?></td>
                                        <td><?php echo $row->dDQty; echo " "; ?></td>
                                        <td><?php echo html_escape($row->supCompany); ?></td>
                                        <td><?php echo html_escape($row->accFN); echo " "; echo html_escape($row->accLN); ?></td>
                                        <td><?php echo $row->delDateTime; ?></td>

                                    </tr><?php endforeach; } ?>
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
<?php } else if ($header == "Return From Branch") { ?>
                        <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Record #</th>
                                        <th><center>Item Name</th>
                                        <th><center>Item Type</center></th>
                                        <th><center>Quantity</th>
                                        <th><center>Issuer</th>
                                        <th><center>Branch</th>
                                        <th><center>Date Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><?php if($badorder == null){?>
                                            <td>No Data Found</td>
                                        <?php } else { foreach($badorder as $row): ?>
                                        <td><?php echo "IS"; echo " "; echo sprintf('%09d',$row->BOID); ?></td>
                                       <td><?php echo html_escape($row->itemName); ?></td>
                                       <td><?php echo html_escape($row->description); ?></td>
                                       <td><?php echo $row->bDQty; echo " "; ?></td>
                                        <td><?php echo html_escape($row->accFN); echo " "; echo html_escape($row->accLN); ?></td><td><?php echo html_escape($row->BObranch); ?></td>
                                        <td><?php echo $row->BODateTime; ?></td>
                                    </tr><?php  endforeach; } ?>
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                <!-- /.col-lg-6 -->
<?php } else if ($header == "Issuance") { ?>
                        <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Record #</th>
                                        <th><center>Item Name</th>
                                        <th><center>Item Type</center></th>
                                        <th><center>Quantity</th>
                                        <th><center>Issuer</th>
                                        <th><center>Branch</th>
                                        <th><center>Supplier</th>
                                        <th><center>Date Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><?php if($issueds == null){?>
                                            <td>No Data Found</td>
                                        <?php } else { foreach($issueds as $row): ?>
                                        <td><?php echo "IS"; echo " "; echo sprintf('%09d',$row->isID); ?></td>
                                       <td><?php echo html_escape($row->itemName); ?></td>
                                       <td><?php echo html_escape($row->description); ?></td>
                                       <td><?php echo $row->isDQty; echo " "; ?></td>
                                        <td><?php echo html_escape($row->accFN); echo " "; echo html_escape($row->accLN); ?></td><td><?php echo html_escape($row->isDesc); ?></td>
                                        <td><?php echo html_escape ($row->supCompany)?></td>
                                        <td><?php echo $row->isDateTime; ?></td>
                                    </tr><?php  endforeach; } ?>
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                <!-- /.col-lg-6 -->
 <?php } else if ($header == "Return To Supplier") { ?>
          <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Record #</th>
                                        <th><center>Item Name</th>
                                        <th><center>Quantity</th>
                                        <th><center>Issuer</th>
                                        <th><center>Supplier</th>    
                                        <th><center>Date Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <tr><?php if($recret == null){?>
                                        <td>NO DATA FOUND</td>
                                <?php }  else {  foreach($recret as $row): ?>
                                        <td><?php echo "IR"; echo " "; echo sprintf('%09d',$row->rDID);?></td> 
                                        <td><?php echo html_escape($row->itemName);?></td> 
                                        <td><?php echo $row->rDQty; echo " "; ?></td>  
                                        <td><?php echo html_escape($row->accFN); echo " "; echo html_escape($row->accLN); ?></td> 
                                        <td><?php echo html_escape($row->supCompany); ?></td>
                                        <td><?php echo html_escape($row->RODateTime); ?></td>
                                    </tr><?php  endforeach; }?>
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                <!-- /.col-lg-6 -->

    <?php } else if ($header == "Bad Orders") { ?>
       <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Record #</th>
                                        <th><center>Item Name</th>
                                        <th><center>Quantity</th>
                                        <th><center>Receiver</th>
                                        <th><center>Branch</th>
                                        <th><center>Supplier</th>
                                        <th><center>Date Recieved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><?php if($boreturns == null){?>
                                        <td>NO DATA FOUND</td>                  
                                <?php }  else { foreach($boreturns as $row): ?>
                                        <td><?php echo "BO"; echo " "; echo sprintf('%09d',$row->BOID);?></td> 
                                        <td><?php echo html_escape($row->itemName);?></td> 
                                        <td><?php echo $row->bDQty; echo " ";?></td>  
                                        <td><?php echo html_escape($row->accFN); echo " "; echo html_escape($row->accLN); ?></td> 
                                        <td><?php echo html_escape($row->bDDesc); ?></td>
                                        <td><?php echo html_escape($row->supCompany); ?></td>
                                        <td><?php echo $row->BODateTime; ?></td>
                                   </tr> <?php endforeach; }?>  
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                <!-- /.col-lg-6 -->
    <?php } else if ($header == "Stock Adjustments") {?>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Item Name</th>
                                        <th><center>Quantity</th>
                                        <th><center>Sign</th>
                                        <th><center>Description</th>
                                        <th><center>Status</th>
                                        <th><center>Date Encoded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><?php if($stockadj == null){?>
                                            <td>No Data Found</td>
                                <?php } else { foreach($stockadj as $row): ?>
                                        <td><?php echo html_escape($row->itemName);?></td> 
                                        <td><?php echo $row->saQty; echo " "; ?></td>
                                        <td><?php echo $row->saSign; ?></td>
                                        <td><?php echo html_escape($row->saDesc);?></td>
                                        <td><?php echo $row->saStat; ?></td>
                                        <td><?php echo $row->saDateTime; ?></td>
                                    </tr><?php  endforeach; } ?>
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                <!-- /.col-lg-6 -->
    <?php } else if ($header == "Reconciliation"){ ?>
         <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Item Name</th>
                                        <th><center>Initial Count</th>
                                        <th><center>Final Count</th>
                                        
                                        <th><center>Date Encoded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr><?php if($endingbal == null){?>
                                            <td>No Data Found</td>
                                       <?php } else { foreach($endingbal as $row): ?>
                                   <td><?php echo html_escape($row->itemName); ?></td>
                                       <td><?php echo $row->eDLogiCnt; echo " "; ?></td>
                                        <td><?php echo $row->eDPhysCnt; echo " "; ?></td>
                                        
                                        <td><?php echo $row->eDDateTime;?></td><td class="hidden"></td>
                                     </tr><?php  endforeach; } ?>  
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
   
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>


        <?php } else if ($header == "Purchase") {?>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        
                                        <th><center>Purchase ID </th>
                                        <th><center>Date Purchase </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><?php if($purchase == null){?>
                                            <td>No Data Found</td>
                                <?php } else { foreach($purchase as $row): ?>
                                         
                                        <td><a href= '<?php echo site_url('Reports/reportsPurchaseDet/').$row->POID;?>' style = "color: #000000;"><?php echo $row->POID; echo " "; ?></a></td>
                                        <td><?php echo html_escape($row->PODateTime);?></td>
                                    </tr><?php  endforeach; } ?>
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>

        <?php } else if ($header == "delPurchase") {?>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Date Purchase </th>
                                        <th><center>Purchase ID </th>
                                        <th><center>Item Name </th>
                                        <th><center>Description</th>
                                        <th><center>Supplier </th>
                                        <th><center>Purchase Quantity </th>
                                        <th><center>Purchase Order Issuer </th>
                                            <th><center>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><?php if($purchase == null){?>
                                            <td>No Data Found</td>
                                <?php } else { foreach($purchase as $row): ?>
                                        <td><?php echo html_escape($row->PODateTime);?></td> 
                                        <td><?php echo $row->POID; echo " "; ?></td>
                                         <td><?php echo html_escape($row->itemName); ?></td>
                                        <td><?php echo html_escape($row->description);?></td>
                                        <td><?php echo $row->supCompany; ?></td>
                                        <td><?php echo $row->pDQty; ?></td>
                                         <td><?php echo html_escape($row->accFN); echo " "; echo html_escape($row->accLN); ?></td>
                                         <td><?php echo $row->pDStatus; echo " "; ?></td>
                                    </tr><?php  endforeach; } ?>
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
<?php } else if ($header == "Pending"){ ?>
         <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">
                                <thead>
                                    <tr>
                                        <th><center>Date Purchase</th>
                                        <th><center>Purchase ID</th>
                                        <th><center>Supplier</th>
                                        <th><center>Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr><?php if($pending == null){?>
                                            <td>No Data Found</td>
                                       <?php } else { foreach($pending as $row): ?>
                                       <td><?php echo html_escape($row->PODateTime);?></td> 
                                        <td><?php echo $row->POID; echo " "; ?></td>
                                         <td><?php echo html_escape($row->POSupID); ?></td>
                                         <td><?php echo $row->pDStatus; echo " "; ?></td>
                                         
                                   
                                     </tr><?php  endforeach; } ?>  
                                </tbody>
                            </table>
                            <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
   

     <?php  } ?>
     <?php } }  endforeach; ?>


        <!-- /#page-wrapper -->

    <!-- Custom Theme JavaScript -->
    <?php include('includes/footer-script.php'); ?>

    <script src="<?php echo base_url();?>/js/view_po.js"></script>
    <script>
        $(document).ready(function() {
        $('#dataTables-example').DataTable({
            "responsive": true,
            "order":[[2, "asc"]],
            "bFilter": false,
            "paging":   false,
            "info":     false
        });
    });
    </script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    
    </script>
    <footer align="center">
        <p><?php echo date("M/d/Y"); ?></p>
        <p>Lighthouse Lamps <?php echo date('Y'); ?>. All Rights Reserved</p>
    </footer>
</body>

</html>
