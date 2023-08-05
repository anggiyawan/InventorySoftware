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

var urlDetail;

function createSalesOrderDetails(){
	$('#dialog-add').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Product Detail',
		href:'../salesorders/formSalesOrdersDetails/<?php echo $action ?>',
		onLoad:function(){
			$('#form-add').form('disableValidation');
			urlDetail = "<?php echo base_url('salesorders/createSalesOrdersDetails/' . $action); ?>";
		}

	});
}

function updateSalesOrderDetails(){

	var row = jQuery('#datagrid-add').datagrid('getSelected');
	
	if(row){
		$('#dialog-add').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../salesorders/formSalesOrdersDetails/<?php echo $action ?>',
			onLoad:function(){

				jQuery('#form-add').form('clear');
				$('#form-add').form('load',row);
				$('#form-add').form('disableValidation');
				urlDetail = "<?php echo base_url('salesorders/updateSalesOrdersDetails/' . $action); ?>";
				// action = 'update';
			}
		});	

	}

}

function removeSalesOrderDetails(){
	var row = jQuery('#datagrid-add').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('salesorders/deleteSalesOrdersDetails/' . $action); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "salesOrderDetailId": row.salesOrderDetailId },
					processData: true,
					success: function( data, textStatus, jQxhr ){
						if(data.status == "success"){
						jQuery('#dialog-add').dialog('close');
						jQuery('#datagrid-add').datagrid('reload');
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

function saveSalesOrderDetails(){

	jQuery('#form-add').form('submit',{
		url: urlDetail,
		onSubmit: function(){
			
			$('#form-add').form('enableValidation');
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
					jQuery('#dialog-add').dialog('close');
					jQuery('#datagrid-add').datagrid('reload');
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
<!-- Dialog Form -->
<form id="form" method="post" novalidate >
<div style="padding: 10px 10px 10px 10px;display:none">
	
	<div class="outerDiv">
            <div class="leftDiv" style="background-color: #fff;padding:10px;color: #red!important">
			
				<div class="form-item">
					<input type="hidden" name="salesOrderId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
				</div>
				<div class="form-item" style="padding-top:16px">
					<div style="float:left;width:130px;align:right">
						<label>Customer</label>
					</div>
					<div style="float:right;padding-left:25px;width:25px"></div>
					<div>
						<input name="customerId" id="customerId" required="true" class="easyui-combogrid" style="width:235px;" data-options="
							panelWidth: 250,
							idField: 'customerId',
							textField: 'customerName',
							editable: true,
							url: '<?php echo base_url('combogrid/combogridCustomer'); ?>',
							mode: 'remote',
							formatter:function(value,row){
                                return row.customerId;
                            },
							columns: [[
								{field:'customerId',title:'ID',width:25},
								{field:'customerName',title:'Customer Name',width:40},
							]],
							onSelect: function(index,row){
								
								if (row.paymentTermId != '' && row.paymentTermId != null) {
									$('#paymentTermId').combogrid('setValue',row.paymentTermId);
								}
								
								// Billing Address
								$('#billId').val(row.billId);
								$('#billAddress1').text(row.billAddress1);
								$('#billAddress2').text(row.billAddress2);
								$('#billCity').text(row.billCity);
								$('#billState').text(row.billState);
								$('#billZipCode').text(row.billZipCode);
								if (row.billPhone != '' && row.billPhone != null) {
									$('#billPhone').text('Phone : '+row.billPhone);
								} else { $('#billPhone').text(row.billPhone); }
								
								if (row.billFax != '' && row.billFax != null) {
									$('#billFax').text('Fax : '+row.billFax);
								} else { $('#billFax').text(row.billFax); }
								
								// Shipping Address
								$('#shipId').val(row.shipId);
								$('#shipAddress1').text(row.shipAddress1);
								$('#shipAddress2').text(row.shipAddress2);
								$('#shipCity').text(row.shipCity);
								$('#shipState').text(row.shipState);
								$('#shipZipCode').text(row.shipZipCode);
								if (row.shipPhone != '' && row.shipPhone != null) {
									$('#shipPhone').text('Phone : '+row.shipPhone);
								} else { $('#shipPhone').text(row.shipPhone); }
								
								if (row.shipFax != '' && row.shipFax != null) {
									$('#shipFax').text('Fax : '+row.shipFax);
								} else { $('#shipFax').text(row.shipFax); }
							},
							fitColumns: true
						">
					</div>
				</div>
				<div class="form-item" style="padding-top:16px">
					<div style="float:left;width:130px;align:right">
						<label>Sales Order No #</label>
					</div>
					<div>
						<input type="text" <?php if ($action == "create") { echo "value='". $salesOrderNumber . "'"; } ?> name="salesOrderNumber" id="salesOrderNumber" readonly style="background-color: #eee" class="easyui-validatebox" required="true" size="30" maxlength="25" validType='length[0,25]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:16px">
					<div style="float:left;width:130px;align:right">
						<label>Reference</label>
					</div>
					<div>
						<input type="text" name="reference" id="reference" class="easyui-textbox" required="true" size="30" maxlength="35" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:16px">
					<div style="float:left;width:130px;align:right">
						<label>Expected Shipment Date</label>
					</div>
					<div>
						<input name="expectedShipmentDate" id="expectedShipmentDate" class="easyui-datebox" style="width:240px" required="true" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
					</div>
				</div>
				<div class="form-item" style="padding-top:16px">
					<div style="float:left;width:130px;align:right">
						<label>Payment Terms</label>
					</div>
					<div>
						<input name="paymentTermId" required="true" id="paymentTermId" class="easyui-combogrid" style="width:240px;" data-options="
							panelWidth: 250,
							idField: 'paymentTermId',
							textField: 'termName',
							editable: false,
							url: '<?php echo base_url('combogrid/combogridPaymentTerms') ?>',
							mode: 'post',
							onSelect: function(){										
								
							},
							onLoadSuccess: function(data){								
								if (action == 'create'){
									var rows = data.rows;
									$('#paymentTermId').combogrid('setValue',rows[0].paymentTermId);
								}
							},
							columns: [[
								{field:'termName',title:'Payment Terms',width:240,align:'left'}
							]],
							fitColumns: true
						">
					</div>
				</div>
				
				<div class="form-item" style="padding-top:16px">
					<div style="float:left;width:130px;align:right">
						<label>Representative</label>
					</div>
					<div>
						<input name="representativeId" id="representativeId" class="easyui-combogrid" style="width:240px;" data-options="
							panelWidth: 250,
							idField: 'representativeId',
							textField: 'representative',
							editable: false,
							url: '<?php echo base_url('combogrid/combogridRepresentative') ?>',
							mode: 'post',
							onSelect: function(){										
								
							},
							onLoadSuccess: function(data){								
								// if (action == 'create'){
									// var rows = data.rows;
									// $('#representativeId').combogrid('setValue',rows[0].representativeId);
								// }
							},
							columns: [[
								{field:'representative',title:'representative',width:240,align:'left'}
							]],
							fitColumns: true
						">
					</div>
				</div>
				
			</div>
            <div class="rightDiv">
			
			<style>fieldset{border:1px solid #95B8E7;border-radius:6px;padding:6px;margin-bottom:1px}legend{font-weight:bold;border-radius:6px;border:1px solid #95B8E7;padding:8px;margin-bottom:8px}</style>
	
				<fieldset>
					<legend>Billing Address</legend>
					<div class="" style="height:100px;">
					<!--
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:30px;float:right" onclick="updateSalesOrderDetails()"></a>
					-->
					<input type="hidden" name="billId" id="billId" required="true">
					<label id="billAddress1" style="display: block;"><?php echo @$billAddress1; ?></label>
					<label id="billAddress2" style="display: block;"><?php echo @$billAddress2; ?></label>
					<label id="billCity" style="display: block;"><?php echo @$billCity; ?></label>
					<label id="billState"><?php echo @$billState; ?></label>
					<label id="billZipCode"><?php echo @$billZipCode; ?></label>
					<label id="billPhone" style="display: block;"><?php echo @$billPhone; ?></label>
					<label id="billFax" style="display: block;"><?php echo @$billFax; ?></label>
					</div>
				</fieldset>
				
				<fieldset style="margin-top: 10px;margin-bottom: 10px">
					<legend>Shipping Address</legend>
					<div class="" style="height:100px;">
					<!--
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:30px;float:right" onclick="updateSalesOrderDetails()"></a>
					-->
					<input type="hidden" name="shipId" id="shipId"  required="true">
					<label id="shipAddress1" style="display: block;"><?php echo @$shipAddress1; ?></label>
					<label id="shipAddress2" style="display: block;"><?php echo @$shipAddress2; ?></label>
					<label id="shipCity" style="display: block;"><?php echo @$shipCity; ?></label>
					<label id="shipState"><?php echo @$shipState; ?></label>
					<label id="shipZipCode"><?php echo @$shipZipCode; ?></label>
					<label id="shipPhone" style="display: block;"><?php echo @$shipPhone; ?></label>
					<label id="shipFax" style="display: block;"><?php echo @$shipFax; ?></label>
					</div>
				</fieldset>
				
			</div>
	</div>
	
	<!-- table -->
	<table id="datagrid-add" class="easyui-datagrid" style="height:280px;width:90%" url="<?php echo $urlDatagrid; ?>" fit="false" toolbar="#toolbar-add" pagination="false" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
		<thead>
			<tr>
				<th field="salesOrderNumber" width="120" sortable="true">Sales Order No</th>
				<th field="productId" width="120" sortable="true">productId</th>
				<th field="productNumber" width="120" sortable="true">Product Number</th>
				<th field="productName" width="200" sortable="true">Product Name</th>
				<th field="priceSell" width="120" sortable="true">Sell Price</th>
				<th field="quantity" width="120" sortable="true">Quantity</th>
				<th field="unit" width="120" sortable="true">Unit</th>
				<th field="amount" width="120" sortable="true" data-options="
							styler: function cellStyler(value,row,index){
										return 'font-weight:bold;';
								}">Amount</th>
				<!--
				<th field="inputBy" width="85" sortable="true">Input By</th>
				<th field="inputDate" width="85" sortable="true">Input Date</th>
				<th field="updateBy" width="85" sortable="true">Update By</th>
				<th field="updateDate" width="85" sortable="true">Update Date</th>
				-->
			</tr>
		</thead>
	</table>
	<!-- table EOF-->
	<!-- TOOLBAR -->
	<div id="toolbar-add" style="padding:4px">
		<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createSalesOrderDetails()">Add</a>
		<?php //} ?>
		<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateSalesOrderDetails()">Edit</a>
		<?php //} ?>
		<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeSalesOrderDetails()">Delete</a>
		<?php //} ?>
	</div>
	<!-- TOOLBAR EOF -->
</div>
</form>
<!-- Dialog Form EOF -->

<!-- Dialog Form -->
<div id="dialog-add" class="easyui-dialog" style="width:450px; height:350px;" modal="true" closed="true" buttons="#dialog-buttons-add">
</div>
<div id="dialog-buttons-add">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveSalesOrderDetails()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-add').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->