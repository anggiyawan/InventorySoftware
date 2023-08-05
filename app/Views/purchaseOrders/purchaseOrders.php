<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>
function ToSearch(){
	var vPurchaseOrderId	= $('#vPurchaseOrderId').textbox('getValue');
	var vCustomerId	= $('#vCustomerId').textbox('getValue');
	var vCustomerName	= $('#vCustomerName').textbox('getValue');
	var vPurchaseOrderNumber	= $('#vPurchaseOrderNumber').textbox('getValue');
	var vStatus	= $('#vStatus').combobox('getValue');
	
	$('#datagrid-master').datagrid('load',{
		purchaseOrderId: vPurchaseOrderId,
		customerId: vCustomerId,
		customerName: vCustomerName,
		purchaseOrderNumber: vPurchaseOrderNumber,
		status: vStatus,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;
var action;

function createPurchaseOrders(){
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		href:'../purchaseorders/formPurchaseOrders/create',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('purchaseorders/createPurchaseOrders'); ?>";
			action = 'create';
		}

	});
}

function updatePurchaseOrders(){

	var row = jQuery('#datagrid-master').datagrid('getSelected');

	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../purchaseorders/formPurchaseOrders/' + row.purchaseOrderId,
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('purchaseorders/updatePurchaseOrders'); ?>";
				action = 'update';
			}
		});

	}

}

function cancelPurchaseOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to undelivered ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('purchaseorders/cancelPurchaseOrders'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "purchaseOrderId": row.purchaseOrderId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						$('#dialog-form').dialog('close');
						$('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid({
							url: "<?php echo base_url('purchaseorders/getJsonDetails?purchaseOrderId=') ?>" + row.purchaseOrderId
						});
						
						$('#datagrid-amount').datagrid({
							url: "<?php echo base_url('purchaseordersamount/getJson?purchaseOrderId=') ?>" + row.purchaseOrderId
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

function removePurchaseOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('purchaseorders/deletePurchaseOrders'); ?>",
					dataType: 'json',
					type: 'post',
					data: { "purchaseOrderId": row.purchaseOrderId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						jQuery('#dialog-form').dialog('close');
						jQuery('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid({
							url: "<?php echo base_url('purchaseorders/getJsonDetails?purchaseOrderId=') ?>" + row.purchaseOrderId
						});
						
						$('#datagrid-amount').datagrid({
							url: "<?php echo base_url('purchaseordersamount/getJson?purchaseOrderId=') ?>" + row.purchaseOrderId
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

function savePurchaseOrders(){
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
				<td valign="middle" align="left" width="100px"><input Name="vPurchaseOrderId" id="vPurchaseOrderId" type="text" class="easyui-textbox" style="width:120px"/></td>
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
				<td height="20" valign="middle" align="right" style="font-size:12px;">Purchase Order No</td>
				<td valign="middle" align="left"><input Name="vPurchaseOrderNumber" id="vPurchaseOrderNumber" value="" type="text" class="easyui-textbox" style="width:120px"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Status</td>
				<td valign="middle" align="left">
					<input name="vStatus" id="vStatus" class="easyui-combogrid" style="width:120px;" data-options="
							panelWidth: 150,
							idField: 'id',
							textField: 'name',
							editable: false,
							url: '<?php echo base_url('combogrid/combogridPurchaseOrderStatus/all'); ?>',
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
<div data-options="region:'center',title:'Purchase Orders'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:70%" bgcolor="#3E6DB9">
	<table id="datagrid-master" striped="true" pageSize="50" pageList="[50,100,150,200]" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('purchaseorders/getJson'); ?>" fit="false" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
	data-options="
	onClickCell:function(index,field,value){
		var row = $(this).datagrid('getRows')[index];
		
		if(row.statusId == 1) {
			$('#btn-purchaseOrders-update').linkbutton('enable');
			$('#link-cancel-purchaseOrders').attr('hidden', true);
		} else if (row.statusId == 3)
		{
			$('#btn-purchaseOrders-update').linkbutton('disable');
			$('#link-cancel-purchaseOrders').attr('hidden', false);
		} else 
		{
			$('#btn-purchaseOrders-update').linkbutton('disable');
			$('#link-cancel-purchaseOrders').attr('hidden', true);
		}
		
		$('#datagrid-detail').datagrid({
			url: '<?php echo base_url('purchaseorders/getJsonDetails?purchaseOrderId=') ?>' + row.purchaseOrderId
		});
		
		$('#datagrid-amount').datagrid({
			url: '<?php echo base_url('purchaseordersamount/getJson?purchaseOrderId=') ?>' + row.purchaseOrderId
		});
	},
	'onDblClickRow': function(index, field, value){
		var row = $(this).datagrid('getRows')[index];
		$('#dialog-view').dialog({
			closed:false,
			iconCls:'icon-more',
			title:'View Purchase Orders',
			openAnimation: 'fadeIn',
			href:'../purchaseorders/viewPurchaseOrders/' + row.purchaseOrderId,
			onLoad:function(){
				
			}

		});
	}
	">
		<thead>
			<tr>
				<th field="purchaseOrderId" width="70" sortable="true">ID</th>
				<th field="status" width="85" sortable="true">Status</th>
				<th field="purchaseOrderNumber" width="120" sortable="true">Purchase Order No</th>
				<th field="reference" width="150" sortable="true">Reference</th>
				<th field="customerId" width="100" sortable="true">Customer ID</th>
				<th field="customerName" width="150" sortable="true">Customer Name</th>
				<th field="totalAmount" width="110" sortable="true">Total Amount</th>
				<th field="purchaseOrderDate" width="100" sortable="true">Order Date</th>
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
					<th field="purchaseOrderNumber" width="120" sortable="true">Purchase Order No</th>
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
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savePurchaseOrders()">Simpan</a>
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
	<a href="javascript:void(0)" id="btn-purchaseOrders-add" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createPurchaseOrders()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" id="btn-purchaseOrders-update" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updatePurchaseOrders()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" id="btn-purchaseOrders-remove" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removePurchaseOrders()">Delete</a>
	<?php //} ?>
</div>
<div align="right" style="margin-right: 20px">
	<a href="#" class="easyui-menubutton" plain="false" data-options="menu:'#mm99',iconCls:'icon-more'" style="width:100px">Action</a>
	<div id="mm99" style="width:200px;">
        <div data-options="iconCls:'icon-ok'" id="link-cancel-purchaseOrders" onclick="cancelPurchaseOrders()">Cancel Purchase Orders</div>
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