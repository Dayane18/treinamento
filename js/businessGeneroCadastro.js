 function gravaGeneroCadastro(codigo, genero, ativo, callback) {
    $.ajax({
        url: 'js/sqlscope_GeneroCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { 
            funcao: "gravar",
            codigo:codigo, 
            genero:genero, 
            ativo:ativo,
        },   
        success: function (data) {
            callback(data);
        } 
    }); 
}  

function recuperaGeneroCadastro(codigo,callback) {
    $.ajax({
        url: 'js/sqlscope_GeneroCadastro.php', //caminho do arquivo a ser executado
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
  
function verificarGenero(genero, callback) {
    $.ajax({
        url:  'js/sqlscope_GeneroCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificarGenero", genero: genero }, //valores enviados ao script
        success: function (data) {
            callback(data)
        }
    });
}

function excluirGeneroCadastro(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_GeneroCadastro.php', //caminho do arquivo a ser executado
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
