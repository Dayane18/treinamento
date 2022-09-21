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

if ($funcao == 'verificarGenero') {
    call_user_func($funcao);
}
return;

function gravar()
{

    session_start();
    $codigo = (int)$_POST['codigo'];
    $genero = "'" . $_POST['genero'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $ativo = 1; 

    $sql = "dbo.Genero_Atualiza 
            $codigo,
            $genero,
            $ativo";

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
    $codigo = $_POST["codigo"]; 
 
    if( $codigo === "" || $codigo === null ) {
        echo "failed#" . "É NECESSÁRIO UM CÓDIGO!";
        return;
    }


    $sql = "SELECT codigo, genero, ativo FROM dbo.genero WHERE codigo = $codigo";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if($row = $result[0]) {

        $codigo = (int)$row['codigo'];
        $genero = (string)$row['genero'];
        $ativo = (int)$row['ativo'];

        $out = $codigo . "^" . $genero . "^" . $ativo;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out;
        }
        return;
    }
}

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
        echo "failed#" . ' ';
        return;
    }

    $result = $reposit->update('dbo.genero' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}


function verificarGenero()
{
    $genero = $_POST["genero"];
    $sql = "SELECT genero FROM dbo.genero WHERE genero = '$genero' AND ATIVO = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (count($result) > 0) {
        echo 'failed#GÊNERO JÁ CADASTRADO';
        return;
    }
    echo 'sucess#';
    return;
}
