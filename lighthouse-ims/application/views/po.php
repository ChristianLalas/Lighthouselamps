<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Purchase Order <small>List</small>
                </h2>
            </div>
            <div class="body">
	        	    <div class='row' style="text-align: center;margin-bottom: 30px;">
                    <a href='<?php echo base_url(); ?>create_po' class='btn btn-success waves-effect'>Create Purchase Order</a>
                </div>
                <div class="input-group" style="margin-top: 10px;">
                  <span class="input-group-addon" id="basic-addon1"><i class="material-icons">search</i></span>
                  <input type="text" id='table_search' class="form-control" placeholder="Search..." aria-describedby="basic-addon1">
                </div>
                <div class='row'>
                  <div class="col-md-12">
                    <table id='table' class="table table-hover table-bordered table-condensed">
                        <thead>
                          <th>PO ID</th>
                          <th>Date Created</th>
                          <th>Supplier</th>
                          <th>Status</th>
                          <th>Action</th>
                        </thead>
                    </table>
                  </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>

<div id="delivery-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delivery</h4>
      </div>
      <form action='<?php echo base_url(); ?>confirm_delivery' method='post'>
        <div class="modal-body">
          <table>
            <tr>
              <td><p><b>PO ID: </b> <span id='po-id'></span></p></td>
            </tr>
            <tr>
              <td><p><b>SUPPLIER: </b> <span id='supplier'></span></p></td>
            </tr>
            <tr>
              <td><p><b>DATE CREATED: </b> <span id='date-created'></span></p></td>
            </tr>
            <tr>
              <td><p><b>DATE TODAY: </b> <span id='date-today'></span></p></td>
            </tr>
          </table>

          <h3>PRODUCTS</h3>
          <p style='float: right; color: red;'>Enter delivery quantity from supplier</p>
          <table id='prod-table' class='table table-bordered table-hover table-condensed bordered'>
            <thead>
              <th>Product Name</th>
              <th width='200px'>QTY</th>
              <th width='250px'>Remarks</th>
            </thead>
            <tbody>
              
            </tbody>
          </table>
          <input type="hidden" name="po_id">
          <input type="hidden" name="po_history_id">
          <input type='hidden' name='suppID'>
          <button type='submit' class='btn btn-primary btn-block'>OK</button>
        </div>
      </form>
      
    </div>

  </div>
</div>