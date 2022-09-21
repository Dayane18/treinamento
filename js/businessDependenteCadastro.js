 function gravaDependenteCadastro(codigo, descricao, ativo, callback) {
    $.ajax({
        url: 'js/sqlscope_DependenteCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { 
            funcao: "gravar",
            
            codigo:codigo,
            descricao:descricao,
            ativo:ativo,
        },   
        success: function (data) {
        callback(data);
        } 
    }); 
}  

function recuperaDependenteCadastro(codigo,callback) {
    $.ajax({
        url: 'js/sqlscope_DependenteCadastro.php', //caminho do arquivo a ser executado
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
  
function verificarDependente(descricao, callback) {
    $.ajax({
        url:  'js/sqlscope_DependenteCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificarDependente", descricao: descricao }, //valores enviados ao script
        success: function (data) {
            callback(data)
        }
    });
}

function excluirDependenteCadastro(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_DependenteCadastro.php', //caminho do arquivo a ser executado
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
