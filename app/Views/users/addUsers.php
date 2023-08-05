<!-- Dialog Form -->
<form id="form" method="post" novalidate>
<input type="hidden" name="userId" required="true" size="30" maxlength="50" />

<table class="table2" width="100%">
<tbody>
	<tr>
		<td><label>Name</label></td>
		<td>:</td>
		<td>
			<input type="text" name="userName" class="easyui-textbox" required="true" size="30" maxlength="25" validType='length[0,25]'/>
		</td>
	</tr>
	<tr>
		<td><label>Full Name</label></td>
		<td>:</td>
		<td>
			<input type="text" name="fullName" class="easyui-textbox" required="true" size="30" maxlength="35" validType='length[0,35]'/>
		</td>
	</tr>
	<tr>
		<td><label>Email</label></td>
		<td>:</td>
		<td>
			<input type="text" name="email" class="easyui-textbox" required="true" size="30" maxlength="35" validType='length[0,35]'/>
		</td>
	</tr>
	<tr>
		<td><label>Password</label></td>
		<td>:</td>
		<td>
			<input type="text" name="passwordChange" class="easyui-textbox" size="30" maxlength="50" validType='length[0,50]'/>
		</td>
	</tr>
	<tr>
		<td><label>Status</label></td>
		<td>:</td>
		<td>
			<select name='statusId' class="easyui-combobox" editable="false" style="width:150px" required="true">
				<option value='1'>Aktif</option>
				<option value='2'>Disable</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label>Group</label></td>
		<td>:</td>
		<td>
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
		</td>
	</tr>
	<tr>
		<td><label>Change Password</label></td>
		<td>:</td>
		<td>
			<select name='changePassword' class="easyui-combobox" editable="false" style="width:150px" required="true">
				<option value="1">Aktif</option>
				<option value="0">Disable</option>
			</select>
		</td>
	</tr>

</tbody>
</table>

	
</form>
<!-- Dialog Form EOF -->