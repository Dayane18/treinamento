<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'grava') {
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

return;

function grava()
{
    //Variáveis
    if ((empty($_POST['id'])) || (!isset($_POST['id'])) || (is_null($_POST['id']))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = (int) $_POST["ativo"];
    }

    session_start();
    $nome = "'". $_POST['nome'] ."'";
    $cpf = "'". $_POST['cpf'] ."'";
    $dataNascimento = $_POST['dataNascimento'] ;
    $dataNascimento = explode("/", $dataNascimento);
    $dataNascimento = "'". $dataNascimento[2] ."-". $dataNascimento[1] ."-".$dataNascimento[0] ."'";
    $ativo = $_POST['ativo'];

    $sql = 'funcionario_Atualiza ' . $id .','  . $ativo . ',' . $nome . ',' . $cpf . ','.  $dataNascimento .' '; 

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera()
{
    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    if (($condicaoId === false) && ($condicaoLogin === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if (($condicaoId === true) && ($condicaoLogin === true)) {
        $mensagem = "Somente 1 parâmetro de pesquisa deve ser informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoId) {
        $cargoIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT C.codigo,C.ativo,C.nome,C.cpf,C.dataNascimento from dbo.funcionario C WHERE (0 = 0)";

    if ($condicaoId) {
        $sql = $sql . " AND C.[codigo] = " . $cargoIdPesquisa . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if($row = $result[0]) {
        $id = +$row['codigo'];
        $ativo = +$row['ativo'];
        $nome = $row['nome'];
        $cpf =  $row['cpf'];
        $dataNascimento =  $row['dataNascimento'];
        $dataNascimento = explode(" ", $dataNascimento);
        $dataNascimento = explode("-", $dataNascimento[0]);
        $dataNascimento =  $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];


        $out = $id . "^" . $nome . "^" . $cpf . "^" . $ativo. "^" . $dataNascimento ;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }
}

function excluir()
{
    $reposit = new reposit();
    // $possuiPermissao = $reposit->PossuiPermissao("CARGO_ACESSAR|CARGO_EXCLUIR");
    // if ($possuiPermissao === 0) {
    //     $mensagem = "O usuário não tem permissão para excluir!";
    //     echo "failed#" . $mensagem . ' ';
    //     return;
    // }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um cargo para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    
    $result = $reposit->update('dbo.funcionario' .'|'.'ativo = 0'.'|'.'codigo ='.$id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function verificaCpf()
{
    $cpf = $_POST["cpf"];
    $sql = "SELECT cpf from cadastro.dbo.funcionario C WHERE (cpf = '$cpf')";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if (odbc_fetch_array($result)){
        echo 'found';
        return;
    }

    if (strpos($cpf, "-") !== false) {
        $cpf = str_replace("-", "", $cpf);
    }
    if (strpos($cpf, ".") !== false) {
        $cpf = str_replace(".", "", $cpf);
    }
    $sum = 0;
    $cpf = str_split($cpf);
    $cpftrueverifier = array();
    $cpfnumbers = array_splice($cpf, 0, 9);
    $cpfdefault = array(10, 9, 8, 7, 6, 5, 4, 3, 2);
    for ($i = 0; $i <= 8; $i++) {
        $sum += $cpfnumbers[$i] * $cpfdefault[$i];
    }
    $sumresult = $sum % 11;
    if ($sumresult < 2) {
        $cpftrueverifier[0] = 0;
    } else {
        $cpftrueverifier[0] = 11 - $sumresult;
    }
    $sum = 0;
    $cpfdefault = array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2);
    $cpfnumbers[9] = $cpftrueverifier[0];
    for ($i = 0; $i <= 9; $i++) {
        $sum += $cpfnumbers[$i] * $cpfdefault[$i];
    }
    $sumresult = $sum % 11;
    if ($sumresult < 2) {
        $cpftrueverifier[1] = 0;
    } else {
        $cpftrueverifier[1] = 11 - $sumresult;
    }
    $returner = 'failed#';
    if ($cpf == $cpftrueverifier) {
        $returner = 'sucess#';
    }


    $cpfver = array_merge($cpfnumbers, $cpf);

    if (count(array_unique($cpfver)) == 1 || $cpfver == array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0)) {
        $returner = 'failed#';
    }

    echo $returner;
    return;
}

