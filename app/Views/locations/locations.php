<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>
function ToSearch(){
	var vLocationName	= $('#vLocationName').textbox('getValue');
	var vRemark			= $('#vRemark').textbox('getValue');
	var vStatusId		= $('#vStatusId').combobox('getValue');

	$('#datagrid-master').datagrid('load',{
		locationName: vLocationName,
		remark: vRemark,
		statusId: vStatusId,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;

function createLocations(){
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		href:'../locations/formLocations',
		onLoad:function(){
			$('#form').form('clear');
			$('#form').form('disableValidation');
			url = "<?php echo base_url('locations/createLocations'); ?>";
		}

	});
}

function createAdjustment(){
	var row = jQuery('#datagrid-details').datagrid('getSelected');

	if(row){
		$('#dialog-adjusment').dialog({
			closed:false,
			iconCls:'icon-add',
			title:'Add Adjusment',
			href:'../locations/formAdjustments',
			onLoad:function(){
				$('#dialog-form').dialog('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('locations/createAdjustments'); ?>";
			}
		});
	} else {
		$.messager.show({
			title: 'Error',
			msg: 'Please Select Product'
		});
	}
}

function updateLocations(){

	var row = jQuery('#datagrid-master').datagrid('getSelected');

	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../locations/formLocations',
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('locations/updateLocations'); ?>";
			}
		});

		// jQuery('#dialog-form').dialog('open').dialog('setTitle','Update Data');

		// jQuery('#form').form('load',row);	

	}

}

function removeLocations(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('locations/deleteLocations'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "locationId": row.locationId },
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

function saveLocations(){

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
					jQuery('#dialog-adjusment').dialog('close');
					jQuery('#datagrid-master').datagrid('reload');
					jQuery('#datagrid-details').datagrid('reload');
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
				<td height="20" valign="middle" align="right" style="font-size:12px;">Nama Location</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vLocationName" id="vLocationName" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Remark</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vRemark" id="vRemark" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Status</td>
				<td width="100" height="20" valign="middle" align="left">
					<select name='vStatusId' id='vStatusId' class="easyui-combobox" editable="false" style="width:90px" required="true">
						<option value=''>All</option>
						<option value='1'>Aktif</option>
						<option value='2'>Disable</option>
					</select>
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
<div data-options="region:'center',title:'Master Location'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:60%" bgcolor="#3E6DB9">
	<table id="datagrid-master" striped="true" pageSize="50" pageList="[50,100,150,200]" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('locations/getJson'); ?>" fit="true" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
	data-options="
	onClickCell:function(index,field,value){
		var row = $(this).datagrid('getRows')[index];
		$('#datagrid-details').datagrid({
			url: '<?php echo base_url('locations/getJsonLocationProducts?locationId=') ?>' + row.locationId
		});
	}
	">
		<thead>
			<tr>
				<th field="locationId" width="80" sortable="true">ID</th>
				<th field="status" width="85" sortable="true">Status</th>
				<th field="locationName" width="350" sortable="true">Location Name</th>
				<th field="remark" width="450" sortable="true">Remark</th>
			</tr>
		</thead>
	</table>
	</div>
	<!-- TABLE UTAMA EOF -->
	<!-- TABLE DETAIL -->
	<div style="height:40%" style="border-style: solid;padding:10px">
	
	<table id="datagrid-details" striped="true" pageSize="100" pageList="[100,200,300]" class="easyui-datagrid" style="height:100%" fit="false" toolbar="#toolbar-detail" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="productId" width="85" sortable="true">Product ID</th>
				<th field="status" width="85" sortable="true">Status</th>
				<th field="productNumber" width="250" sortable="true">Product Number</th>
				<th field="productName" width="350" sortable="true">Product Name</th>
				<th field="stockAcc" width="140" sortable="true">Stock Accounting</th>
				<th field="stockPhy" width="140" sortable="true">Stock Physical</th>
			</tr>
		</thead>
	</table>
	
	</div>
	<!-- TABLE DETAIL EOF -->
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:500px; height:250px; padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveLocations()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->

<!-- Dialog Form -->
<div id="dialog-adjusment" class="easyui-dialog" style="width:500px; height:300px; padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-adjusment">
</div>
<div id="dialog-buttons-adjusment">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveLocations()">Adjusted</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-adjusment').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->

<!-- TOOLBAR -->
<div id="toolbar-master" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createLocations()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateLocations()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeLocations()">Delete</a>
	<?php //} ?>
</div>
<!-- TOOLBAR EOF -->

<!-- TOOLBAR DETAIL -->
<div id="toolbar-detail" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:125px" onclick="createAdjustment()">Addjustment</a>
	<?php //} ?>
</div>
<!-- TOOLBAR DETAIL EOF -->
<?php $this->endSection() ?>