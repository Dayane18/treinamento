 function gravaEstadoCivilCadastro(codigo, estadoCivil, ativo, callback) {
    $.ajax({
        url: 'js/sqlscope_EstadoCivilCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { 
            funcao: "gravar",
            codigo:codigo, 
            estadoCivil:estadoCivil, 
            ativo:ativo,
        },   
        success: function (data) {
        callback(data);
        } 
    }); 
}  

function recuperaEstadoCivilCadastro(codigo,callback) {
    $.ajax({
        url: 'js/sqlscope_EstadoCivilCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao:'recupera',
            codigo:codigo
        }, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function verificarEstadoCivil(estadoCivil, callback) {
    $.ajax({
        url:  'js/sqlscope_EstadoCivilCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificarEstadoCivil", estadoCivil: estadoCivil }, //valores enviados ao script
        success: function (data) {
            callback(data)
        }
    });
}
  
function excluirEstadoCivilCadastro(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_EstadoCivilCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: 'excluir',
            codigo: codigo,
    }, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}
