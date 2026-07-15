$(document).ready(function() {
    $('#select-relatorio-status').on('change', function() {
        let statusId = $(this).val();
        let $form = $('#formRelatorioStatus');
        
        let rotaOriginal = $form.data('route-url');
        
        if (statusId && rotaOriginal) {
          
            let rotaFinal = rotaOriginal.replace(':id', statusId);
            
            $form.attr('action', rotaFinal);
        }
    });
    
    $('#modalRelatorioStatus').on('hidden.bs.modal', function () {
        $('#formRelatorioStatus').attr('action', '');
        $('#select-relatorio-status').val('');
    });
});