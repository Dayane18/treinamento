<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = true;
$condicaoGravarOK = true;
$condicaoExcluirOK = true;



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */
  $page_title = "Estado civil Filtro";
  $page_nav['tabelaBasica']['sub']['estadoCivil']['active'] = true;

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php


include("inc/nav.php");

/* $page_nav["configuração"]["sub"]["filtro"]["active"] = true; */

include("inc/nav.php");



?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "://url.com"
    $breadcrumbs["Configurações"] = "";
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
                            <h2>Cadastro Estado Civil</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="" class="smart-form client-form" id="formUsuario" method="post " enctype="multipart/form-data">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Estado civil
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" value="" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Estado civil</label>
                                                                <label class="input">
                                                                    <input id="estadoCivil" type="text" maxlength="999" name="estadocivil" class="required" value="" placeholder="" pattern="[a-zA-Záãâéêíîóôõú\s]+$" onkeyup="verificarNome()">
                                                                </label>
                                                            </section>
                                                            <!-- <section class="col col-3">
                                                                <label class="label">Descrição</label>
                                                                <label class="input">
                                                                    <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                        <input id="descricao" maxlength="255" name="descricao" class="required" type="text" value="">
                                                                    </label>
                                                                </label>
                                                                </label>
                                                            </section> -->
                                                            <section class="col col-1 col-auto" hidden>
                                                                <label class="label"> Ativo </label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-2" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <p>CONFIRMA A EXCLUSÃO ? </p>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-floppy-o"></span>
                                        </button>
                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o"></span>
                                        </button>
                                        <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                            <span class="fa fa-backward "></span>
                                        </button>
                                    </footer>
                                </form>
                            </div>
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

<script src="<?php echo ASSETS_URL; ?>/js/businessEstadoCivilCadastro.js" type="text/javascript"></script>

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
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {


        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "Atenção",
            buttons: [{
                html: "Excluir registro",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    excluir();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });

        $("#btnExcluir").on("click", function() {
            var id = $("#codigo").val();

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });


        $("#btnNovo").on("click", function() {
            novo();
        });



        
        $("#btnGravar").on("click", function() {
            verificaEstadoCivil();

        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });


        carregaPagina();
    });


    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaEstadoCivilCadastro(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            piece = out.split("^");
                            // Atributos de vale transporte unitário que serão recuperados: 
                            var codigo = piece[0];
                            var estadoCivil = piece[1];
                            var ativo = piece[2];
                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html
                            $('#codigo').val(codigo);
                            $('#estadoCivil').val(estadoCivil);
                            $('#ativo').val(ativo);

                            return;

                        }
                    }
                );
            }
        }
        $("#descricao").focus();
    }

    function novo() {
        $(location).attr('href', 'estadoCivilCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'estadoCivilCadastroFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "SELECIONE UMA OPÇÃO PARA EXCLUIR!!", "error"); //?
            return;
        }

        excluirEstadoCivilCadastro(id,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];

                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                    } else {
                        smartAlert("Atenção", "OPERAÇÃO NÃO REALIZADA - ENTRE EM CONTATO COM A GIR!", "error");
                    }
                    voltar();
                } else {
                    smartAlert("Sucesso", "OPERAÇÃO REALIZADA COM SUCESSO!", "success");
                    voltar();
                }
            }
        );
    }

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        // $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        var codigo = +$('#codigo').val();
        var estadoCivil = $('#estadoCivil').val();
        var ativo = +$('#ativo').val();

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!estadoCivil) {
            smartAlert("Atenção", "INFORME O ESTADO CIVIL", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        gravaEstadoCivilCadastro(codigo, estadoCivil, ativo,
            function(data) {
                if (data.indexOf("sucess") < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "OPERAÇÃO NÃO REALIZADA - ENTRE EM CONTATO COM A GIR!", "error");
                        $("#btnGravar").prop('disabled', false);
                    }
                } else {
                    smartAlert("Sucesso", "OPERAÇÃO REALIZADA COM SUCESSO!", "success");
                    voltar();

                }
            }
        );
    }

    function verificarNome() {

var texto = document.getElementById("estadoCivil").value;

for (letra of texto) {
    if (!isNaN(texto)) {


        document.getElementById("estadoCivil").value = "";
        return;
    }
    letraspermitidas = "ABCEDFGHIJKLMNOPQRSTUVXWYZ abcdefghijklmnopqrstuvxwyzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ"
    var ok = false;
    for (letra2 of letraspermitidas) {
        if (letra == letra2) {
            ok = true;
        }
    }
    if (!ok) {
        document.getElementById("estadoCivil").value = "";
        return;
    }
}

}

    function verificaEstadoCivil() {

        var estadoCivil = $('#estadoCivil').val();

        if (!estadoCivil) {
            smartAlert("Atenção", "INFORME O ESTADO CIVIL", "error");
            $("#btnGravar").prop('disabled', true);
            return;
        }

        verificarEstadoCivil(estadoCivil,
            function(data) {
                if (data.indexOf("sucess") < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        // $("#btnGravar").prop('disabled', false);
                        $("#estadoCivil").val('');
                        return false;
                    }
                } else {
                    gravar();
                    return true;
                }
            }
        );
    }
</script>