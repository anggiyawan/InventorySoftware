<script type="text/javascript">
		// $(function(){
			// $('#cc').combogrid({
				// formatter:function(row){
					// var imageFile = 'images/' + row.description;
					// return '<img class="item-img" src="'+imageFile+'"/><span class="item-text">'+row.text+'</span>';
				// }
			// });
		// });
	</script>
	<!-- Dialog Form -->
        <form id="ff" method="post" action="">
		<input type="hidden" id="menuTypeId" name="menuTypeId" value="<?php echo $menu->menuTypeId ?>">
            <div style="margin-bottom:10px">
				<input type="text" id="menuId" name="menuId" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo $menu->menuId ?>" data-options="label:'ID:',required:true, readonly:true, validType:'length[0,10]'"/>
            </div>
			<div style="margin-bottom:10px">
				<input type="text" id="menu" name="menu" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo $menu->menu ?>" data-options="label:'Menu:',required:true, validType:'length[0,100]'"/>
            </div>
            <div style="margin-bottom:10px">
                <input type="text" id="title" name="title" class="easyui-textbox" id="password" required="true" size="30" maxlength="50" value="<?php echo $menu->title ?>" data-options="label:'Menu Title:',required:true, validType:'length[0,100]'"/>
            </div>
			<div style="margin-bottom:10px">
			
				<!--<input type="text" id="icon" name="icon" class="easyui-textbox" id="icon" required="true" size="30" maxlength="50" value="<?php echo $menu->icon ?>" data-options="label:'Icon:',required:true"/>-->
				<input class="easyui-combogrid" name="icon" value="<?php echo $menu->icon ?>" id="icon" style="width:235px" data-options="label:'Icon:',required:true,
									panelWidth: 450,
									idField: 'description',
									textField: 'description',
									editable: false,
									url: '<?php echo base_url('menu/getIconMenu'); ?>',
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
                <input id="base_url" name="base_url" class="easyui-textbox" size="34" maxlength="50" value="<?php echo base_url() ?>" placeholder="<?php echo base_url() ?>" data-options="disabled:true, label:'Url:'"/>
                <input id="url" name="url" class="easyui-textbox" size="15" maxlength="50" value="<?php echo $menu->url ?>" placeholder="<?php echo base_url() ?>" data-options="required:true, validType:'length[0,50]'"/>
            </div>
			
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='view' id='view' <?php echo ($menu->view) ? 'checked' : '' ?>><label> View</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='created' id='created' <?php echo ($menu->created) ? 'checked' : '' ?>><label> Created</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='updated' id='updated' <?php echo ($menu->updated) ? 'checked' : '' ?>><label> Updated</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='cancelled' id='cancelled' <?php echo ($menu->cancelled) ? 'checked' : '' ?>><label> Cancelled</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='deleted' id='deleted' <?php echo ($menu->deleted) ? 'checked' : '' ?>><label> Deleted</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='printed' id='printed' <?php echo ($menu->printed) ? 'checked' : '' ?>><label> Printed</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='downloaded' id='downloaded' <?php echo ($menu->downloaded) ? 'checked' : '' ?>><label> Downloaded</label>
			</div>
			<!--
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='uploaded' id='uploaded' <?php //echo ($menu->uploaded) ? 'checked' : '' ?>><label> Uploaded</label>
			</div>
			-->
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='closed' id='closed' <?php echo ($menu->closed) ? 'checked' : '' ?>><label> Closed</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='verified' id='verified' <?php echo ($menu->verified) ? 'checked' : '' ?>><label> Verified</label>
			</div>
			
        </form>
<!-- Dialog Form EOF -->