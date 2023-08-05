<form id="ff" method="post" action="" novalidate>
	<input type="hidden" id="menuTypeId" name="menuTypeId" value="<?php echo $menuTypeId ?>">
	<input type="hidden" id="menuId" name="menuId" value="<?php //echo $menu_type ?>">
	<div style="margin-bottom:10px">
		<input type="text" id="menu" name="menu" class="easyui-textbox" required="true" size="30" maxlength="50" value="" data-options="label:'Menu:',required:true"/>
	</div>
	<div style="margin-bottom:10px">
		<input type="text" id="title" name="title" class="easyui-textbox" id="password" required="true" size="30" maxlength="50" value="" data-options="label:'Menu Title:',required:true"/>
	</div>
	<div style="margin-bottom:10px">
			
		<!--<input type="text" id="icon" name="icon" class="easyui-textbox" id="icon" required="true" size="30" maxlength="50" value="<?php echo $menu->icon ?>" data-options="label:'Icon:',required:true"/>-->
		<input class="easyui-combogrid" name="icon" value="" id="icon" style="width:235px" data-options="label:'Icon:',required:true,
							panelWidth: 450,
							idField: 'description',
							textField: 'description',
							editable: false,
							url: '<?php echo base_url('menu/getIconMenu/'); ?>',
							method: 'post',
							columns: [[
								{field:'id',title:'ID',width:25},
								{field:'description',title:'Images',width:220,align:'right'},
								{field:'img',title:'Image',width:80,align:'right',
									formatter: function(value){
										return '<img src=<?php echo base_url('assets/images/icons/'); ?>/'+value+' width=80>';
									}
								}
									
								
							]],
							fitColumns: true
						">
	</div>
	<div style="margin-bottom:10px">
		<input id="base_url" name="base_url" class="easyui-textbox" size="35" maxlength="50" value="<?php echo base_url() ?>" placeholder="<?php echo base_url() ?>" data-options="disabled:true,label:'Url:'"/>
		<input id="url" name="url" class="easyui-textbox" size="15" maxlength="50" value="" placeholder="<?php echo base_url() ?>" data-options="required:true, validType:'length[0,50]'"/>
	</div>
	
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='view' id='view'><label> View</label>
	</div>
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='created' id='created'><label> Created</label>
	</div>
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='updated' id='updated'><label> Updated</label>
	</div>
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='cancelled' id='cancelled'><label> Cancelled</label>
	</div>
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='deleted' id='deleted'><label> Deleted</label>
	</div>
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='printed' id='print'><label> Printed</label>
	</div>
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='downloaded' id='downloaded'><label> Downloaded</label>
	</div><!--
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='uploaded' id='uploaded'><label> Uploaded</label>
	</div>-->
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='closed' id='closed'><label> Closed</label>
	</div>
	<div style="margin-bottom:0px">
		<input type='checkbox' class="easyui-checkbox" name='verified' id='verified'><label> Verified</label>
	</div>
	
</form>