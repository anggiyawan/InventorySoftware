<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>
function ToSearch(){
	var vRepresentativesName	= $('#vRepresentativesName').textbox('getValue');
	var vDescription	= $('#vDescription').textbox('getValue');

	$('#datagrid-master').datagrid('load',{
		representative: vRepresentativesName,
		description: vDescription,
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
		href:'../representatives/formRepresentatives',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('representatives/createRepresentatives'); ?>";
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
			href:'../representatives/formRepresentatives',
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('representatives/updateRepresentatives'); ?>";
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
					url: "<?php echo base_url('representatives/deleteRepresentatives'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "representativeId": row.representativeId },
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
				<td height="20" valign="middle" align="right" style="font-size:12px;">Representative Name</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vRepresentativesName" id="vRepresentativesName" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Description</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vUserName" id="vDescription" size="8" value="" type="text" class="easyui-textbox"/></td>
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
<div data-options="region:'center',title:'Master Representatives'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
	<table id="datagrid-master" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('representatives/getJson'); ?>" fit="true" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="representativeId" width="70" sortable="true">ID</th>
				<th field="status" width="85" sortable="true">Status</th>
				<th field="representative" width="250" sortable="true">Representative</th>
				<th field="description" width="350" sortable="true">Description</th>
				<!--
				<th field="inputBy" width="85" sortable="true">Input By</th>
				<th field="inputDate" width="85" sortable="true">Input Date</th>
				<th field="updateBy" width="85" sortable="true">Update By</th>
				<th field="updateDate" width="85" sortable="true">Update Date</th>-->
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
<?php $this->endSection() ?>