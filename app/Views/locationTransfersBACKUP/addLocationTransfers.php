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
	
	function createTransfers(){
		$('#dialog-add').dialog({
			closed:false,
			iconCls:'icon-add',
			title:'Add Data',
			// href:'../locationtransfers/formLocationDetailsss',
			onLoad:function(){
				$('#form').form('disableValidation');
				// url = "<?php echo base_url('locationtransfers/createLocationTransfers'); ?>";
			}

		});
	}
	$('#datagrid-detail').edatagrid({
	   url: "<?php echo base_url('locationtransfers/getJsonDetailsTemp'); ?>",
	   saveUrl: "<?php echo base_url('locationtransfers/createLocationTransferDetails/' . $action); ?>",
	   updateUrl: 'modules/loanhistory/update_loanhistory.php',
	   destroyUrl: 'modules/loanhistory/delete_loanhistory.php',
	   onError: function(index, row){
			alert(row.msg)
		}
	   // onBeginEdit: function(index,row){
		   // alert('test');
                // var ed = $(this).datagrid('getEditor',{index:index,field:'defect'});
                // $(ed.target).numberbox('setValue', 0)
            
      
            // },
	});
	function addNewRow(index){
        // var row = $('#dgrid_loanapp').datagrid('getSelected');
        // if (row){
        $('#datagrid-detail').edatagrid('addRow');     
        // }
    }
	
function removeTransfers(){
	var dg = $('#datagrid-detail');
	  var row = dg.datagrid('getSelected');
	  if(row){
		  var row_index = dg.datagrid('getRowIndex', row);
		  dg.datagrid('deleteRow', row_index);	  
		
		$('#datagrid-master').datagrid('reload');
							$.messager.show({
								title:'INFO',
								msg:'Success Delete',
								timeout:5000,
								showType:'slide'
							});
	  }
	  
	// var row = jQuery('#datagrid-master').datagrid('getSelected');
	// if (row){
		// jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			// if (r){
				// $.ajax({
					// url: "<?php echo base_url('salesorders/deleteSalesOrders'); ?>",
					// dataType: 'json',
					// type: 'post',
					// contentType: 'application/json',
					// data: { "salesOrderId": row.salesOrderId },
					// processData: true,
					// success: function( data, textStatus, jQxhr ){
						// if(data.status == "success"){
						// jQuery('#dialog-form').dialog('close');
						// jQuery('#datagrid-master').datagrid('reload');
							// $.messager.show({
								// title:'INFO',
								// msg:data.msg,
								// timeout:5000,
								// showType:'slide'
							// });
							
					// } else {
						// jQuery.messager.show({
							// title: 'Error',
							// msg: data.msg
						// });
					// }
					// },
					// error: function( jqXhr, textStatus, errorThrown ){
						// console.log( errorThrown );
					// }
				// });
			// }
		// });
	// }
}
</script>
<script type="text/javascript">
        var editIndex = undefined;
        function endEditing(){
			alert('endEditing');
            if (editIndex == undefined){return true}
            if ($('#dg').datagrid('validateRow', editIndex)){
                $('#dg').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }
        function onClickCell(index, field){
            if (editIndex != index){
                if (endEditing()){
                    $('#dg').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dg').datagrid('getEditor', {index:index,field:field});
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndex = index;
                } else {
                    setTimeout(function(){
                        $('#dg').datagrid('selectRow', editIndex);
                    },0);
                }
            }
        }
        function onEndEdit(index, row){
            var ed = $(this).datagrid('getEditor', {
                index: index,
                field: 'productid'
            });
            row.productname = $(ed.target).combobox('getText');
        }
        function append(){
            if (endEditing()){
                $('#dg').datagrid('appendRow',{status:'P'});
                editIndex = $('#dg').datagrid('getRows').length-1;
                $('#dg').datagrid('selectRow', editIndex)
                        .datagrid('beginEdit', editIndex);
            }
        }
        function removeit(){
            if (editIndex == undefined){return}
            $('#dg').datagrid('cancelEdit', editIndex)
                    .datagrid('deleteRow', editIndex);
            editIndex = undefined;
        }
        function acceptit(){
            if (endEditing()){
                $('#dg').datagrid('acceptChanges');
            }
        }
        function reject(){
            $('#dg').datagrid('rejectChanges');
            editIndex = undefined;
        }
        function getChanges(){
            var rows = $('#dg').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
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
								var src = $('#sourceLocation').textbox('getValue');
								var dest = $('#destinationLocation').textbox('getValue');
								
								if (src != '' && dest != '') {
									if (src == dest) {
										
										$.messager.show({
											title: 'Error',
											msg: 'Please select another location'
										});
										$('#sourceLocation').combogrid('setValue', '');
										
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
			<input name="destinationLocation" id="destinationLocation" required="true" class="easyui-combogrid" style="width:140px;" data-options="
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
								var src = $('#sourceLocation').textbox('getValue');
								var dest = $('#destinationLocation').textbox('getValue');

								if (src == dest) {
										
									$.messager.show({
										title: 'Error',
										msg: 'Please select another location'
									});
									$('#destinationLocation').combogrid('setValue', '');
									
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
<script>
// $(function(){
	// $('#datagrid-detail').datagrid({
		// onBeforeEdit: function(index,row){
			// var col = $(this).datagrid('getColumnOption', 'productId');
			// col.editor = {
				// type:'combobox',
				// options:{
					// valueField:'productId',
					// textField:'productName',
					// method:'get',
					// url:"<?php echo base_url('combogrid/combogridProducts'); ?>",
					// required:true,
					// value: row.productid,
					// onChange: function(value){
						// var dg = $('#datagrid-detail');
						// var row = dg.datagrid('getSelected');
						// var rowIndex = dg.datagrid('getRowIndex', row);
						// var ed = dg.datagrid('getEditor', {index:rowIndex,field:'attr1'});
						// var text = $(ed.target).textbox('getValue');
						// alert(text)
					// }
				// }
			// }
		// }
	// })
// });
</script>
<div style="padding: 30px 10px 10px 10px;">
<table id="datagrid-detail" class="easyui-edatagrid" url='' style="height:300px;" fit="false" toolbar="#toolbar-detail" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
	<thead>
		<tr>
			<th field="productId" editor="textbox" hidden="false" style="background-color: #eee" width="110" sortable="true" class="easyui-validatebox">ProductId</th>
			<th field="productNumber" style="background-color: #eee" width="110" sortable="true" class="easyui-validatebox"
			data-options="{
				editor:{
					type:'textbox',
					options:{
						readonly:true
					},
				},
				styler: function cellStyler(value,row,index){
							return 'font-weight:bold;background-color: #ccc';
					}
				}">Product Number</th>
			<th field="productName" width="250" sortable="true"
			data-options="width:600,
                        editor:{
                            type:'combogrid',
                            options:{
								panelWidth: 500,
								editable: false,
                                idField:'productName',
                                valueField:'productId',
                                textField:'productName',
                                method:'get',
                                url:'<?php echo base_url('combogrid/combogridProductsByStockLocation?source=100001&destination=100002'); ?>',
                                required:true,
								columns: [[
									{field:'productNumber',title:'ID',width:200},
									{field:'productName',title:'Product Name',width:200},
									{field:'stockPhyHand',title:'Stock',width:120}
								]],
								onSelect: function(index,rowCombogrid){
									// var rows = $('#datagrid-detail').edatagrid('getSelected');
									// if (rows){
									  // var indexs = $('#datagrid-detail').edatagrid('getRowIndex', rows);
									  // alert(rows);
									  // $('#datagrid-detail').edatagrid('updateRow', {index: indexs,row:{productStock:row.stockPhyHand}});
									  // $('#datagrid-detail').datagrid('reload');
									 
									// }
									
									
									$('#sourceLocation').combogrid('disable');
									$('#destinationLocation').combogrid('disable');
									
									var dg = $('#datagrid-detail');
									var row = dg.datagrid('getSelected');
									var rowIndex = dg.datagrid('getRowIndex', row);
									
									var ed = dg.datagrid('getEditor', {index:rowIndex,field:'productId'});
									$(ed.target).textbox('setValue', rowCombogrid.productId);
									
									var ed = dg.datagrid('getEditor', {index:rowIndex,field:'sourceStock'});
									$(ed.target).textbox('setValue', rowCombogrid.sourceStock);
									
									var ed = dg.datagrid('getEditor', {index:rowIndex,field:'destinationStock'});
									$(ed.target).textbox('setValue', rowCombogrid.destinationStock);
									
									var ed = dg.datagrid('getEditor', {index:rowIndex,field:'productNumber'});
									$(ed.target).textbox('setValue', rowCombogrid.productNumber);
									
									// int sourceStock = rowCombogrid.sourceStock;
									var ed = dg.datagrid('getEditor', {index:rowIndex,field:'transferQuantity'});
									$(ed.target).numberbox('options').max = parseInt(rowCombogrid.sourceStock);
									// $(ed.target).textbox('textbox').attr('maxlength', 2);
									// .textbox({
									  // required: true,
									  // validType: 'maxlength[0,parseInt(rowCombogrid.sourceStock)]'
									// });
									// alert(rowCombogrid.sourceStock);
								},
                            }
                        }">Product Name</th>
						
			<th field="sourceStock" id="sourceStock" data-options="{
				editor:{
					type:'textbox',
					options:{
						readonly:true
					},
				},
				styler: function cellStyler(value,row,index){
						return 'font-weight:bold;background-color: #ccc';
					}
				}" width="120" sortable="true">Source Stock</th>
				
			<th field="destinationStock" editor="{type:'numberbox',options:{readonly:true,required:true,precision:0}}" width="140" sortable="true"
			data-options="{
				editor:{
					type:'textbox',
					options:{
						readonly:true
					},
				},
				styler: function cellStyler(value,row,index){
						return 'font-weight:bold;background-color: #ccc';
					}
				}">Destination Stock</th>
			<th field="transferQuantity" id="transferQuantity" editor="{type:'textbox',options:{required:true,precision:0}}" width="120" sortable="true">Transfer Quantity</th>
		</tr>
	</thead>
</table>
</div>

<!-- Dialog Add -->
<div id="dialog-add" class="easyui-dialog" data-options="iconCls:'icon-save',modal:true" style="width:450px;height:450px; padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-add">
</div>
<div id="dialog-buttons-add">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveLocationTransfers()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-add').dialog('close')">Batal</a>
</div>
<!-- Dialog Add Eof -->

<!-- TOOLBAR -->
<div id="toolbar-detail" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" data-options="disabled:true" class="easyui-linkbutton" id="location-add" iconCls="icon-add" style="width:100px" onclick="addNewRow()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<!--<a href="javascript:void(0)" data-options="disabled:true" class="easyui-linkbutton" id="location-update" iconCls="icon-edit" style="width:100px" onclick="updateTransfers()">Edit</a>-->
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" data-options="disabled:true" class="easyui-linkbutton" id="location-delete" iconCls="icon-cancel" style="width:100px" onclick="removeTransfers()">Delete</a>
	<?php //} ?>
</div>
<!-- TOOLBAR EOF -->
			