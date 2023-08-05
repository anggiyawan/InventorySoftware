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
</script>
<style>
.window-proxy-mask, .window-mask {
	background: #444;
}
</style>
<!-- Dialog Form -->
<form id="form" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="locationId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>ID Number</label>
		</div>
		<div>
			<input type="text" name="locationName" class="easyui-textbox" required="true" size="30" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Date</label>
		</div>
		<div>
			<input name="locationTransferDate" class="easyui-datebox" size="30" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
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
            <input name="sourceLocation" id="sourceLocation" required="true" class="easyui-combogrid" style="width:140px;" data-options="
							label: 'Source Location',
							labelPosition: 'top',
							prompt: 'Source Location',
							panelWidth: 500,
							idField: 'locationId',
							textField: 'locationName',
							editable: true,
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
								// reset
								$('#unit').val('Pcs');
							},
							fitColumns: true
						">
		</span>
		<span style="margin:50px">
		</span>
		<span style="display:inline-block">
			<input name="destinationLocation" id="destinationLocation" required="true" class="easyui-combogrid" style="width:140px;" data-options="
							label: 'Destination Location',
							labelPosition: 'top',
							prompt: 'Destination Location',
							panelWidth: 500,
							idField: 'locationId',
							textField: 'locationName',
							editable: true,
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
								// reset
								$('#unit').val('Pcs');
							},
							fitColumns: true
						">
						
		</span>
	</div>
</form>
<!-- Dialog Form EOF -->
<div style="padding: 30px 10px 10px 10px;">
<table id="datagrid-detail" class="easyui-datagrid" style="height:200px;" fit="false" toolbar="#toolbar-detail" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
	<thead>
		<tr>
			<th field="salesOrderNumber" width="120" sortable="true">Product Number</th>
			<th field="productId" width="250" sortable="true">Product Name</th>
			<th field="productNumber" width="200" sortable="true">Current Availability</th>
			<th field="productName" width="120" sortable="true">Transfer Quantity</th>
		</tr>
	</thead>
</table>
</div>

<!-- TOOLBAR -->
<div id="toolbar-detail" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createTransfers()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateTransfers()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeTransfers()">Delete</a>
	<?php //} ?>
</div>
<!-- TOOLBAR EOF -->