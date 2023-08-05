<?php echo $this->extend('layout/default') ?>

<?php $this->section('content') ?>
<script>         
// $(function() {
    
    // var p = $('#layout_workerss').layout('panel','west').panel({
        // onCollapse:function(){    
			// alert('collapse');			
        // },
		// onExpand:function(){
			// alert('expand');
		// }
    // });
    
// });
</script>

<div class="easyui-layout" id="layout_work" fit="true">
        <div region="north" style="height:10px;" title="Filter">
            
        </div>
        <div data-options="region:'west'" title="Filter&nbsp;workers" style="width:30%"> 
                <table id="dg_workers_filter" class="easyui-datagrid"  nowrap="false" striped="true" fit="true" fitColumns="true"  border="false"
                       data-options="idField:'id'"  singleSelect="true" selectOnCheck="true"
                       loadMsg="Cargando por favor espere..." >
                    <thead >  
                        <tr>  
                            <th field="ck" checkbox="true"></th>
                            <th  field="id" align="center">ID</th>  
                            <th  field="name" width="35" align="left">Name</th>                           
                        </tr>
                    </thead>                                  
                </table>
        </div>
        <div data-options="region:'center'" title="Center">
                DATA
        </div>
    </div>
	
<?php $this->endSection() ?>