<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>
function ToSearch(){
	var vUserName	= $('#vUserName').textbox('getValue');
	var vGorupId	= $('#vGorupId').combobox('getValue');

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

		// jQuery('#dialog-form').dialog('open').dialog('setTitle','Update Data');

		// jQuery('#form').form('load',row);	

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
		<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
                <table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
	                <tr>
                        <td colspan="2"  height="10" valign="middle" align="left"></td>
                    </tr>
                    
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Nama User</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="userName" id="userName" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">IP Address</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="ipAddress" id="ipAddress" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Date From</td>
                        <td width="80" height="20" valign="middle" align="right">
							<input name="txtTglAwal" id="txtTglAwal" class="easyui-datebox" size="9" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
						</td>
                    </tr>
					
					
                    <tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Date To</td>
                        <td width="80" height="20" valign="middle" align="right">
							<input name="txtTglAkhir" id="txtTglAkhir" class="easyui-datebox" size="9" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d H:i:s') ?>"> 
						</td>
                    </tr>
					
	                <tr>
                        <td colspan="2"  height="10" valign="middle" align="left"></td>
                    </tr>

	                <tr>
                        <td colspan="2" height="25" valign="middle" align="center">
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="ToSearch()">Search</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
                        </td>
                    </tr>
                  

                  </table>
                   <!-- JAVASCRIPT DAN FUNCTION -->
	                <script type="text/javascript">
	                    function myformatter(date){
							var y = date.getFullYear();
							var m = date.getMonth()+1;
							var d = date.getDate();
							return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
						}
						
						function myparser(s){
							if (!s) return new Date();
							var ss = (s.split('-'));
							var y = parseInt(ss[0],10);
							var m = parseInt(ss[1],10);
							var d = parseInt(ss[2],10);
							if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
								return new Date(y,m-1,d);
							} else {
								return new Date();
							}
						}
						function DoBack() {
							document.location.href = "<?php echo base_url() ?>";
						}


						function ToSearch(){
						var userName	= $('#userName').textbox('getValue');
						var ipAddress	= $('#ipAddress').textbox('getValue');
						var tglawal		= $("#txtTglAwal").datebox('getValue');
						var tglakhir	= $("#txtTglAkhir").datebox('getValue');
						if ( tglawal == "" ) {
										jQuery.messager.show({
												title: 'Peringatan',
												msg: "Isi tanggal dengan lengkap !!"
											});
							} else if ( tglakhir == "" ) {
										jQuery.messager.show({
												title: 'Peringatan',
												msg: "Isi tanggal dengan lengkap !!"
											});
							} else {
								$('#datagrid-master').datagrid('load',{
									userName	: userName,
									ipAddress	: ipAddress,
									tglawal		: tglawal,
									tglakhir	: tglakhir,
								});
							}
						}

	                </script>
        </div>


<!-- #Body -->
<div data-options="region:'center',title:'Master Login History'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
	<table id="datagrid-master" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('logLogin/getJson'); ?>" fit="true" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="userId" width="80" sortable="true">ID</th>
				<th field="userName" width="150" sortable="true">User Name</th>
				<th field="ipAddress" width="250" sortable="true">Ip Address</th>
				<th field="computer" width="250" sortable="true">Computer</th>
				<th field="version" width="120" sortable="true">Version</th>
				<th field="inputDate" width="140" sortable="true">Last Login</th>
				<!--
				<th field="inputBy" width="85" sortable="true">Input By</th>
				<th field="inputDate" width="85" sortable="true">Input Date</th>
				<th field="updateBy" width="85" sortable="true">Update By</th>
				<th field="updateDate" width="85" sortable="true">Update Date</th>
				-->
			</tr>
		</thead>
	</table>
	</div>
	<!-- TABLE UTAMA EOF -->
	<!-- TABLE DETAIL -->
	<div style="height:25%" style="border-style: solid;padding:10px">
	</div>
	<!-- TABLE DETAIL EOF -->
</div>

<!-- TOOLBAR EOF -->
<?php $this->endSection() ?>