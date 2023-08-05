<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="robots" content="noindex" />
<title>Management Information System :. - <?php echo COMPANY ?></title>
	<link rel="shortcut icon" href="<?php echo base_url('favicon.ico'); ?>" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo base_url('assets/easyuilogin-v2.css?v=' . VERSION); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/easyuilogin.css?v=' . VERSION); ?>">

	<script type="text/javascript" src="<?php echo base_url('assets/jquery.min.js?v=' . VERSION); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.easyui.min.js?v=' . VERSION); ?>"></script>

<script type="text/javascript">
	$.parser.onComplete = function(){
		$('body').css('visibility','visible');
	};
</script>	
<style>
.text-login {
	font-size: 12px;
    color: #aaa;
	position: relative;
    border: 1px solid #95B8E7;
    background-color: #fff;
    vertical-align: middle;
    display: inline-block;
    overflow: hidden;
    -moz-border-radius: 5px 5px 5px 5px;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 5px 5px 5px 5px;
	outline: none;
	text-align: start;
    padding: 16px 10px !important;
    margin: 0px;
    width: 100% !important;
    height: 12px !important;
}
.text-login:focus {
	border: 0;
	box-shadow: 0 0 5px rgba(81, 203, 238, 1);
	border: 1px solid rgba(81, 203, 238, 1);
}

@keyframes shake {
  10%, 90% {
    transform: translate3d(-1px, 0, 0);
  }
  
  20%, 80% {
    transform: translate3d(2px, 0, 0);
  }

  30%, 50%, 70% {
    transform: translate3d(-4px, 0, 0);
  }

  40%, 60% {
    transform: translate3d(4px, 0, 0);
  }
}
</style>
</head>
<body style="height:100%;width:100%;background-image:url(assets/images/bg_default.gif);background-repeat:repeat;">
	<div class="easyui-panel" style="background:#3e6db9;pdding:6px 6px 0px 0px; width=90%;height:30px;overflow: hidden;text-overflow: ellipsis;">
        <!--<img src="assets/images/logo2.png" border="0"  height="30" style="vertical-align: middle;padding:8px;"/>-->
		<font color="#FFFFFF" height="30" style="vertical-align: middle;padding:12px;"><?php echo COMPANY ?>, <?php echo ADDRESS ?></font>
    </div>
    <div style="background:#ffffff;pdding:0px 0px 0px 0px; width=90%;height:1px;">
    </div>
	
<section class="">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-6 text-center mb-5">
</div>
</div>
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="easyui-panel login-wrap mt-3 p-4 p-md-4">

<h3 class="text-center mb-4">Please Sign In ...</h3>

					<?php if ( session()->getFlashdata('message') ) { ?>
					<script>
					$( document ).ready(function() {
						$('.text-login').css("animation", "shake 0.82s cubic-bezier(.36,.07,.19,.97) both");
					});
					</script>
					<div style="animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;padding: 7px 0px 8px 5px;margin-bottom: 8px;border-radius: 6px 6px 6px 6px;background:#FDE4E1;color: #B10009;border:solid 1px #FBD3C6;">
						<?php echo session()->getFlashdata('message') ?>
					</div>
					<?php } ?>
	<form method="post" action="">
			<div style="margin-bottom:10px">
				<input type="text" name="txtuser" id="txtuser" class="text-login" prompt="Username" style="width:100%;height:34px;padding:10px;" autocomplete="on">
			</div>
			<div style="margin-bottom:10px">
				<input type="password" name="txtpassword" id="txtpassword" class="text-login" prompt="Password" style="width:100%;height:34px;padding:10px" autocomplete="on">
			</div>
			<div style="margin-bottom:5px">
				<input name="login" type="submit" value=" Login " class="easyui-linkbutton" style="padding:5px 20px 5px 20px;">
			</div>
			
	</form>
</div>

			<div class="easyui-panel p-2 mt-2 col-md-12">
				<p style="margin-bottom: 12px 12px 12px 12px!important">IP Anda : <?php echo $ipAddress ?></p>
	        </div>
			<?php if ( $getBrowser != 'Google Chrome' ) { ?>
			<div class="easyui-panel p-2 mt-2 col-md-12" style="background-color: #FEEFB3;margin-top: 12px!important">
				<p>Disarankan untuk memakai Google Chrome <a href="https://www.google.com/chrome/browser/desktop/index.html"> Download</a></p>
	        </div>
			<?php } ?>
			
			<p style="text-align:center;">Copyrights &copy;  <?php echo COMPANY ?> - <?php echo VERSION ?><br>
		<?php echo ADDRESS ?></p>
        
            <p style="text-align:center;">
            All data and programs is owned by <?php echo COMPANY ?> <br />
            and are not allowed misuse or copied <br />
            without permission of the company.
            </p>
</div>
</div>
</div>
</section>
</body>
</html>