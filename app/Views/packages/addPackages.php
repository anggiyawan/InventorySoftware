<script>
var urlAction;

function createPackageDetails(){
	var salesOrderId = $('#salesOrderId').val();
	if (salesOrderId != '') {
		$('#dialog-add').dialog({
			closed:false,
			iconCls:'icon-add',
			title:'Add Package',
			href:'../packages/formPackagesDetails/<?php echo $action ?>?salesOrderId=' + salesOrderId,
			onLoad:function(){
				$('#form-add').form('disableValidation');
				urlAction = "<?php echo base_url('packages/createPackagesDetails/' . $action); ?>";
			}

		});
	} else {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Sales Order No'
		});
	}
}

function updatePackageDetails(){

	var row = jQuery('#datagrid-detail').datagrid('getSelected');
	var salesOrderId = $('#salesOrderId').val();
	if(row != '' && salesOrderId != ''){

		$('#dialog-add').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update Package',
			href:'../packages/formPackagesDetails/<?php echo $action ?>?salesOrderId=' + salesOrderId,
			onLoad:function(){

				jQuery('#form-add').form('clear');
				$('#form-add').form('load',row);
				$('#form-add').form('disableValidation');
				urlAction = "<?php echo base_url('packages/updatePackagesDetails/' . $action); ?>";
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
					url: "<?php echo base_url('packages/deletePackagesDetails/' . $action); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "packageDetailId": row.packageDetailId },
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

function savePackageDetails(){

	jQuery('#form-add').form('submit',{
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
					jQuery('#dialog-add').dialog('close');
					jQuery('#datagrid-detail').datagrid('reload');
						$.messager.show({
							title:'INFO',
							msg:data.msg,
							timeout:5000,
							showType:'slide'
						});
						
				} else {
					jQuery.messager.show({
						title: 'Error',
						msg: data.msg
					});
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
<form id="form" method="post" novalidate >

	<input type="hidden" name="userId" required="true" size="30" maxlength="50" />
	<div class="form-item">
		<input type="hidden" name="userId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Package Slip#</label>
		</div>
		<div>
			<input type="text" name="packageNumber" <?php echo "value='". $packageNumber . "'"; ?> readonly style="background-color: #eee" class="easyui-validatebox" required="true" size="30" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Sales Order No</label>
		</div>
		<div>
			<input type="hidden" name="salesOrderId" id="salesOrderId">
			<input name="salesOrderNumber" id="salesOrderNumber" required="true" class="easyui-combogrid" style="width:240px;" data-options="
							panelWidth: 450,
							idField: 'salesOrderId',
							textField: 'salesOrderNumber',
							editable: true,
							url: '<?php echo base_url('combogrid/combogridSalesOrderToPackage') ?>',
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
														url: '<?php echo base_url('packages/deleteDetailsTempAll'); ?>',
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
								{field:'salesOrderId',title:'salesOrderId',width:240,align:'left'},
								{field:'customerName',title:'Customer',width:240,align:'left'},
								{field:'salesOrderNumber',title:'Sales Order No',width:240,align:'left'},
								{field:'expectedShipment',title:'Expected Shipment',width:240,align:'left'}
							]],
							fitColumns: true
						">
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
	
	<div style="padding: 30px 10px 10px 10px;">
	<table id="datagrid-detail" class="easyui-datagrid" url='<?php echo $urlDatagrid; ?>' style="height:300px;" fit="false" toolbar="#toolbar-detail" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="salesOrderDetailId" width="120" sortable="true" >salesOrderDetailId</th>
				<th field="productNumber" width="120" sortable="true" >Product Number</th>
				<th field="productName" width="250" sortable="true" >Product Name</th>
				<th field="ordered" width="80" sortable="true">Ordered</th>
				<th field="packed" width="80" sortable="true">Packed</th>
				<th field="quantityToPack" width="130" sortable="true">Quantity To Pack</th>
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
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savePackageDetails()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->