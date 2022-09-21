<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
// $condicaoAcessarOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('USUARIO_GRAVAR', $arrayPermissao, true));

// $esconderBtnGravar = "";
// if ($condicaoGravarOK === false) {
//     $esconderBtnGravar = "none";
// }

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Usuário Filtro";
$page_nav['configuracao']['sub']['usuarios']['active'] = true;

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Cadastro"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style"">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Usuário Filtro</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuarioFiltro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <!-- <section class="col col-4">
                                                                <label class="label">Nome</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="nome" maxlength="50" name="nome" type="text" value="">
                                                                </label>
                                                            </section> -->
                                                            <section class="col col-3 col-auto">
                                                                <label class="label">Nome</label>
                                                                <label class="input">
                                                                    <input id="nome" maxlength="" name="nome" type="text" class="" value="">
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label"> Ativo </label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="">
                                                                        <option value=""></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" type="text" maxlength="14" name="cpf" class="" value="" class="form-control cpf-mask">
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Gênero</label>
                                                                <label class="select">
                                                                    <!-- <option></option> -->
                                                                    <select id="genero" type="text" maxlength="15" name="genero" class="" value="" placeholder="">

                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, genero 
                                                                        FROM dbo.genero
                                                                        WHERE ativo = 1 ";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $genero = $row['genero'];
                                                                            echo
                                                                            '<option value=' . $codigo . '>' . $genero . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Estado civil</label>
                                                                <label class="select">
                                                                    <select id="estadocivil" type="text" maxlength="15" name="estadocivil" class="" value="" placeholder="">
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, estadoCivil 
                                                                        FROM dbo.estadoCivil
                                                                        WHERE ativo = 1 ";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $estadoCivil = $row['estadoCivil'];
                                                                            echo '<option value=' . $codigo . '>' . $estadoCivil . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label">Data Inicial
                                                                </label>
                                                                <label class="input">
                                                                    <input id="dataInicial" maxlength="" name="dataInicial" type="text" class="datepicker " value="" placeholder="Ex.: dd/mm/aaaa" maxlength="10" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="--/--/----" data-dateformat="dd/mm/yy">
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label">Data final</label>
                                                                <label class="input">
                                                                    <input id="dataFinal" maxlength="" name="dataFinal" type="text" class="datepicker " value="" placeholder="Ex.: dd/mm/aaaa" maxlength="10" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="--/--/----" data-dateformat="dd/mm/yy">
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <footer>
                                                    <button id="btnSearch" type="button" class="btn btn-info pull-right" title="Buscar">
                                                        <span class="fa fa-search"></span>
                                                        <button id="btnNovo" type="button" class="btn btn-primary pull-right" title="Novo">
                                                            <span class="fa fa-file"></span>
                                                        </button>
                                                        <button id="btnPdf" type="button" class="btn btn-danger pull-right" title="Pdf">
                                                            <span class="fa fa-file-pdf-o"></span>
                                                        </button>
                                                </footer>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="resultadoBusca"></div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
        <!-- end widget grid -->
    </div>
    <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>
<!--script src="<?php echo ASSETS_URL; ?>/js/businessTabelaBasica.js" type="text/javascript"></script-->
<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script>
    $("#cpf").mask("999.999.999-99");

    $(document).ready(function() {
        $('#btnSearch').on("click", function() {
            listarFiltro();
        });
        $('#btnNovo').on("click", function() {
            novo();
        });

        $('#btnPdf').on("click", function() {
            gerarPdf();
        });

    });

    function listarFiltro() {

        var nomeFiltro = $('#nome').val();
        var ativoFiltro = $('#ativo').val();
        var CpfFiltro = $('#cpf').val();
        var dataInicial = $('#dataInicial').val();
        var dataFinal = $('#dataFinal').val();
        var generoFiltro = $('#genero').val();
        var estadoCivilFiltro = $('#estadocivil').val();

        var data = new Date();
        var dia = data.getDate();
        var mes = data.getMonth();
        var anoAtual = data.getFullYear();

        var dataAtual = dia + '/' + mes + '/' + anoAtual;


        if (dataInicial != "") {

            if (dataInicial < '01/01/1922' || dataInicial > dataAtual) {
                smartAlert("Atenção", "DATA INVALIDA!", "error");
                $('#dataInicial').val('');
                return;
            }
        }

        if (dataFinal != "") {

            if (dataFinal < '01/01/1922' ||  dataFinal > dataAtual) {
                smartAlert("Atenção", "DATA INVALIDA!", "error");
                $('#dataFinal').val('');
                return;
            }
        }

        var parametrosUrl = '&nomeFiltro=' + encodeURIComponent(nomeFiltro) + '&ativoFiltro=' + encodeURIComponent(ativoFiltro) + '&cpfFiltro=' + encodeURIComponent(CpfFiltro) +
            '&dataInicial=' + encodeURIComponent(dataInicial) + '&dataFinal=' + encodeURIComponent(dataFinal) + '&generoFiltro=' + encodeURIComponent(generoFiltro) + '&estadoCivilFiltro=' + encodeURIComponent(estadoCivilFiltro);

        $('#resultadoBusca').load('funcionarioCadastroFiltroListagem.php?' + parametrosUrl);
    }

    function novo() {
        $(location).attr('href', 'funcionarioCadastro.php');
    }

    function gerarPdf() {
        var generoPdf = $('#genero').val();
        var estadoCivilPdf = $('#estadocivil').val();

        var parametrosUrl = '&generoPdf=' + encodeURIComponent(generoPdf) + '&estadoCivilPdf=' + encodeURIComponent(estadoCivilPdf);
        $(location).attr('href', 'folhaRelatorio.php?' + parametrosUrl);
    }

    function gerarPdfIndividual() {

        $(location).attr('href', 'folhaRelatorioIndividual.php?');
    }
</script>