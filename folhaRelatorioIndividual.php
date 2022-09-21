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

$sql= "SELECT DISTINCT F.codigo, F.nome, F.dataNascimento, F.cpf, F.rg, G.genero as apelidoGenero , E.estadoCivil as apelidoEstado, F.cep, F.logradouro, F.bairro,
F.cidade, F.numero, F.complemento, F.uf, F.emprego, F.pispasep FROM Funcionarios AS F 
INNER JOIN dbo.genero AS G ON G.codigo = F.genero 
INNER JOIN dbo.estadoCivil AS E ON E.codigo = F.estadoCivil WHERE (0=0) AND F.codigo = $codigo";

$sql = $sql . $where;
$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";
$row = $result[0];

if ($row) {
    $codigo = (int)$row['codigo'];
    $nome = (string)$row['nome'];
    $dataNascimento = $row['dataNascimento'];
    $dataNascimento = explode("-", $dataNascimento);
    $dataNascimento = "'" . $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0] . "'";
    $cpf = (string)$row['cpf'];
    $ativo = (int)$row['ativo'];
    $rg = (string)$row['rg'];
    $genero = (string)$row['apelidoGenero'];
    $estadoCivil = (string)$row['apelidoEstado'];
    $cep = (string)$row['cep'];
    $logradouro = (string)$row['logradouro'];
    $bairro = (string)$row['bairro'];
    $cidade = (string)$row['cidade'];
    $numero = (int)$row['numero'];
    $complemento = (string)$row['complemento'];
    $uf = (string)$row['uf'];
    $emprego = (int)$row['emprego'];
    $pispasep = (string)$row['pispasep'];
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

// -----------------------------------------------------------------

$sql = "SELECT telefone, principalTel, whatsapp
FROM funcionarioTelefone AS T  LEFT JOIN dbo.Funcionarios AS F ON T.funcionarios = F.codigo WHERE (0=0) AND F.codigo = $codigo";

$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$contadorTel = 0;
$arrayTelefone = array();
foreach ($result as $row) {

    $telefone = $row['telefone'];
    $telefonePrincipal = $row['principalTel'];
    $whatsapp = $row['whatsapp'];

    $contadorTel = $contadorTel + 1;
    $arrayTelefone[] = array(
        "sequencialTelefone" => $contadorTel,
        "telefone" => $telefone,
        "principalTel" => $telefonePrincipal,
        "whatsapp" => $whatsapp,
    );
}
$strArrayTelefone = json_encode($arrayTelefone);

// ----------------------------------------------------------------------------------

$sql = "SELECT E.email, E.principal FROM dbo.email AS E 
LEFT JOIN dbo.Funcionarios AS F ON E.funcionarios = F.codigo WHERE F.codigo = $codigo";

$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$contadorEmail = 0;
$arrayEmail = array();
foreach ($result as $row) {

    $email = $row['email'];
    $emailPrincipal = $row['principal'];

    $contadorEmail = $contadorEmail + 1;
    $arrayEmail[] = array(
        "sequencialEmail" => $contadorEmail,
        "email" => $email,
        "principal" => $emailPrincipal,

    );
}
$strArrayEmail = json_encode($arrayEmail);

// ------------------------------------------------------------------------------------------------

$sql= "SELECT D.nome, D.cpf, D.dataNascimento, T.descricao 
FROM dbo.funcionarioDependente AS D
INNER JOIN dbo.Funcionarios AS F ON D.funcionarios = F.codigo
INNER JOIN dbo.tipoDependente AS T ON T.codigo = D.tipoDependente WHERE F.codigo = $codigo";


$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$contadorDep = 0;
$arrayDependente = array();
foreach ($result as $row) {
    $tipo = mb_convert_encoding($row['tipoDependente'], 'UTF-8', 'HTML-ENTITIES');

    
    $nomeDependente = $row['nome'];
    $tipoDependente = $row['descricao'];
    $cpfDependente = $row['cpf'];
    $dependenteDataNasc = $row['dataNascimento'];
    $dependenteDataNasc = explode("-", $dependenteDataNasc);
    $dependenteDataNasc = $dependenteDataNasc[2] . "/" . $dependenteDataNasc[1] . "/" . $dependenteDataNasc[0];

    $contadorDep = $contadorDep + 1;
    $arrayDependente[] = array(
        "sequencialDependente" => $contadorDep,
        "nome" => $nomeDependente,
        "tipoDependente" => $tipoDependente,
        "cpf" => $cpfDependente,
        "dataNascimento" => $dependenteDataNasc,

    );
}
$strArrayDependente = json_encode($arrayDependente);

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
        $this->Image('https://media.discordapp.net/attachments/973591012826038362/1011666677802467328/footerRelatorio.png', -1, 276, 243, 30); #logo da empresa

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



$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 9, iconv('UTF-8', 'windows-1252', "Cidade:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(17);
$pdf->Cell(44, 9, iconv('UTF-8', 'windows-1252', $cidade),0 , 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 9, iconv('UTF-8', 'windows-1252', "Bairro:"), 0, 0, "R", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(76);
$pdf->Cell(36.5, 9, iconv('UTF-8', 'windows-1252', $bairro), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(6, 9, iconv('UTF-8', 'windows-1252', "UF:"), 0, 0, "R", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(118);
$pdf->Cell(20, 9, iconv('UTF-8', 'windows-1252', $uf), 0, 0, "L", 0);


$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 9, iconv('UTF-8', 'windows-1252', "Endereço:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(21);
$pdf->Cell(65, 9, iconv('UTF-8', 'windows-1252', $logradouro ), 0, 0, "L", 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 9, iconv('UTF-8', 'windows-1252', "Numero:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(100);
$pdf->Cell(12, 9, iconv('UTF-8', 'windows-1252', $numero ),0 , 0, "L", 0); 

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(23, 9, iconv('UTF-8', 'windows-1252', "Complemento:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(136);
$pdf->Cell(70, 9, iconv('UTF-8', 'windows-1252', $complemento ), 0, 0, "L", 0);


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

$pdf->Ln(10);

foreach ($arrayTelefone as $key) {


    $y = $y + 10;
    $pdf->SetY(86 + $y);
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
  
$pdf->SetX(50);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $telefone), 1, 0, "C", 0);
$pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $telefoneStatus), 1, 0, "C", 0);
$pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', $whatsappStatus), 1, 0, "C", 0);
    
}
  

$y += 20;



$linhaPagina1 = $pdf->GetY();
$pdf->Line(0, $linhaPagina1 + 15, 285, $linhaPagina1 + 15);
$pdf->Ln(27);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, -10, iconv('UTF-8', 'windows-1252', "DADOS DE CONTATO - EMAIL"), 0, 0, "C", 0);
$pdf->Ln(2);

$pdf->SetX(42);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', "Email"), 1, 0, "C", true);
$pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', 'Principal'), 1, 0, "C", true);

$pdf->Ln(10);

foreach ($arrayEmail as $key) {


    $y = $y + 10;
    $pdf->SetY(95 + $y);
    $pdf->SetX(42);


    $contadorEmail = $contadorEmail + 1;
    $email = $key["email"];
    $emailPrincipal = $key["principal"];


    $emailStatus = "";
    if ($emailPrincipal == 1) {
        $emailStatus = "Sim";
    } else {
        $emailStatus = "Não";
    }

    $pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', "$email"), 1, 0, "C", 0);
    $pdf->Cell(58, 10, iconv('UTF-8', 'windows-1252', "$emailStatus"), 1, 0, "C", 0);
    
}


$y += 20;

$linhaPagina1 = $pdf->GetY();
$pdf->Line(0, $linhaPagina1 + 15, 285, $linhaPagina1 + 15);
$pdf->Ln(25);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, -10, iconv('UTF-8', 'windows-1252', "DADOS DOS DEPENDENTES"), 0, 0, "C", 0);
$pdf->Ln(5);

$pdf->SetX(30);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(48, 10, iconv('UTF-8', 'windows-1252', "Nome"), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', "Tipo"), 1, 0, "C", true);
$pdf->Cell(35, 10, iconv('UTF-8', 'windows-1252', "CPF"), 1, 0, "C", true);
$pdf->Cell(33, 10, iconv('UTF-8', 'windows-1252', "Data de Nascimento"), 1, 0, "C", true);

$pdf->Ln(10);

foreach ($arrayDependente as $key) {

    // $y = $y + 10;
    $x = 30;
    // $pdf->SetY(105 + $y);
    $pdf->SetX($x);

    // if ($y > 160) {
    //     $y = 10;
    //  }

    $contadorDep = $contadorDep + 1;
    $sequencialDependente = $key["sequencialDependente"];


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

        $pdf->ln();
}

$pdf->Output();