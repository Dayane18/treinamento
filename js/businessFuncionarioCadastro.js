function gravaUsuarioCadastro(codigo, nomeUsuario, dataNascimento, cpf, ativo, rg, genero, estadoCivil, jsonTelefoneArray, jsonEmailArray, cep, logradouro, cidade, bairro, numero, complemento,
     uf, jsonDependenteArray, emprego, pispasep,  callback) {
    $.ajax({
        url: 'js/sqlscope_FuncionarioCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "gravar",
            codigo: codigo,
            nomeUsuario: nomeUsuario,
            dataNascimento: dataNascimento,
            cpf: cpf,
            ativo: ativo,
            rg: rg,
            genero:genero,
            estadoCivil:estadoCivil,
            jsonTelefoneArray: jsonTelefoneArray,
            jsonEmailArray: jsonEmailArray,
            cep: cep,
            logradouro: logradouro,
            bairro: bairro,
            cidade: cidade,
            numero: numero,
            complemento: complemento,
            uf: uf,
            jsonDependenteArray:jsonDependenteArray,
            emprego:emprego,
            pispasep:pispasep
        },
        //success é nescessário!!!
        success: function (data) {
            callback(data);
        }
    });
}

function verificarCpfRepetido(cpf, callback) {
    $.ajax({
        url: 'js/sqlscope_FuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificaCpf", cpf: cpf }, //valores enviados ao script
        success: function (data) {
            callback(data)
        }
    });
}

function verificarRgRepetido(rg, callback) {
    $.ajax({
        url: 'js/sqlscope_FuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificaRgRepetido", rg: rg }, //valores enviados ao script
        success: function (data) {
            callback(data)
        }
    });
}

function validaTelefone(telefone, callback) {
    $.ajax({
        url: 'js/sqlscope_FuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: validaTelefone, telefone: telefone }, //valores enviados ao script
        success: function (data) {
            callback(data)
        }
    });
}

function validaEmail(email, callback) {
    $.ajax({
        url: 'js/sqlscope_FuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "validaEmail", email: email }, //valores enviados ao script
        success: function (data) {
            callback(data)
        }
    });
}

function recuperaUsuarioCadastro(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_FuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: 'recupera',
            codigo: codigo
        }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

function excluirUsuarioCadastro(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_FuncionarioCadastro.php', //caminho do arquivo a ser executado
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
