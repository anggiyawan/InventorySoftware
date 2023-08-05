	<!-- TABLE UTAMA -->
	<div style="height:100%" bgcolor="#3E6DB9">
	<table id="datagrid-location-stock" pageSize="50" pageList="[50,100,150,200]" class="easyui-datagrid" style="height:100%;width:100%" url="<?php echo base_url('products/getJson'); ?>" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="productId" width="80" sortable="true">ID</th>
				<th field="status" width="80" sortable="true">Status</th>
				<th field="productNumber" width="150" sortable="true">Product Number</th>
				<th field="productName" sortable="true">Product Name</th>
				<th field="stockPhyHand" width="100" sortable="true">Physical Stock</th>
				<th field="priceCost" width="100" sortable="true">Price (Cost)</th>
				<th field="priceSell" width="100" sortable="true">Price (Sell)</th>
				<th field="unit" width="80" sortable="true">Unit</th>
				<th field="remark" sortable="true">Remark</th>
			</tr>
		</thead>
	</table>
	</div>
	<!-- TABLE UTAMA EOF -->