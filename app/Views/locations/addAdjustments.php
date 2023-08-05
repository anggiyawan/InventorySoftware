<!-- Dialog Form -->
<form id="form" method="post" novalidate >

	<div class="form-item">
		<input type="hidden" name="productId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
		<input type="hidden" name="locationId" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
		<input type="hidden" name="stockPhy" id="stockPhy" required="true" size="30" maxlength="20" validType='length[0,20]' readonly="true"/>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Product Name</label>
		</div>
		<div>
			<input type="text" name="productName" readonly class="easyui-textbox" required="true" size="35" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Physical New Quantity</label>
		</div>
		<div>
			<input type="text" name="physicalQuantity" id="physicalQuantity" class="easyui-textbox" required="true" size="35" maxlength="25" validType='length[0,25]'/>
		</div>
	</div>
	<div class="form-item" style="padding-top:4px">
		<div style="float:left;width:130px;align:right">
			<label>Quantity Adjusted</label>
		</div>
		<div>
			<input type="text" name="adjustmentQuantity" id="adjustmentQuantity" readonly class="easyui-textbox" required="true" size="35" maxlength="25" validType='length[0,25]' value="0"/>
		</div>
	</div>
	<div class="form-item" style="padding-top:8px;margin-top:20px;border-top: 1px solid #ccc;">
		<div style="float:left;width:130px;align:right">
			<label>Remark</label>
		</div>
		<div>
			<input type="text" name="remarkAdjustment" class="easyui-textbox" data-options="multiline:true,prompt:'You can enter a maximum of 255 characters'" style="width:280px;height:50px;" validType='length[0,255]'/>
		</div>
	</div>
	
</form>
<!-- Dialog Form EOF -->
<script>
function calc() {
	let total = parseInt($("#stockPhy").val())+parseInt($("#physicalQuantity").val());
	
	$("#adjustmentQuantity").textbox('setValue', total);
}
// var t = $('#physicalQuantity');
// t.textbox('textbox').bind('keydown', function(e){
	// alert('test');
// });
$('#physicalQuantity').textbox({
	inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{
		keyup:function(e){
			console.log($(this).val());
			let total = parseInt($(this).val()) - parseInt($("#stockPhy").val());
			$("#adjustmentQuantity").textbox('setValue', total);
		}
	})
})
</script>