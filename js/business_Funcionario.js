function gravaFuncionario(id, ativo, nome, cpf, dataNascimento, callback) {
    $.ajax({
        url: 'js/sqlscope_usuarioCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "grava", id: id, ativo: ativo, nome: nome, cpf: cpf, dataNascimento: dataNascimento }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaCargo(id, callback) {
    $.ajax({
        url: 'js/sqlscope_usuarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function excluirCargo(id, callback) {
    $.ajax({
        url: 'js/sqlscope_usuarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}
function verificaCpf(cpf, callback) {
    $.ajax({
        url: 'js/sqlscope_UsuarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificaCpf", cpf: cpf }, //valores enviados ao script     
        success: function (data) {
            if (data == 'found'){
                smartAlert("Atenção", "CPF já cadastrado do sistema!", "error");

            }
            if (data == 'failed#') {
                $("#btnGravar").prop('disabled', true);
                smartAlert("Atenção", "CPF inválido!", "error");
                           
            }
            else {

                $("#btnGravar").prop('disabled', false);

            }
        }

    });
}

