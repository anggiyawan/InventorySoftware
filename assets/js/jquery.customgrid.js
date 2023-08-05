/**
 * EasyUI for jQuery Custom Grid 1.0
 * 
 * Copyright (c) 2022 Anggiyawan. All rights reserved.
 *
 *
 */
/**
 * Custom Grid - EasyUI for jQuery
 * 
 * 
 */
(function ($) {
  function buildMenu(target) {
    const state = $(target).data('datagrid');
    //Freezing columns do not allow modification of attributes and locations
    //const fields = $(target).datagrid('getColumnFields',true).concat($(target).datagrid('getColumnFields', false));
    const fields = $(target).datagrid('getColumnFields');
    if (!state.columnMenu) {
      state.columnMenu = $('<div></div>').appendTo('body');
      state.columnMenu.menu({
        onClick: function (item) {
          if (item.iconCls === 'tree-checkbox1') {
            $(target).datagrid('hideColumn', item.name);
            $(this).menu('setIcon', {
              target: item.target,
              iconCls: 'tree-checkbox0'
            });
          } else if (item.iconCls === 'tree-checkbox0') {
            $(target).datagrid('showColumn', item.name);
            $(this).menu('setIcon', {
              target: item.target,
              iconCls: 'tree-checkbox1'
            });
          } else if (item.iconCls === 'icon-save') {
            //Save configuration
          }
          let opts = [];
          for (let i = 0; i < fields.length; i++) {
            const field = fields[i];
            const col = $(target).datagrid('getColumnOption', field);
            opts.push(col);
          }
          //Save the adjusted attributes to localstorage in
          localStorage.setItem($(target).datagrid('options').id, JSON.stringify(opts));
		  // alert('test');
        }
      });
      state.columnMenu.menu('appendItem', {
        text: 'Save configuration',
        name: 'saveconfigitem',
        iconCls: 'icon-save'
      });
      for (let i = 0; i < fields.length; i++) {
        const field = fields[i];
        const col = $(target).datagrid('getColumnOption', field);
        if (col.title !== undefined)
          state.columnMenu.menu('appendItem', {
            text: col.title,
            name: field,
            iconCls: !col.hidden ? 'tree-checkbox1' : 'tree-checkbox0'
          });
      }
    }
    return state.columnMenu;
  }

  $.extend($.fn.datagrid.methods, {
    columnMenu: function (jq) {
      return buildMenu(jq[0]);

    },
    resetColumns: function (jq) {
      return jq.each(function () {
        const opts = $(this).datagrid('options');
        const local = JSON.parse(localStorage.getItem(opts.id));
        //Frozen columns do not participate in settings
        //const fields = $(this).datagrid('getColumnFields', true).concat($(this).datagrid('getColumnFields', false));
        //const fields = $(this).datagrid('getColumnFields');
        if (local !== null) {
          //load  sort datagrid columns 
          let sortcolumns = [];
          for (let i = 0; i < local.length; i++) {
            const field = local[i].field;
            const localboxwidth = local[i].boxWidth;
            const localwidth = local[i].width;
            const localhidden = local[i].hidden || false;
            let col = $(this).datagrid('getColumnOption', field);
            //Modify column widths and hidden attributes
            col.boxWidth = localboxwidth;
            col.width = localwidth;
            col.hidden = localhidden;
            sortcolumns.push(col);
          }
          $(this).datagrid({
            columns: [sortcolumns]
          }).datagrid('columnMoving');
        }
          
      });
    }
  });

})(jQuery);

var loadFilter = function loadFilter(data, parents = '') {
	// console.log(parents);
	if (!this.columns && data.columns) {
		this.columns = data.columns;
		var opts = $(this).datagrid('options');
		var url = opts.url;
		$(this).datagrid({
			headerContextMenu: function(e, field){
				e.preventDefault();
			},
			onHeaderContextMenu: function(e, field){
				e.preventDefault();
				$(this).datagrid('columnMenu').menu('show', {
					left:e.pageX,
					top:e.pageY
				});
			},
			onRowContextMenu: function(e,index,row){
				$('#mm').menu();
				$('#tt').tree();
				// $('#cc').on('contextmenu',function(e){
					$('#mm').menu('show', {
						// hideOnUnhover: true,
						left: e.pageX,
						top: e.pageY
					});
				// });
				e.preventDefault();
			  },
			pageSize:50,
			pageList:[50,100,150,200],
			pagination: true,
			rownumbers: true,
			singleSelect: true,
			columns: data.columns,
			striped: true			
			// url: null
		}).datagrid('columnMoving');
		// setTimeout(function() {
			// opts.url = url;
		// }, 0);
	}
	return data;
}
