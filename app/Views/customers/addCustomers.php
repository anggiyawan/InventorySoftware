<!-- Dialog Form -->
<form id="form" method="post" autocomplete="off" autocomplete="chrome-off" autoComplete='none'>
<div style="padding: 10px 10px">
	<div class="form-item">
		<input type="hidden" name="customerId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:200px;align:right;">
			<label>Customer Type</label>
		</div>
			<label>
			<input type="radio" name="customerTypeId" value="1" checked>Business
			</label>
			
			<label>
			<input type="radio" name="customerTypeId" value="2">Individual
			</label>
	</div>
	<div class="form-item" style="padding-top:12px">
		<div style="float:left;width:200px;align:right">
			<label>Customer Name</label>
		</div>
		<div>
			<input type="text" name="customerName" class="easyui-validatebox" data-options="required:true,validType:'length[0,255]'" style="text-transform: uppercase;" autocompete="off" size="30"/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:200px;align:right">
			<label>Customer Display Name</label>
		</div>
		<div>
			<input type="text" name="customerDisplay" class="easyui-validatebox" style="text-transform: uppercase;" size="30" maxlength="50" validType='length[0,50]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:200px;align:right">
			<label>Customer Email</label>
		</div>
		<div>
			<input type="email" name="customerEmail" class="easyui-validatebox" data-options="validType:'email'" size="30"/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:200px;align:right">
			<label>Customer Phone</label>
		</div>
		<div>
			<span style="display:inline-block">
				<input name="customerPhone" class="easyui-textbox" data-options="prompt:'Work Phone'" validType='length[0,20]'>
			</span>
			<span style="display:inline-block">
				<input name="customerMobile" class="easyui-textbox" data-options="prompt:'Mobile'" validType='length[0,20]'>
			</span>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:200px;align:right">
			<label>Website</label>
		</div>
		<div>
			<input type="text" name="customerWebsite" class="easyui-textbox" size="30" maxlength="50" validType='length[0,50]'/>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:8px">
		<div style="float:left;width:200px;align:right">
			<label>Status</label>
		</div>
		<div>
			<input name="customerStatusId" id="customerStatusId" class="easyui-combogrid" style="width:90px;" data-options="
							panelWidth: 250,
							panelHeight: 220,
							idField: 'id',
							textField: 'name',
							editable: false,
							url: '<?php echo base_url('combogrid/combogridCustomerStatus/notAll'); ?>',
							mode: 'post',
							onSelect: function(){										
								
							},
							onLoadSuccess: function(data){								
								if (action == 'create'){
									var rows = data.rows;
									$('#customerStatusId').combogrid('setValue',rows[0].id);
								}
							},
							columns: [[
								{field:'name',title:'name',width:240,align:'right'}
							]],
							fitColumns: true
						">
		</div>
	</div>
	
</div>

<div id="tt" class="easyui-tabs" style="width:99%;margin-top:10px" data-options="tabPosition:'top'">
	<div title='Other Details' style='padding:10px'>

		<div class="form-item" style="padding-top:8px">
			<div style="float:left;width:200px;align:right">
				<label>Currency</label>
			</div>
			<div>
				<input type="text" name="customerCurrency" value="Rp" readonly style="background-color: #eee" class="easyui-validatebox" required="true" size="30" maxlength="35" validType='length[0,35]'/>
			</div>
		</div>
		<div class="form-item" style="padding-top:8px">
			<div style="float:left;width:200px;align:right">
				<label>Payment Terms</label>
			</div>
			<div>
				<input name="paymentTermId" id="paymentTermId" class="easyui-combogrid" style="width:240px;" data-options="
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
		
	</div>
	
	<div title='Address' style='padding:10px'>
	 <fieldset id="teacher_2">
		
		<div class="outerDiv">
            <div class="leftDiv">
                <h3  style="padding-bottom:20px"><label>BILLING ADDRESS</label></h3>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Country</label>
					</div>
					<div>
						<input type="text" name="addressBillCountry" value="ID" readonly required style="background-color: #eee" class="easyui-validatebox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;">
						<label>Address</label>
					</div>
					<div>
						<input type="text" name="addressBillStreet1" class="easyui-textbox" data-options="multiline:true,prompt:'Street 1'" style="width:235px;height:50px;" validType='length[0,255]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>-</label>
					</div>
					<div>
						<input type="text" name="addressBillStreet2" class="easyui-textbox" data-options="multiline:true,prompt:'Street 2'" style="width:235px;height:50px;" validType='length[0,255]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>City</label>
					</div>
					<div>
						<input type="text" name="addressBillCity" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>State</label>
					</div>
					<div>
						<input type="text" name="addressBillState" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Zip Code</label>
					</div>
					<div>
						<input type="text" name="addressBillZipCode" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Phone</label>
					</div>
					<div>
						<input type="text" name="addressBillPhone" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Fax</label>
					</div>
					<div>
						<input type="text" name="addressBillFax" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
		
            </div>
            <div class="rightDiv">
				<h3  style="padding-bottom:20px"><label>SHIPPING ADDRESS</label></h3>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Country</label>
					</div>
					<div>
						<input type="text" name="addressShipCountry" value="ID" readonly required style="background-color: #eee" class="easyui-validatebox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;">
						<label>Address</label>
					</div>
					<div>
						<input type="text" name="addressShipStreet1" class="easyui-textbox" data-options="multiline:true,prompt:'Street 1'" style="width:235px;height:50px;" validType='length[0,255]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>-</label>
					</div>
					<div>
						<input type="text" name="addressShipStreet2" class="easyui-textbox" data-options="multiline:true,prompt:'Street 2'" style="width:235px;height:50px;" validType='length[0,255]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>City</label>
					</div>
					<div>
						<input type="text" name="addressShipCity" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>State</label>
					</div>
					<div>
						<input type="text" name="addressShipState" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Zip Code</label>
					</div>
					<div>
						<input type="text" name="addressShipZipCode" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Phone</label>
					</div>
					<div>
						<input type="text" name="addressShipPhone" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				<div class="form-item" style="padding-top:8px">
					<div style="float:left;width:200px;align:right">
						<label>Fax</label>
					</div>
					<div>
						<input type="text" name="addressShipFax" class="easyui-textbox" validType='length[0,35]'/>
					</div>
				</div>
				
            </div>
            <div style="clear: both;"></div>
        </div>

	</div>
	
	<div title='Remarks' style='padding:10px'>
		<div class="form-item" style="padding-top:8px">
			<div>
				<input name="customerRemark" class="easyui-textbox" data-options="multiline:true,label:'Remarks <i>(For Internal Use)</i>',labelPosition:'top'" style="width:400px;height:100px;" maxlength="35" validType='length[0,255]'/>
			</div>
		</div>
		
	</div>
</div>

<!-- Dialog Form EOF -->
<script>
	$(function(){
		$('input.easyui-validatebox').validatebox({
			validateOnCreate: false,
			err: function(target, message, action){
				var opts = $(target).validatebox('options');
				message = message || opts.prompt;
				$.fn.validatebox.defaults.err(target, message, action);
			}
		});
	});
</script>
</form>