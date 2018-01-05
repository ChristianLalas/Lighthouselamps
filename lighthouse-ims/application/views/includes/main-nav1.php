<body style="  background: white">
        <input type="hidden" id="route" value="<?php echo site_url();?>">
        <nav class="navbar-default navbar--top"  role="navigation" style="margin-bottom: 0; background: white ">
             <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background: #05202f">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo site_url('dashboard');?>">
                <img href="<?php echo site_url('dashboard');?>" src="<?php echo base_url('/images/lighthouse.png');?>" alt=" "class="img-rounded little-logo" height="100px" width="175px">
                </a>
			</div>

            
            <!-- /.navbar-header -->
			
            <ul align="center" class="nav navbar-top-links navbar-right">
               
                <li class="dropdown" >
            
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="" type="button" class="btn btn-danger"><span class="badge"></span><i class="fa fa-warning fa-fw"></i> LOW STOCKS</a>
                        </li> -->
                        <li><a href=""><i class="fa fa-warning fa-fw"></i> LOW STOCKS</a>
                        </li> 
                        <li class="divider"></li>
                        <!--<li><a href="" type="button" class="btn btn-danger"><span class="badge"></span><i class="fa fa-list fa-fw"></i> REQUESTS</a>
                        </li>--> 
                        <li><a href=""><i class="fa fa-list fa-fw"></i> REQUESTS</a>
                        </li> 
                        </ul>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                        <h3><?php foreach ($accounts as $rowss):
                            if($rowss->accID == $accountUN){
                            echo html_escape($rowss->accUN);
                            ?><input type="hidden" id='currentUser' value='<?php echo $rowss->accID;?>' />
                             <input type="hidden" id='currentUserType' value='<?php echo $rowss->accType;?>' />
                           <?php }
                            endforeach;?>
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
            

          
                <!-- /.navbar-static-side -->
        </nav>
		</body>