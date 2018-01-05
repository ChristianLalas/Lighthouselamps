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
                    <h1 class="page-header wsub" align="center"><?php foreach($inventory as $row):
                    if($row->itemCode == $itemCode){?>
                        <?php echo $row->itemName;?>
                        <br> <span> Add Image </span>
                          <?php } endforeach; ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
                 
                
                     <center>
   

  <div class="form-group">
 <?php foreach($inventory as $row):
 if($row->itemCode == $itemCode){?>
 <?php echo form_open_multipart('Inventory/save/'.$row->itemCode);?>

 <?php } endforeach; ?>
  <center>
            <label for="exampleInputPassword1">Photo</label>            
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>

            <div class="kv-avatar center-block" style="width:200px">
                <input id="avatar-2" name="userImage" type="file" class="file-loading">
            </div>
          </div>
        <center>
         <?php echo form_submit('submit', 'Save', 'class="btn btn-primary"'); ?></td>
            </center>
</form>


 <script type="text/javascript" src="<?php echo base_url();?>/vendor/jquery/jquery.min.js"></script>
    <!-- bootsrap js -->
    <script type="text/javascript" src="<?php echo base_url();?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- file input -->

     <script src="<?php echo base_url();?>/vendor/fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"> </script>

 <script src="<?php echo base_url();?>/vendor/fileinput/js/plugins/sortable.min.js" type="text/javascript"> </script>

  <script src="<?php echo base_url();?>/vendor/fileinput/js/plugins/purify.min.js" type="text/javascript"> </script>

   <script src="<?php echo base_url();?>/vendor/fileinput/js/fileinput.min.js"></script> 


    <script type="text/javascript">
            var btnCust = '<button type="button" class="btn btn-default" title="Add picture tags" ' + 
            'onclick="alert(\'Call your custom code here.\')">' +
            '<i class="glyphicon glyphicon-tag"></i>' +
            '</button>'; 
        $("#avatar-2").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img href="<?php echo site_url('dashboard');?>" src="<?php echo base_url('/images/default.jpg');?>"  height="100px" width="155px">',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
        });

        $(document).ready(function() {
            $("#uploadImageForm").unbind('submit').bind('submit', function() {

                var form = $(this);
                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: false,
                    success:function(response) {
                        if(response.success == true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');

                            $('input[type="text"]').val('');
                            $(".fileinput-remove-button").click();
                        }
                        else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');
                        }
                    }
                });

                return false;
            });
        });
    </script>
                    </div>
           
 
    <!-- Custom Theme JavaScript -->
    
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
