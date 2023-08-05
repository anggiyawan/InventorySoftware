<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Layout</title>
		<link rel="shortcut icon" href="<?php echo base_url('favicon.ico'); ?>" type="image/x-icon">
		<link id="theme_style" rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/default/easyui.css?v=' . VERSION); ?>">
		<link href="<?php echo base_url('assets/css/style.css?v=' . VERSION); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('assets/themes/icon.css?v=6' . VERSION); ?>" rel="stylesheet" media="screen">	

	<script type="text/javascript" src="<?php echo base_url('assets/jquery.min.js?v=' . VERSION); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.easyui.min.js?v=' . VERSION); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/columns-ext.js?v=' . VERSION); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.edatagrid.js?v=' . VERSION); ?>"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/plugins/jquery.layout.js"></script>
<script>
$(document).on("contextmenu",function(e){e.preventDefault()});
$.parser.onComplete = function(){
	$('body').css('visibility','visible');
};
$(document).keyup(function(e) {
     if (e.key === "Escape") { // escape key maps to keycode `27`
        $('#dialog-form').dialog('close');
        $('#dialog-view').dialog('close');
        $('#dialog-add').dialog('close');
    }
});
</script>
<style>
body{
	margin: 0;
	font-size: 10px;
	*font-family:verdana,helvetica,arial,sans-serif;
	font-family: Arial !important;
	*background: #ffffff;
	background-color:#FFFFFF;
	font: 62.5% "Trebuchet MS", sans-serif; */
	*font: 35% verdana, arial;
	height:100%;
}
</style>
</head>
<body id="cc" class="easyui-layout" style="visibility:hidden">
<div data-options="region:'center'">
	<div id="layoutWork" class="easyui-layout" style="width:100%;height:100%;">
		<div data-options="region:'north',border:false" style="height:35px;background:#ffffff;padding:0px;">
            <div class="HeaderTopMenu">
				<div style="background: #3e6db9;padding:9px;float:left" align="left">
					<font color="#ffffff"><?php echo COMPANY ?></font>
				</div>
                <div style="background: #3e6db9;color:fff;padding:9px;" align="right">
                <div align="right">
					 <font color="#ffffff">Username : <?php echo session()->get('userName') ?></font>
                </div>
				
                </div>
            </div>
            <div class="HeaderTopModule"></div>
		</div>
		<div data-options="region:'south',split:true" style="background: #3e6db9;height:30px;padding:0px;">
            <font color="#ffffff"><?php echo COPYRIGHT ?> | <?php //echo version ?> | User : <?php echo session()->get('userName'); ?></font>
        </div>
		
		<?= $this->renderSection('content') ?>
	</div>
</div>
</body>
</html>