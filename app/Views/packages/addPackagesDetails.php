<!-- Dialog Form -->
<form id="form-add" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="packageDetailId" id="packageDetailId" required="true"/>
		<input type="hidden" name="salesOrderDetailId" id="salesOrderDetailId" required="true"/>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Product</label>
		</div>
		<div>
			<input name="productId" id="productId" required="true" class="easyui-combogrid" style="width:220px;" data-options="
							panelWidth: 550,
								editable: false,
                                idField:'productId',
                                textField:'productName',
                                method:'post',
                                url:'<?php echo base_url('combogrid/combogridProductsToPackage?salesOrderId=' . $salesOrderId); ?>',
                                required:true,
								columns: [[
									{field:'productNumber',title:'ID',width:200},
									{field:'productName',title:'Product Name',width:300},
									{field:'salesOrderNumber',title:'Sales Order No',width:140},
									{field:'quantity',title:'Ordered',width:120},
									{field:'package',title:'Package',width:120}
								]],
								onSelect: function(index, value){
									  $('#salesOrderDetailId').val(value.salesOrderDetailId);
									  $('#ordered').val(value.quantity);
									  $('#package').val(value.package);
									  
								},
							fitColumns: true
						">
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Ordered</label>
		</div>
		<div>
			<input type="text" name="ordered" id="ordered" readonly class="easyui-validatebox" style="background-color: #eee;width:140px" validType='length[0,255]'/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Package</label>
		</div>
		<div>
			<input type="text" name="package" id="package" readonly class="easyui-validatebox" style="background-color: #eee;width:140px" validType='length[0,255]'/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Quantity To Pack</label>
		</div>
		<div>
			<input name="quantityToPack" required="true" id="quantityToPack" class="easyui-numberspinner" style="width:140px"/>
		</div>
	</div>
</form>
<!-- Dialog Form EOF -->