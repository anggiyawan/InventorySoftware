<!-- JAVASCRIPT DAN FUNCTION -->
<script type="text/javascript">
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

var urlDetail;

function createTransfers(){
	var source = $('#sourceLocationId').combogrid('getValue');
	var destination = $('#destinationLocationId').combogrid('getValue');
	if (source != '' && destination != '') {
		$('#dialog-add').dialog({
			closed:false,
			iconCls:'icon-add',
			title:'Add Data',
			href:'../locationtransfers/formLocationTransferDetails/<?php echo $action ?>?source=' + source + '&destination=' + destination,
			onLoad:function(){
				$('#form-add').form('disableValidation');
				urlDetail = "<?php echo base_url('locationtransfers/createLocationTransferDetails/' . $action); ?>";
			}

		});
	} else {
		$.messager.show({
			title: 'Error',
			msg: 'Location empty'
		});
	}
}

function updateTransfers(){

	var row = jQuery('#datagrid-detail').datagrid('getSelected');
	
	if(row){

	var source = $('#sourceLocationId').combogrid('getValue');
	var destination = $('#destinationLocationId').combogrid('getValue');
		if (source != '' && destination != '') {
			$('#dialog-add').dialog({
				closed:false,
				iconCls:'icon-edit',
				title:' Update',
				href:'../locationtransfers/formLocationTransferDetails/<?php echo $action ?>?source=' + source + '&destination=' + destination,
				// href:'../locationtransfers/formLocationTransferDetails/create',
				onLoad:function(){

					jQuery('#form-add').form('clear');
					$('#form-add').form('load',row);
					$('#form-add').form('disableValidation');
					urlDetail = "<?php echo base_url('locationtransfers/updateLocationTransferDetails/' . $action); ?>";
				}
			});	
		} else {
			$.messager.show({
				title: 'Error',
				msg: 'Location empty'
			});
		}
	
	}

}

function removeTransfers(){
	var row = jQuery('#datagrid-detail').datagrid('getSelected');
	
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('locationtransfers/deleteLocationTransferDetails/' . $action); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "locationTransferDetailId": row.locationTransferDetailId },
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
								$('#destinationLocationId').combogrid('readonly', false);
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

function saveTransfers(){

	jQuery('#form-add').form('submit',{
		url: urlDetail,
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
					jQuery('#datagrid-detail').datagrid('reload');
						$.messager.show({
							title:'INFO',
							msg:data.msg,
							timeout:5000,
							showType:'slide'
						});
						
						$('#sourceLocationId').combogrid('readonly', true);
						$('#destinationLocationId').combogrid('readonly', true);
						
						$('#location-add').linkbutton('enable');
						$('#location-update').linkbutton('enable');
						$('#location-delete').linkbutton('enable');
						
				} else {
					$.messager.show({
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
<style>
.window-proxy-mask, .window-mask {
	background: #444;
}
</style>
<!-- Dialog Form -->
<form id="form" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="locationTransferId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Reference Number</label>
		</div>
		<div>
			<input type="text" name="reffNumber" readonly class="easyui-validatebox" <?php if ($action == "create") { echo "value='". @$locationTransferNumber . "'"; } ?> style="background-color: #eee" required="true" size="30" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Date</label>
		</div>
		<div>
			<input name="transferDate" class="easyui-datebox" size="30" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
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
			<label>Target</label>
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
								{field:'locationId',title:'ID',width:70},
								{field:'locationName',title:'Location Name',width:200},
								{field:'remark',title:'Remark',width:200},
							]],
							onSelect: function(index,row){
								var src = $('#sourceLocationId').textbox('getValue');
								var dest = $('#destinationLocationId').textbox('getValue');
								
								if (src != '' && dest != '') {
									if (src == dest) {
										
										$.messager.show({
											title: 'Error',
											msg: 'Please select another location'
										});
										$('#sourceLocationId').combogrid('setValue', '');
										
									} else {
									
										$('#location-add').linkbutton('enable');
										$('#location-update').linkbutton('enable');
										$('#location-delete').linkbutton('enable');
										
									}
								}
							},
							fitColumns: true
						">
		</span>
		<span style="margin:50px">
		</span>
		<span style="display:inline-block">
			<input name="destinationLocationId" id="destinationLocationId" <?php if ($action != "create") { echo "disabled"; } ?> required="true" class="easyui-combogrid" style="width:140px;" data-options="
							label: 'Destination Location',
							labelPosition: 'top',
							prompt: 'Destination Location',
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
								{field:'locationId',title:'ID',width:70},
								{field:'locationName',title:'Location Name',width:200},
								{field:'remark',title:'Remark',width:200},
							]],
							onSelect: function(index,row){
								var src = $('#sourceLocationId').textbox('getValue');
								var dest = $('#destinationLocationId').textbox('getValue');

								if (src == dest) {
										
									$.messager.show({
										title: 'Error',
										msg: 'Please select another location'
									});
									$('#destinationLocationId').combogrid('setValue', '');
									
								} else {
								
									$('#location-add').linkbutton('enable');
									$('#location-update').linkbutton('enable');
									$('#location-delete').linkbutton('enable');
									
								}
							},
							fitColumns: true
						">
						
		</span>
	</div>
</form>
<!-- Dialog Form EOF -->
<div style="padding: 30px 10px 10px 10px;">
<table id="datagrid-detail" class="easyui-datagrid" url='<?php echo $urlDatagrid; ?>' style="height:300px;" fit="false" toolbar="#toolbar-detail" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
	<thead>
		<tr>
			<th field="productNumber" width="110" sortable="true" >Product Number</th>
			<th field="productName" width="250" sortable="true">Product Name</th>
			<th field="sourceStock" width="120" sortable="true">Source Stock</th>
			<th field="destinationStock" width="140" sortable="true">Destination Stock</th>
			<th field="transferQuantity" id="transferQuantity" width="120" sortable="true">Transfer Quantity</th>
		</tr>
	</thead>
</table>
</div>

<!-- Dialog Add -->
<div id="dialog-add" class="easyui-dialog" data-options="iconCls:'icon-save',modal:true" style="width:450px;padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-add">
</div>
<div id="dialog-buttons-add">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveTransfers()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-add').dialog('close')">Batal</a>
</div>
<!-- Dialog Add Eof -->

<!-- TOOLBAR -->
<div id="toolbar-detail" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" <?php if ($action == "create") { echo "data-options='disabled:true'"; } ?> class="easyui-linkbutton" id="location-add" iconCls="icon-add" style="width:100px" onclick="createTransfers()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" <?php if ($action == "create") { echo "data-options='disabled:true'"; } ?> class="easyui-linkbutton" id="location-update" iconCls="icon-edit" style="width:100px" onclick="updateTransfers()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" <?php if ($action == "create") { echo "data-options='disabled:true'"; } ?> class="easyui-linkbutton" id="location-delete" iconCls="icon-cancel" style="width:100px" onclick="removeTransfers()">Delete</a>
	<?php //} ?>
</div>
<!-- TOOLBAR EOF -->
			