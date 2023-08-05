<!DOCTYPE html>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo COMPANY ?></title>

		<link rel="shortcut icon" href="<?php echo base_url('favicon.ico'); ?>" type="image/x-icon">
		<link id="theme_style" rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/default/easyui.css'); ?>">
		<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('assets/themes/icon.css'); ?>" rel="stylesheet" media="screen">	

	<script type="text/javascript" src="<?php echo base_url('assets/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.easyui.min.js'); ?>"></script>

<script type="text/javascript">
$.parser.onComplete = function(){
	$('body').css('visibility','visible');
};
jQuery(document).ready(function(){
	// delay();
});
function delay() {
	var secs = 2;
	setTimeout('initFadeIn()', secs);
}
function initFadeIn() {
	jQuery("body").css("visibility","visible");
	jQuery("body").css("display","none");
	jQuery("body").fadeIn(200);
}
// function realtime(){
		// $.ajax({
		// type : 'POST',
		// url  : "<?php echo base_url('api/check_refresh/user'); ?>",
		// success : function(data){
			// if( data.status === "02"){
			  // document.location.href = "<?php echo base_url('logout'); ?>"
			// } 
		// }
		// });
	// }
	// setInterval("realtime()", 5000);
</script>
    <script type="text/javascript">
function CekAktif() {
	
	$('#tt').tabs({
		border: false,
		onSelect: function (title) {
			sessionStorage.usedData = title;
		   
		 //   document.getElementById("btn1").value == title;
		   // document.getElementById("btn1").click();
			
		}
	});
	var ttts = sessionStorage.getItem("usedData");
	if (ttts == "") {
		//alert(' kosog is selected');
	} else {
		//alert(ttts + ' ada is selected');
		$('#tt').tabs('select',ttts);
	}
}
		
function changePassword(){
	// $('#form').form('resetValidation');
	$('#oldPassword').textbox('setValue', '');
	$('#newPassword').textbox('setValue', '');
	$('#confirmPassword').textbox('setValue', '');
	$('#form-change').form('disableValidation');

	$('#dialog-change').dialog('open').dialog('setTitle', 'Change Password');
}
		
function saveChange(){
	$('#form-change').form('submit',{
		url: "<?php echo base_url('changePassword') ?>",
		contentType: 'application/json',
		onSubmit: function(){
			
			$('#form-change').form('enableValidation');
			if ($(this).form('validate')) {
				$.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});
				
				// setTimeout(function(){
					// $.messager.progress('close');
				// }, 15000);
				
				return true;
			} else {
				return false;
			}
			
		},
		success: function(result){
			if (result) {
				data = $.parseJSON(result);
				
				$.messager.progress('close');
				
				if( data.status == "success" ){
					// alert(data.status)
					$('#dialog-change').dialog('close');
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
			} else {
				$.messager.progress('close');
				alert('Save Failed');
			}
			
		}
	});
}
   </script>


<style>
.tag-box {
  transition: box-shadow .5s;
  width: 20%;
  padding: 5px;
  background-color: #eaf2ff;
  border: 1px solid #eaf2ff;
  float: left;
  margin-right: 1%;
  margin-bottom: 5px;
  border-radius: 6px;
}

.tag-box:hover {
  box-shadow: 0 0 6px rgba(25,25,25,.2); 
}

@media only screen and (max-width: 600px) {
.tag-box {
	width: 41%;
	height: 180px;
    }
}

@media only screen and (max-width: 850px) {
.tag-box {
	width: 41%;
	height: 120px;
    }
}
@media only screen and (max-width: 1450px) {
  width: 10px;
  padding: 5px;
  background-color: #f0f0f0;
  border: 1px solid #ccc;
  float: left;
  margin-right: 2%;
  margin-bottom: 10px;	
}
</style>
</head>
<!--<body leftmargin="0" topmargin="0" class="easyui-layout" onload="CekAktif();" style="visibility:hidden">-->
<body leftmargin="0" topmargin="0" class="easyui-layout" onload="CekAktif();" style="visibility:hidden">
<div id="dialog-change" class="easyui-dialog" style="width:450px; height:300px; padding: 4px 6px" modal="true" closed="true" buttons="#dialog-change-btn">
<form id="form-change" method="post" action="<?php echo base_url('nc/jawab_nc'); ?>">
		<div class="form-item">
			<div style="float:left;width:130px;align:left">
				<label>User ID</label>
			</div>
			<div>
				<input type="text" name="userId" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo session()->get('userId') ?>" readonly>
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Name</label>
			</div>
			<div>
				<input type="text" name="userName" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo session()->get('userName') ?>" readonly>
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Fullname</label>
			</div>
			<div>
				<input type="text" name="fullName" class="easyui-textbox" required="true" size="30" maxlength="35" value="<?php echo session()->get('fullName') ?>" validType='length[0,35]' readonly>
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Old Password</label>
			</div>
			<div>
				<input type="text" name="oldPassword" id="oldPassword" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>New Password</label>
			</div>
			<div>
				<input type="text" name="newPassword" id="newPassword" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Confirm Password</label>
			</div>
			<div>
				<input type="text" name="confirmPassword" id="confirmPassword" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
</form>
</div>
<div id="dialog-change-btn">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="saveChange()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-change').dialog('close')">Batal</a>
</div>

<style>
.btn-head {
	background-color: #bbd1a1;
  -webkit-animation-name: acceptSlide;
  -webkit-animation-duration: 0.4s;
  animation-name: acceptSlide;
  animation-duration: 0.4s;
   width: 400px;
   padding: 6px;
    height: 100px;
    width: 200px;
    background: #f3f0f1;
    position: relative;
    margin-bottom: 25px;
    border-radius: 4px;
    text-align: center;
    cursor: pointer;
    transition: all 0.1s ease-in-out;

}
.btn-head:hover {
	box-shadow: 0 0 6px rgba(25,25,25,.2); 
}


         .btn-grad {background-image: linear-gradient(to right, #006699  0%, #006699  1%, #006699  100%)}
         .btn-grad {
            padding: 4px 4px;
            text-align: center;
            text-transform: uppercase;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;            
            box-shadow: 0 0 2px #eee;
            border-radius: 4px;
          }

          .btn-grad:hover {
            background-position: right center; /* change the direction of the change here */
            color: #fff;
            text-decoration: none;
          }
         
</style>
	<div data-options="region:'north',border:false" style="height:35px;background:#ffffff;padding:0px">
            <div class="HeaderTopMenu">
				<div style="background: #3e6db9;padding:10px;float:left" align="left">
					<font color="#ffffff"><?php echo \TglToDay(date('Y-m-d')) ?>, <?php echo \DateFormatIndo(date('Y-m-d')) ?></font>
				</div>
                <div style="background: #3e6db9;padding:10px;" align="right">
                <div align="right">
                     <font color="#ffffff">User ID : <?php echo session()->get('userName') ?> |
					<?php //if ( $this->session->userdata('change_pwd') == 1 ) { ?>
                     <a href="#" onclick="changePassword()" style="color:#ffffff;" class="btn-grad">Change Password</a>  |
					<?php //} ?>
                     <a href="<?php echo base_url('logout') ?>" style="color:#ffffff;" class="btn-grad">Logout</a></font>
                </div>
                </div>
            </div>
            <div class="HeaderTopModule">
			
			</div>
            
    </div>


	<div data-options="region:'south',border:false" style="height:55px;background:#ffffff;padding:5px;"><?php echo COPYRIGHT ?>
		<marquee><?php // echo online(); ?>
		</marquee>
	</div>

	<div data-options="region:'center',title:'<?php echo COMPANY ?>'">

	<div id="tt" class="easyui-tabs" style="width:100%;height:100%;" data-options="tabPosition:'left'">
		<?php echo $boxMenu; ?>           
	</div>
    </div>
    <form method="post" name="frm" target="_parent" id="frm" >  
    <input name="btn1" type="submit" id="btn1" value="F Submit " hidden=hidden />
    </form>
</body>
</html>
