$(document).ready(function(){
    $('#example').DataTable( {
        dom: 'Bfrtip',
        "info": false,
        "order":[[0, 'desc']],
        buttons: [
            { extend: 'pdf', text:'PDF <i class="fas fa-download"></i>',className: 'btn-pdf' },
            { extend: 'excel', text: 'EXCEL <i class="fas fa-download"></i>',className: 'btn-excel' }
        ]
    } );
    
});