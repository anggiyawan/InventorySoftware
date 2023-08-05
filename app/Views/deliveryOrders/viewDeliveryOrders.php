<script>
onload_menu();
function onload_menu(){	
	
	$('#tt').tabs({
		border: false,
		onSelect: function (title) {
			sessionStorage.usedDataMenu = title;
			var name = title.toLowerCase().replace(" ", "-");				
		}
	});
	var ttts = sessionStorage.getItem("usedDataMenu");
	if (ttts == "") {
		alert(' kosog is selected');
		$('#p').panel('refresh',"<?php echo base_url('cproducts/formProducts/create') ?>");
	} else {
		// alert(ttts + ' ada is selected');
		// alert(ttts);
		var name = ttts.toLowerCase().replace(" ", "-");
		$('#p').panel('refresh',"<?php echo base_url('products/formProducts/create') ?>/" + name);			
		$('#tt').tabs('select',ttts);
	}
}

function approvalDeliveryOrders(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('deliveryOrders/approvalDeliveryOrders'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "deliveryOrderId": row.deliveryOrderId, "approvalId": '<?php echo $approvalId ?>', "approvalHeader": '<?php echo $approvalHeader ?>' },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						jQuery('#dialog-view').dialog('close');
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
</script>
<div style="padding: 10px;color: grey">

<div id="p" class="easyui-panel" style="width:100%;height:55px;padding:10px;background:#fafafa;">
	<div style="float:left;padding: 0px">
		<h1><?php echo $deliveryOrderNumber; ?></h1>
	</div>
	
	<div style="float:right;padding: 0px">
		<div style="float:left;padding: 0px;width:200px">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" style="width:120px" onclick="printlDeliveryOrders()">Print</a>
		</div>
		<div style="float:right;padding: 0px;width:300px">
			<a href="javascript:void(0)" <?php echo $approvalButton ?> class="easyui-linkbutton" iconCls="icon-ok" style="width:120px" onclick="approvalDeliveryOrders()"><?php echo $approvalLabel; ?></a>
			<a href="javascript:void(0)" <?php echo $approvalButton ?> class="easyui-linkbutton" iconCls="icon-cancel" style="width:120px" onclick="createSalesOrderDetails()">Rejected</a>
		</div>
	</div>
	</div>

</div>
<div id="tt" class="easyui-tabs" style="width:100%" data-options="tabPosition:'top', border: false, fit: true,tabWidth:200">
	<div title='Delivery Orders Details' style='padding:0px'>
					<!-- Content -->
						<div id="p" class="easyui-panel"
								style="width:100%;height:500px;padding:10px;background:#fafafa;"
								data-options="iconCls:'icon-save',closable:false,
										collapsible:false,minimizable:false,maximizable:false">
										
								<iframe border="0" src="<?php echo base_url('deliveryorders/pdfDeliveryOrders'); ?>" width="100%" height="100%"></iframe>
						</div>
					<!-- Content -->
	</div>
	
	<div title='History' style='padding:0px'>
	</div>
</div>