<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>

function ToSearch(){
	// let grid = $("#datagrid-master").datagrid('options').columns;
	// console.log(grid);
	var vUserName	= $('#vUserName').textbox('getValue');
	var vGorupId	= $('#vGorupId').combobox('getValue');

	$('#datagrid-master').datagrid('load',{
		userName: vUserName,
		groupId: vGorupId,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;

function createUser(){
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		href:'../shipments/formShipments',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('shipments/createShipments'); ?>";
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
			href:'../shipments/formShipments',
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('shipments/updateShipments'); ?>";
			}
		});

		// jQuery('#dialog-form').dialog('open').dialog('setTitle','Update Data');

		// jQuery('#form').form('load',row);	

	}

}

function removeUser(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('shipments/deleteShipments'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "userId": row.userId },
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
<!-- #Left Menu -->
<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
		<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Nama User</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vUserName" id="vUserName" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
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
<div data-options="region:'center',title:'Master Shipments'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
	<table id="datagrid-master" class="easyui-datagrid" style="height:100%" url="" fit="true" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="userId" width="80" sortable="true">ID</th>
				<th field="status" width="85" sortable="true">Status</th>
				<th field="userName" width="150" sortable="true">UserName</th>
				<th field="fullName" width="250" sortable="true">FullName</th>
				<th field="email" width="250" sortable="true">Email</th>
				<th field="groupName" width="120" sortable="true">Group</th>
				<th field="lastLogin" width="85" sortable="true">Last Login</th>
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
	</div>
	<!-- TABLE DETAIL EOF -->
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:500px; height:400px; padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master">
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
$(function(){
	$('#datagrid-master').datagrid({
		url: "<?php echo base_url('shipments/getJson'); ?>",
		columns:[[
			{id:'userId',field:'userId',title:'userID',width:80},
			{id:'id2',field:'status',title:'status',width:85},
			{id:'id2',field:'userName',title:'userName',width:125},
			{id:'id2',field:'fullName',title:'fullName',width:250},
			{id:'id2',field:'email',title:'email',width:250},
			{id:'id2',field:'groupName',title:'groupName',width:120},
			{id:'id2',field:'lastLogin',title:'lastLogin',width:80},
		  ]] 
		// rownumbers: true,
		// singleSelect: true,
	}).datagrid('columnMoving');
	// $('#datagrid-master').datagrid('hideColumn', 'userId');
})
// $('#datagrid-master').datagrid({
  // columns:[[
    // {id:'userId',field:'userId',title:'userID',width:80},
    // {id:'id2',field:'status',title:'status',width:85},
    // {id:'id2',field:'userName',title:'userName',width:125},
    // {id:'id2',field:'fullName',title:'fullName',width:250},
    // {id:'id2',field:'email',title:'email',width:250},
    // {id:'id2',field:'groupName',title:'groupName',width:120},
    // {id:'id2',field:'lastLogin',title:'lastLogin',width:80},
  // ]]
// });
</script>
<?php $this->endSection() ?>