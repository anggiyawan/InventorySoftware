<script>
function myformatter(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
}

function myparser(s){
	if (!s) return new Date();
	var ss = (s.split('-'));
	var y = parseInt(ss[0],10);
	var m = parseInt(ss[1],10);
	var d = parseInt(ss[2],10);
	if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
		return new Date(y,m-1,d);
	} else {
		return new Date();
	}
}
	
var urlAction;

function createPackageDetails(){
	var salesOrderId		= $('#salesOrderId').val();
	var sourceLocationId	= $('#sourceLocationId').val();
	
	if (salesOrderId == '') {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Sales Order No'
		});
		$('#salesOrderNumber').textbox('clear').textbox('textbox').focus();
	} else
	if (sourceLocationId == '') {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Location'
		});
		$('#sourceLocationId').textbox('clear').textbox('textbox').focus();
	}
	else {
		$('#dialog-add').dialog({
			closed:false,
			iconCls:'icon-add',
			title:'Add Delivery',
			href:'../deliveryOrders/formDeliveryOrdersDetails/<?php echo $action ?>?salesOrderId=' + salesOrderId + '&sourceLocationId=' + sourceLocationId,
			onLoad:function(){
				$('#form-add').form('disableValidation');
				urlAction = "<?php echo base_url('deliveryOrders/createDeliveryOrdersDetails/' . $action); ?>";
			}

		});
	}
}

function updatePackageDetails(){

	var row = jQuery('#datagrid-detail').datagrid('getSelected');
	var salesOrderId = $('#salesOrderId').val();
	if (salesOrderId == '') {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Sales Order No'
		});
		$('#salesOrderNumber').textbox('clear').textbox('textbox').focus();
	} else
	if (row.sourceLocationId == '') {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Location'
		});
		$('#sourceLocationId').textbox('clear').textbox('textbox').focus();
	}
	else if(row != ''){

		$('#dialog-add').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update Delivery',
			href:'../deliveryOrders/formDeliveryOrdersDetails/<?php echo $action ?>?salesOrderId=' + salesOrderId + '&deliveryOrderDetailId=' + row.deliveryOrderDetailId + '&sourceLocationId=' + row.sourceLocationId,
			onLoad:function(){

				jQuery('#form-add').form('clear');
				$('#form-add').form('load',row);
				$('#form-add').form('disableValidation');
				urlAction = "<?php echo base_url('deliveryOrders/updateDeliveryOrdersDetails/' . $action); ?>";
			}
		});

	}

}

function removePackageDetails(){
	var row = jQuery('#datagrid-detail').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('deliveryOrders/deleteDeliveryOrdersDetails/' . $action); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "deliveryOrderDetailId": row.deliveryOrderDetailId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						jQuery('#dialog-add').dialog('close');
						jQuery('#datagrid-detail').datagrid('reload');
							$.messager.show({
								title:'INFO',
								msg:data.msg,
								timeout:5000,
								showType:'slide'
							});
							
							var arr = $('#datagrid-detail').datagrid('getRows');
							if (arr.length <= 1) {
								$('#sourceLocationId').combogrid('readonly', false);
							}
							
					} else {
						jQuery.messager.show({
							title: 'Error',
							msg: data.msg
						});
					}
					},
					error: function( jqXhr, textStatus, errorThrown ){
						console.log( errorThrown );
					}
				});
			}
		});
	}
}

function saveDeliveryOrdersDetails(){

	$('#form-add').form('submit',{
		url: urlAction,
		onSubmit: function(){
			
			$('#form-add').form('enableValidation');
			if ($(this).form('validate')) {
				$.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});
				return true;
			} else {
				return false;
			}
			
		},
		success: function(result){
			if (result) {
				
				// var result = eval('('+result+')');
				data = $.parseJSON(result);
				// data = (result);
				$.messager.progress('close');
				// alert(data);
				if(data.status == "success"){
					$('#dialog-add').dialog('close');
					$('#datagrid-detail').datagrid('reload');
						$.messager.show({
							title:'INFO',
							msg:data.msg,
							timeout:5000,
							showType:'slide'
						});
					
					$('#sourceLocationId').combogrid('readonly', true);
						
				} else {
					$.messager.show({
						title: 'Error',
						msg: data.msg
					});
					$('#quantity').textbox('clear').textbox('textbox').focus();
				}
			
			} else {
				$.messager.progress('close');
				alert('Save Failed');
			}
		}
	});
}
</script>
<!-- Dialog Form -->
<form id="form" name="form2" method="post" novalidate >

	<input type="hidden" name="deliveryOrderId"/>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Delivery Order No#</label>
		</div>
		<div>
			<input type="text" name="deliveryOrderNumber" <?php echo "value='". $deliveryOrderNumber . "'"; ?> readonly style="background-color: #eee" class="easyui-validatebox" required="true" size="30" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Sales Order No</label>
		</div>
		<div>
			<input type="hidden" name="salesOrderId" id="salesOrderId">
			<input name="salesOrderNumber" id="salesOrderNumber" <?php if($action != "create"){ echo "readonly"; }?> required="true" class="easyui-combogrid" style="width:240px;" data-options="
							panelWidth: 550,
							idField: 'salesOrderId',
							textField: 'salesOrderNumber',
							editable: true,
							url: '<?php echo base_url('combogrid/combogridSalesOrderToDelivery') ?>',
							mode: 'remote',
							onSelect: function(index, row){
								var beforeSalesOrderId = $('#salesOrderId').val();
								
								if ( beforeSalesOrderId === '' ) {
									$('#salesOrderId').val(row.salesOrderId);
								} else if ( beforeSalesOrderId !== row.salesOrderId ) {
									$.messager.confirm({
											title: 'Confirm',
											content:'Are you sure you want to change ?',
											fn:function(r){
												if (r){ 
													$('#salesOrderId').val(row.salesOrderId);
													$('#salesOrderNumber').combogrid('setValue', row.salesOrderId);
													
													$.ajax({
														url: '<?php echo base_url('deliveryOrders/deleteDetailsTempAll'); ?>',
														type: 'post',
														processData: true,
														success: function( data, textStatus, jQxhr ){
															$('#datagrid-detail').datagrid('reload');
														}
													});
													
												} else {
													$('#salesOrderNumber').combogrid('setValue', beforeSalesOrderId);
												}
											}
										});
								}
								
							},
							onLoadSuccess: function(data){								
								// if (action == 'create'){
									// var rows = data.rows;
									// $('#paymentTermId').combogrid('setValue',rows[0].paymentTermId);
								// }
							},
							columns: [[
								{field:'salesOrderId',title:'salesOrderId',width:130,align:'left'},
								{field:'salesOrderNumber',title:'Sales Order No',align:'left'},
								{field:'customerName',title:'Customer',width:240,align:'left'},
								{field:'expectedShipment',title:'Expected Shipment',width:180,align:'left'}
							]],
							fitColumns: true
						">
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Shipment Date</label>
		</div>
		<div>
			<input name="shipmentDate" class="easyui-datebox" style="width:120px" required="true" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
			<input name="shipmentTime" class="easyui-timespinner" style="width:115px" required="true" data-options="validType:'length[5,5]'" value="<?php echo date('H:i', strtotime(date('H:i'))); ?>">
		</div>
	</div>
		
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Remark</label>
		</div>
		<div>
			<input type="text" name="remark" class="easyui-textbox" data-options="multiline:true,prompt:'You can enter a maximum of 255 characters'" style="width:280px;height:50px;" validType='length[0,255]'/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px;margin-top:20px;border-top: 1px solid #ccc;">
		<div style="float:left;width:130px;align:right">
			<label>Location</label>
		</div>
		<span style="display:inline-block">
			<input name="sourceLocationId" id="sourceLocationId" <?php if ($action != "create") { echo "disabled"; } ?> required="true" class="easyui-combogrid" style="width:140px;" data-options="
				label: 'Source Location',
				labelPosition: 'top',
				prompt: 'Source Location',
				panelWidth: 500,
				idField: 'locationId',
				textField: 'locationName',
				editable: false,
				url: '<?php echo base_url('combogrid/combogridLocations'); ?>',
				mode: 'remote',
				formatter:function(value,row){
					// return row.productId;
				},
				columns: [[
					{field:'locationName',title:'Location Name',width:200},
					{field:'remark',title:'Remark',width:200},
				]],
				onSelect: function(index,row){
					// var src = $('#sourceLocationId').textbox('getValue');
					// var dest = $('#destinationLocationId').textbox('getValue');
					
					// if (src != '' && dest != '') {
						// if (src == dest) {
							
							// $.messager.show({
								// title: 'Error',
								// msg: 'Please select another location'
							// });
							// $('#sourceLocationId').combogrid('setValue', '');
							
						// } else {
						
							// $('#location-add').linkbutton('enable');
							// $('#location-update').linkbutton('enable');
							// $('#location-delete').linkbutton('enable');
							
						// }
					// }
				},
				fitColumns: true
			">
		</span>
	</div>
	
	<div style="padding: 30px 10px 10px 10px;">
	<table id="datagrid-detail" class="easyui-datagrid" url='<?php echo $urlDatagrid; ?>' style="height:300px;" fit="false" toolbar="#toolbar-detail" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="productNumber" width="120" sortable="true" >Product Number</th>
				<th field="productName" width="250" sortable="true" >Product Name</th>
				<th field="ordered" width="80" sortable="true">Ordered</th>
				<th field="quantity" width="130" sortable="true">Quantity</th>
			</tr>
		</thead>
	</table>
	</div>
	
	
</form>
<!-- Dialog Form EOF -->

<div id="toolbar-detail" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createPackageDetails()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updatePackageDetails()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removePackageDetails()">Delete</a>
	<?php //} ?>
</div>

<!-- Dialog Form -->
<div id="dialog-add" class="easyui-dialog" style="width:450px; padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-add">
</div>
<div id="dialog-buttons-add">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDeliveryOrdersDetails()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-add').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->