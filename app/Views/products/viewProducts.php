<script>

</script>

<div id="tt" class="easyui-tabs" style="width:100%" data-options="tabPosition:'top',tabWidth:200">
	<div title='Products Details' style='padding:0px'>
					<!-- Content -->
						<div id="p" class="easyui-panel"
								style="width:100%;height:100%;padding:10px;background:#fafafa;"
								data-options="iconCls:'icon-save',closable:false,
										collapsible:false,minimizable:false,maximizable:false">
						</div>
					<!-- Content -->
	</div>
	<div title='Location Stock' style='padding:0px'>
					<!-- Content -->
						<div id="p" class="easyui-panel"
								style="width:100%;height:100%;padding:10px;background:#fafafa;"
								data-options="iconCls:'icon-save',closable:false,
										collapsible:false,minimizable:false,maximizable:false,
										tools:[{
					iconCls:'icon-reload',
					handler:function(){
						$('#p').panel('refresh', '<?php echo base_url('products/viewLocationStock'); ?>');
					}
				}]">
							<!--<iframe border="0" src="<?php echo base_url('products/viewLocationStock'); ?>" width="100%" height="100%"></iframe>-->
							<table id="datagrid-location-stock" pageSize="50" pageList="[50,100,150,200]" class="easyui-datagrid" style="height:400px;width:100%" url="<?php echo base_url('products/getJsonLocationStock?productId=' . $action); ?>" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
								<thead>
									<tr>
										<th field="locationName" width="80" sortable="true">Location</th>
										<th field="stockAcc" width="120" sortable="true">Stock Accounting</th>
										<th field="stockPhy" width="120" sortable="true">Stock Physical</th>
										<th field="remark" width="450" sortable="true">Remark</th>
									</tr>
								</thead>
							</table>
	
						</div>
					<!-- Content -->
	</div>
	
	<div title='Transaction Details' style='padding:0px'>
	</div>
	
	<div title='History' style='padding:0px'>
	</div>
</div>