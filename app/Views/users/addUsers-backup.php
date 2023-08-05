<!-- Dialog Form -->
<form id="form" method="post" novalidate >

<table class="table2" width="100%">
	<tbody>
		<tr>
		<td>Harga Jual</td>
		<td>:</td><td>Harga Beli</td>
		<td>:</td>
		<td><input type="text" name="cost_from_mfg" value="7000" id="cost_from_mfg">
	</tr>

</tbody></table>

	<input type="hidden" name="userId" required="true" size="30" maxlength="50" />
	<div class="form-item">
		<input type="hidden" name="userId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Name</label>
		</div>
		<div>
			<input type="text" name="userName" class="easyui-textbox" required="true" size="30" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Fullname</label>
		</div>
		<div>
			<input type="text" name="fullName" class="easyui-textbox" required="true" size="30" maxlength="35" validType='length[0,35]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Email</label>
		</div>
		<div>
			<input type="text" name="email" class="easyui-textbox" required="true" size="30" maxlength="35" validType='length[0,35]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Password</label>
		</div>
		<div>
			<input type="text" name="passwordChange" class="easyui-textbox" size="30" maxlength="50" validType='length[0,50]'/>
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
	
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Group</label>
		</div>
		<div>
		<select class="easyui-combogrid" name="groupId" style="width:235px" required="true" data-options="
				panelWidth: 300,
				idField: 'groupId',
				textField: 'groupName',
				editable: false,
				url: '<?php echo base_url('groups/combogridGroups'); ?>',
				method: 'post',
				columns: [[
					{field:'groupId',title:'ID',width:50},
					{field:'groupName',title:'Group name',width:80,align:'right'}
				]],
				fitColumns: true,
			">
		</select>

<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Change Password</label>
		</div>
		<div>
			<select name='changePassword' class="easyui-combobox" editable="false" style="width:150px" required="true">
				<option value="1">Aktif</option>
				<option value="0">Disable</option>
			</select>
		</div>
	</div>
	</div>
	</div>
	
	
</form>
<!-- Dialog Form EOF -->