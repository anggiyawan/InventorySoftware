<!-- Dialog Form -->
<style>fieldset{border:2px solid #ddd;border-radius:6px;padding:6px;margin-bottom:1px}legend{font-weight:bold;border-radius:6px;border:2px solid #ddd;padding:8px;margin-bottom:8px}</style>
<form id="form" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="productId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right;">
			<label>Product Type</label>
		</div>
		<div>
			<input name="productType" id="productType" required="true" class="easyui-combogrid" style="width:150px;" data-options="
					panelWidth: 150,
					idField: 'id',
					textField: 'name',
					editable: false,
					url: '<?php echo base_url('combogrid/combogridProductType/type'); ?>',
					mode: 'remote',
					columns: [[
						{field:'name',title:'Type',width:40},
					]],
					fitColumns: true
				">
		</div>
	</div>
	<div class="form-item" style="padding-top:16px">
		<div style="float:left;width:130px;align:right">
			<label>Product Number</label>
		</div>
		<div>
			<input type="text" name="productNumber" <?php if ($action == "update") { echo "readonly"; } ?> class="easyui-textbox" style="width:270px;" required="true" size="30" maxlength="50" validType='length[0,50]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Product Name</label>
		</div>
		<div>
			<input type="text" name="productName" class="easyui-textbox" style="width:270px;" required="true" size="30" maxlength="50" validType='length[0,50]'/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Price (Cost)</label>
		</div>
		<div>
			<input type="text" name="priceCost" class="easyui-numberspinner" required="true" style="width:150px;" min="0" validType='length[0,35]' data-options="min:0,max:99999999"/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Price (Sell)</label>
		</div>
		<div>
			<input type="text" name="priceSell" class="easyui-numberspinner" required="true" style="width:150px;" min="0" validType='length[0,35]' data-options="min:0,max:99999999"/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Dimensions (cm)</label>
		</div>
		<div>
            <input class="easyui-numberspinner" type="text" name="length" style="width:80px;" data-options="prompt:'Length',validType:'length[0,4]'"> x 
			<input class="easyui-numberspinner" type="text" name="width" style="width:80px;" data-options="prompt:'Width',validType:'length[0,4]'"> x
			<input class="easyui-numberspinner" type="text" name="height" style="width:80px;" data-options="prompt:'Height',validType:'length[0,4]'">
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Weight (kg)</label>
		</div>
		<div>
			<input type="text" name="weight" class="easyui-numberspinner" required="true" style="width:150px;" min="0" validType='length[0,35]' data-options="min:0,max:9999"/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Unit</label>
		</div>
		<div>
			<input name="unit" id="unit" required="true" class="easyui-combogrid" style="width:150px;" data-options="
					panelWidth: 150,
					idField: 'name',
					textField: 'name',
					editable: false,
					url: '<?php echo base_url('combogrid/combogridUnit'); ?>',
					mode: 'remote',
					columns: [[
						{field:'name',title:'Unit',width:40},
					]],
					fitColumns: true
				">
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:130px;align:right">
			<label>Status</label>
		</div>
		<div>
			<select name='statusId' class="easyui-combobox" required="true" editable="false" style="width:150px" required="true">
				<option value='1'>Aktif</option>
				<option value='2'>Disable</option>
			</select>
		</div>
	</div>
	
	<?php if ($action == "create") { ?>
	<fieldset style="background-color: #eee;margin-top:20px">
        <legend>Data Stock</legend>
		
		<div class="form-item" style="padding-top:8px">
			<div style="float:left;width:130px;align:right">
				<label>Open Stock</label>
			</div>
			<div>
				<input type="number" name="productOpenStock" value="0" class="easyui-textbox" style="width:120px" maxlength="50" validType='length[0,50]'/>
			</div>
		</div>
		
		<div class="form-item" style="padding-top:8px">
			<div style="float:left;width:130px;align:right">
				<label>Location</label>
			</div>
			<div>
				<input name="locationId" id="locationId" class="easyui-combogrid" style="width:120px;" data-options="
					panelWidth: 250,
					idField: 'locationId',
					textField: 'locationName',
					editable: true,
					url: '<?php echo base_url('combogrid/combogridLocations'); ?>',
					mode: 'remote',
					columns: [[
						{field:'locationId',title:'ID',width:25},
						{field:'locationName',title:'Location Name',width:40},
					]],
					fitColumns: true
				">
			</div>
		</div>
	
	</fieldset>
	<?php } ?>
</form>
<!-- Dialog Form EOF -->