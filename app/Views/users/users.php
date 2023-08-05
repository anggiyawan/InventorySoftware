<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>
function ChangeUrl(page, url) {
	if (typeof (history.pushState) != "undefined") {
		var obj = { Page: page, Url: url };
		history.pushState('123', 'test', '?' + url);
	} else {
		alert("Browser does not support HTML5.");
	}
}
	
function ToSearch(){
	// let grid = $("#datagrid-master").datagrid('options').columns;
	// console.log(grid);
	// $('#cc').layout('panel','west').panel('collapse',true); 
	// collapsed="true"

	var vUserName	= $('#vUserName').textbox('getValue');
	var vGorupId	= $('#vGorupId').combobox('getValue');

	const searchURL = new URL(window.location);
	searchURL.searchParams.set('userName', vUserName);
	searchURL.searchParams.set('groupId', vGorupId);
	window.history.pushState({}, '', searchURL);
	
	$('#datagrid-master').datagrid('load',{
		userName: vUserName,
		groupId: vGorupId,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;

function createUser(){
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		href:'../users/formUsers',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('users/createUsers'); ?>";
		}

	});
}

function updateUser(){

	var row = jQuery('#datagrid-master').datagrid('getSelected');

	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../users/formUsers',
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('users/updateUsers'); ?>";
			}
		});

	}

}

function removeUser(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('users/deleteUsers'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "userId": row.userId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						jQuery('#dialog-form').dialog('close');
						jQuery('#datagrid-master').datagrid('reload');
							$.messager.show({
								title:'INFO',
								msg:data.msg,
								timeout:5000,
								showType:'slide'
							});
							
					} else {
						jQuery.messager.show({
							title: 'Error',
							msg: data.msg
						});
					}
					},
					error: function( jqXhr, textStatus, errorThrown ){
						console.log( errorThrown );
					}
				});
			}
		});
	}
}

function saveUser(){

	jQuery('#form').form('submit',{
		url: url,
		onSubmit: function(){
			
			$('#form').form('enableValidation');
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
				// data = (result);
				$.messager.progress('close');
				// alert(data);
				if(data.status == "success"){
					jQuery('#dialog-form').dialog('close');
					jQuery('#datagrid-master').datagrid('reload');
						$.messager.show({
							title:'INFO',
							msg:data.msg,
							timeout:5000,
							showType:'slide'
						});
						
				} else {
					jQuery.messager.show({
						title: 'Error',
						msg: data.msg
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
<!-- #Left Menu -->
<!--<div data-options="region:'west',split:true" id="layout-west" title="Look up &amp; Tools" style="width:200px;">-->
<div data-options="region:'west',split:true" title="Filter&nbsp;workers" style="width:200px"> 
		<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Nama User</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vUserName" id="vUserName" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Group</td>
				<td width="100" height="20" valign="middle" align="left">
					<input name="vGorupId" id="vGorupId" class="easyui-combogrid" style="width:90px;" data-options="
							panelWidth: 250,
							idField: 'groupId',
							textField: 'groupName',
							editable: false,
							url: '<?php echo base_url('groups/combogridGroups/all'); ?>',
							mode: 'remote',
							onSelect: function(){										
								
							},
							columns: [[
								{field:'groupId',title:'ID',width:80},
								{field:'groupName',title:'Group name',width:240,align:'right'}
							]],
							fitColumns: true
						">
				</td>
			</tr>
			
			
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>

			<tr>
				<td colspan="2" height="25" valign="middle" align="center">
					<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="changetheme('gray')">Change</a>-->
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="ToSearch()">Search</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
				</td>
			</tr>
		  

		  </table>
		  
</div>


<!-- #Body -->
<div data-options="region:'center',title:'Master Users'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
		<table id="datagrid-master" class="easyui-datagrid" style="height:100%" data-options="loadFilter: loadFilter, toolbar: '#toolbar-master', url:'<?php echo base_url('users/getJson'); ?>'"></table>
	</div>
	<!-- TABLE UTAMA EOF -->
	<!-- TABLE DETAIL -->
	<div style="height:25%" style="border-style: solid;padding:10px">
		<table id="datagrid-detail" class="easyui-datagrid" style="height:100%" data-options="loadFilter: loadFilter, url:'<?php echo base_url('users/getJson'); ?>'"></table>
	</div>
	<!-- TABLE DETAIL EOF -->
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:500px; height:400px; padding: 10px 10px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->

<!-- TOOLBAR -->
<div id="toolbar-master" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createUser()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateUser()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeUser()">Delete</a>
	<?php //} ?>    
</div>
<!-- TOOLBAR EOF -->

<div id="mm" class="easyui-menu" noline="true" minWidth="30" data-options="hideOnUnhover:true,inline:true" style="width:120px;display:none">
	<div data-options="name:'refresh',iconCls:'icon-reload'">Refresh</div>
	<div data-options="name:'fitColumns',iconCls:'icon-fitcolumn'">Fit Columns</div>
	<div data-options="name:'save',iconCls:'icon-save'">Save</div>
	<div data-options="name:'print',iconCls:'icon-print'">Print</div>
	<div class="menu-sep"></div>
	<div data-options="name:'exit'">Exit</div>
</div>
<script>
// function menuHandler(item){
	// console.log('<p>Click Item: '+item.name+'</p>');
// }
</script>

<script type="text/javascript">
var createGridHeaderContextMenu = function(e, field) {
    e.preventDefault();
    var grid = $(this);/* The grid itself */
    var headerContextMenu = this.headerContextMenu;/* Column header menu object on Grid */
    var okCls = 'tree-checkbox1';//Selected
    var emptyCls = 'tree-checkbox0';//Cancel
    if (!headerContextMenu) {
        var tmenu = $('<div style="width:180px;"></div>').appendTo('body');
        var fields = grid.datagrid('getColumnFields');
        for ( var i = 0; i <fields.length; i++) {
            var fildOption = grid.datagrid('getColumnOption', fields[i]);
            if (!fildOption.hidden) {
                $('<div iconCls="'+okCls+'" field="' + fields[i] + '"/>').html('<span style="font-size:14px">'+fildOption.title+'</span>').appendTo(tmenu);
            } else {
                $('<div iconCls="'+emptyCls+'" field="' + fields[i] + '"/>').html('<span style="font-size:14px">'+fildOption.title+'</span>').appendTo(tmenu);
            }
        }
        headerContextMenu = this.headerContextMenu = tmenu.menu({
            onClick : function(item) {
                var field = $(item.target).attr('field');
                if (item.iconCls == okCls) {
                    grid.datagrid('hideColumn', field);
                    $(this).menu('setIcon', {
                        target : item.target,
                        iconCls : emptyCls
                    });
                } else {
                    grid.datagrid('showColumn', field);
                    $(this).menu('setIcon', {
                        target : item.target,
                        iconCls : okCls
                    });
                }
            }
        });
    }
    headerContextMenu.menu('show', {
        left : e.pageX,
        top : e.pageY
    });
};
$.fn.datagrid.defaults.onHeaderContextMenu = createGridHeaderContextMenu;

(function( $ ){
// Klik kanan
$.fn.myfunction = function (params = '') {
	
	var params = $.extend({
		urlSave	: '',
		datagridId		: "#" + this[0].id
	},params);
	
	// var datagridId = "#" + this[0].id;
	$('#mm').menu({
		onClick:function(item){
			let grid = $(params.datagridId).datagrid('options').columns[0];
			if(item.name == 'fitColumns') {
				console.log(params.datagridId);
				for(var i=0; i<grid.length; i++){ 
					var field = grid[i];
					$(params.datagridId).datagrid('autoSizeColumn', field.field);
				}
				
			} else
			if(item.name == 'refresh') {
				$(params.datagridId).datagrid('reload');
			} else
			if(item.name == 'save') {
				saved(grid);
			} else
			if(item.name == 'print') {
				$(params.datagridId).datagrid('hideColumn', 'userId');
			}
			$('#mm').menu('hide');
		}
	});
	
	function saved(grid) {
		$.ajax({
			url: alertss.urlSave,
			dataType: 'json',
			type: 'post',
			data: { "grid": JSON.stringify(grid) },
			processData: true,
			success: function( data, textStatus, jQxhr ){
				if(data.status == "success"){
					$.messager.show({
						title:'INFO',
						msg:data.msg,
						timeout:5000,
						showType:'slide'
					});
					
			} else {
				jQuery.messager.show({
					title: 'Error',
					msg: data.msg
				});
			}
			},
			error: function( jqXhr, textStatus, errorThrown ){
				console.log( errorThrown );
			}
		});
	}
}
})( jQuery );


// $("#datagrid-detail").myfunction({
    // urlSave : "<?php echo base_url('users/grid'); ?>"
// });

// $("#datagrid-master").myfunction({
    // urlSave : "<?php echo base_url('users/grid'); ?>"
// });

</script>
<?php $this->endSection() ?>