<!-- Dialog Form -->
<form id="form-add" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="locationTransferDetailId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Product</label>
		</div>
		<div>
			<input name="productId" id="productId" required="true" class="easyui-combogrid" style="width:220px;" data-options="
							panelWidth: 500,
								editable: true,
                                idField:'productId',
                                textField:'productName',
                                method:'get',
                                url:'<?php echo base_url('combogrid/combogridProductsByStockLocation?source=' . $source . '&destination=' . $destination . ''); ?>',
                                required:true,
								columns: [[
									{field:'productNumber',title:'ID',width:200},
									{field:'productName',title:'Product Name',width:200},
									{field:'sourceStock',title:'Source Stock',width:120},
									{field:'destinationStock',title:'Destination Stock',width:120}
								]],
								onSelect: function(index, value){
									// var rows = $('#datagrid-detail').edatagrid('getSelected');
									// if (rows){
									  // var indexs = $('#datagrid-detail').edatagrid('getRowIndex', rows);
									  // alert(rows);
									  // $('#datagrid-detail').edatagrid('updateRow', {index: indexs,row:{productStock:row.stockPhyHand}});
									  // $('#datagrid-detail').datagrid('reload');
									  $('#sourceStock').val(value.sourceStock);
									  $('#destinationStock').val(value.destinationStock);
									  
									  // $('#transferQuantity').numberbox('options').max = 10; //parseInt(value.sourceStock);
									// }
								},
							fitColumns: true
						">
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Source Stock</label>
		</div>
		<div>
			<input type="text" name="sourceStock" id="sourceStock" readonly class="easyui-validatebox" style="background-color: #eee;width:140px" validType='length[0,255]'/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Destination Stock</label>
		</div>
		<div>
			<input type="text" name="destinationStock" id="destinationStock" readonly class="easyui-validatebox" style="background-color: #eee;width:140px" validType='length[0,255]'/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Transfer Quantity</label>
		</div>
		<div>
			<input name="transferQuantity" id="transferQuantity" class="easyui-numberspinner" style="width:140px"/>
		</div>
	</div>
</form>
<!-- Dialog Form EOF -->