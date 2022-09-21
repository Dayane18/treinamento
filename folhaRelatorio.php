<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');

require_once('fpdf/fpdf.php');

// if ((empty($_GET["codigo"])) || (!isset($_GET["codigo"])) || (is_null($_GET["codigo"]))) {
//     $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
//     echo "failed#" . $mensagem . ' ';
//     return;
// } else {
//     $codigo = +$_GET["codigo"];
// }

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

        $this->Ln(24); #Quebra de Linhas
    }

    function Footer()
    {
        $this->Image('https://media.discordapp.net/attachments/973591012826038362/1011666677802467328/footerRelatorio.png', -1, 265, 215, 35); #logo da empresa

        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 9);
        // Print centered page number
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', "São Paulo - Rio de janeiro
        ©NTL, Todos os direitos reservados, 1988 - 2022."), 0, 0, 'R');
    }
}

$pdf = new PDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
$pdf->SetMargins(5, 10, 5); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();

$pdf->AcceptPageBreak();

$pdf->SetFont('Times', 'B', 14);
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(200, -7, iconv('UTF-8', 'windows-1252', "RELATÓRIO DOS FUNCIONARIOS"), 1, 1, "C", 1);
$pdf->Ln(8);

$where = " WHERE (0 = 0)";

$sql = 'SELECT F.codigo, F.nome, F.dataNascimento, F.cpf, F.ativo, F.rg, E.estadoCivil, G.genero, F.cep, F.logradouro, F.bairro, F.cidade, F.numero, F.complemento, F.uf, F.emprego, F.pispasep
FROM Funcionarios AS F LEFT JOIN dbo.genero AS G ON G.codigo = F.genero 
LEFT JOIN dbo.estadoCivil AS E ON F.estadoCivil = E.codigo';

$generoPdf = "";
$generoPdf = $_GET["generoPdf"];

if ($generoPdf) {
    $where = $where  . " AND G.codigo = $generoPdf";
}

$estadoCivilPdf = "";
$estadoCivilPdf = $_GET["estadoCivilPdf"];

if ($estadoCivilPdf) {
    $where = $where  . " AND E.codigo = $estadoCivilPdf";
}

$sql = $sql . $where;
$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$y = 58;


foreach ($result as $row) {

    $codigo = (int)$row['codigo'];
    $nome = (string)$row['nome'];
    $dataNascimento = (string)$row['dataNascimento'];
    $dataNascimento = explode("/", $dataNascimento);
    $dataNascimento = "'" . $dataNascimento[2] . "-" . $dataNascimento[1] . "-" . $dataNascimento[0] . "'";
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
    $complemento = ", " . (string)$row['complemento'];
    $uf = (string)$row['uf'];
    $emprego = (int)$row['emprego'];
    $pispasep = (string)$row['pispasep'];

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

    if ($complemento == ", ") {

        $complemento = "";
    } else {

        $complemento = $complemento;
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

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(13, 15, iconv('UTF-8', 'windows-1252', "Nome:"), 0, 0, "L", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(15);
    $pdf->Cell(50, 15, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 15, iconv('UTF-8', 'windows-1252', "CPF:"), 0, 0, "L", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(74);
    $pdf->Cell(31, 15, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(14, 15, iconv('UTF-8', 'windows-1252', "RG:"), 0, 0, "R", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(119);
    $pdf->Cell(30, 15, iconv('UTF-8', 'windows-1252', $rg), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(23, 15, iconv('UTF-8', 'windows-1252', "Estado Civil: "), 0, 0, "R", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(169.5);
    $pdf->Cell(30, 15, iconv('UTF-8', 'windows-1252', $estadoCivil), 0, 0, "L", 0);

    $pdf->Ln(7);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(65, 15, iconv('UTF-8', 'windows-1252', "Primeiro Emprego:"), 0, 0, "L", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(32);
    $pdf->Cell(33, 15, iconv('UTF-8', 'windows-1252', $emprego), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 15, iconv('UTF-8', 'windows-1252', "PIS/PASEP:"), 0, 0, "L", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(83);
    $pdf->Cell(19, 15, iconv('UTF-8', 'windows-1252', $pispasep), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(23, 15, iconv('UTF-8', 'windows-1252', "Genêro: "), 0, 0, "R", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(124);
    $pdf->Cell(18, 15, iconv('UTF-8', 'windows-1252', $genero), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(29, 15, iconv('UTF-8', 'windows-1252', "Dependente:"), 0, 0, "R", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(171);
    $pdf->Cell(37, 15, iconv('UTF-8', 'windows-1252', $contadorDependente), 0, 0, "L", 0);

    $pdf->Ln(7);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(12, 15, iconv('UTF-8', 'windows-1252', "Cidade:"), 0, 0, "L", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(17);
    $pdf->Cell(40, 15, iconv('UTF-8', 'windows-1252', $cidade), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(19, 15, iconv('UTF-8', 'windows-1252', "Bairro:"), 0, 0, "R", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(77);
    $pdf->Cell(34.5, 15, iconv('UTF-8', 'windows-1252', $bairro), 0, 0, "L", 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(16, 15, iconv('UTF-8', 'windows-1252', "Endereço:"), 0, 0, "L", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(128);
    $pdf->Cell(56, 15, iconv('UTF-8', 'windows-1252', $logradouro . ", " .  $numero . $complemento), 0, 0, "L", 0);

    $linhaPagina1 = $pdf->GetY();
    $pdf->Line(0, $linhaPagina1 + 15, 265, $linhaPagina1 + 15);

    $pdf->Ln(12);
}



$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln();

$pdf->Ln();

$pdf->SetFont('Arial', '', 8);
$contador = 0;

$pdf->Ln(8);

$pdf->Output();
