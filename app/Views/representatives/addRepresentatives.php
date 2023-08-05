<!-- Dialog Form -->
<form id="form" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="representativeId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Representative</label>
		</div>
		<div>
			<input type="text" name="representative" class="easyui-textbox" required="true" size="30" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Description</label>
		</div>
		<div>
			<input type="text" name="description" class="easyui-textbox" size="30" maxlength="35" validType='length[0,35]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Status</label>
		</div>
		<div>
			<select name='statusId' class="easyui-combobox" editable="false" style="width:150px" required="true">
				<option value='1'>Aktif</option>
				<option value='2'>Disable</option>
			</select>
		</div>
	</div>	
</form>
<!-- Dialog Form EOF -->