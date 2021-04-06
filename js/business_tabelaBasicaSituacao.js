function gravaSituacao(formData) {
    formData.append('funcao', 'grava');
    $.ajax({ 
        url: 'js/sqlscope_tabelaBasicaSituacao.php',
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, textStatus) {
            if (data.trim() === 'success') {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success"); 
               voltar();
            } else {
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
            }
        }, error: function (xhr, er) {
            console.log(xhr, er);
        }
    });
}

function recuperaSituacao(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaSituacao.php',
        dataType: 'html', 
        type: 'post',
        data: {funcao: 'recupera', codigo: codigo},      
        success: function (data) {
            callback(data); 
        }
    });
}

function excluirSituacao(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaSituacao.php', 
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', codigo: codigo}, //valores enviados ao script   
        success: function (data, textStatus) {
            debugger; 
            if (textStatus === 'success') {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success"); 
               voltar();
            } else {
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
            }
        }, error: function (xhr, er) {
            console.log(xhr, er);
        }
    });
}