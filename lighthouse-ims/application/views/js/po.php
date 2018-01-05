<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/submit.js'></script>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#table').DataTable({
			ajax: window_location+'/htdocs/po_table',
			columns: [
						{data: 'po_form_id'},
						{data: 'date_created'},
						{data: 'suppName'},
						{data: 'status'},
						{
							bSearchable: false,
							mRender: function(row, setting, full){
								if(full.status === 'pending')
								{
									return "<a href="+window_location+"/htdocs/po_history?po_id="+full.po_id+" class='btn btn-primary btn-xs btn-block view'>View</a>"+
											"<button type='button' class='btn btn-success btn-xs btn-block delivery'>Delivery</button>"+
											"<button type='button' class='btn btn-warning btn-xs btn-block cancel'>Cancel</button>"+
											"<a href="+window_location+"/htdocs/po_form?po_id="+full.po_id+" class='btn btn-info btn-xs btn-block view'><i class='material-icons'>print</i> Print Order Form</a>";
								}
								if(full.status === 'incomplete')
								{
									return "<a href="+window_location+"/htdocs/po_history?po_id="+full.po_id+" class='btn btn-primary btn-xs btn-block view'>View</a>"+
											"<button type='button' class='btn btn-success btn-xs btn-block delivery'>Delivery</button>"+
											"<a href="+window_location+"/htdocs/po_form?po_id="+full.po_id+" class='btn btn-info btn-xs btn-block view'><i class='material-icons'>print</i> Print Order Form</a>";
								}
								return "<a href="+window_location+"/htdocs/po_history?po_id="+full.po_id+" class='btn btn-primary btn-xs btn-block view'>View</a>";
							}
						},
					],
			scrollX: false,
			columnDefs: [{targets: 3, width: '100px'}],
			ordering: false,
			bPaginate: false,
            language: {
                info: 'Total number of PO: <b> _MAX_ </b>',
                infoEmpty: 'Total number of PO: <b> 0 </b>'
            }
		});

		$('#table_search').on('keyup', function () {
	        table.search(this.value).draw();
	    });

	    var init_modal = function(table){
			$('table').on('click', '.delivery', function(){
				var data = table.row($(this).closest('tr')).data();

				$.get(window_location+'/htdocs/po_delivery', {po_id: data.po_id}, function(response){
					var response_data = JSON.parse(response);
					var date_created = Date.parse(response_data[0].date_created);
					var date_today = Date.today().toString('MMM d, yyyy');
					var modal = $('#delivery-modal');

					modal.find('#po-id').html(response_data[0].po_form_id);
					modal.find('#date-created').html(date_created.toString('MMM d, yyyy'));
					modal.find('#date-today').html(date_today);
					modal.find('#supplier').html(response_data[0].suppName);
					modal.find('input[name=po_id]').val(response_data[0].po_id);
					modal.find('input[name=po_history_id]').val(response_data[0].po_history_id);
					modal.find('input[name=suppID]').val(response_data[0].suppID);

					var prod_table = modal.find('#prod-table tbody');
					prod_table.html('');
					$.each(response_data, function(index, value){
						if(value.status === "complete")
						{
							var row = "<tr style='color: #000;'>"+
										"<td>"+value.prodName+"</td>"+
										"<td>Complete ("+value.total_qty+"/"+value.total_qty+")"+" <span style='color: red; font-size: 12px;'> Extra: "+value.extra_qty+"</span</td>"+
										"<td><span style='font-size: 12px;'>"+value.remarks+"</span>"+
										"<input type='hidden' name='itemNum[]' value='"+value.itemNum+"'>"+
										"<input type='hidden' name='total_qty[]' value='"+value.total_qty+"'>"+
										"<input type='hidden' name='remaining_qty[]' value='"+value.remaining_qty+"'>"+
										"</td>"+
									"</tr>";
						}
						else
						{
							var row = "<tr>"+
										"<td>"+value.prodName+"</td>"+
										"<td><input name='delivered_qty[]' type='number' step='1' min='0' max-qty='"+value.remaining_qty+"' style='width: 150px;'> / "+value.remaining_qty+" <span style='color: red; font-size: 12px;'></span</td>"+
										"<td><textarea name='remarks[]' style='width: 250px;'></textarea>"+
										"<input type='hidden' name='itemNum[]' value='"+value.itemNum+"'>"+
										"<input type='hidden' name='total_qty[]' value='"+value.total_qty+"'>"+
										"<input type='hidden' name='remaining_qty[]' value='"+value.remaining_qty+"'>"+
										"</td>"+
									"</tr>";
						}
						prod_table.append(row);
					});
					modal.modal('show');

					prod_table.find("input[name*=delivered_qty]").on('keyup', function(){
						var max = parseFloat($(this).attr('max-qty'));
						var val = parseFloat($(this).val());
						if(val > max)
						{
							$(this).closest('td').find('span').html('Extra '+ (val-max));
							$(this).closest('td').find('span').css('display', 'block');
						}
						else
						{
							$(this).closest('td').find('span').html('');
							$(this).closest('td').find('span').css('display', 'block');
						}
					});

				});
			});
		}
		init_modal(table);
	});
</script>