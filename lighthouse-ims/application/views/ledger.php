<?php include('includes/meta.php'); ?>
<?php include('includes/header-script.php'); ?>
<body ng-app = "ledger" ng-controller = "ledgerCtrl">
	<div id="wrapper">
		<?php include('includes/main-nav.php'); ?>

        <!--Content-->
        <?php foreach($accounts as $rows):
            if($rows->accID == $accountUN){
            if($rows->accType == "MANAGER"){ ?>
		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" align="center"><?php foreach($inventory as $row):
                    if($row->itemCode == $itemCode){?>
                        <?php echo $row->itemName;?>
                        
                    <br><span>DETAILED LEDGER</span></h1>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="text-align:center;float:none!important;margin:0 auto;">
                    <form method="post" action="<?php echo site_url('Inventory/getItemLedgerHistory');?>" name="form">
                        
                        <div class="col-lg-1" style="margin-top:19px;display:inline-block;float:none!important;">
                               
                        </div>
                    </form>
                    <?php } endforeach; ?>
                </div>
            </div>
                <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>STARTING QUANTITY</th>
                                        <th>
                                            <?php if($StartingBal == null){
                                                    echo 0;
                                                } else {
                                                        echo $StartingBal[0]->baseQty;
                                                } 
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>TRANSACTION ID</th>
                                        <th>DESCRIPTION</th>
                                        <th>DATE AND TIME</th>
                                        <th>ADD</th>
                                        <th>SUBTRACT</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo $footerLable?> QUANTITY</th>
                                    <th>
                                        <?php if($EndingBal == null){
                                                echo 0;
                                            } else {
                                                 echo $EndingBal[0]->baseQty;
                                            } 
                                                
                                        ?>
                                    </th>
                                </tfoot>
                                <tbody> 
                                    <?php 
                                    if($delData != null){
                                       foreach($delData as $rows):?>
                                            <tr>
                                                <td><?php echo $rows->delRecieptNo?></td>
                                                <td>Deliveries</td>
                                                <td><?php echo $rows->delDateTime?></td>
                                                <td><?php echo $rows->dDQty?></td>
                                                <td></td>
                                                
                                            </tr>
                                    <?php endforeach;}?> 

                                    <?php if($IssueData != null){ 
										foreach ($IssueData as $rows): ?>
                                        <tr>
                                            <td>IS<?php echo $rows->isID?></td>
                                            <td><?php echo "Issued"; echo" to  "; echo $rows->isDesc;?></td>
                                            <td><?php echo $rows->isDateTime?></td>
                                            <td></td>
                                            <td><?php echo $rows->isDQty?></td>

                                            
                                        </tr>
                                    <?php endforeach;}?>

                                    <?php if($BOData != null){
                                        foreach ($BOData as $rows): ?> 
										<tr>
                                            <td>BO<?php echo $rows->BOID;?></td>
                                            <td><?php echo "Return"; echo" From  "; echo $rows->BObranch;?></td>
                                            <td><?php echo $rows->BODateTime; ?></td>
                                            <td><?php echo $rows->bDQty?></td>
                                            <td></td>
                                            
                                            
                                        </tr>
                                    <?php endforeach;}?>

                                    <?php if($ROData != null){
                                        foreach ($ROData as $rows): ?> 
                                        <tr>
                                            <td>RO<?php echo $rows->ROID;?></td>
                                            <td><?php echo "Return"; echo" to  "; echo $rows->supCompany;?></td>
                                            <td><?php echo $rows->RODateTime; ?></td>
                                            <td></td>
                                            <td><?php echo $rows->rDQty?></td>
                                            
                                            
                                            
                                        </tr>
                                    <?php endforeach;}?>
                                    
                                    <?php if($corrData != null){ 
                                        foreach ($corrData as $rows): ?>
                                        <tr>
                                            <td></td>
                                            <td>Stock Adjustments</td>
                                            <td><?php echo $rows->saDateTime;?></td> 
                                            <?php if (strcmp('DEDUCT', $rows->saSign) == -1  ){?>
                                                <td></td>
                                                <td><?php echo $rows->saQty?></td>
                                            <?php } else if (strcmp('ADD', $rows->saSign) == 0 ){?>
                                                <td><?php echo $rows->saQty?></td>
                                                <td></td>
                                            <?php }?>
                                        </tr>
                                    <?php endforeach;}?>

                           

                                
                                </tbody>                                      

                            </table>
                           <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><h3>Price History</h3></th>                                       
                                    </tr>
                                    <tr>
                                        <th>Date/Time</th>
                                        <th>Price</th>
                                        <?php if($price != null){ 
                                        foreach ($price as $rows): ?>
                                        <tr>
                                            <td><?php echo $rows->dt?></td>
                                           
                                                <td><?php echo $rows->price?></td>
                                            <?php ?>
                                        </tr>
                                    </tr>
                                    <?php endforeach;}?>
                            </table>          
                        </div>
                    </div>
                </div>
                <?php } }  endforeach; ?>
            </div>
       </div>
    

    <?php include('includes/footer-script.php'); ?>
    <?php include('includes/modals.php'); ?>

    <script src="<?php echo base_url();?>/js/ledger.js"></script>
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
 <footer align="center">
            <p><?php echo date("M/d/Y"); ?></p>
            <p>Lighthouse <?php echo date('Y'); ?>. All Rights Reserved</p>
        </footer>

   </div>     
</body>

</html>
