<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');

require_once('fpdf/fpdf.php');

if ((empty($_GET["id"])) || (!isset($_GET["id"])) || (is_null($_GET["id"]))) {
    $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
    echo "failed#" . $mensagem . ' ';
    return;
} else {
    $codigo = +$_GET["id"];
}

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');










class PDF extends FPDF
{
    function Header()
    {
        global $codigo;

        $this->Cell(116, 1, "", 0, 1, 'C', 0); #Título do Relatório
        $this->Image('C:\inetpub\wwwroot\Cadastro\img\logoNTL.png',1, 1, 55, 18); #logo da empresa
        $this->SetXY(190, 5);
        $this->SetFont('Arial', 'B', 8); #Seta a Fonte
        $this->Cell(20, 5, 'Pagina ' . $this->pageno()); #Imprime o Número das Páginas

        $this->SetDrawColor(232, 232, 232);
        $this->SetFillColor(232, 232, 232);

        $this->Image('C:\inetpub\wwwroot\Cadastro\img\image (1).png', 46, 88, 110, 100); #logo da empresa

        $this->Ln(22); #Quebra de Linhas
    }

    function Footer()
    {
        $this->Image('https://media.discordapp.net/attachments/973591012826038362/1011666677802467328/footerRelatorio.png', -1, 275, 243, 30); #logo da empresa

        $this->SetY(-6.7);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 9);
        // Print centered page number
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', "São Paulo - Rio de janeiro
        ©NTL, Todos os direitos reservados, 1988 - 2022."), 0, 0, 'R');
    }
}

$pdf = new PDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
$pdf->SetMargins(5, 10, 5); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'default'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 14);
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(200, -8, iconv('UTF-8', 'windows-1252', "RELATÓRIO DOS FUNCIONARIOS"), 0, 0, "C", 1);
$pdf->Ln(8);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(193, -5, iconv('UTF-8', 'windows-1252', "DADOS DO FUNCIONÁRIO "), 0, 0, "C", 0);
$pdf->Ln(4);

$where = " WHERE (0 = 0) AND F.codigo = $codigo";

$sql = "SELECT F.codigo, F.nome, F.dataNascimento, F.cpf, F.ativo, rg, E.estadoCivil, G.genero, cep, logradouro, bairro, cidade, numero, complemento, uf, emprego, pispasep
 FROM Funcionarios AS F 
 LEFT JOIN dbo.genero AS G ON G.codigo = F.genero 
LEFT JOIN dbo.estadoCivil AS E ON F.estadoCivil = E.codigo";

$sql = $sql . $where;
$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";
$row = $result[0];
$y = 58;

if ($row) {
    $codigo = (int)$row['codigo'];
    $nome = (string)$row['nome'];
    $dataNascimento = $row['dataNascimento'];
    $dataNascimento = explode("-", $dataNascimento);
    $dataNascimento = "'" . $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0] . "'";
    $cpf = (string)$row['cpf'];
    $ativo = (int)$row['ativo'];
    $rg = (string)$row['rg'];
    $genero = (string)$row['genero'];
    $estadoCivil = (string)$row['estadoCivil'];
    $cep = (string)$row['cep'];
    $logradouro = (string)$row['logradouro'];
    $bairro = (string)$row['bairro'];
    $cidade = (string)$row['cidade'];
    $numero = (int)$row['numero'];
    $complemento = "," . (string)$row['complemento'];
    $uf = (string)$row['uf'];
    $emprego = (int)$row['emprego'];
    $pispasep = (string)$row['pispasep'];
}

if ($ativo == 1) {
    $descricaoAtivo = "Sim";
} else {
    $descricaoAtivo = "Não.";
}

if ($emprego == 1) {
    $emprego = "(X) Sim. ( ) Não";
} else {
    $emprego = "( ) Sim. (X) Não";
}

if ($pispasep == "") {
    $pispasep = "Primeiro emprego";
} else {
    $pispasep = "$pispasep";
}

if ($complemento == ",  ") {

    $complemento = "";
} else {

    $complemento = $complemento;
}

if ($email == " ") {

    $email = "";
    $emailPrincipal = "";
} else {

    $email = $email;
    $emailPrincipal = $emailPrincipal;
}

$sql = "SELECT * FROM funcionarioDependente WHERE funcionarios = $codigo";

$reposit = new reposit();
$strArrayDependente = $reposit->RunQuery($sql);

$contadorDependente = 0;

foreach ($strArrayDependente as $row) {
    $contadorDependente =  $contadorDependente + 1;
}

if ($contadorDependente == 0) {
    $contadorDependente = "Não possui dependente";
} else {
    $contadorDependente = "$contadorDependente";
}

// --------------------------------------------------------array telefone-------------------------------------------------------------------------------------------

$reposit = "";
$result = "";
$sql = "SELECT telefone, principalTel, whatsapp, funcionarios 
FROM funcionarioTelefone AS T  LEFT JOIN dbo.Funcionarios AS F ON T.funcionarios = F.codigo WHERE (0=0) AND F.codigo =" . $codigo;

$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$contadorTel = 0;
$arrayTelefone = array();
foreach ($result as $row) {

    $telefone = "";
    $telefone = $row['telefone'];
    $telefonePrincipal = "";
    $telefonePrincipal = $row['principalTel'];
    $whatsapp = "";
    $whatsapp = $row['whatsapp'];
    $funcionarios = "";
    $funcionarios = $row['funcionarios'];

   

    $contadorTel = $contadorTel + 1;
    $arrayTelefone[] = array(
        "sequencialTelefone" => $contadorTel,
        "telefone" => $telefone,
        "principalTel" => $telefonePrincipal,
        "whatsapp" => $whatsapp,
        "funcionarios" => $funcionarios
    );
}
$strArrayTelefone = json_encode($arrayTelefone);

// ---------------------------------------------------array email--------------------------------------------------------------------------------------

$reposit = "";
$result = "";
$sql = "SELECT E.email, E.principal, E.funcionarios FROM dbo.email AS E 
LEFT JOIN dbo.Funcionarios AS F ON E.funcionarios = F.codigo WHERE F.codigo =" . $codigo;

$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$contadorEmail = 0;
$arrayEmail = array();
foreach ($result as $row) {

    $email = $row['email'];
    $emailPrincipal = $row['principal'];
    $funcionarios = $row['funcionarios'];

    $contadorEmail = $contadorEmail + 1;
    $arrayEmail[] = array(
        "sequencialEmail" => $contadorEmail,
        "email" => $email,
        "principal" => $emailPrincipal,
        "funcionarios" => $funcionarios

    );
}
$strArrayEmail = json_encode($arrayEmail);

//-------------------------------------------- Array Dependente------------------------------------------------------//

$reposit = "";
$result = "";
$sql = "SELECT D.nome, D.tipoDependente, D.cpf, D.dataNascimento, T.descricao,  D.funcionarios 
FROM dbo.funcionarioDependente AS D 
LEFT JOIN dbo.tipoDependente AS T ON T.codigo = D.tipoDependente
LEFT JOIN dbo.Funcionarios AS F ON D.funcionarios = F.codigo WHERE F.codigo =" . $codigo;


$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$contadorDep = 0;
$arrayDependente = array();
foreach ($result as $row) {
    $tipo = mb_convert_encoding($row['tipoDependente'], 'UTF-8', 'HTML-ENTITIES');

    $nomeDependente = "";
    $nomeDependente = $row['nome'];
    $tipoDependente = "";
    $tipoDependente = $row['descricao'];
    $cpfDependente = "";
    $cpfDependente = $row['cpf'];
    $dependenteDataNasc = "";
    $dependenteDataNasc = $row['dataNascimento'];
    $dependenteDataNasc = explode("-", $dependenteDataNasc);
    $dependenteDataNasc = $dependenteDataNasc[2] . "/" . $dependenteDataNasc[1] . "/" . $dependenteDataNasc[0];
    $funcionarios = "";
    $funcionarios = $row['funcionarios'];

    $contadorDep = $contadorDep + 1;
    $arrayDependente[] = array(
        "sequencialDependente" => $contadorDep,
        "nome" => $nomeDependente,
        "tipoDependente" => $tipoDependente,
        "cpf" => $cpfDependente,
        "dataNascimento" => $dependenteDataNasc,
        "funcionarios" => $funcionarios
    );
}
$strArrayDependente = json_encode($arrayDependente);

// ---------------------------------------------------------------------------------------------------------------------------------

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 5, iconv('UTF-8', 'windows-1252', "Nome:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(15);
$pdf->Cell(50, 5, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "CPF:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(74);
$pdf->Cell(31, 5, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(14, 5, iconv('UTF-8', 'windows-1252', "RG:"), 0, 0, "R", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(119);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $rg), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', "Estado Civil: "), 0, 0, "R", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(171);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $estadoCivil), 0, 0, "L", 0);

$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(65, 5, iconv('UTF-8', 'windows-1252', "Primeiro Emprego:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(32);
$pdf->Cell(33, 5, iconv('UTF-8', 'windows-1252', $emprego), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "PIS/PASEP:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(83);
$pdf->Cell(19, 5, iconv('UTF-8', 'windows-1252', $pispasep), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', "Genêro: "), 0, 0, "R", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(124);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', $genero), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(29, 5, iconv('UTF-8', 'windows-1252', "Dependente:"), 0, 0, "R", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(171);
$pdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', $contadorDependente), 0, 0, "L", 0);

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 9, iconv('UTF-8', 'windows-1252', "Cidade:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(17.5);
$pdf->Cell(40, 9, iconv('UTF-8', 'windows-1252', $cidade . ", " . $uf), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 9, iconv('UTF-8', 'windows-1252', "Bairro:"), 0, 0, "R", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(76);
$pdf->Cell(35.5, 9, iconv('UTF-8', 'windows-1252', $bairro), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 9, iconv('UTF-8', 'windows-1252', "Endereço:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(126);
$pdf->Cell(56, 9, iconv('UTF-8', 'windows-1252', $logradouro . ", " . $numero .  $complemento), 0, 0, "L", 0);

$linhaPagina1 = $pdf->GetY();
$pdf->Line(0, $linhaPagina1 + 12, 285, $linhaPagina1 + 12);
$pdf->Ln(30);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, -18, iconv('UTF-8', 'windows-1252', "DADOS DE CONTATO - TELEFONE"), 0, 0, "C", 0);
$pdf->Ln(-2);

$pdf->SetX(50);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', "Telefone"), 1, 0, "C", true);
$pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', 'Principal'), 1, 0, "C", true);
$pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', 'Whatsapp'), 1, 0, "C", true);

$y += 20;

$i = 0;

foreach ($arrayTelefone as $key) {

    $y = $y + 10;
    $pdf->SetY(1 + $y);
    $pdf->SetX(50);

    $contadorTel = $contadorTel + 1;
    $telefone = $key["telefone"];
    $principal = $key["principalTel"];
    $whatsapp = $key["whatsapp"];

  
    $telefoneStatus = "";
    if ($principal == 1) {
        $telefoneStatus = "Sim";
    } else {
        $telefoneStatus = "Não";
    }

    $whatsappStatus = "";
    if ($whatsapp == 1) {
        $whatsappStatus = "Sim";
    } else {
        $whatsappStatus = "Não";
    }


    if ($principal == 1) {
        $pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $telefone), 1, 0, "C", 0);
        $pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $telefoneStatus), 1, 0, "C", 0);
        $pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $whatsappStatus), 1, 0, "C", 0);

    }

}

$y += 35;

foreach ($arrayTelefone as $key) {
   
    $i++;

    $y = $y + 10;
    $pdf->SetY(-74 + $y);
    $pdf->SetX(50);

      if($y == 138 ){
        $y =120;
    }

    $contadorTel = $contadorTel + 1;
    $telefone = $key["telefone"];
    $principal = $key["principalTel"];
    $whatsapp = $key["whatsapp"];

  
    $telefoneStatus = "";
    if ($principal == 1) {
        $telefoneStatus = "Sim";
    } else {
        $telefoneStatus = "Não";
    }

 
    $whatsappStatus = "";
    if ($whatsapp == 1) {
        $whatsappStatus = "Sim";
    } else {
        $whatsappStatus = "Não";
    }

    if ($i > 3) break;

    if ($principal == 0) {
        $pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $telefone), 1, 0, "C", 0);
        $pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $telefoneStatus), 1, 0, "C", 0);
        $pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $whatsappStatus), 1, 0, "C", 0);

    }

}

$linhaPagina1 = $pdf->GetY($y);
$pdf->Line(0, $linhaPagina1 + 19, 285, $linhaPagina1 + 19);
$pdf->Ln(5);

// ---------------------------------------------------------------------------------------------------------

$y += -10;

$pdf->SetY($y);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, -10, iconv('UTF-8', 'windows-1252', "DADOS DE CONTATO - EMAIL"), 0, 0, "C", 0);
$pdf->Ln(5);


$y += 4;

$pdf->SetY($y);
$pdf->SetX(43);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', "Email"), 1, 0, "C", true);
$pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', "Principal"), 1, 0, "C", true);


$y += -2;

$i = 0;

foreach ($arrayEmail as $key) {
    $y = $y + 10;
    $pdf->SetY(-8 + $y);
    $pdf->SetX(43);


    $contadorEmail = $contadorEmail + 1;
    $email = $key["email"];
    $emailPrincipal = $key["principal"];


    $emailStatus = "";
    if ($emailPrincipal == 1) {
        $emailStatus = "Sim";
    } else {
        $emailStatus = "Não";
    }

    if ($emailPrincipal == 1) {
       
        
    }
}

// $y += -2;

foreach ($arrayEmail as $key) {

    $d++;

    $y = $y + 10;
    $pdf->SetY(-28  + $y);
    $pdf->SetX(43);

    // if($y == 215 ){
    //     $y =205.4;
    // }


    $contadorEmail = $contadorEmail + 1;
    $email = $key["email"];
    $emailPrincipal = $key["principal"];


    $emailStatus = "";
    if ($emailPrincipal == 1) {
        $emailStatus = "Sim";
    } else {
        $emailStatus = "Não";
    }

    if ($d > 3) break;

    if ($emailPrincipal == 0) {
        $pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', "$email"), 1, 0, "C", 0);
        $pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', "$emailStatus"), 1, 0, "C", 0);
    }
}


$linhaPagina1 = $pdf->GetY($y);
$pdf->Line(0, $linhaPagina1 + 19, 285, $linhaPagina1 + 19);
$pdf->Ln(10);

// -------------------------------------------------------------------------------------------------------------------

$y += 5;

$pdf->SetY($y);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, -10, iconv('UTF-8', 'windows-1252', "DADOS DOS DEPENDENTES"), 0, 0, "C", 0);
$pdf->Ln(5);

$y += 4;

$pdf->SetY($y);
$pdf->SetX(30);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(48, 10, iconv('UTF-8', 'windows-1252', "Nome"), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', "Tipo"), 1, 0, "C", true);
$pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', "CPF"), 1, 0, "C", true);
$pdf->Cell(33, 10, iconv('UTF-8', 'windows-1252', "Data de Nascimento"), 1, 0, "C", true);

$y += -8 ;

foreach ($arrayDependente as $key) {

    $y = $y + 10;
    $pdf->SetY(8 + $y);
    $pdf->SetX(30);

    if ($y == 266) {
       $y = 19;
    }


    $contadorDep = $contadorDep + 1;
    $sequencialDependente = $key["sequencialDependente"];
    $funcionarios = $key["funcionarios"];

    $pdf->Cell(48, 10, iconv('UTF-8', 'windows-1252', $nomeDependente), 1, 0, "C", 0);
    $pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $tipoDependente), 1, 0, "C", 0);
    $pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $cpfDependente), 1, 0, "C", 0);
    $pdf->Cell(33, 10, iconv('UTF-8', 'windows-1252', $dependenteDataNasc), 1, 0, "C", 0);

    $nomeDependente = $key["nome"];
        $nomeDependente = ($nomeDependente);
    
        $tipoDependente = $key["tipoDependente"];
        $tipoDependente = ($tipoDependente);
    
        $cpfDependente = $key["cpf"];
        $cpfDependente = ($cpfDependente);
    
        $dependenteDataNasc = $key["dataNascimento"];
        $dependenteDataNasc = ($dependenteDataNasc);
    
  
        // AcceptPageBreak()
}
$pdf->Output();