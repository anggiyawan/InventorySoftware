<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>
function ToSearch(){
	
	// Update
	// var row = $("#datagrid-master").datagrid("getSelected");	
	// var rowIndex = $("#datagrid-master").datagrid("getRowIndex", row);	   
	
	// $('#datagrid-master').datagrid('updateRow', {
	  // index: rowIndex,
	  // row: {salesOrderNumber: "60",reference:"John"}
	// });
	
	// Delete
	// var row = $("#datagrid-master").datagrid("getSelected");	
	// var rowIndex = $("#datagrid-master").datagrid("getRowIndex", row);	   
	
	// $('#datagrid-master').datagrid('deleteRow',rowIndex);
	
	// Insert
	// var row = $("#datagrid-master").datagrid("getSelected");	
	// var rowIndex = $("#datagrid-master").datagrid("getRowIndex", row);	   
	
	// $('#datagrid-master').datagrid('insertRow', {
	  // index: 0,
	  // row: {salesOrderNumber: "60",reference:"John"}
	// }).datagrid('enableDnd');
	
	// Reload Client
	// $('#datagrid-master').datagrid('loadData', {"total":0,"rows":[]});
	
	var vSalesOrderId	= $('#vSalesOrderId').textbox('getValue');
	var vCustomerId	= $('#vCustomerId').textbox('getValue');
	var vCustomerName	= $('#vCustomerName').textbox('getValue');
	var vSalesOrderNumber	= $('#vSalesOrderNumber').textbox('getValue');
	var vStatus	= $('#vStatus').combobox('getValue');
	
	$('#datagrid-master').datagrid('load',{
		salesOrderId: vSalesOrderId,
		customerId: vCustomerId,
		customerName: vCustomerName,
		salesOrderNumber: vSalesOrderNumber,
		status: vStatus,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;
var action;

function createSalesOrders(){
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		href:'../salesorders/formSalesOrders/create',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('salesorders/createSalesOrders'); ?>";
			action = 'create';
		}

	});
}

function updateSalesOrders(){

	var row = jQuery('#datagrid-master').datagrid('getSelected');

	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../salesorders/formSalesOrders/' + row.salesOrderId,
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('salesorders/updateSalesOrders'); ?>";
				action = 'update';
			}
		});

	}

}

function cancelSalesOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to undelivered ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('salesorders/cancelSalesOrders'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "salesOrderId": row.salesOrderId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						$('#dialog-form').dialog('close');
						$('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid({
							url: "<?php echo base_url('salesorders/getJsonDetails?salesOrderId=') ?>" + row.salesOrderId
						});
						
						$('#datagrid-amount').datagrid({
							url: "<?php echo base_url('salesordersamount/getJson?salesOrderId=') ?>" + row.salesOrderId
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

function removeSalesOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('salesorders/deleteSalesOrders'); ?>",
					dataType: 'json',
					type: 'post',
					data: { "salesOrderId": row.salesOrderId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						jQuery('#dialog-form').dialog('close');
						jQuery('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid({
							url: "<?php echo base_url('salesorders/getJsonDetails?salesOrderId=') ?>" + row.salesOrderId
						});
						
						$('#datagrid-amount').datagrid({
							url: "<?php echo base_url('salesordersamount/getJson?salesOrderId=') ?>" + row.salesOrderId
						});
						
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

function saveSalesOrders(){
	// var rows = $('#datagrid-add').datagrid('getRows');
	// $.each(rows, function(i, row) {
		// console.log(row);
	// });
	
	jQuery('#form').form('submit',{
		url: url,
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
					jQuery('#datagrid-master').datagrid('reload');
					jQuery('#datagrid-detail').datagrid('reload');
					jQuery('#datagrid-amount').datagrid('reload');
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
		<table width="80%" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td height="10" valign="middle" align="left" width="10px"></td>
				<td height="10" valign="middle" align="left" width="10px"></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">ID</td>
				<td valign="middle" align="left" width="100px"><input Name="vSalesOrderId" id="vSalesOrderId" type="text" class="easyui-textbox" style="width:120px"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer ID</td>
				<td valign="middle" align="left"><input Name="vCustomerId" id="vCustomerId" type="text" class="easyui-textbox" style="width:120px"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Name</td>
				<td valign="middle" align="left"><input Name="vCustomerName" id="vCustomerName" value="" type="text" class="easyui-textbox" style="width:120px"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Sales Order No</td>
				<td valign="middle" align="left"><input Name="vSalesOrderNumber" id="vSalesOrderNumber" value="" type="text" class="easyui-textbox" style="width:120px"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Status</td>
				<td valign="middle" align="left">
					<input name="vStatus" id="vStatus" class="easyui-combogrid" style="width:120px;" data-options="
							panelWidth: 150,
							idField: 'id',
							textField: 'name',
							editable: false,
							url: '<?php echo base_url('combogrid/combogridSalesOrderStatus/all'); ?>',
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
<div data-options="region:'center',title:'Sales Orders'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:70%" bgcolor="#3E6DB9">
	<table id="datagrid-master" striped="true" pageSize="50" pageList="[50,100,150,200]" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('salesorders/getJson'); ?>" fit="false" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
	data-options="
	onClickCell:function(index,field,value){
		var row = $(this).datagrid('getRows')[index];
		
		if(row.statusId == 1) {
			$('#btn-salesOrders-update').linkbutton('enable');
			$('#link-cancel-salesOrders').attr('hidden', true);
		} else if (row.statusId == 3)
		{
			$('#btn-salesOrders-update').linkbutton('disable');
			$('#link-cancel-salesOrders').attr('hidden', false);
		} else 
		{
			$('#btn-salesOrders-update').linkbutton('disable');
			$('#link-cancel-salesOrders').attr('hidden', true);
		}
		
		$('#datagrid-detail').datagrid({
			url: '<?php echo base_url('salesorders/getJsonDetails?salesOrderId=') ?>' + row.salesOrderId
		});
		
		$('#datagrid-amount').datagrid({
			url: '<?php echo base_url('salesordersamount/getJson?salesOrderId=') ?>' + row.salesOrderId
		});
	},
	'onDblClickRow': function(index, field, value){
		var row = $(this).datagrid('getRows')[index];
		$('#dialog-view').dialog({
			closed:false,
			iconCls:'icon-more',
			title:'View Sales Orders',
			openAnimation: 'fadeIn',
			href:'../salesorders/viewSalesOrders/' + row.salesOrderId,
			onLoad:function(){
				
			}

		});
	}
	">
		<thead>
			<tr>
				<th field="salesOrderId" width="70" sortable="true">ID</th>
				<th field="status" width="85" sortable="true">Status</th>
				<th field="salesOrderNumber" width="120" sortable="true">Sales Order No</th>
				<th field="reference" width="150" sortable="true">Reference</th>
				<th field="customerId" width="100" sortable="true">Customer ID</th>
				<th field="customerName" width="150" sortable="true">Customer Name</th>
				<th field="totalAmount" width="110" sortable="true">Total Amount</th>
				<th field="salesOrderDate" width="100" sortable="true">Order Date</th>
				<th field="expectedShipmentDate" width="100" sortable="true">Exp Shipment Date</th>
				<th field="inputUserName" width="100" sortable="true">Input By</th>
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
	<div id="tt" class="easyui-tabs" style="width:100%" data-options="tabPosition:'top', border: false, fit: true,tabWidth:200">
		<div title='Details' style='padding:0px'>
						<!-- Content -->
							<div style="height:30%" style="border-style: solid;padding:10px">
		<table id="datagrid-detail" striped="true" class="easyui-datagrid" style="height:100%" fit="false" toolbar="" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
			<thead>
				<tr>
					<th field="salesOrderNumber" width="120" sortable="true">Sales Order No</th>
					<th field="productId" width="100" sortable="true">Product ID</th>
					<th field="productNumber" width="120" sortable="true">Product Number</th>
					<th field="productName" width="350" sortable="true">Product Name</th>
					<th field="priceSell" width="110" sortable="true">Sell Price</th>
					<th field="quantity" width="100" sortable="true">Quantity</th>
					<th field="delivery" width="100" sortable="true">Delivery</th>
					<th field="unit" width="100" sortable="true">Unit</th>
					<th field="amount" width="100" sortable="true" data-options="
							styler: function cellStyler(value,row,index){
										return 'font-weight:bold;';
								}">Amount</th>
				</tr>
			</thead>
		</table>
	</div>
						<!-- Content -->
		</div>
		
		<div title='Details Amount' style='padding:0px'>
		<table id="datagrid-amount" striped="true" class="easyui-datagrid" style="height:100%" fit="false" toolbar="" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
			<thead>
				<tr>
					<th field="title" width="180" sortable="true">Detail</th>
					<th field="value" width="150" sortable="true">Amount</th>
				</tr>
			</thead>
		</table>
		</div>
	</div>
	<!-- TABLE DETAIL EOF -->
</div>
<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:100%; height:100%;" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveSalesOrders()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->
<!-- Dialog View Eof -->
<div id="dialog-view" class="easyui-dialog" style="width:100%; height:100%; padding: 0px 0px;top:0px" modal="true" closed="true" buttons="">
</div>
<!-- Dialog View Eof -->

<!-- TOOLBAR -->
<div id="toolbar-master" style="padding:4px">
<div align="left" style="float:left">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" id="btn-salesOrders-add" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createSalesOrders()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" id="btn-salesOrders-update" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateSalesOrders()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" id="btn-salesOrders-remove" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeSalesOrders()">Delete</a>
	<?php //} ?>
</div>
<div align="right" style="margin-right: 20px">
	<a href="#" class="easyui-menubutton" plain="false" data-options="menu:'#mm99',iconCls:'icon-more'" style="width:100px">Action</a>
	<div id="mm99" style="width:200px;">
        <div data-options="iconCls:'icon-ok'" id="link-cancel-salesOrders" onclick="cancelSalesOrders()">Cancel Sales Orders</div>
        <div data-options="iconCls:'icon-print'">Print</div>
    </div>
</div>
</div>
<!-- TOOLBAR EOF -->
<script>
/*

 $('#datagrid-master').datagrid({
            pageNumber:1,
            pageSize:20
        });
$('#datagrid-master').datagrid({
  columns:[[
    {id:'userId',field:'userId',title:'userID',width:80},
    {id:'id2',field:'status',title:'status',width:85},
    {id:'id2',field:'userName',title:'userName',width:125},
    {id:'id2',field:'fullName',title:'fullName',width:250},
    {id:'id2',field:'email',title:'email',width:250},
    {id:'id2',field:'groupName',title:'groupName',width:120},
    {id:'id2',field:'lastLogin',title:'lastLogin',width:80},
  ]]
});

*/
</script>
<?php $this->endSection() ?>