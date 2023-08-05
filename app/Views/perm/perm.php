<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
        <!-- #Left Menu -->
		<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
                <form id="form" method="post" novalidate >
				<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
	                <tr>
                        <td colspan="2"  height="10" valign="middle" align="left"></td>
                    </tr>
					
                    <tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">From</td>
                        <td width="100" height="20" valign="middle" align="left">
							<select class="easyui-combogrid" name="groupFrom" id="groupFrom" required="true" style="width:115px" data-options="
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
									fitColumns: true
								">
							</select>
						</td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">To</td>
                        <td width="100" height="20" valign="middle" align="left">
							<select class="easyui-combogrid" name="groupTo" id="groupTo" required="true" style="width:115px" data-options="
									panelWidth: 300,
									idField: 'groupId',
									textField: 'groupName',
									editable: false,
									url: '<?php echo base_url('groups/combogridGroups/'); ?>',
									method: 'post',
									columns: [[
										{field:'groupId',title:'ID',width:50},
										{field:'groupName',title:'Group name',width:80,align:'right'}
									]],
									fitColumns: true
								">
							</select>
						</td>
                    </tr>
					
					
	                <tr>
                        <td colspan="2" height="25" valign="middle" align="center">
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:false" onclick="ToCopy()">Copy</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
                        </td>
                    </tr>
                  

                  </table>
				  </form>
                   <!-- JAVASCRIPT DAN FUNCTION -->
	                <script type="text/javascript">
	                    function myformatter(date) {
	                        var y = date.getFullYear();
	                        var m = date.getMonth() + 1;
	                        var d = date.getDate();
	                        return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
	                    }
	                    function myparser(s) {
	                        if (!s) return new Date();
	                        var ss = (s.split('/'));
	                        var y = parseInt(ss[0], 10);
	                        var m = parseInt(ss[1], 10);
	                        var d = parseInt(ss[2], 10);
	                        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
	                            //return new Date(y, m - 1, d);
	                            return new Date(d, m - 1, y);
	                        } else {
	                            return new Date();
	                        }
	                    }
						function DoBack() {
							document.location.href = "<?php echo base_url() ?>";
						}


						function ToCopy(){
							var groupFrom	= $('#groupFrom').combobox('getValue');
							var groupTo	= $('#groupTo').combobox('getValue');
							
							if ( groupFrom.length === 0 || groupTo.length === 0 ){
								$.messager.show({
									title:'INFO',
									msg:"Belum menentukan group",
									timeout:5000,
									showType:'slide'
								});
							} else {
								$.messager.confirm('Confirm','Are you sure to Copy Permissions ?',function(r){
									if (r){
										saveCopy();
									}
								});	
							}
						}


	                </script>
        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Permissions'" style="background-color:#D7E4F2;">
                <!-- TABLE UTAMA -->
		<div style="height:98%" bgcolor="#3E6DB9">
          
                    <!-- ## CONTENT ##-->
<script>
function OnSelectGrid(index, record){
	$('#datagrid-master').datagrid({
	url: "<?php echo base_url('perm/getJson/'); ?>/" + index
	});
}

function checkClick(menuId, name, groupId) {

	if (groupId == '000000' || groupId == '') {
		$.messager.show({
			title:'INFO',
			msg:"Select one of the Group",
			timeout:5000,
			showType:'slide'
		});
	} else {
	
		var value = document.getElementById(name + menuId);
		if ( value.checked ) { val = 1; } else { val = 0; }

		$.ajax({
			type:'POST',
			url: "<?php echo base_url('perm/updateId'); ?>/" + menuId + "-" + name + "-" + val + "-" + groupId, // this external php file isn't connecting to mysql db
		});
	
	}

}

function saveCopy(){

		$('#form').form('submit',{
		url: "<?php echo base_url('perm/copyGroups'); ?>",
		dataType: "json",
		contentType: "application/json",
		onSubmit: function(){
			
			$('#form').form('enableValidation');
			var groupFrom	= $('#groupFrom').combobox('getValue');
			var groupTo	= $('#groupTo').combobox('getValue');
			
			if ( groupFrom.length === 0 || groupTo.length === 0 ){
				$.messager.show({
					title:'INFO',
					msg:"Belum menentukan group",
					timeout:5000,
					showType:'slide'
				});
				return false;
			}
			if ($(this).form('validate')) {
				$.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});
				return true;
			} else {
				return false;
			}
			
		},
		success: function(result){
			if (result) {
				// var result = eval('('+result+')');
				data = $.parseJSON(result);
				$.messager.progress('close');
				
				if( data.status == "success" ){
					jQuery('#dialog-form').dialog('close');
					jQuery('#datagrid-crud-customer').datagrid('reload');
					$.messager.show({
							title:'INFO',
							msg:"Data Save Success",
							timeout:5000,
							showType:'slide'
						});
				} else {
					jQuery.messager.show({
						title: 'Error',
						msg: data.message
					});
				}
			} else {
				$.messager.progress('close');
				alert('Save Failed');
			}
			
		}
	});
}
</script>
<!-- Data Grid -->
<div id="toolbar">
<div style="padding:10px;">
	Group : 
	<select class="easyui-combogrid" id="groupId" style="width:250px" data-options="
			panelWidth: 300,
			idField: 'groupId',
			textField: 'groupName',
			editable: false,
			url: '<?php echo base_url('groups/combogridGroups/000000'); ?>',
			method: 'post',
			columns: [[
				{field:'groupId',title:'ID',width:50},
				{field:'groupName',title:'Group name',width:80,align:'right'}
			]],
			fitColumns: true,
			onChange: OnSelectGrid
		">
	</select>
	
</div>
</div>
<table id="datagrid-master" class="easyui-datagrid" url="<?php echo base_url('perm/getJson'); ?>/000000" fit="true" toolbar="#toolbar" pagination="false" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true"
data-options="
	onSortColumn: function(){
        //var opts = $(this).datagrid('options');
            // opts.sorting = false;
			// test = $.parseJSON(opts);
			//alert(opts.sortName);
			// opts.sortable  = false;
			//$('#' + opts.sortName + '44').prop('checked', true);
    },
	onDblClickCell:function(index,field,value){
		var row = $(this).datagrid('getSelected');
		var group = $('#groupId').combobox('getValue');
		
		var checked = $('#view' + row.menuId).is(':checked');
		
		if(row.view.length > 0) {
			if (checked)
				$('#view' + row.menuId).prop('checked', false);
			else
				$('#view' + row.menuId).prop('checked', true);
		
			checkClick(row.menuId, 'view', group);
		}
		
		if(row.created.length > 0) {
			if (checked)
				$('#created' + row.menuId).prop('checked', false);
			else
				$('#created' + row.menuId).prop('checked', true);
			
			checkClick(row.menuId, 'created', group);
		}
		
		if(row.updated.length > 0) {
			if (checked)
				$('#updated' + row.menuId).prop('checked', false);
			else
				$('#updated' + row.menuId).prop('checked', true);
			
			checkClick(row.menuId, 'updated', group);
		}

		if(row.cancelled.length > 0) {
			if (checked)
				$('#cancelled' + row.menuId).prop('checked', false);
			else
				$('#cancelled' + row.menuId).prop('checked', true);
			
			checkClick(row.menuId, 'cancelled', group);
		}
		
		if(row.deleted.length > 0) {
			if (checked)
				$('#deleted' + row.menuId).prop('checked', false);
			else
				$('#deleted' + row.menuId).prop('checked', true);
			
			checkClick(row.menuId, 'deleted', group);
		}
		
		if(row.printed.length > 0) {
			if (checked)
				$('#printed' + row.menuId).prop('checked', false);
			else
				$('#printed' + row.menuId).prop('checked', true);
				
			checkClick(row.menuId, 'printed', group);
		}
		
		if(row.downloaded.length > 0) {
			if (checked)
				$('#downloaded' + row.menuId).prop('checked', false);
			else
				$('#downloaded' + row.menuId).prop('checked', true);
				
			checkClick(row.menuId, 'downloaded', group);
		}
		
		// if(row.uploaded.length > 0) {
			// if (checked)
				// $('#uploaded' + row.menuId).prop('checked', false);
			// else
				// $('#uploaded' + row.menuId).prop('checked', true);
				
			// checkClick(row.menuId, 'uploaded', group);
		// }
		
		if(row.closed.length > 0) {
			if (checked)
				$('#closed' + row.menuId).prop('checked', false);
			else
				$('#closed' + row.menuId).prop('checked', true);
			
			checkClick(row.menuId, 'closed', group);
		}
		
		if(row.verified.length > 0) {
			if (checked)
				$('#verified' + row.menuId).prop('checked', false);
			else
				$('#verified' + row.menuId).prop('checked', true);
			
			checkClick(row.menuId, 'verified', group);
		}
		
	},
	onSelect: function(index, row) {
		// $(this).datagrid('unselectRow', index);
	}
	">
			<thead>
		<tr>
			<?php //if ( $this->permissions->superadmin() ) { ?>
				<!--<th field="menuId" width="20" sortable="false">ID</th>
				<th field="url" width="80" sortable="false">URL</th>-->
			<?php //} ?>
			
			<th field="menu" width="150" sortable="false">Menu</th>
			<th field="view" width="45" sortable="false" align="center">View</th>
			<th field="created" width="45" sortable="false" align="center" onclick="verticaltest();">Create</th>
			<th field="updated" width="45" sortable="false" align="center">Update</th>
			<th field="cancelled" width="45" sortable="false" align="center">Cancel</th>
			<th field="deleted" width="45" sortable="false" align="center">Delete</th>
			<th field="printed" width="45" sortable="false" align="center">Print</th>
			<th field="downloaded" width="45" sortable="false" align="center">Download</th>
			<th field="closed" width="45" sortable="false" align="center">Close</th>
			<th field="verified" width="45" sortable="false" align="center">Verify</th>
		</tr>
	</thead>
</table>
<script>
function verticaltest(){
	alert('test123');
}
</script>
				</div>
	                <!-- TABLE TENGAH
					<div style="height:2px;background-color:#3E6DB9;margin:2px">
					</div>
					<!-- TABLE TENGAH EOF -->
				<div style="height:0%" style="border-style: solid;padding:10px">
				</div>


	</div>
<?php $this->endSection() ?>