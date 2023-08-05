<?php $uri = service('uri'); // load uri segment ?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<script type="text/javascript">
var url;
$('#ff').form('disableValidation');

function create_menu(id){	
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-edit ',
		title:'Add Data',
		href:"<?php echo base_url('menu/addMenu') ?>/" + id,
		onLoad:function(){
		}
	});
	
	$('#ff').form('disableValidation');
	
	$('#ff').form('clear');
	
	// $('#ff').form('clear');
	// $('#base_url').textbox('setText', '<?php echo base_url() ?>');
}

function updateMenu(id){
	$('#form').form('disableValidation');
	
	$('#form').form('clear');
	
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-edit ',
		title:'Update Data',
		href:"<?php echo base_url('menu/editMenu') ?>/" + id,
		onLoad:function(){
		}
	});
}

function deleteMenu(id){
	$.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
		if (r){
			$.post("<?php echo base_url('menu/deleteMenu'); ?>",{menuId:id},function(result){
				
				if (result.status == "success"){
					onload_menu();
					
					jQuery.messager.show({
						title: 'Info',
						msg: result.message
					});
				} else {
					jQuery.messager.show({
						title: 'Error',
						msg: result.message
					});
				}
			},'json');
		}
	});
}

function submitForm(){

	$('#ff').form('submit',{
		url: "<?php echo base_url('menu/menuSave') ?>",
		dataType: "json",
		contentType: "application/json; charset=utf-8",
		onSubmit: function(){
			
			$(this).form('enableValidation');
			if ($(this).form('validate')) {
				$.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});
				
				setTimeout(function(){
					$.messager.progress('close');
				}, 20000);
				
				return true;
			} else {
				return false;
			}
			
		},
		success: function(result){
			if (result) {
				data = $.parseJSON(result);
				
				if( data.status == "success" ){
					
					// DoBack();
					onload_menu();
					$('#dialog-form').dialog('close');
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
				
				$.messager.progress('close');
			} else {
				$.messager.progress('close');
				alert('Save Failed');
			}
			
		}
	});
}

function submitMenu(){

	$('#form').form('submit',{
		url: "<?php echo base_url('menu/updateMenu') ?>",
		dataType: "json",
		contentType: "application/json; charset=utf-8",
		onSubmit: function(){
			
			$(this).form('enableValidation');
			if ($(this).form('validate')) {
				$.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});
				
				setTimeout(function(){
					$.messager.progress('close');
				}, 20000);
				return true;
			} else {
				return false;
			}
			
		},
		success: function(result){
			if (result) {
				data = $.parseJSON(result);
				
				if( data.status == "success" ){
					
					onload_menu();
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
				
				$.messager.progress('close');
			} else {
				$.messager.progress('close');
				alert('Save Failed');
			}
			
		}
	});
}
function clearForm(){
	$('#ff').form('clear');
}

</script>
<div class="box-body">
		
	  <form id="form" method="post" action="">
		<div class="form-group">
		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
		<!--<a href="<?php echo base_url('menu/menuAdd/' . $uri->getSegment(3)) ?>" class="easyui-linkbutton" iconCls="icon-add">Add Menu</a>-->
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" onclick="create_menu('<?php echo $uri->getSegment(3) ?>')">Add Menu</a>
				<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="submitMenu()">Save Menu</a>
		<!--<button type="submit" id="saveMenu" class="easyui-linkbutton" iconCls="icon-save">Save Menu</button>-->
	  </div>
	  <div id="sideMenu" class="dd">
		<?php echo $admin_menu ?>
	  </div>
	  <input type="hidden" name="type" value="<?php echo $uri->getSegment(3) ?>">
	  <textarea name="jsonMenu" hidden id="tampilJsonSideMenu"></textarea>
	  </form>
	  
</div>
		
		

		
<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:500px; height:480px; padding: 10px 20px" modal="true" closed="true" buttons="#dialog-buttons-user">
</div>
<div id="dialog-buttons-user">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="submitForm()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form EOF -->


<script>
  $(function(){
    $('#navMenu').addClass('active');
    $('#sideMenu').nestable({
		group: 1
	});
    $('#tampilJsonSideMenu').html(window.JSON.stringify($('#sideMenu').nestable('serialize')));
    $('#sideMenu').on('change', function() {
      $('#tampilJsonSideMenu').val(window.JSON.stringify($('#sideMenu').nestable('serialize')));      
    });
  });
</script>