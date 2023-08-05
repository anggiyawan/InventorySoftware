<!-- Dialog Form -->
<form id="form-add" method="post" novalidate>
<input type="hidden" name="salesOrderDetailId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>

<table class="table2" width="100%">
<tbody>
	<tr>
		<td>
			<label>Product</label>
		</td>
		<td>:</td>
		<td>
			<input name="productId" id="productId" required="true" class="easyui-combogrid" style="width:235px;" data-options="
							panelWidth: 600,
							idField: 'productId',
							textField: 'productName',
							editable: true,
							url: '<?php echo $urlProductId ?>',
							mode: 'remote',
							formatter:function(value,row){
                                // return row.productId;
                            },
							columns: [[
								{field:'productId',title:'ID',width:70},
								{field:'productNumber',title:'Product Number',width:200},
								{field:'productName',title:'Product Name',width:250},
								{field:'unit',title:'Unit',width:45},
								{field:'amount',title:'Sell Price',width:115},
								{field:'priceSell',title:'Sell Price',width:115,hidden:true},
							]],
							onSelect: function(index,row){
								// reset
								$('#unit').val('Pcs');
								$('#quantity').textbox('setValue', '');
								$('#priceSell').val(0);
								$('#priceAmount').val(0);
								
								$('#unit').val(row.unit);
								$('#priceSell').val(row.priceSell);
							},
							fitColumns: true
						">
		</td>
	</tr>
	<tr>
		<td>
			<label>Quantity</label>
		</td>
		<td>:</td>
		<td>
			<input type="text" name="quantity" id="quantity" onfocusout="calcAmount()" class="easyui-numberspinner " style="width:120px;" required="true" size="30" min="1"
						data-options="
						min:1,
						max:999999"/>
		</td>
	</tr>
	<tr>
		<td>
			<label>Unit</label>
		</td>
		<td>:</td>
		<td>
			<input type="text" name="unit" id="unit" readonly style="background-color: #eee" class="easyui-validatebox" required="true" style="width:20px;" maxlength="25" validType='length[0,25]'/>
		</td>
	</tr>
	<tr>
		<td>
			<label>Sell Price</label>
		</td>
		<td>:</td>
		<td>
			<input type="text" name="priceSell" id="priceSell" readonly style="background-color: #eee" class="easyui-validatebox" required="true" style="width:100px;" maxlength="25" validType='length[0,25]'/>
		</td>
	</tr>
</tbody>
</table>

</form>
<!-- Dialog Form EOF -->