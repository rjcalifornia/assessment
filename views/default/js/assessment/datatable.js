/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require.config( {
    baseUrl: "js",
   paths: {
        "jszip": "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min",
        "pdfmake": "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min",
        "fonts": "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts",
        "printn": "https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min",
        "datatables": "https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min",
        "bootstrapjs": "https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min",
        "datatablebtn": "https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.6.5/js/dataTables.buttons.min",
        "datatablesflh": "https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min",
        "datatableshtml5": "https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min",
        
},
shim: {
    'bootstrap': {
      deps: ['jquery']
    },
    "vfs_fonts": ["pdfmake"]
  },
  map: {
    '*': {
      'datatables.net': 'datatables',
    }
  },
    
} );


define(function(require) {
    var elgg = require("elgg");
    var $ = require("jquery");
    //var Datatable = require("datatable");
//console.log('9fdf');

require(['jquery', 'jszip', 'pdfmake', 'fonts', 'datatables', 'bootstrapjs','datatablebtn', 'datatablesflh','datatableshtml5',  ], function($) {
  'use strict';
 
  $('#example').dataTable({
      dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                //title: 'Reporte de proyectos desde '+ '{{data.fecha_inicio|date('d-m-Y')}} ' + ' hasta ' + '{{data.fecha_fin|date('d-m-Y')}}',
                className: "btn btn-sm btn-success",
                text: 'Download CSV report',
                exportOptions: {
                    stripNewlines: true,
                    stripHtml:true,
                    trim : true,
                    columns: [0, 1,2],
                    
                }
             
            },
            {
                extend: 'copy',
                //title: 'Reporte de proyectos desde '+ '{{data.fecha_inicio|date('d-m-Y')}} ' + ' hasta ' + '{{data.fecha_fin|date('d-m-Y')}}',
                className: "btn btn-sm btn-success",
                text: 'Copy to clipboard',
                exportOptions: {
                    stripNewlines: true,
                    stripHtml:true,
                    trim : true,
                    columns: [0, 1,2],
                    
                }
             
            },
            
            {
                extend: 'excel',
                //title: 'Reporte de proyectos desde '+ '{{data.fecha_inicio|date('d-m-Y')}} ' + ' hasta ' + '{{data.fecha_fin|date('d-m-Y')}}',
                className: "btn btn-sm btn-success",
                text: 'Download Excel',
                exportOptions: {
                    stripNewlines: true,
                    stripHtml:true,
                    trim : true,
                    columns: [0, 1,2],
                    
                }
             
            }
            
            
        ]
  });
});
   
});