<?php include('includes/meta.php'); ?>
<?php include('includes/header-script.php'); ?>
<body ng-app = 'endingBalance' ng-controller= 'endingBalanceCtrl'>
     <div id="wrapper">
        <!-- Navigation -->
        <?php include('includes/main-nav.php');?>

    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" align="center">RECONCILIATION</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div align="center">

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                <?php foreach($accounts as $rows):
                    if($rows->accID == $accountUN){
                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>
                    <div class="panel-body">
                        <div class="col-lg-2">
                            Number of Items In The Table
                        </div>
                        <div class="col-lg-2">
                            <input type="number" class="form-control" id="arrayCount" value="<?php echo count($items)?>" disabled/>
                        </div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">        
                                <thead>
                                    <tr>
                                        <th><center>Item Name</th>
                                        <th><center>Item Type</th>
                                        <th><center>Physical Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($items == null){?>
                                        <tr>
                                            <td>NO DATA FOUND</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php } else if($items == "TRUE"){?>
                                        <tr>
                                            <td>Ending Balance Has Been Done For The Day</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php } else { 
                                        $i = 0; 
                                        foreach($items as $row):?>
                                        <tr>
                                            <td><?php echo html_escape($row->itemName); ?></td>
                                            <td><?php echo html_escape($row->itemTypeName); ?></td>
                                            <input type="hidden" id="logCnt<?php echo $i;?>" value="<?php echo $row->itemQty; ?>" />
                                            <input type="hidden" id="itemCode<?php echo $i;?>" value="<?php echo $row->itemCode; ?>"/>
                                            <input type="hidden" id="bCValue<?php echo $i;?>" value="<?php echo $row->bCValue; ?>"/>
                                            <td>
                                                <input type="number" onkeyup="calculate()" class="form-control" style="padding:0!important;width:80px;" id="physCntBaseQty<?php echo $i;?>" ng-change="checkInputs(<?php echo $i;?>)" ng-change="clearArray()" name ="physCnt<?php echo $i;?>" ng-model='physCntBaseQty<?php echo $i;?>'  min='0'/ >
                    
                                                <input type="hidden" class="form-control" style="padding:0!important;width:80px;" id="physCntCovQty<?php echo $i;?>" ng-change="checkInputs(<?php echo $i;?>)" ng-change="clearArray()" name ="physCntCovQty<?php echo $i;?>" ng-model='physCnt<?php echo $i;?>' value="0"  min='0'/>                         
                                            </td>
                                        </tr>
                                    <?php  $i++; endforeach;}?>
                                    <script>
                                        function calculate(){
                                            var i = 0;
                                            
                                            do{
                                                var num = document.getElementById("logCnt"+i).value - 
                                                document.getElementById("physCntBaseQty"+i).value;
                                                document.getElementById("desc"+i).value = num;
                                                i++;
                                                
                                            }while(i < 100);

                                        }

                                    </script>
                                </tbody>
                            </table>
                        <!-- /.panel-body -->
                        <input type="button" value="Save" ng-click="saveReq()"  class="btn btn-default"/>
                        <input type="button" value="Print" ng-click="print('endBalTable')"  class="btn btn-default"/>
                    </div>
                    <?php } } endforeach; ?>

                    <!-- /.panel -->
                <?php foreach($accounts as $rows):
                    if($rows->accID == $accountUN){
                    if($rows->accType == "MANAGER"){ ?>
                    <div class="panel-body">
                        <center><div class="col-lg-12">
                           <input type="button" value="START" ng-click="start()"  class="btn btn-default"/>
                            <button  type="button" class="btn btn-default">
                                <a href="<?php echo site_url('Ending_Request/cancel_reconciliation');?>" style = "color: #000000;"><?php echo "CANCEL";?></a>
                            </button>
                        </div></center>
                        <div class="col-lg-2">
                            Number of Items In The Table
                        </div>
                        <div class="col-lg-2">
                            <input type="number" class="form-control" id="arrayCount1" value="<?php echo count($items1)?>" disabled/>
                        </div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="endBalTable" border="1">        
                                <thead>
                                    <tr>
                                        <th><center>Item Name</th>
                                        <th><center>Logical Count</th>
                                        <th><center>Physical Count</th>
                                        <th><center>Difference</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($items1 == null){?>
                                        <tr>
                                            <td>NO DATA FOUND</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php } else if($items1 == "TRUE"){?>
                                        <tr>
                                            <td>Ending Balance Has Been Done For The Day</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php } else { 
                                        $i = 0; 
                                        foreach($items1 as $row):?>
                                        <tr>
                                            <td><?php echo html_escape($row->itemName); ?></td>
                                            <td><?php echo html_escape($row->itemQty); ?></td>
                                            <td><?php echo html_escape($row->eDPhysCnt); ?></td>
                                            
                                            <input type="hidden" id="logCnt<?php echo $i;?>" value="<?php echo $row->itemQty; ?>" />
                                            <input type="hidden" id="itemCode<?php echo $i;?>" value="<?php echo $row->itemCode; ?>"/>
                                            <input type="hidden" id="bCValue<?php echo $i;?>" value="<?php echo $row->bCValue; ?>"/>
                                            <input type="hidden" id="physCnt<?php echo $i;?>" value="<?php echo $row->eDPhysCnt;?>" />
                                            
                                            <td><input type="text" value="<?php echo html_escape($row->eDLogiCnt) - ($row->eDPhysCnt); ?>" disabled/>
                                            </td>
                                            
                                        </tr>
                                    <?php  $i++; endforeach;}?>
                                </tbody>
                            </table>
                        <!-- /.panel-body -->
                        <input type="button" value="Save" ng-click="save()"  class="btn btn-default"/>
                    </div>  
                <?php } } endforeach; ?>  
                </div>
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    </div>
    <?php include('includes/footer-script.php'); ?>
    <?php include('includes/modals.php'); ?>

    <script src="<?php echo base_url();?>/js/endingRequest.js"></script>

 <footer align="center">
            <p><?php echo date("M/d/Y"); ?></p>
            <p>Lighthouse Lamps <?php echo date('Y'); ?>. All Rights Reserved</p>
        </footer>
</body>

</html>
