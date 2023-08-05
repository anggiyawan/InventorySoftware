<script>
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

</script>
<!-- Dialog Form -->
<form id="form" method="post" novalidate style="padding:8px">
	
	<input type="hidden" name="deliveryOrderId"/>
	<div class="form-item" style="padding-top:8px">
		<div style="width:350px;align:right">
			<label>Do you want to mark the shipment(s) as Delivered?</label>
		</div>
	</div>
	
	<div class="form-item" style="padding-top:20px">
		<div style="float:left;width:130px;align:right">
			<label>Delivered On</label>
		</div>
		<div>
			<input name="deliveryRealDate" class="easyui-datebox" style="width:120px" required="true" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
			<input name="deliveryRealTime" class="easyui-timespinner" style="width:115px" required="true" data-options="validType:'length[5,5]'" value="<?php echo date('H:i', strtotime(date('H:i'))); ?>">
		</div>
	</div>
</form>
<!-- Dialog Form EOF -->