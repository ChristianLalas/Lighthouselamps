<?php include('includes/meta.php'); ?>
<?php include('includes/header-script.php'); ?>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include('includes/main-nav.php'); ?>

        <!--Content-->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header wsub" class="alert-link" align="center">INVENTORY
                    <br><span>LOW STOCK</span></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
                <div class="col-lg-12">
                    <div class="panel panel-default">
                            <!-- /.panel-heading -->
                <?php foreach($accounts as $rows):
                    if($rows->accID == $accountUN){
                    if($rows->accType == "WAREHOUSE EMPLOYEE" || $rows->accType == "MANAGER" ){ ?>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
										<th><center>Product Name</th>
                                         <th><center>Product Type</th>
                                         <th><center>Product Quantity</th>
										<th><center>Reorder Level</th>
                                        <?php foreach($accounts as $rows):
                                            if($rows->accID == $accountUN){
                                            if($rows->accType == "MANAGER" ){ ?>
                                        <th><center>Action</th>
                                        <?php } } endforeach; ?>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                               <?php if($inventory == null){?>
                                    <tr>
                                        <td>No Item in Low Stock</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                <?php }  else { foreach ($inventory as $row): ?>
                                    <tr>
										<td><center><?php echo html_escape($row->itemName)?></th>
										<td><center><?php echo $row->itemTypeName?></th>
                                        <td><center><?php echo $row->itemQty?></th>
										<td><center><?php echo $row->itemRLvl?></th>
                                        <?php foreach($accounts as $rows):
                                            if($rows->accID == $accountUN){
                                            if($rows->accType == "MANAGER" ){ ?>
                                        <td><center><a style="color: blue" href="<?php echo site_url('Purchase');?>">PURCHASE</a></center></td>
                                        <?php } } endforeach; ?>
                                    </tr>
                                <?php endforeach; }?>	 
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <?php } } endforeach; ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include('includes/footer-script.php'); ?>

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
            <p>Lighthouse Lamps<?php echo date('Y'); ?>. All Rights Reserved</p>
        </footer>
</body>

</html>
