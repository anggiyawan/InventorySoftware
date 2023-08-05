<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<!-- #Left Menu -->
<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
		<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
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
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Display</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vCustomerDisplay" id="vCustomerDisplay" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Email</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vCustomerEmail" id="vCustomerEmail" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Phone</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vCustomerPhone" id="vCustomerPhone" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Mobile</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vCustomerMobile" id="vCustomerMobile" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Type</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vCustomerType" id="vCustomerType" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Customer Status</td>
				<td>
					<input name="vCustomerStatus" id="vCustomerStatus" class="easyui-combogrid" style="width:90px;" data-options="
							panelWidth: 250,
							panelHeight: 220,
							idField: 'id',
							textField: 'name',
							editable: false,
							url: '<?php echo base_url('combogrid/combogridCustomerStatus/all'); ?>',
							mode: 'post',
							onSelect: function(){										
								
							},
							columns: [[
								{field:'id',title:'ID',width:60},
								{field:'name',title:'name',width:240,align:'right'}
							]],
							fitColumns: true
						">
				</td>
			</tr>
			
			
			<!--
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Group</td>
				<td width="100" height="20" valign="middle" align="left">
					<input name="vGorupId" id="vGorupId" class="easyui-combogrid" style="width:90px;" data-options="
							panelWidth: 250,
							idField: 'groupId',
							textField: 'groupName',
							editable: false,
							url: '<?php echo base_url('groups/combogridGroups/all'); ?>',
							mode: 'remote',
							onSelect: function(){										
								
							},
							columns: [[
								{field:'groupId',title:'ID',width:60},
								{field:'groupName',title:'Group name',width:240,align:'right'}
							]],
							fitColumns: true
						">
				</td>
			</tr>
			-->
			
			
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>

			<tr>
				<td colspan="2" height="25" valign="middle" align="center">
					<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="changetheme('gray')">Change</a>-->
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="ToSearch()">Search</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
				</td>
			</tr>
		  

		  </table>
		  
</div>


<!-- #Body -->
<div data-options="region:'center',title:'Master Customers'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
	<table id="datagrid-master" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('customers/getJson'); ?>" fit="false" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="customerId" width="80" sortable="true">ID</th>
				<th field="status" width="80" sortable="true">status</th>
				<th field="customerName" sortable="true">Customer Name</th>
				<th field="customerDisplay" width="150" sortable="true">Customer Display</th>
				<th field="customerEmail" width="250" sortable="true">Customer Email</th>
				<th field="customerPhone" width="120" sortable="true">Customer Phone</th>
				<th field="customerMobile" width="120" sortable="true">Customer Mobile</th>
				<th field="customerType" width="130" sortable="true">Customer Type</th>
				<th field="customerWebsite" width="120" sortable="true">Website</th>
				<th field="customerRemark" width="120" sortable="true">Remark</th>
				<th field="paymentTerm" width="120" sortable="true">Payment Term</th>
				
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
	<div style="height:25%" style="border-style: solid;padding:10px;background-color:#fff" bgcolor="#000">
		
	</div>
	<!-- TABLE DETAIL EOF -->
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:100%; height:100%; padding: 10px 0px;top:0px" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master" style="text-align:left">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->

<!-- TOOLBAR -->
<div id="toolbar-master" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createUser()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateUser()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeUser()">Delete</a>
	<?php //} ?>
</div>
<!-- TOOLBAR EOF -->

<script>
// $('#datagrid-master').datagrid({
  // singleSelect: false,
  // ctrlSelect: true,
  // checkOnSelect: false,
  // scrollOnSelect: false
// });
function ToSearch(){
	
	var vCustomerId			= $('#vCustomerId').textbox('getValue');
	var vCustomerName		= $('#vCustomerName').textbox('getValue');
	var vCustomerDisplay	= $('#vCustomerDisplay').textbox('getValue');
	var vCustomerEmail		= $('#vCustomerEmail').textbox('getValue');
	var vCustomerPhone		= $('#vCustomerPhone').textbox('getValue');
	var vCustomerMobile		= $('#vCustomerMobile').textbox('getValue');
	var vCustomerType		= $('#vCustomerType').textbox('getValue');
	var vCustomerStatus		= $('#vCustomerStatus').combogrid('getValue');
	
	$('#datagrid-master').datagrid('load',{
		customerId: vCustomerId,
		customerName: vCustomerName,
		customerDisplay: vCustomerDisplay,
		customerEmail: vCustomerEmail,
		customerPhone: vCustomerPhone,
		customerMobile: vCustomerMobile,
		customerType: vCustomerType,
		customerStatus: vCustomerStatus,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;
var action;

function createUser(){
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		href:'../customers/formCustomers',
		onLoad:function(){
			// $('#form').form('disableValidation');
			url = "<?php echo base_url('customers/createCustomers'); ?>";
			action = 'create';
		}

	});
}

function updateUser(){

	var row = jQuery('#datagrid-master').datagrid('getSelected');

	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../customers/formCustomers',
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('customers/updatecustomers'); ?>";
				action = 'update';
			}
		});

	}

}

function removeUser(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('customers/deleteCustomers'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "customerId": row.customerId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						jQuery('#dialog-form').dialog('close');
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
					},
					error: function( jqXhr, textStatus, errorThrown ){
						console.log( errorThrown );
					}
				});
			}
		});
	}
}

function saveUser(){

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

<?php $this->endSection() ?>