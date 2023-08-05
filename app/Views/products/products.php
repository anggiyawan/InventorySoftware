<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>
function ToSearch(){
	var vProductId		= $('#vProductId').textbox('getValue');
	var vProductNumber	= $('#vProductNumber').textbox('getValue');
	var vProductName	= $('#vProductName').textbox('getValue');
	var vUnit			= $('#vUnit').textbox('getValue');
	var vStatus			= $('#vStatus').combobox('getValue');
	var vProductType	= $('#vProductType').combobox('getValue');

	$('#datagrid-master').datagrid('load',{
		productId: vProductId,
		productName: vProductName,
		productNumber: vProductNumber,
		unit: vUnit,
		status: vStatus,
		productType: vProductType,
	}); 
}
function DoBack() {
	document.location.href = "<?php echo base_url() ?>";
}

var url;

function createProduct(){
	// $('#dialog-form').height("100");
	// $('#dialog-form').fadeIn();
	$('#dialog-form').dialog({
		closed:false,
		iconCls:'icon-add',
		title:'Add Data',
		openAnimation: 'fadeIn',
		href:'../products/formProducts/create',
		onLoad:function(){
			$('#form').form('disableValidation');
			url = "<?php echo base_url('products/createProducts'); ?>";
		}

	});
}

function updateProduct(){
	// $('#dialog-form').height("1000");
	var row = jQuery('#datagrid-master').datagrid('getSelected');

	if(row){

		$('#dialog-form').dialog({
			closed:false,
			iconCls:'icon-edit',
			title:' Update',
			href:'../products/formProducts/update',
			onLoad:function(){

				jQuery('#form').form('clear');
				$('#form').form('load',row);
				$('#form').form('disableValidation');
				url = "<?php echo base_url('products/updateProducts'); ?>";
			}
		});

	}

}

function removeProduct(){
	var row = jQuery('#datagrid-master').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					url: "<?php echo base_url('products/deleteProducts'); ?>",
					dataType: 'json',
					type: 'post',
					// contentType: 'application/json',
					data: { "productId": row.productId },
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

function saveProduct(){

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

// $(function(){
    // var dg = $('#datagrid-master').edatagrid();
    // dg.edatagrid({
        // fit:true,
        // fitColumns: true,   
    // });
// });
</script>
<!-- #Left Menu -->
<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
		<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td colspan="2"  height="10" valign="middle" align="left"></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Product ID</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vProductId" id="vProductId" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Product Number</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vProductNumber" id="vProductNumber" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Product Nama</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vProductName" id="vProductName" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Unit</td>
				<td width="100" height="20" valign="middle" align="left"><input  Name="vUnit" id="vUnit" size="8" value="" type="text" class="easyui-textbox"/></td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Status</td>
				<td width="100" height="20" valign="middle" align="left">
					<select name='vStatus' id='vStatus' class="easyui-combobox" required="true" editable="false" style="width:90px" required="true">
						<option value=''>All</option>
						<option value='1'>Aktif</option>
						<option value='2'>Disable</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td height="20" valign="middle" align="right" style="font-size:12px;">Product Type</td>
				<td width="100" height="20" valign="middle" align="left">
					<input name="vProductType" id="vProductType" class="easyui-combogrid" style="width:90px;" data-options="
						panelWidth: 150,
						idField: 'id',
						textField: 'name',
						editable: false,
						url: '<?php echo base_url('combogrid/combogridProductType/all'); ?>',
						mode: 'remote',
						columns: [[
							{field:'name',title:'Type',width:40},
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
<div data-options="region:'center',title:'Master Products'" style="background-color:#D7E4F2;">
	<!-- TABLE UTAMA -->
	<div style="height:75%" bgcolor="#3E6DB9">
	<table id="datagrid-master" striped="true" class="easyui-datagrid" style="height:100%;width:100%" url="<?php echo base_url('products/getJson'); ?>" toolbar="#toolbar-master" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
	data-options="
							rowStyler: function(index,row){
									// if (index % 2 == 1){
										// return 'background:#eaf2ff;color:#000;opacity: 10;';
									// }									
								},
							'onClickRow': function(index, field, value){
								var row = jQuery('#datagrid-master').datagrid('getSelected');
								
								if ( row !== null ) {
									$('#stockAccHand').text(row.stockAccHand);
									$('#stockAccCommit').text(row.stockAccCommit);
									$('#stockAccSale').text(row.stockAccSale);
									
									$('#stockPhyHand').text(row.stockPhyHand);
									$('#stockPhyCommit').text(row.stockPhyCommit);
									$('#stockPhySale').text(row.stockPhySale);
								}
								
							},
							'onDblClickRow': function(index, field, value){
								var row = jQuery('#datagrid-master').datagrid('getSelected');
								// alert('test');
								$('#dialog-view').dialog({
									closed:false,
									iconCls:'icon-add',
									title:'View Products',
									openAnimation: 'fadeIn',
									href:'../products/viewProducts/' + row.productId,
									onLoad:function(){
										
									}
	
								});
							},">
		<thead>
			<tr>
				<th field="productId" width="80" sortable="true">ID</th>
				<th field="productTypeDesc" width="110" sortable="true">Product Type</th>
				<th field="status" width="80" sortable="true">Status</th>
				<th field="productNumber" width="150" sortable="true">Product Number</th>
				<th field="productName" sortable="true">Product Name</th>
				<th field="stockPhyHand" width="100" sortable="true">Physical Stock</th>
				<th field="priceCostCurrency" width="100">Price (Cost)</th>
				<th field="priceSellCurrency" width="100">Price (Sell)</th>
				<th field="unit" width="80" sortable="true">Unit</th>
				<th field="remark" sortable="true">Remark</th>
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
	<div style="height:25%" style="border-style: solid;">
	<div style="height:100%;background-color:#fff">
	
		<div class="outerDiv">
            <div class="leftDiv" style="background-color: #eee;padding:10px">
			
				<h3>Accounting Stock</h3>
				<div style="margin-bottom:10px"></div>
				
				<table>
					<tr>
						<td style="padding:6px" title="Current stock available for this item" position="top" class="easyui-tooltip"><label>Stock on Hand</label></td>
						<td style="width:15px">:</td>
						<td><label id="stockAccHand">0</label></td>
					</tr>
					<tr>
						<td style="padding:6px" title="Stock that is committed to sales order(s) but not yet invoiced" position="top" class="easyui-tooltip"><label>Committed Stock</label></td>
						<td style="width:15px">:</td>
						<td><label id="stockAccCommit">0</label></td>
					</tr>
					<tr>
						<td style="padding:6px" title="Available for sale = Stock on hand - Committed Stock" position="top" class="easyui-tooltip"><label>Available for Sale</label></td>
						<td style="width:15px">:</td>
						<td><label id="stockAccSale">0</label></td>
					</tr> 
				</table>
				
			</div>
            <div class="rightDiv" style="background-color: #eee;padding:10px">
				
				<h3>Physical Stock</h3>
				<div style="margin-bottom:10px"></div>
				
				<table>
					<tr>
						<td style="padding:6px" title="Current stock available for this item" position="top" class="easyui-tooltip"><label>Stock on Hand</label></td>
						<td style="width:15px">:</td>
						<td><label id="stockPhyHand">0</label></td>
					</tr>
					<tr>
						<td style="padding:6px" title="Stock that is committed to sales order(s) but not yet shipped" position="top" class="easyui-tooltip"><label>Committed Stock</label></td>
						<td style="width:15px">:</td>
						<td><label id="stockPhyCommit">0</label></td>
					</tr>
					<tr>
						<td style="padding:6px" title="Available for sale = Stock on hand - Committed Stock" position="top" class="easyui-tooltip"><label>Available for Sale</label></td>
						<td style="width:15px">:</td>
						<td><label id="stockPhySale">0</label></td>
					</tr> 
				</table>
				
			</div>
		</div>
		
	</div>
	</div>
	<!-- TABLE DETAIL EOF -->
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:500px;padding: 10px 20px;top:50px" modal="true" closed="true" buttons="#dialog-buttons-master">
</div>
<div id="dialog-buttons-master">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveProduct()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form Eof -->
<!-- Dialog View Eof -->
<div id="dialog-view" class="easyui-dialog" style="width:100%; height:100%; padding: 0px 0px;top:0px" modal="true" closed="true" buttons="">
</div>
<!-- Dialog View Eof -->

<!-- TOOLBAR -->
<div id="toolbar-master" style="padding:4px">
	<?php //if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="createProduct()">Add</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="updateProduct()">Edit</a>
	<?php //} ?>
	<?php //if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="removeProduct()">Delete</a>
	<?php //} ?>
</div>
<!-- TOOLBAR EOF -->
<?php $this->endSection() ?>