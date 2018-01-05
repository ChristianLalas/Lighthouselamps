<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/submit.js'></script>
<script type="text/javascript">
	$(document).ready(function(){
		var user_type = $('#sess_user_type').val();
		var table = $('#table').DataTable({
			ajax: window_location+'/htdocs/read_products',
			columns: [
		                {
		                  mRender: function(row, setting, full){
		                  	if(user_type === 'owner'){
			                  	if(full.prodQty == '0')
			                  	{
			                  		return "<button type='button' class='btn btn-warning btn-xs update' title='Update'>Update</button>"+
			                          "<button type='button' class='btn btn-danger btn-xs delete' title='Delete'>Disable</button>";
			                  	}
			                    return "<button type='button' class='btn btn-warning btn-xs update' title='Update'>Update</button>"+
			                          "<button type='button' class='btn btn-danger btn-xs' title='Delete' disabled>Disable</button>";
			                }
			                return "<button type='button' class='btn btn-warning btn-xs update' title='Update' disabled>Update</button>"+
			                          "<button type='button' class='btn btn-danger btn-xs' title='Delete' disabled>Disable</button>";
			               }
		                },
		                {
		                  mRender: function(row, setting, full){
		                    if(full.image){
		                      return "<img src='"+window.location.origin+'/htdocs/uploads/'+full.image+"' width='100px'>";
		                    }else{
		                      return "<img src='"+window.location.origin+'/htdocs/uploads/default.jpg'+"' width='100px'>";
		                    }
		                  }
		                },
		                {
		                  mRender: function(row, setting, full){
		                    if(parseFloat(full.prodQty) <= parseFloat(full.prodOrderLvl)){
		                      return "<a href='"+window_location+"/htdocs/productLedger/"+full.itemNum+"' style='color: red;'>"+full.prodName+"</a>";
		                    }
		                    return "<a href='"+window_location+"/htdocs/productLedger/"+full.itemNum+"' class='submit_form'>"+full.prodName+"</a>";
		                  }
		                },
		                {data: 'prodBrand'},
		                {data: 'prodDesc'},
		                {
		                	mRender: function(row, setting, full){
		                		return "P "+full.price;
		                	}
		                },
		                {
		                	mRender: function(row, setting, full){
		                		if(parseFloat(full.prodQty) > 1)
		                		{
		                			return full.prodQty+" units";
		                		}
		                		return full.prodQty+" unit";
		                	}
		                },
		                {
		                	mRender: function(row, setting, full){
		                		if(parseFloat(full.prodOrderLvl) > 1)
		                		{
		                			return full.prodOrderLvl+" units";
		                		}
		                		return full.prodOrderLvl+" unit";
		                	}
		                }
		              ],
		    columnDefs: [{targets: 0, width: '50px'}, {targets: 1, width: '80px'}, {targets: [5,6,7], width: '40px'}],
		    scrollX: true,
		    ordering: false,
			bPaginate: false,
            language: {
                info: 'Total number of records: <b> _MAX_ </b>',
                infoEmpty: 'Total number of records: <b> 0 </b>'
            }
		});
		table.column(4).visible(false);
		table.column(7).visible(false);

		$('#show_all_columns').click(function(){
			if($(this).attr('checked'))
			{
				table.column(4).visible(false);
				table.column(7).visible(false);

				$(this).removeAttr('checked');
				$(this).html("Show All Columns");
			}else
			{
				table.column(4).visible(true);
				table.column(7).visible(true);

				$(this).attr('checked', 'true');
				$(this).html("<i class='material-icons'>done</i> Show All Columns");
			}
		});

		$('#table_search').on('keyup', function () {
	        table.search(this.value).draw();
	    });

	    initModals(table);

	    $('#show_all_columns').trigger('click');
	});

	var initModals = function(table){

// ADD PRODUCT
		$('#add').click(function(){
			var modal = $('#add-modal');
			modal.find('input').val('');
			modal.find('select').val('');
			modal.find('textarea').val('');
			modal.find('file').val('');
			modal.find('.temp-img').attr('src', window_location+'/htdocs/uploads/default.jpg');

			$('#product_exist_warning').css('display', 'none');
			$(this).closest('form').find('button[type=submit]').removeAttr('disabled');

			modal.modal('show');
		});
		$('#products').change(function(){
			var remaining_qty = $(this).find('option:selected').attr('remaining_qty');
			var supplier = $(this).find('option:selected').attr('supplier');
			var suppID = $(this).find('option:selected').attr('suppID');
			var brand = $(this).find('option:selected').attr('brand');
			
			form.find("input[name='remaining_qty']").val(remaining_qty);
			form.find("input[name='supplier']").val(supplier);
			form.find("input[name='suppID']").val(suppID);
			form.find("input[name='brand']").val(brand);
			form.find("input[name='qty']").attr('max', remaining_qty);
			form.find("input[name='brand']").focus();
			form.find("input[name='supplier']").focus();
		});

// DELETE PRODUCT
		$('table').on('click', '.delete', function(){
			var modal = $('#delete-modal');
			var data = table.row($(this).closest('tr')).data();
			var form = modal.find('form');
			var image = (data.image === '') ? 'default.jpg' : data.image;

			form.find('.productName').html(data.prodName);
			form.find('.productImage').attr('src', window_location+'/htdocs/uploads/'+ image);
			form.find('input[name=itemNum]').val(data.itemNum);

			modal.modal('show');
		});	

// UPDATE PRODUCT
		$('table').on('click', '.update', function(){
			var modal = $('#update-modal');
			var data = table.row($(this).closest('tr')).data();
			var form = modal.find('form');
			var image = (data.image === '') ? 'default.jpg' : data.image;

			modal.find('input').val('');
			modal.find('select').val('');
			modal.find('textarea').val('');
			modal.find('file').val('');
			modal.find('.temp-img').attr('src', window_location+'/htdocs/uploads/default.jpg');

			modal.find('.productImage').attr('src', window_location+'/htdocs/uploads/'+ image);
			modal.find('.productName').html(data.prodName);
			modal.find('.productPrice').html(data.price);
			modal.find('input[name=itemNum]').val(data.itemNum);
			modal.find('input[name=pname]').val(data.prodName);

			modal.modal('show');
		});	
	}

</script>
<script>
    $('.img').change(function(ev){
      readURL(this);
    });

    var readURL = function(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var form = $(input).closest('form');

            reader.onload = function (e) {
               form.find('.temp-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
	var products = [];
	var is_product_exist = false;
	$.get(window_location+'/htdocs/get_all_products', function(response){
		products = JSON.parse(response);
	});
	$(document).ready(function(){
		$('#add-modal').on('keyup', 'input[name=pname]', function(){
			var name = $(this).val();
			var brand = $('#add-modal').find('input[name=brand]').val();
			is_product_exist = false;
			$.each(products, function(index, value){
				if(value.prodName.trim() == name.trim() && value.prodBrand.trim() == brand.trim()){
					is_product_exist = true;
				}
			});
			if(is_product_exist)
			{
				$('#product_exist_warning').css('display', 'block');
				$(this).closest('form').find('button[type=submit]').attr('disabled', true);
			}else
			{
				$('#product_exist_warning').css('display', 'none');
				$(this).closest('form').find('button[type=submit]').removeAttr('disabled');
			}
		});
		$('#add-modal').on('change', 'input[name=pname]', function(){
			var name = $(this).val();
			var brand = $('#add-modal').find('input[name=brand]').val();
			is_product_exist = false;
			$.each(products, function(index, value){
				if(value.prodName.trim() == name.trim() && value.prodBrand.trim() == brand.trim()){
					is_product_exist = true;
				}
			});
			if(is_product_exist)
			{
				$('#product_exist_warning').css('display', 'block');
				$(this).closest('form').find('button[type=submit]').attr('disabled', true);
			}else
			{
				$('#product_exist_warning').css('display', 'none');
				$(this).closest('form').find('button[type=submit]').removeAttr('disabled');
			}
		});
		$('#add-modal').on('keyup', 'input[name=brand]', function(){
			var brand = $(this).val();
			var name = $('#add-modal').find('input[name=pname]').val();
			is_product_exist = false;
			$.each(products, function(index, value){
				if(value.prodName.trim() == name.trim() && value.prodBrand.trim() == brand.trim()){
					is_product_exist = true;
				}
			});
			if(is_product_exist)
			{
				$('#product_exist_warning').css('display', 'block');
				$(this).closest('form').find('button[type=submit]').attr('disabled', true);
			}else
			{
				$('#product_exist_warning').css('display', 'none');
				$(this).closest('form').find('button[type=submit]').removeAttr('disabled');
			}
		});
		$('#add-modal').on('change', 'input[name=brand]', function(){
			var brand = $(this).val();
			var name = $('#add-modal').find('input[name=pname]').val();
			is_product_exist = false;
			$.each(products, function(index, value){
				if(value.prodName.trim() == name.trim() && value.prodBrand.trim() == brand.trim()){
					is_product_exist = true;
				}
			});
			if(is_product_exist)
			{
				$('#product_exist_warning').css('display', 'block');
				$(this).closest('form').find('button[type=submit]').attr('disabled', true);
			}else
			{
				$('#product_exist_warning').css('display', 'none');
				$(this).closest('form').find('button[type=submit]').removeAttr('disabled');
			}
		});
	});
</script>