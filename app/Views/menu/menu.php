<?php echo $this->extend('layout/defaultNoLayout') ?>

<?php $this->section('content') ?>
<?php $uri = service('uri'); // load uri segment ?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<style type="text/css">
.dd-action {
  position: absolute;
  right: 10px;
  z-index: 99;
  bottom: 6px;
}
.dd-action>a {
  margin-right: 10px;
}
.cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
* html .cf { zoom: 1; }
*:first-child+html .cf { zoom: 1; }

html { margin: 0; padding: 0; }
body { font-size: 100%; margin: 0; padding: 1.75em; font-family: 'Helvetica Neue', Arial, sans-serif; }

h1 { font-size: 1.75em; margin: 0 0 0.6em 0; }

a { color: #2996cc; }
a:hover { text-decoration: none; }

p { line-height: 1.5em; }
.small { color: #666; font-size: 0.875em; }
.large { font-size: 1.25em; }

/**
 * Nestable
 */

.dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }

.dd-item,
.dd-empty,
.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

.dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }

.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}

.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

/**
 * Nestable Extras
 */

.nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

#nestable-menu { padding: 0; margin: 20px 0; }

#nestable-output,
#nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

#nestable2 .dd-handle {
    color: #fff;
    border: 1px solid #999;
    background: #bbb;
    background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
    background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
    background:         linear-gradient(top, #bbb 0%, #999 100%);
}
#nestable2 .dd-handle:hover { background: #bbb; }
#nestable2 .dd-item > button:before { color: #fff; }

@media only screen and (min-width: 700px) {

    .dd { float: left; width: 100%; }
    .dd + .dd { margin-left: 2%; }

}

.dd-hover > .dd-handle { background: #2ea8e5 !important; }

/**
 * Nestable Draggable Handles
 */

.dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd3-content:hover { color: #2ea8e5; background: #fff; }

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-item > button { margin-left: 30px; }

.dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
    border: 1px solid #aaa;
    background: #ddd;
    background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:         linear-gradient(top, #ddd 0%, #bbb 100%);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
.dd3-handle:hover { background: #ddd; }

/**
 * Socialite
 */

.socialite { display: block; float: left; height: 35px; }

    </style>
	<body class="easyui-layout" style="visibility:hidden" onload="onload_menu()">
	<div data-options="region:'center'">
	<div class="easyui-layout" style="width:100%;height:100%;">
        <!-- #Left Menu -->
		<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:155px;">
				<div id="tt" class="easyui-tabs" style="width:100%;height:100%;" data-options="tabPosition:'left'">
					<?php foreach ($menuType as $value): ?>
						<div title="<?php echo $value->type ?>" style="padding:10px">
						</div>
					<?php endforeach ?>
				</div>
				<!--<div id="tab-tools">
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" onclick="addPanel()"></a>
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-remove'" onclick="removePanel()"></a>
				</div>-->
        </div>
		
<!-- JAVASCRIPT DAN FUNCTION -->
<script type="text/javascript">
	function DoBack() {
		document.location.href = "<?php echo base_url() ?>";
	}
	
	var index = 0;
	function addPanel(){
		index++;
		$('#tt').tabs('add',{
			title: 'Tab'+index,
			content: '<div style="padding:10px">Content'+index+'</div>',
			closable: true
		});
	}
	function removePanel(){
		var tab = $('#tt').tabs('getSelected');
		if (tab){
			var index = $('#tt').tabs('getTabIndex', tab);
			$('#tt').tabs('close', index);
		}
	}
	onload_menu();
	function onload_menu(){	
		
		$('#tt').tabs({
			border: false,
			onSelect: function (title) {
				sessionStorage.usedDataMenu = title;
				var name = title.toLowerCase().replace(" ", "-");
				// alert(name);
				const nextURL = "<?php echo base_url('menu/manage') ?>/" + name;
				const nextTitle = 'My new page title';
				const nextState = { additionalInformation: 'Updated the URL with JS' };

				// This will create a new entry in the browser's history, without reloading
				window.history.pushState(nextState, nextTitle, nextURL);

				// This will replace the current entry in the browser's history, without reloading
				window.history.replaceState(nextState, nextTitle, nextURL);
				$('#p').panel('refresh',"<?php echo base_url('menu/onloadMenu/') ?>/" + name);
				
			}
		});
		var ttts = sessionStorage.getItem("usedDataMenu");
		if (ttts == "") {
			alert(' kosog is selected');
			$('#p').panel('refresh',"<?php echo base_url('menu/onloadMenu/' . $uri->getSegment(3)) ?>");
		} else {
			// alert(ttts + ' ada is selected');
			// alert(ttts);
			var name = ttts.toLowerCase().replace(" ", "-");
			$('#p').panel('refresh',"<?php echo base_url('menu/onloadMenu') ?>/" + name);			
			$('#tt').tabs('select',ttts);
		}
	}
	
</script>
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Master Page Menu'" style="background-color:#D7E4F2;">
		<!-- TABLE UTAMA -->
		<div style="height:100%" bgcolor="#3E6DB9">
		
				<!-- Content -->
						<div id="p" class="easyui-panel"
								style="width:100%;height:100%;padding:10px;background:#fafafa;"
								data-options="iconCls:'icon-save',closable:false,
										collapsible:false,minimizable:false,maximizable:false">
						</div>
					<!-- Content -->
		</div>
		<!-- TABLE UTAMA EOF -->
		</div>
	</div>

	</div>
<!-- TOOLBAR -->

<!-- TOOLBAR EOF -->
<script>
  $(function(){
    $('#navMenu').addClass('active');
    $('#sideMenu').nestable({
		group: 1
	});
    $('#tampilJsonSideMenu').html(window.JSON.stringify($('#sideMenu').nestable('serialize')));
    $('#sideMenu').on('change', function() {
      $('#tampilJsonSideMenu').val(window.JSON.stringify($('#sideMenu').nestable('serialize')));      
    });
  });
</script>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-nestable/jquery.nestable.js'); ?>"></script>
<?php $this->endSection() ?>