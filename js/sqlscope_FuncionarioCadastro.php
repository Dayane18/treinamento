<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravar') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'verificaCpf') {
    call_user_func($funcao);
}

if ($funcao == 'verificaRgRepetido') {
    call_user_func($funcao);
}


return;

function gravar()
{

    session_start();
    $codigo = (int)$_POST['codigo'];
    $nomeUsuario = "'" . $_POST['nomeUsuario'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $dataNascimento = $_POST['dataNascimento'];
    $dataNascimento = explode("/", $dataNascimento);
    $dataNascimento = "'" . $dataNascimento[2] . "-" . $dataNascimento[1] . "-" . $dataNascimento[0] . "'";
    $cpf = "'" . (string) $_POST['cpf'] . "'";
    $ativo = 1;
    $rg = "'" . (string) $_POST['rg'] . "'";
    $genero = (int) $_POST['genero'] ;
    $estadoCivil = (int) $_POST['estadoCivil'] ;


    $strArrayTelefone = $_POST['jsonTelefoneArray'];
    $arrayTelefone = ($strArrayTelefone);
    $xmlTelefone = "";
    $nomeXml = "ArrayOfFuncionarioTelefone";
    $nomeTabela = "funcionarioTelefone";
    if (sizeof($arrayTelefone) > 0) {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTelefone as $chave) {
            $xmlTelefone = $xmlTelefone . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialTelefone")) {
                    continue;
                }
                if ($campo === "descricaoTelefonePrincipal") {
                    $xmlTelefone = $xmlTelefone . "<" . $campo . '>"' . $valor . '"</' . $campo . ">";
                } else {
                    $xmlTelefone = $xmlTelefone . "<" . $campo . ">" . $valor . "</" . $campo . ">";
                }
            }
            $xmlTelefone = $xmlTelefone . "</" . $nomeTabela . ">";
        }
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    } else {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlTelefone);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlTelefone = "'" . $xmlTelefone . "'";

    // ---------------------------------email---------------------------------------------

    $comum = new comum();
    $strArrayEmail = $_POST["jsonEmailArray"];
    $arrayEmail = $strArrayEmail;
    $xmlEmail = new \FluidXml\FluidXml('ArrayOfEmail', ['encoding' => '']);
    foreach ($arrayEmail as $item) {
        $xmlEmail->addChild('email', true) //nome da tabela
            ->add('email', $item['email']) //setando o campo e definindo o valor
            ->add('emailPrincipal', $item['emailPrincipal']);
    }
    $xmlEmail = $comum->formatarString($xmlEmail);

    // -----------------------------------------Dependente-----------------------

    $comum = new comum();
    $strArrayDependente = $_POST["jsonDependenteArray"];
    $arrayDependente = $strArrayDependente;
    $xmlDependente = new \FluidXml\FluidXml('ArrayOfDependente', ['encoding' => '']);


    foreach ($arrayDependente as $item) {

        $dataNascDependente =(string)$item['dataNascDependente'];

        $dataNascDependente = (explode("/", $dataNascDependente, 3));
        $dataDia = $dataNascDependente[0];
        $dataMes = $dataNascDependente[1];
        $dataAno = $dataNascDependente[2];
        $item['dataNascDependente'] = $dataAno . '-' . $dataMes . '-' . $dataDia;

        $xmlDependente->addChild('Dependente', true) //nome da tabela
            ->add('nome', $item['dependente'])
            ->add('tipoDependente', $item['tipoDependente']) //setando o campo e definindo o valor
            ->add('cpf', $item['cpfDependente'])
            ->add('dataNascimento', $item['dataNascDependente']);
    }
    $xmlDependente = $comum->formatarString($xmlDependente);


    $cep = "'" . (string)$_POST['cep'] . "'";
    $logradouro = "'" . (string)$_POST['logradouro'] . "'";
    $bairro = "'" . (string)$_POST['bairro'] . "'";
    $cidade = "'" . (string)$_POST['cidade'] . "'";
    $numero = "'" . (string)$_POST['numero'] . "'";
    $complemento = "'" . (string)$_POST['complemento'] . "'";
    $uf = "'" . (string)$_POST['uf'] . "'";
    $emprego = "'" . (string)$_POST['emprego'] . "'";
    $pispasep = "'" . (string)$_POST['pispasep'] . "'";

    $sql = "dbo.funcionario_Atualiza
            $codigo,
            $nomeUsuario,
            $dataNascimento,
            $cpf,
            $ativo,
            $rg,
            $genero,
            $estadoCivil,
            $xmlTelefone,
            $xmlEmail,
            $cep,
            $logradouro,
            $bairro,
            $cidade,
            $numero,
            $complemento,
            $uf,
            $xmlDependente,
            $emprego,
            $pispasep";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

// --------------------------------------------------------------------------------------------------------

function recupera()
{
    $codigo = $_POST["codigo"];

    if ($codigo === "" || $codigo === null) {
        echo "failed#" . "É NECESSÁRIO UM CÓDIGO!";
        return;
    }

    $sql = "SELECT codigo, nome, dataNascimento, cpf, ativo, rg, genero, estadoCivil, cep, logradouro, bairro, cidade, numero, complemento, uf, emprego, pispasep 
    FROM dbo.Funcionarios 
    WHERE codigo = $codigo";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        $codigo = (int)$row['codigo'];
        $nomeUsuario = (string)$row['nome'];
        $dataNascimento = (string)$row['dataNascimento'];
        $cpf = (string)$row['cpf'];
        $ativo = (int)$row['ativo'];
        $rg = (string)$row['rg'];
        $genero = (string)$row['genero'];
        $estadoCivil = (string)$row['estadoCivil'];
        $cep = (string)$row['cep'];
        $logradouro = (string)$row['logradouro'];
        $bairro = (string)$row['bairro'];
        $cidade = (string)$row['cidade'];
        $numero = (string)$row['numero'];
        $complemento = (string)$row['complemento'];
        $uf = (string)$row['uf'];
        $emprego = (int)$row['emprego'];
        $pispasep = (string)$row['pispasep'];

        $dataNascimento = explode("-", $dataNascimento);
        $dataDia = $dataNascimento[2];
        $dataMes = $dataNascimento[1];
        $dataAno = $dataNascimento[0];
        $dataNascimento = $dataDia . '/' . $dataMes . '/' . $dataAno;



        $sql = "SELECT telefone, principalTel, whatsapp FROM dbo.funcionarioTelefone WHERE funcionarios = $codigo";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contadorTelefone = 0;
        $arrayTelefone = array();
        foreach ($result as $row) {

            $telefone = $row['telefone'];
            $principal = $row['principalTel'];
            $whatsapp = $row['whatsapp'];

            if ($principal == 1) {
                $descricaoTelefonePrincipal = "Sim";
            } else {
                $descricaoTelefonePrincipal = "Não";
            }

            if ($whatsapp == 1) {
                $descricaoTelefoneWhatsApp = "Sim";
            } else {
                $descricaoTelefoneWhatsApp = "Não";
            }

            $contadorTelefone = $contadorTelefone + 1;
            $arrayTelefone[] = array(
                "sequencialTelefone" => $contadorTelefone,
                "telefone" => $telefone,
                "telefonePrincipal" => $principal,
                "telefoneWhatsApp" => $whatsapp,
                "descricaoTelefonePrincipal" => $descricaoTelefonePrincipal,
                "descricaoTelefoneWhatsApp" => $descricaoTelefoneWhatsApp
            );
        }
        $strArrayTelefone = json_encode($arrayTelefone);

        // ------------------------------email-------------------

        $sql = "SELECT email, principal FROM dbo.email WHERE funcionarios = $codigo";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contadorEmail = 0;
        $arrayEmail = array();
        foreach ($result as $row) {

            $email = $row['email'];
            $principal = $row['principal'];

            if ($principal == 1) {
                $descricaoEmailPrincipal = "Sim";
            } else {
                $descricaoEmailPrincipal = "Não";
            }

            $contadorEmail = $contadorEmail + 1;
            $arrayEmail[] = array(
                "sequencialEmail" => $contadorEmail,
                "email" => $email,
                "emailPrincipal" => $principal,
                "descricaoEmailPrincipal" => $descricaoEmailPrincipal
            );
        }
        $strArrayEmail = json_encode($arrayEmail);

        $sql = "SELECT nome, tipoDependente, cpf, dataNascimento FROM dbo.funcionarioDependente WHERE funcionarios = $codigo";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contadorDependente = 0;
        $arrayDependente = array();
        foreach ($result as $row) {

            $nome = $row['nome'];
            $tipoDependente = $row['tipoDependente'];
            $cpfDependente = $row['cpf'];
            $dataNasc = $row['dataNascimento'];
            $dataNasc = (explode("-", $dataNasc, 3));
            $dataDia = $dataNasc[2];
            $dataMes = $dataNasc[1];
            $dataAno = $dataNasc[0];
            $dataNasc = $dataDia . '/' . $dataMes . '/' . $dataAno;

            $contadorDependente = $contadorDependente + 1;
            $arrayDependente[] = array(
                "sequencialDependente" => $contadorDependente,
                "dependente" => $nome,
                "tipoDependente" => $tipoDependente,
                "cpfDependente" => $cpfDependente,
                "dataNascDependente" => $dataNasc
            );
        }
        $strArrayDependente = json_encode($arrayDependente);

        $out = $codigo . "^" .
            $nomeUsuario . "^" .
            $dataNascimento . "^" .
            $cpf . "^" .
            $ativo . "^" .
            $rg . "^" .
            $genero . "^" .
            $estadoCivil . "^" .
            $cep . "^" .
            $logradouro . "^" .
            $bairro . "^" .
            $cidade . "^" .
            $numero . "^" .
            $complemento . "^" .
            $uf . "^" .
            $emprego . "^" .
            $pispasep;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . '#' . $strArrayTelefone . '#' . $strArrayEmail . '#' . $strArrayDependente;
        }
        return;
    }
}

// ---------------------------------------------------------------------------------------------------------------

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("USUARIO_ACESSAR|USUARIO_EXCLUIR");

    // if ($possuiPermissao === 0) {
    //     $mensagem = "O usuário não tem permissão para excluir!";
    //     echo "failed#" . $mensagem . ' ';
    //     return;
    // }

    $codigo = $_POST["codigo"];

    if ((empty($_POST['codigo']) || (!isset($_POST['codigo'])) || (is_null($_POST['codigo'])))) {
        $mensagem = "Selecione um lancamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('dbo.Funcionarios' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

// ---------------------------------------------------------------------------------------------------------------

function verificaCpf()
{
    $cpf = $_POST["cpf"];
    $sql = "SELECT cpf FROM dbo.Funcionarios WHERE cpf = '$cpf'";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (count($result) > 0) {
        echo 'failed#';
        return;
    }
    echo 'sucess#';
    return;
}

// ---------------------------------------------------------------------------------------------------------------------

function verificaRgRepetido()
{
    $rg = $_POST["rg"];
    $sql = "SELECT rg FROM dbo.Funcionarios WHERE rg = '$rg'";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (count($result) > 0) {
        echo 'failed#';
        return;
    }

    echo 'sucess#';
    return;
}


// ---------------------------------------------------------------------------------------------------------------------------


