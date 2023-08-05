<!-- Dialog Form -->
<form id="form-add" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="deliveryOrderDetailId" id="deliveryOrderDetailId"/>
		<input type="hidden" name="salesOrderDetailId" id="salesOrderDetailId"/>
		<input type="hidden" name="sourceLocationId" id="sourceLocationId" value="<?php echo $sourceLocationId; ?>"/>
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
                                url:'<?php echo $urlProductId; ?>',
                                required:true,
								columns: [[
									{field:'productNumber',title:'ID',width:200},
									{field:'productName',title:'Product Name',width:300},
									{field:'salesOrderNumber',title:'Sales Order No',width:140},
									{field:'quantity',title:'Ordered',width:120},
									{field:'delivered',title:'Delivered',width:120},
								]],
								onSelect: function(index, value){
									  $('#salesOrderDetailId').val(value.salesOrderDetailId);
									  $('#ordered').val(value.quantity);
									  $('#delivered').val(value.delivered);
									  $('#stockPhy').text(value.stockPhy);
									  
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
			<label>Delivered</label>
		</div>
		<div>
			<input name="delivered" required="true" id="delivered" readonly class="easyui-validatebox" style="background-color: #eee;width:140px" />
		</div>
	</div>
	
	<fieldset>
		<legend>Quantity</legend>
		<div class="" style="height:100px;text-align:right">
		
		<div class="form-item" style="padding-top:8px">
			<div style="float:left;width:130px;align:right">
				<label>Total Quantity</label>
			</div>
			<div>
				<input name="quantity" required="true" id="quantity" class="easyui-numberspinner" style="width:140px"/>
			</div>
		</div>
		
		<div class="form-item" style="padding-top:8px">
			<div style="float:left;width:130px;align:right">
				<label>Stock On Hand</label>
			</div>
			<div>
				<label id="stockPhy" style="display: block;"><?php echo @$stockPhy; ?></label>
			</div>
		</div>
		
		<div class="form-item" style="padding-top:8px">
			<div style="float:left;width:130px">
				<label>Location Available</label>
			</div>
			<div>
				<span class="easyui-linkbutton" style="width:140px;font-size:16px"><?php echo $sourceLocation; ?></span>
			</div>
		</div>
	
		</div>
	</fieldset>
</form>
<!-- Dialog Form EOF -->