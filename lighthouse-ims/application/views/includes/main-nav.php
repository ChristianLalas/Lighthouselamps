<body style="  background: white">
    <input type="hidden" id="route" value="<?php echo site_url();?>"/>
        
             <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; position: fixed; width: 100%">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo site_url('inventory');?>">
                <img href="<?php echo site_url('inventory');?>" src="<?php echo base_url('/images/a.png');?>" alt=" "class="img-rounded little-logo" height="100px" width="175px">
                </a>
            </div>

            
            <!-- /.navbar-header -->
            <div class ="personal-nav">
            <ul align="center" class="nav navbar-top-links navbar-right"> 
            <?php foreach($accounts as $rows):
                        if($rows->accID == $accountUN){
                        if($rows->accType == "MANAGER" || $rows->accType == "WAREHOUSE EMPLOYEE" ){ ?>              
                <li class="dropdown">
                    <a class="dropdown-toggle edit " data-toggle="dropdown" href="#" aria-expanded="true">

                      <span class="badge" style="background-color:#f2d647;">
                  <?php foreach($accounts as $rows):
                        if($rows->accID == $accountUN){
                        if($rows->accType == "MANAGER"){ ?>
                      <?php $totalNotif = $counts + $countsReq+ $countsRecon; if($totalNotif > 0) { ?> <h4><?php echo $totalNotif;} ?></h4>
                  <?php } }  endforeach; ?>

                  <?php foreach($accounts as $rows):
                        if($rows->accID == $accountUN){
                        if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>
                      <?php $totalNotif = $counts ; if($totalNotif > 0) { ?> <h4><?php echo $totalNotif;} ?></h4>
                  <?php } }  endforeach; ?>
                    </span>
                        <h3><i class="fa fa-bell-o fa-fw"></i><i class="fa fa-caret-down"></i> </h3>
                    </a>
                
                    <ul class="dropdown-menu dropdown-user">
                    <?php if($counts > 0) { ?>
                        <li><a href="<?php echo site_url('Inventory/inventoryLowS');?>" type="button" class="btn btn-danger"><span class="badge"><?php echo $counts; ?></span><i class="fa fa-warning fa-fw"></i> LOW STOCKS</a>
                        </li> 
                    <?php } else { ?>   
                        <li><a href="<?php echo site_url('Inventory/inventoryLowS');?>"><i class="fa fa-warning fa-fw"></i> LOW STOCKS</a>
                        </li> <?php } ?>
                    <?php foreach($accounts as $rows):
                      if($rows->accID == $accountUN){
                      if($rows->accType == "MANAGER"){ ?>
                    <?php if($countsReq > 0) { ?>
                        <li><a href="<?php echo site_url('Requests');?>" type="button" class="btn btn-danger"><span class="badge"><?php echo $countsReq; ?></span><i class="fa fa-list fa-fw"></i> REQUESTS</a>
                        </li> 
                    <?php } else { ?> 
                        <li><a href="<?php echo site_url('Requests');?>"><i class="fa fa-list fa-fw"></i> REQUESTS</a>
                        </li> <?php } ?>
                  
                    <?php if($countsRecon > 0) { ?>
                        <li><a href="<?php echo site_url('Ending_Request');?>" type="button" class="btn btn-danger"><span class="badge"><?php echo $countsRecon; ?></span><i class="fa fa-list fa-fw"></i> RECONCILIATION REQUEST</a>
                        </li> 
                    <?php } else { ?> 
                        <li><a href="<?php echo site_url('Ending_Request');?>"><i class="fa fa-list fa-fw"></i>RECONCILIATION REQUESTS</a>
                        </li> <?php } ?>
                  <?php } } endforeach; ?>
                        </ul>

                         <?php } }  endforeach; ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                        <h3><?php foreach ($accounts as $rowss):
                            if($rowss->accID == $accountUN){
                            echo html_escape($rowss->accUN);
                            ?><input type="hidden" id='currentUser' value='<?php echo $rowss->accID;?>' />
                             <input type="hidden" id='currentUserType' value='<?php echo $rowss->accType;?>' />
                           <?php } endforeach;?>
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i></h3>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                       <li><a href="<?php echo site_url('User_Profile');?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url('Verifylogin/logOut/').$accountUN;?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
               
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            </div>
                
                 <div class="navbar-default side-nav sidebar" role="navigation" >
                   <div class="sidebar-nav navbar-collapse">
                     <hr class = "top">
                         <ul class="nav" id="side-menu">
                            <li>
                                <a href="<?php echo site_url('Inventory');?>" ><i class="fa fa-folder fa-fw" ></i>MASTER LIST</a>
                            </li>
                            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                            <li>
                                    <a href="<?php echo site_url('Categorylist');?>"><i class="fa fa-folder fa-fw"></i>CATEGORY LIST</a>
                            </li>
                            <li>
                                    <a href="<?php echo site_url('Itemtype');?>"><i class="fa fa-folder fa-fw"></i>ITEM TYPE</a>
                            </li>
                              <?php } } endforeach; ?>
                             
                          

                             <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                              <li>

                            <li>
                                <a href="<?php echo site_url('Purchase');?>"><i class="fa fa-list fa-fw"></i> PURCHASE ORDER</a>
                            </li>
                              <li>
                            <li>
                                <a href="<?php echo site_url('Suppliers');?>"><i class="fa fa-user fa-fw"></i> SUPPLIERS</a>
                            </li>
                               <?php } } endforeach; ?>
                               <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER") { ?>
                                    

                             <li>
                                <a href="<?php echo site_url('Deliveries');?>"><i class="fa fa-truck fa-fw"></i> DELIVERY</a>
                             </li>
                            <?php } }  endforeach; ?>


                            </li>
                             
                               <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE") { ?>
                                    
                                    
                             <li>
                                <a href="<?php echo site_url('Deliveries');?>"><i class="fa fa-truck fa-fw"></i> DELIVERY</a>
                             </li>
                            <?php } }  endforeach; ?>

                              <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>
                             <li>
                                <a href="<?php echo site_url('Stock_Issuance');?>"><i class="fa fa-minus fa-fw"></i> STOCK ISSUANCE</a>
                            </li>
                             <?php } } endforeach; ?>
                            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE" ){ ?>
                            <li>
                             <a href=""><i class="fa fa-trash fa-fw"></i> RETURNS<span class="fa fa-arrow-circle-down"></span></a>
                                <ul class="nav nav-second-level">
                                     <li>
                                     
                                <a href="<?php echo site_url('Bad_Order');?>"> RETURN FROM BRANCH</a>
                             </li>
                             <li>
                                <a href="<?php echo site_url('Returns');?>"> RETURN TO SUPPLIER</a>
                             </li>
                                </ul> 
                            </li>
                            <?php } } endforeach; ?>

                            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>


                             <li>
                                <a href="<?php echo site_url('Ending_Request');?>"><i class="fa fa-plus fa-fw"></i> RECONCILIATION</a>
                              </li>
                                <?php } } endforeach; ?>


                             </li>
                             <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>
                             <li>
                                <a href="<?php echo site_url('Stock_Adjustments');?>"><i class="fa fa-plus fa-fw"></i> STOCK ADJUSTMENT</a>
                             </li>
                             <?php } } endforeach; ?>
                             
                             <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                            <li>
                                <a href="<?php echo site_url('Reports');?>"><i class="fa fa-book fa-fw"></i> REPORTS</a>
                            </li>
                            <?php } } endforeach; ?>
                            <li>
                                <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>

                                <a href=""><i class="fa fa-user fa-fw"></i> ACCOUNTS<span class="fa fa-arrow-circle-down"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo site_url('Accounts');?>">PROFILE</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('ActivityLogs');?>">ACTIVITY LOGS</a>
                                    </li> 
                                </ul>
                            </li>
              
                                <?php } } endforeach; ?>
                        </ul>
                        <hr class = "bottom">
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->


                <?php foreach((array)$recon as $row): 
                    if($row->recon == '1'){ ?>
                <div class="navbar-default side-nav sidebar" role="navigation" >
                   <div class="sidebar-nav navbar-collapse" >
                     <hr class = "top">
                         <ul class="nav" id="side-menu" style="background-color: #f18973">
                            <li>
                                <a href="<?php echo site_url('Inventory');?>" onclick="return false;" ><i class="fa fa-folder fa-fw" ></i>MASTER LIST</a>
                            </li>
                            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                            <li>
                                    <a href="<?php echo site_url('Categorylist');?>"  onclick="return false;"><i class="fa fa-folder fa-fw"></i>CATEGORY LIST</a>
                            </li>
                            <li>
                                    <a href="<?php echo site_url('Itemtype');?>"  onclick="return false;"><i class="fa fa-folder fa-fw"></i>ITEM TYPE</a>
                            </li>
                              <?php } } endforeach; ?>
                             <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>
                             <li>
                                    <a href="<?php echo site_url('Categorylist');?>"  onclick="return false;"><i class="fa fa-folder fa-fw"></i>CATEGORY LIST</a>
                            </li>

                            <li>
                                    <a href="<?php echo site_url('Itemtype');?>"  onclick="return false;"><i class="fa fa-folder fa-fw"></i>ITEM TYPE</a>
                            </li>
                           <?php } } endforeach; ?>
                          

                             <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                              <li>

                            <li>
                                <a href="<?php echo site_url('Purchase');?>"  onclick="return false;"><i class="fa fa-list fa-fw"></i> PURCHASE ORDER</a>
                            </li>
                              <li>
                            <li>
                                <a href="<?php echo site_url('Suppliers');?>"  onclick="return false;"><i class="fa fa-user fa-fw"></i> SUPPLIERS</a>
                            </li>
                               <?php } } endforeach; ?>
                               <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER") { ?>
                                    

                             <li>
                                <a href="<?php echo site_url('Deliveries');?>"  onclick="return false;"><i class="fa fa-truck fa-fw"></i> DELIVERY</a>
                             </li>
                            <?php } }  endforeach; ?>


                            </li>
                             
                               <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE") { ?>
                                    
                                    
                             <li>
                                <a href="<?php echo site_url('Deliveries');?>"  onclick="return false;"><i class="fa fa-truck fa-fw"></i> DELIVERY</a>
                             </li>
                            <?php } }  endforeach; ?>

                              <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>
                             <li>
                                <a href="<?php echo site_url('Stock_Issuance');?>"  onclick="return false;"><i class="fa fa-minus fa-fw"></i> STOCK ISSUANCE</a>
                            </li>
                             <?php } } endforeach; ?>
                            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE" ){ ?>
                            <li>
                             <a href=""><i class="fa fa-trash fa-fw"  onclick="return false;"></i> RETURNS<span class="fa fa-arrow-circle-down"></span></a>
                                <ul class="nav nav-second-level">
                                     <li>
                                     
                                <a href="<?php echo site_url('Bad_Order');?>"> RETURN FROM BRANCH</a>
                             </li>
                             <li>
                                <a href="<?php echo site_url('Returns');?>"> RETURN TO SUPPLIER</a>
                             </li>
                                </ul> 
                            </li>
                            <?php } } endforeach; ?>

                            <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>


                             <li>
                                <a href="<?php echo site_url('Ending_Request');?>" ><i class="fa fa-plus fa-fw"></i> RECONCILIATION</a>
                              </li>
                                <?php } } endforeach; ?>


                             </li>
                             <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "WAREHOUSE EMPLOYEE"){ ?>
                             <li>
                                <a href="<?php echo site_url('Stock_Adjustments');?>"  onclick="return false;"><i class="fa fa-plus fa-fw"></i> STOCK ADJUSTMENT</a>
                             </li>
                             <?php } } endforeach; ?>
                             
                             <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>
                            <li>
                                <a href="<?php echo site_url('Reports');?>" onclick="return false;"><i class="fa fa-book fa-fw"></i> REPORTS</a>
                            </li>
                            <?php } } endforeach; ?>
                            <li>
                                <?php foreach($accounts as $rows):
                                    if($rows->accID == $accountUN){
                                    if($rows->accType == "MANAGER"){ ?>

                                <a href=""><i class="fa fa-user fa-fw"  onclick="return false;"></i> ACCOUNTS<span class="fa fa-arrow-circle-down"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo site_url('Accounts');?>">PROFILE</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('ActivityLogs');?>">ACTIVITY LOGS</a>
                                    </li> 
                                </ul>
                            </li>
              
                                <?php } } endforeach; ?>
                        </ul>
                        <hr class = "bottom">
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
                <?php } endforeach; ?>
        </nav>
        </body>