<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>

function ToSearch(){
	var vDeliveryOrderId = $('#vDeliveryOrderId').textbox('getValue');
	var vCustomerId	= $('#vCustomerId').textbox('getValue');
	var vCustomerName	= $('#vCustomerName').textbox('getValue');
	var vDeliveryOrderNumber	= $('#vDeliveryOrderNumber').textbox('getValue');
	var vStatus	= $('#vStatus').combobox('getValue');
	
	$('#datagrid-master').datagrid('load',{
		deliveryOrderId: vDeliveryOrderId,
		customerId: vCustomerId,
		customerName: vCustomerName,
		deliveryOrderNumber: vDeliveryOrderNumber,
		status: vStatus,
	}); 
}

function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;

function createDeliveryOrders(){
	$('#dialog-form').dialog({
		closed:false,
		cache: false,
		iconCls:'icon-add',
		title:'Add Data',
		processData: false,
		href:'../deliveryOrders/formDeliveryOrders/create',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('deliveryOrders/createDeliveryOrders'); ?>";
		}

	});
}

function updateDeliveryOrders(){

	var row = jQuery('#datagrid-master').datagrid('getSelected');

	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../deliveryOrders/formDeliveryOrders/' + row.deliveryOrderId,
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('deliveryOrders/updateDeliveryOrders'); ?>";
			}
		});

	}

}

function removeDeliveryOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('deliveryOrders/deleteDeliveryOrders'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "deliveryOrderId": row.deliveryOrderId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						$('#dialog-form').dialog('close');
						$('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid({
							url: "<?php echo base_url('deliveryOrders/getJsonDetails?deliveryOrderId=') ?>" + row.deliveryOrderId
						});
							$.messager.show({
								title:'INFO',
								msg:data.msg,
								timeout:5000,
								showType:'slide'
							});
							
					} else {
						$.messager.show({
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

function markAsDeliveryOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		
		$('#dialog-mark-delivered').dialog({
			closed: false,
			cache: false,
			iconCls:'icon-add',
			title:'Mark As Delivered',
			// processData: false,
			href:'../deliveryOrders/formMarkDelivered/create',
			onLoad:function(){
				$('#dialog-form').dialog('clear');
				$('#form').form('disableValidation');
				$('#form').form('load',row);
				url = "<?php echo base_url('deliveryOrders/markAsDelivered'); ?>";
			}

		});
		
	} else {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Delivery Order'
		});
	}
}

function markAsUndeliveryOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to undelivered ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('deliveryOrders/markAsUndeliveryOrders'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "deliveryOrderId": row.deliveryOrderId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						$('#dialog-form').dialog('close');
						$('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid({
							url: "<?php echo base_url('deliveryOrders/getJsonDetails?deliveryOrderId=') ?>" + row.deliveryOrderId
						});
							$.messager.show({
								title:'INFO',
								msg:data.msg,
								timeout:5000,
								showType:'slide'
							});
							
					} else {
						$.messager.show({
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
	} else {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Delivery Order'
		});
	}
}

function cancelDeliveryOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to undelivered ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('deliveryOrders/cancelDeliveryOrders'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "deliveryOrderId": row.deliveryOrderId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						$('#dialog-form').dialog('close');
						$('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid({
							url: "<?php echo base_url('deliveryOrders/getJsonDetails?deliveryOrderId=') ?>" + row.deliveryOrderId
						});
							$.messager.show({
								title:'INFO',
								msg:data.msg,
								timeout:5000,
								showType:'slide'
							});
							
					} else {
						$.messager.show({
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
	} else {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Delivery Order'
		});
	}
}

function saveDeliveryOrders(){
	$('#form').form('submit',{
		url: url,
		contentType:false,
		cache:false,
		processData:false,
		onSubmit: function(){
			
			$('#form').form('enableValidation');
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
					jQuery('#dialog-form').dialog('close');
					jQuery('#dialog-mark-delivered').dialog('close');
					jQuery('#datagrid-master').datagrid('reload');
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
<!-- #Left Menu -->
<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
		<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">ID</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vDeliveryOrderId" id="vDeliveryOrderId" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer ID</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vCustomerId" id="vCustomerId" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Name</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vCustomerName" id="vCustomerName" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Delivery Order No</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vDeliveryOrderNumber" id="vDeliveryOrderNumber" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Status</td>
				<td width="100" height="20" valign="middle" align="left">
					<input name="vStatus" id="vStatus" class="easyui-combogrid" style="width:90px;" data-options="
							panelWidth: 150,
							idField: 'id',
							textField: 'name',
							editable: false,
							url: '<?php echo base_url('combogrid/combogridDeliveryOrderStatus/all'); ?>',
							mode: 'post',
							onSelect: function(){										
								
							},
							columns: [[
								{field:'name',title:'Status',width:80,align:'left'}
							]],
							fitColumns: true
						">
				</td>
			</tr>
			
			
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>

			<tr>
				<td colspan="2" height="25" valign="middle" align="center">
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="ToSearch()">Search</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
				</td>
			</tr>
		</table>		  
</div>


<!-- #Body -->
<div data-options="region:'center',title:'Delivery Orders'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
	<table id="datagrid-master" pageSize="50" pageList="[50,100,150,200]" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('deliveryOrders/getJson'); ?>" fit="false" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
	data-options="
	onClickCell:function(index,field,value){
		var row = $(this).datagrid('getRows')[index];
		
		if(row.statusId == 1)
		{
			$('#link-mark-delivered').attr('hidden', true);
			$('#link-mark-undelivered').attr('hidden', true);
			$('#link-cancel-procesed').attr('hidden', true);
			
			$('#btn-deliveryOrders-update').linkbutton('enable');
		} else if(row.statusId == 2)
		{
			$('#link-mark-delivered').attr('hidden', false);
			$('#link-mark-undelivered').attr('hidden', true);
			$('#link-cancel-procesed').attr('hidden', false);
			
			$('#btn-deliveryOrders-update').linkbutton('disable');
		} else {
			$('#link-mark-delivered').attr('hidden', true);
			$('#link-mark-undelivered').attr('hidden', false);
			$('#link-cancel-procesed').attr('hidden', true);
			
			$('#btn-deliveryOrders-update').linkbutton('disable');
		}
		
		$('#datagrid-details').datagrid({
			url: '<?php echo base_url('deliveryOrders/getJsonDetails?deliveryOrderId=') ?>' + row.deliveryOrderId
		});
	},
	'onDblClickRow': function(index, field, value){
		var row = $(this).datagrid('getRows')[index];
		$('#dialog-view').dialog({
			closed:false,
			iconCls:'icon-more',
			title:'View Sales Orders',
			openAnimation: 'fadeIn',
			href:'../deliveryOrders/viewDeliveryOrders/' + row.deliveryOrderId,
			onLoad:function(){
				
			}

		});
	}
	">
		<thead>
			<tr>
				<th field="deliveryOrderId" width="70" sortable="true">ID</th>
				<th field="status" width="85" sortable="true">Status</th>
				<th field="deliveryOrderNumber" width="120" sortable="true">Delivery Order No</th>
				<th field="salesOrderNumber" width="120" sortable="true">Sales Order No</th>
				<th field="customerId" width="100" sortable="true">Customer ID</th>
				<th field="customerName" width="200" sortable="true">Customer Name</th>
				<th field="customerDisplay" width="150" sortable="true">Customer Display</th>
				<th field="shipmentDate" width="110" sortable="true">Shipment Date</th>
				<th field="shipmentTime" width="110" sortable="true">Shipment Time</th>
				<th field="deliveryDate" width="110" sortable="true">Delivery Date</th>
				<th field="deliveryTime" width="110" sortable="true">Delivery Time</th>
				<th field="remark" width="110" sortable="true">Remark</th>
				<!--
				<th field="inputBy" width="85" sortable="true">Input By</th>
				<th field="inputDate" width="85" sortable="true">Input Date</th>
				<th field="updateBy" width="85" sortable="true">Update By</th>
				<th field="updateDate" width="85" sortable="true">Update Date</th>
				-->
			</tr>
		</thead>
	</table>
	</div>
	<!-- TABLE UTAMA EOF -->
	<!-- TABLE DETAIL -->
	<div style="height:25%" style="border-style: solid;padding:10px">
	
	<table id="datagrid-details" class="easyui-datagrid" style="height:100%" fit="false" toolbar="" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="productNumber" width="150" sortable="true" >Product Number</th>
				<th field="productName" width="350" sortable="true">Product Name</th>
				<th field="ordered" width="120" sortable="true">Ordered</th>
				<th field="quantity" width="140" sortable="true">Quantity</th>
			</tr>
		</thead>
	</table>
		
	</div>
	<!-- TABLE DETAIL EOF -->
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:850px; padding: 10px 20px;top:10px" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDeliveryOrders()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->
<!-- Dialog View Eof -->
<div id="dialog-view" class="easyui-dialog" style="width:100%; height:100%; padding: 0px 0px;top:0px" modal="true" closed="true" buttons="">
</div>
<!-- Dialog View Eof -->

<!-- Dialog Mark Delivered -->
<div id="dialog-mark-delivered" class="easyui-dialog" style="width:450px; height:250px; padding: 0px 0px;top:0px" modal="true" closed="true" buttons="#dialog-buttons-delivered">
</div>
<div id="dialog-buttons-delivered">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDeliveryOrders()">Proceed</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-mark-delivered').dialog('close')">Cancel</a>
</div>
<!-- Dialog Mark Delivered -->

<!-- TOOLBAR -->
<div id="toolbar-master" style="padding:4px">
<div align="left" style="float:left">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" id="btn-deliveryOrders-add" class="easyui-linkbutton" iconCls="icon-add" style="width:150px" onclick="createDeliveryOrders()">Add Delivery</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" id="btn-deliveryOrders-update" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateDeliveryOrders()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" id="btn-deliveryOrders-remove" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeDeliveryOrders()">Delete</a>
	<?php //} ?>
</div>
<div align="right" style="margin-right: 20px">
	<a href="#" class="easyui-menubutton" plain="false" data-options="menu:'#mm99',iconCls:'icon-more'" style="width:100px">Action</a>
	<div id="mm99" style="width:200px;">
        <div data-options="iconCls:'icon-ok'" hidden="true" id="link-mark-undelivered" onclick="markAsUndeliveryOrders()">Mark As Undelivered</div>
        <div data-options="iconCls:'icon-ok'" hidden="true" id="link-mark-delivered" onclick="markAsDeliveryOrders()">Mark As Delivered</div>
        <div data-options="iconCls:'icon-ok'" hidden="true" id="link-cancel-procesed" onclick="cancelDeliveryOrders()">Cancel Procesed</div>
        <div data-options="iconCls:'icon-print'">Print</div>
    </div>
</div>
</div>
<!-- TOOLBAR EOF -->
<?php $this->endSection() ?>