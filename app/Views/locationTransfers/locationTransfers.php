<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
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
function ToSearch(){
	var vReffNumber		= $('#vReffNumber').textbox('getValue');
	var vRemark			= $('#vRemark').textbox('getValue');
	var vDate			= $('#vDate').datebox('getValue');

	$('#datagrid-master').datagrid('load',{
		reffNumber: vReffNumber,
		remark: vRemark,
		date: vDate,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;

function createLocationTransfers(){
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		href:'../locationtransfers/formLocationTransfers/create',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('locationtransfers/createLocationTransfers'); ?>";
		}

	});
}

/*
function updateLocationTransfers(){

	var row = jQuery('#datagrid-master').datagrid('getSelected');
	
	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../locationtransfers/formLocationTransfers/' + row.locationTransferId,
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('locationtransfers/updateLocationTransfers'); ?>";
			}
		});	

	}

}
*/

function removeLocationTransfers(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('locationtransfers/deleteLocationTransfers'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "locationTransferId": row.locationTransferId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						$('#dialog-form').dialog('close');
						$('#datagrid-master').datagrid('reload');
						$('#datagrid-details').datagrid('loadData', []);
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

function saveLocationTransfers(){

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
// $('#datagrid-detail').datagrid('readonly');
</script>
<!-- #Left Menu -->
<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
		<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Reff Number</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vReffNumber" id="vReffNumber" size="11" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Remark</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vRemark" id="vRemark" size="11" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Date</td>
				<td width="80" height="20" valign="middle" align="right">
					<input name="vDate" id="vDate" class="easyui-datebox" size="11" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php //echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
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
<div data-options="region:'center',title:'Location Transfer'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
	<table id="datagrid-master" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('locationtransfers/getJson'); ?>" fit="true" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
	data-options="
	onClickCell:function(index,field,value){
		var row = $(this).datagrid('getRows')[index];
		
		$('#datagrid-details').datagrid({
			url: '<?php echo base_url('locationtransfers/getJsonDetails?id=') ?>' + row.locationTransferId
		});
	}
	">
		<thead>
			<tr>
				<th field="reffNumber" width="100" sortable="true">Reff Number</th>
				<th field="transferDate" width="100" sortable="true">Transfer Date</th>
				<th field="inputDate" width="100" sortable="true">Time</th>
				<th field="sourceLocationName" width="120" sortable="true">Source</th>
				<th field="destinationLocationName" width="120" sortable="true">Destination</th>
				<th field="inputUserName" width="80" sortable="true">Input By</th>
				<th field="remark" width="350" sortable="true">Remark</th>
			</tr>
		</thead>
	</table>
	</div>
	<!-- TABLE UTAMA EOF -->
	<!-- TABLE DETAIL -->
	<div style="height:25%" style="border-style: solid;padding:10px">
	
		<table id="datagrid-details" class="easyui-datagrid" style="height:100%" fit="false" toolbar="" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
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
	<!-- TABLE DETAIL EOF -->
</div>
<style type="text/css">
	.window-proxy-mask, .window-mask {
		background: #444;
	}
</style>
<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" data-options="iconCls:'icon-save',modal:true" style="width:850px; padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveLocationTransfers()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->

<!-- TOOLBAR -->
<div id="toolbar-master" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createLocationTransfers()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeLocationTransfers()">Delete</a>
	<?php //} ?>
</div>
<!-- TOOLBAR EOF -->
<?php $this->endSection() ?>