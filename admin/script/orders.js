$(document).ready(function(){
    $('#example').DataTable( {
        dom: 'Bfrtip',
        "info": false,
        "order":[[0, 'desc']],
        //"pageLength": 50,
        buttons: [
            { extend: 'pdf', text:'PDF <i class="fas fa-download"></i>',className: 'btn-pdf' },
            { extend: 'excel', text: 'EXCEL <i class="fas fa-download"></i>',className: 'btn-excel' }
            //'excel'
            // 'excelHtml5','pdfHtml5'
        ]
    } );
    
});