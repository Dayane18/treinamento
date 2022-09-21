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
$page_title = "Usuário";
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
                            <h2>Dados do usuário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="" class="smart-form client-form" id="formUsuario" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
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
                                                            <section class="col col-3">
                                                                <label class="label">Nome</label>
                                                                <label class="input">
                                                                    <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                        <input id="nome" maxlength="255" name="nome" class="required" type="text" pattern="[a-zA-Záãâéêíîóôõú\s]+$" value=" " onkeyup="verificarNome()">
                                                                    </label>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Data de Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNasc" maxlength="" name="dataNasc" type="text" class="datepicker required" value="" placeholder="Ex.: dd/mm/aaaa" maxlength="10" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="--/--/----" data-dateformat="dd/mm/yy">
                                                            </section>
                                                            <section class="col-1 col-lg-1">
                                                                <label class="label">Idade</label>
                                                                <label class="input">
                                                                    <input id="idade" type="text" maxlength="02" name="idade" class="readonly" value="" readonly>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" type="text" maxlength="14" name="cpf" class="required" value="" class="form-control cpf-mask">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">RG</label>
                                                                <label class="input">
                                                                    <input id="rg" type="text" maxlength="15" name="rg" class="required" value="" placeholder="">
                                                                </label>
                                                            </section>
                                                            <div class="row">
                                                            </div>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label"> Primeiro emprego </label>
                                                                <label class="select">
                                                                    <select id="emprego" name="emprego" class="required">
                                                                        <option value=""></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">PIS/PASEP</label>
                                                                <label class="input">
                                                                    <input id="pispasep" type="text" maxlength="15" name="pispasep" class="required" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Estado civil</label>
                                                                <label class="select">
                                                                    <select id="estadocivil" type="text" maxlength="15" name="estadocivil" class="required" value="" placeholder="">
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
                                                            <section class="col col-2">
                                                                <label class="label">Gênero</label>
                                                                <label class="select">
                                                                    <!-- <option></option> -->
                                                                    <select id="genero" type="text" maxlength="15" name="genero" class="required" value="" placeholder="">
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
                                                                            echo '<option value=' . $codigo . '>' . $genero . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
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
                                        <!-- ---------------------------------------------------------------dependente---------------------------------------- -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDependente" class="" id="accordionDependente">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dependente
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDependente" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="jsonDependente" name="jsonDependente" type="hidden" value="[]">
                                                        <div id="formDependente" class="col-sm-12">
                                                            <input id="sequencialDependente" name="sequencialDependente" type="hidden" value="">
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label">Nome do dependente</label>
                                                                    <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                        <input id="dependente" maxlength="255" name="dependente" type="text" value="" pattern="[a-zA-Záãâéêíîóôõú\s]+$" onkeyup="verificarNomeDepen()">
                                                                    </label>
                                                                    </label>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Dependente</label>
                                                                    <label class="select">
                                                                        <!-- <option></option> -->
                                                                        <select id="tipoDependente" type="text" maxlength="15" name="tipoDependente" value="" placeholder="">
                                                                            <option value=""></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, descricao 
                                                                        FROM dbo.tipoDependente
                                                                        WHERE ativo = 1 ";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">CPF</label>
                                                                    <label class="input">
                                                                        <input id="cpfDependente" type="text" maxlength="14" name="cpfDependente" value="" class="form-control cpf-mask">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2 col-auto">
                                                                    <label class="label">Data de Nascimento</label>
                                                                    <label class="input">
                                                                        <input id="dataNascDependente" maxlength="" name="dataNascDependente" type="text" class="datepicker" value="" placeholder="Ex.: dd/mm/aaaa" maxlength="10" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="--/--/----" data-dateformat="dd/mm/yy" onchange="calculaIdadeDependente()">
                                                                </section>

                                                                <section class="col col-md-4">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddDependente" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverDependente" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>

                                                            </div>

                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableDependente" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center">Nome</th>
                                                                            <th class="text-center">Tipo Dependente</th>
                                                                            <th class="text-center">CPF</th>
                                                                            <th class="text-center">Data Nascimento</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="" id="accordionContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Contato
                                                    </a>
                                                </h4>
                                            </div>
                                            <!-- ----------------------tabelaTelefone--------------------- -->
                                            <div id="collapseContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="jsonTelefone" name="jsonTelefone" type="hidden" value="[]">
                                                        <div id="formTelefone" class="col-sm-6">
                                                            <input id="sequencialTelefone" name="sequencialTelefone" type="hidden" value="">
                                                            <input id="descricaoTelefonePrincipal" name="descricaoTelefonePrincipal" type="hidden" value="">
                                                            <input id="descricaoTelefoneWhatsApp" name="descricaoTelefoneWhatsApp" type="hidden" value="">

                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <label class="label" for="telefone">Telefone</label>
                                                                    <label class="input"><i class="icon-prepend fa fa-phone"></i>
                                                                        <input id="telefone" name="telefone" type="text" placeholder="(99) 99999-9999">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-md-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label class="checkbox ">
                                                                        <input id="telefonePrincipal" name="telefonePrincipal" type="checkbox" value="true" checked /><i></i>
                                                                        Principal
                                                                    </label>
                                                                </section>
                                                                <section class="col col-md-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label class="checkbox ">
                                                                        <input id="telefoneWhatsApp" name="telefoneWhatsApp" type="checkbox" value="true" checked /><i></i>
                                                                        Whatsapp
                                                                    </label>
                                                                </section>
                                                                <section class="col col-md-4">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddTelefone" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverTelefone" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableTel" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center">Telefone</th>
                                                                            <th class="text-center">Principal</th>
                                                                            <th class="text-center">Whatsapp</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- -------------------TabelaEmail-------------------------- -->
                                                        <input id="jsonEmail" name="jsonEmail" type="hidden" value="[]">
                                                        <div id="formEmail" class="col-sm-6">
                                                            <input id="sequencialEmail" name="sequencialEmail" type="hidden" value="">
                                                            <input id="descricaoEmailPrincipal" name="descricaoEmailPrincipal" type="hidden" value="">

                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <label class="label" for="email">Email</label>
                                                                    <label class="input"><i class="icon-prepend fa fa-envelope"></i>
                                                                        <input id="email" name="email" type="email" input type="email">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-md-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label class="checkbox ">
                                                                        <input id="emailPrincipal" name="emailPrincipal" type="checkbox" value="true" checked /><i></i>
                                                                        Principal
                                                                    </label>
                                                                </section>
                                                                <section class="col col-md-4">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddEmail" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverEmail" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>


                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center">Email</th>
                                                                            <th class="text-center">Principal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ------------------Endereço------------------------  -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco" class="" id="accordionEndereco">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Endereço
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEndereco" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CEP</label>
                                                                <label class="input">
                                                                    <input id="cep" maxlength="15" name="cep" class="required" type="text" value="">
                                                                </label>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" maxlength="255" name="logradouro" class="required" type="text" value="">
                                                                </label>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" maxlength="255" name="bairro" class="required" type="text" value="">
                                                                </label>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input id="localidade" maxlength="255" name="localidade" class="required" type="text" value="">
                                                                </label>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">UF</label>
                                                                <label class="input">
                                                                    <input id="uf" maxlength="2" name="uf" class="required" type="text" value="" readonly>
                                                                </label>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <div class="row">
                                                            </div>
                                                            <section class="col col-1">
                                                                <label class="label">Número</label>
                                                                <label class="input">
                                                                    <input id="numero" maxlength="5" name="numero" class="required" type="text" value="">
                                                                </label>
                                                                </label>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" maxlength="255" name="complemento" class="" type="text" value="">
                                                                </label>
                                                                </label>
                                                                </label>
                                                            </section>

                                                        </div>
                                                    </fieldset>
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
                                    </div>
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

<script src="<?php echo ASSETS_URL; ?>/js/businessFuncionarioCadastro.js" type="text/javascript"></script>

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
        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($("#jsonEmail").val());
        jsonDependenteArray = JSON.parse($("#jsonDependente").val());


        $("#cpf").mask("999.999.999-99");
        $("#cpfDependente").mask("999.999.999-99");
        $("#telefone").mask("(99) 9999-9999?9");
        $("#cep").mask("99999-999");
        $("#pispasep").mask("999.99999.99-9");
        $("#rg").mask("99.999.999-9");


        $("#telefone").on("blur", function() {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);

            if (last.length == 5) {
                var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);

                var lastfour = last.substr(1, 4);

                var first = $(this).val().substr(0, 9);

                $(this).val(first + move + '-' + lastfour);
            }
        });

        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnExcluir").on("click", function() {
            var id = $("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "SELECIONE PARA EXCLUIR!", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#btnRemoverTelefone").on("click", function() {
            var id = $("#codigo").val();

            if (id === 0) {
                smartAlert("Selecione um registro para excluir !");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                excluirTelefone();
            }
        });

        $("#btnRemoverEmail").on("click", function() {
            var id = $("#codigo").val();

            if (id === 0) {
                smartAlert("Selecione um registro para excluir !");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                excluirEmail();
            }
        });

        $("#btnRemoverDependente").on("click", function() {
            var id = $("#codigo").val();

            if (id === 0) {
                smartAlert("Selecione um registro para excluir !");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                excluirDependente();
            }
        });

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

        $("#dataNasc").on("change", function() {
            var dataNasc = $("#dataNasc").val();
            var retornoDaFuncao = calculaIdade(dataNasc);
            if (retornoDaFuncao === false) {
                $("#dataNasc").val('');
                $('#idade').val('');
            }
        })

        $("#cpf").on("change", function() {
            var cpf = $("#cpf").val();
            // if (cpf == "" || cpf == '___.___.___-__') {
            //     limpaCpf();
            // }
            if (testeCPF(cpf) == false) {
                $("#cpf").val('');
                smartAlert("Atenção", "CPF INVÁLIDO", "error");
                return;
            } else {
                verificaCpfRepetido();
            }
        })

        $("#cpfDependente").on("change", function() {
            var cpf = $("#cpfDependente").val();
            if (testeCPFdependente(cpf) == false) {
                $("#cpfDependente").val('');
                smartAlert("Atenção", "CPF INVÁLIDO", "error");
                return;
            } else {
                verificaCpfDependenteRepetido();
            }
        })

        $("#rg").on("change", function() {
            var rg = $("#rg").val();
            if (verificaRgRepetido(rg) == false) {
                $("#rg").val('');
                smartAlert("Atenção", "RG INVÁLIDO", "error");
                return;
            }
        })

        $("#telefone").on("change", function() {
            var telefone = $("#telefone").val();
            validaTelefone();
        });

        $("#email").on("change", function() {
            var email = $("#email").val();
            validaEmail();

        });

        $("#btnAddTelefone").on("click", function() {
            if (validaTelefone()) {
                addTelefone();
            }
        });

        $("#btnAddEmail").on("click", function() {
            if (validaEmail()) {
                addEmail();
            }
        });

        $("#btnAddDependente").on("click", function() {
            if (validaDependente()) {
                addDependente();

            }
        });

        $("#cep").blur(function() {
            var cep = this.value.replace(/[^0-9]/, "");

            if (cep.length != 8) {
                return false;
            }
            var url = "https://viacep.com.br/ws/" + cep + "/json/";

            $.getJSON(url, function(dadosRetorno) {
                try {
                    $("#logradouro").val(dadosRetorno.logradouro);
                    $("#bairro").val(dadosRetorno.bairro);
                    $("#localidade").val(dadosRetorno.localidade);
                    $("#uf").val(dadosRetorno.uf);
                } catch (ex) {}

            });
        });

        $("#emprego").on("change", function() {
            verificaPispasep();

        });

        carregaPagina();
    });

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        // $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        var codigo = +$('#codigo').val();
        var ativo = +$('#ativo').val();
        var nomeUsuario = $('#nome').val();
        nomeUsuario = nomeUsuario.trim();
        var dataNascimento = $('#dataNasc').val();
        var cpf = $('#cpf').val();
        var rg = $('#rg').val();
        var genero = $('#genero').val();
        var estadoCivil = $('#estadocivil').val();
        var jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        var jsonEmailArray = JSON.parse($("#jsonEmail").val());
        var cep = $('#cep').val();
        var logradouro = $('#logradouro').val();
        var bairro = $('#bairro').val();
        var cidade = $('#localidade').val();
        var numero = $('#numero').val();
        var complemento = $('#complemento').val();
        var uf = $('#uf').val();
        var jsonDependenteArray = JSON.parse($("#jsonDependente").val());
        var emprego = $('#emprego').val();
        var pispasep = $('#pispasep').val();


        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!nomeUsuario) {
            smartAlert("Atenção", "INFORME O NOME", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!dataNascimento) {
            smartAlert("Atenção", "INFORME A DATA DE NASCIMENTO", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (cpf == "" || cpf == '___.___.___-__') {
            smartAlert("Atenção", "INFORME UM CPF CORRETO", "error");
            $("#cpf").val('');
            return;
        }


        if (!rg) {
            smartAlert("Atenção", "INFORME O RG", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!genero) {
            smartAlert("Atenção", "INFORME O GÊNERO", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!estadoCivil) {
            smartAlert("Atenção", "INFORME O ESTADO CIVIL", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!jsonTelefoneArray && !jsonEmailArray) {
            smartAlert("Atenção", "INFORME UM TELEFONE OU UM EMAIL", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cep) {
            smartAlert("Atenção", "INFORME O CEP", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!logradouro) {
            smartAlert("Atenção", "INFORME A LOCALIDADE", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!bairro) {
            smartAlert("Atenção", "INFORME O BAIRRO", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cidade) {
            smartAlert("Atenção", "INFORME A CIDADE", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!numero) {
            smartAlert("Atenção", "INFORME O NÚMERO", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!uf) {
            smartAlert("Atenção", "INFORME O UF", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!emprego) {
            smartAlert("Atenção", "INFORME O EMPREGO", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (emprego == 0 && !pispasep) {
            smartAlert("Atenção", "INFORME O PISPASEP", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        gravaUsuarioCadastro(codigo, nomeUsuario, dataNascimento, cpf, ativo, rg, genero, estadoCivil, jsonTelefoneArray, jsonEmailArray, cep, logradouro, bairro, cidade, numero, complemento, uf, jsonDependenteArray, emprego, pispasep,
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
                    return '';
                } else {
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "OPERAÇÃO REALIZADA COM SUCESSO!", "success");
                    voltar();

                }
            }
        );
    }

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaUsuarioCadastro(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayTelefone = piece[2];
                            var strArrayEmail = piece[3];
                            var strArrayDependente = piece[4];
                            piece = out.split("^");
                            // Atributos de vale transporte unitário que serão recuperados: 

                            var codigo = piece[0];
                            var nomeUsuario = piece[1];
                            var dataNascimento = piece[2];
                            var cpf = piece[3];
                            var ativo = piece[4];
                            var rg = piece[5];
                            var genero = piece[6];
                            var estadoCivil = piece[7];
                            var cep = piece[8];
                            var logradouro = piece[9];
                            var bairro = piece[10];
                            var cidade = piece[11];
                            var numero = piece[12];
                            var complemento = piece[13];
                            var uf = piece[14];
                            var emprego = piece[15];
                            var pispasep = piece[16];

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html
                            $('#codigo').val(codigo);
                            $('#nome').val(nomeUsuario);
                            $('#dataNasc').val(dataNascimento);
                            $('#cpf').val(cpf);
                            $('#ativo').val(ativo);
                            $('#rg').val(rg);
                            $('#genero').val(genero);
                            $('#estadocivil').val(estadoCivil);
                            $('#jsonTelefone').val(strArrayTelefone);
                            jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                            fillTableTelefone() //chamando função
                            $('#jsonEmail').val(strArrayEmail);
                            jsonEmailArray = JSON.parse($("#jsonEmail").val());
                            fillTableEmail()
                            $('#cep').val(cep);
                            $('#logradouro').val(logradouro);
                            $('#bairro').val(bairro);
                            $('#localidade').val(cidade);
                            $('#numero').val(numero);
                            $('#complemento').val(complemento);
                            $('#uf').val(uf);
                            $('#jsonDependente').val(strArrayDependente);
                            jsonDependenteArray = JSON.parse($("#jsonDependente").val());
                            fillTableDependente()
                            $('#emprego').val(emprego);
                            $('#pispasep').val(pispasep);
                            verificaPispasep();
                            calculaIdade(dataNascimento);


                            return;
                        }
                    }
                );
            }
        }
        $("#descricao").focus();
    }

    function verificarNome() {

        var texto = document.getElementById("nome").value;

        for (letra of texto) {
            if (!isNaN(texto)) {

                document.getElementById("nome").value = "";
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
                document.getElementById("nome").value = "";
                return;
            }
        }

    }

    function verificarNomeDepen() {

        var texto = document.getElementById("dependente").value;

        for (letra of texto) {
            if (!isNaN(texto)) {

                document.getElementById("dependente").value = "";
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
                document.getElementById("dependente").value = "";
                return;
            }
        }

    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "SELECIONE UM REGISTRO PARA EXCLUIR!", "error");
            return;
        }

        excluirUsuarioCadastro(id,
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

    function excluirTelefone() {
        var arrSequencial = [];
        $('#tableTel input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
                var obj = jsonTelefoneArray[i];
                if (jQuery.inArray(obj.sequencialTelefone, arrSequencial) > -1) {
                    jsonTelefoneArray.splice(i, 1);
                }
            }
            $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
            fillTableTelefone();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Telefone para excluir.", "error");

    }

    function excluirEmail() {
        var arrSequencial = [];
        $('#tableEmail input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonEmailArray.length - 1; i >= 0; i--) {
                var obj = jsonEmailArray[i];
                if (jQuery.inArray(obj.sequencialEmail, arrSequencial) > -1) {
                    jsonEmailArray.splice(i, 1);
                }
            }
            $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
            fillTableEmail();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Email para excluir.", "error");

    }

    function excluirDependente() {
        var arrSequencial = [];
        $('#tableDependente input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
                var obj = jsonDependenteArray[i];
                if (jQuery.inArray(obj.sequencialDependente, arrSequencial) > -1) {
                    jsonDependenteArray.splice(i, 1);
                }
            }
            $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
            fillTableDependente();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Dependente para excluir.", "error");

    }

    function novo() {
        $(location).attr('href', 'funcionarioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'funcionarioCadastroFiltro.php');
    }

    function calculaIdade(dataNasc) {

        var dataNascimento = dataNasc.split('/');

        var anoNascFuncionario = dataNasc.split('/');
        var diaNasc = anoNascFuncionario[0];
        var mesNasc = anoNascFuncionario[1];
        var anoNasc = anoNascFuncionario[2];

        var data = new Date();
        var dataVerificação = data.toLocaleDateString();

        var dia = data.getDate();
        var mes = data.getMonth();
        var anoAtual = data.getFullYear();


        var idade = anoAtual - anoNasc;

        var mesAtual = data.getMonth() + 1;

        //Se mes atual for menor que o nascimento, nao fez aniversario ainda;
        if (mesAtual < mesNasc) {
            idade--;
        } else {
            //Se estiver no mes do nascimento, verificar o dia
            if (mesAtual == mesNasc) {
                if (dia < diaNasc) {

                    //Se a data atual for menor que o dia de nascimento ele ainda nao fez aniversario
                    idade--;
                }
            }
        }

        var dataValida = moment(dataNascimento, 'DD/MM/YYYY').isValid();

        if (!dataValida) {
            smartAlert("Atenção", "DATA INVALIDA!", "error");
            $('#idade').val('');
            $('#dataNasc').val('');
            return false;
        }
        if (moment(dataNascimento, 'DD/MM/YYYY').diff(moment()) > 0) {
            smartAlert("Atenção", "DATA NÃO PODE SER MAIOR QUE HOJE!", "error");
            $('#idade').val('');
            $('#dataNasc').val('');
            return false;
        }

        if ($('#idade').val() > "100") {
            smartAlert("Atenção", "DATA NÃO PERMITIDA!", "error");
            $('#idade').val('');
            $('#dataNasc').val('');
            return false;
        }

        $("#idade").val(idade);

        return true;
    }

    function testeCPF(cpf) {
        if (typeof cpf !== "string") return false
        cpf = cpf.replace(/[\s.-]*/igm, '')
        if (
            !cpf ||
            cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999"
        ) {
            return false
        }
        var soma = 0
        var resto
        for (var i = 1; i <= 9; i++)
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i)
        resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11)) resto = 0
        if (resto != parseInt(cpf.substring(9, 10))) return false
        soma = 0
        for (var i = 1; i <= 10; i++)
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i)
        resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11)) resto = 0
        if (resto != parseInt(cpf.substring(10, 11))) {
            return false
        }

        return true
    }

    function verificaCpfRepetido() {
        var cpf = $('#cpf').val();
        if (!cpf) {
            smartAlert("Atenção", "INFORME O CPF", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        for (var i = 0; i < jsonDependenteArray.length; i++) {
            if (cpf == jsonDependenteArray[i].cpfDependente) {
                smartAlert("Atenção", "INFORME UM CPF DIFERENTE DO DEPENDENTE", "error");
                $("#cpf").val('');
                return;
            }
        }
        verificarCpfRepetido(cpf,
            function(data) {
                if (data.indexOf("sucess") < 0) {
                    var piece = data.split("#"); // talvez tirar
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "CPF JÁ CADASTRADO", "error");
                        $("#btnGravar").prop('disabled', true);
                        $("#cpf").val('');
                    }
                    return;
                }
            }
        );
    }

    function verificaRgRepetido() {
        var rg = $('#rg').val();
        if (!rg) {
            smartAlert("Atenção", "INFORME O RG", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        verificarRgRepetido(rg,
            function(data) {
                if (data.indexOf("sucess") < 0) {
                    var piece = data.split("#"); // talvez tirar
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "RG JÁ CADASTRADO", "error");
                        $("#btnGravar").prop('disabled', false);
                        $("#rg").val('');
                    }
                    return;
                }
            }
        );
    }

    function verificaTelefoneRepetido() {
        var telefone = $('#telefone').val();
        if (telefone) {
            smartAlert("Atenção", "INFORME O TELEFONE", "error");
            $("#btnAddTelefone").prop('disabled', false);
            return;
        }
        verificaTelefoneRepetido(telefone,
            function(data) {
                if (data.indexOf("sucess") < 0) {
                    var piece = data; // talvez tirar
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnAddTelefone").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "TELEFONE JÁ CADASTRADO", "error");
                        $("#btnAddTelefone").prop('disabled', true);
                        $("#telefone").val('');
                    }
                    return;
                }
            }
        );
    }

    function verificaEmailRepetido() {
        var email = $('#email').val();
        if (email) {
            smartAlert("Atenção", "INFORME O EMAIL", "error");
            $("#btnAddEmail").prop('disabled', false);
            return;
        }
        verificaEmailRepetido(email,
            function(data) {
                if (data.indexOf("sucess") < 0) {
                    var piece = data; // talvez tirar
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnAddEmail").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "EMAIL JÁ CADASTRADO", "error");
                        $("#btnAddEmail").prop('disabled', true);
                        $("#email").val('');
                    }
                    return;
                }
            }
        );
    }

    function limpaFormulárioCep() {
        //Limpa valores do formulário de cep.
        document.getElementById('cep').value = ("");
        document.getElementById('logradouro').value = ("");
        document.getElementById('bairro').value = ("");
        document.getElementById('localidade').value = ("");
        document.getElementById('uf').value = ("");
    }

    function verificaPispasep() {

        var emprego = +$("#emprego").val();


        if (emprego === '___._____.__-_') {
            smartAlert("Erro", "Informe um pispasep.", "error");
            $("#emprego").val('');
            return false;
        }

        if (emprego == 1) {
            $("#pispasep").addClass("readonly");
            $("#pispasep").attr('disabled', true);
            $("#pispasep").val('');
        } else if (emprego == 0) {
            $("#pispasep").removeClass("readonly");
            $("#pispasep").attr('disabled', false);
            return;
        } else if (emprego == " ") {
            $("#pispasep").addClass("readonly");
            $("#pispasep").attr('disabled', true);
            $("#pispasep").val('');
        }
    }

    // --------------------0----------------------telefone----------------------------


    function validaTelefone() {
        var existe = false;
        var achou = false;
        var tel = $('#telefone').val();
        var sequencialTelefone = +$('#sequencialTelefone').val();
        var telefonePrincipalMarcado = 0;

        if (tel === '(__) ____-_____') {
            smartAlert("Erro", "Informe um telefone.", "error");
            $("#telefone").val('');
            return false;
        }


        if ($("#telefonePrincipal").is(':checked') === true) {
            telefonePrincipalMarcado = 1;
        }

        if (tel === '') {
            smartAlert("Erro", "Informe um telefone.", "error");
            return false;
        }

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefonePrincipalMarcado === 1) {
                if ((jsonTelefoneArray[i].telefonePrincipal === 1) && (jsonTelefoneArray[i].sequencialTelefone !== sequencialTelefone)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonTelefoneArray[i].telefone === tel) && (jsonTelefoneArray[i].sequencialTelefone !== sequencialTelefone)) {
                    existe = true;
                    break;
                }
            }
        }


        if (existe === true) {
            smartAlert("Erro", "Telefone já cadastrado.", "error");
            return false;
        }

        if ((achou === true) && (telefonePrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um telefone principal na lista.", "error");
            return false;
        }


        return true;
    }

    function addTelefone() {
        var item = $("#formTelefone").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataTel
        });

        if (item["sequencialTelefone"] === '') {
            if (jsonTelefoneArray.length === 0) {
                item["sequencialTelefone"] = 1;
            } else {
                item["sequencialTelefone"] = Math.max.apply(Math, jsonTelefoneArray.map(function(o) {
                    return o.sequencialTelefone;
                })) + 1;
            }
        } else {
            item["sequencialTelefone"] = +item["sequencialTelefone"];
        }

        var index = -1;
        $.each(jsonTelefoneArray, function(i, obj) {
            if (+$('#sequencialTelefone').val() === obj.sequencialTelefone) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTelefoneArray.splice(index, 1, item);
        else
            jsonTelefoneArray.push(item);

        $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
        fillTableTelefone();
        clearFormTelefone();

    };

    function processDataTel(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "telefone")) {
            var valorTel = $("#telefone").val();
            if (valorTel !== '') {
                fieldName = "telefone";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }

        if (fieldName !== '' && (fieldId === "telefonePrincipal")) {
            var telefonePrincipal = 0;
            if ($("#telefonePrincipal").is(':checked') === true) {
                telefonePrincipal = 1;
            }
            return {
                name: fieldName,
                value: telefonePrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "telefoneWhatsApp")) {
            var telefoneWhatsApp = 0;
            if ($("#telefoneWhatsApp").is(':checked') === true) {
                telefoneWhatsApp = 1;
            }
            return {
                name: fieldName,
                value: telefoneWhatsApp
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoTelefonePrincipal")) {
            var descricaoTelefonePrincipal = "Não";
            if ($("#telefonePrincipal").is(':checked') === true) {
                descricaoTelefonePrincipal = "Sim";
            }
            return {
                name: fieldName,
                value: descricaoTelefonePrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoTelefoneWhatsApp")) {
            var descricaoTelefoneWhatsApp = "Não";
            if ($("#telefoneWhatsApp").is(':checked') === true) {
                descricaoTelefoneWhatsApp = "Sim";
            }
            return {
                name: fieldName,
                value: descricaoTelefoneWhatsApp
            };
        }

        return false;
    }

    function fillTableTelefone() {
        $("#tableTel tbody").empty();
        for (var i = 0; i < jsonTelefoneArray.length; i++) {
            var row = $('<tr />');
            $("#tableTel tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelefoneArray[i].sequencialTelefone + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTelefone + ');">' + jsonTelefoneArray[i].telefone + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTelefoneArray[i].descricaoTelefonePrincipal + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTelefoneArray[i].descricaoTelefoneWhatsApp + '</td>'));
        }
    }

    function carregaTelefone(sequencialTelefone) {
        var arr = jQuery.grep(jsonTelefoneArray, function(item, i) {
            return (item.sequencialTelefone === sequencialTelefone);
        });

        clearFormTelefone();

        if (arr.length > 0) {
            var item = arr[0];
            $("#telefone").val(item.telefone);
            $("#sequencialTelefone").val(item.sequencialTelefone);
            $("#telefonePrincipal").val(item.telefonePrincipal);
            $("#telefoneWhatsApp").val(item.telefoneWhatsApp);

            var telefonePrincipal = $("#telefonePrincipal").val();
            var telefoneWhatsApp = $("#telefoneWhatsApp").val();


            if (telefonePrincipal == 1) {
                $('#telefonePrincipal').prop('checked', true);
            } else if (telefonePrincipal == 0) {
                $('#telefonePrincipal').prop('checked', false);
            }

            if (telefoneWhatsApp == 1) {
                $('#telefoneWhatsApp').prop('checked', true);
            } else if (telefoneWhatsApp == 0) {
                $('#telefoneWhatsApp').prop('checked', false);
            }
        }
    }

    function clearFormTelefone() {

        $("#telefone").val('');
        $("#sequencialTelefone").val('');
        $('#telefonePrincipal[type=checkbox]').prop('checked', false);
        $('#telefoneWhatsApp[type=checkbox]').prop('checked', false);
    }

    // ---------------------------------------------Email-----------------------------



    function validaEmail() {
        var existe = false;
        var achou = false;
        var email = $('#email').val();
        var sequencialEmail = +$('#sequencialEmail').val();
        var emailPrincipalMarcado = 0;

        if ($("#emailPrincipal").is(':checked') === true) {
            emailPrincipalMarcado = 1;
        }

        if (email === '') {
            smartAlert("Erro", "Informe um email.", "error");
            return false;
        }

        if (!ValidarEmail(email)) {
            smartAlert("Erro", "Informe um Email válido !", "error");
            return false;
        }

        //OLHA ISSO 
        if (!(email)) {
            smartAlert("Erro", "Informe um email correto.", "error");
            return false;
        }

        for (i = jsonEmailArray.length - 1; i >= 0; i--) {
            if (emailPrincipalMarcado === 1) {
                if ((jsonEmailArray[i].emailPrincipal === 1) && (jsonEmailArray[i].sequencialEmail !== sequencialEmail)) {
                    achou = true;
                    break;
                }
            }
            if (email !== "") {
                if ((jsonEmailArray[i].email === email) && (jsonEmailArray[i].sequencialEmail !== sequencialEmail)) {
                    existe = true;
                    break;
                }
            }
        }

        for (i = jsonEmailArray.length - 1; i >= 0; i--) {

            if (email !== "") {
                if ((jsonEmailArray[i].email === email) && (jsonEmailArray[i].sequencialEmail !== sequencialEmail)) {
                    existe = true;
                    break;
                }
            }
        }


        if (existe === true) {
            smartAlert("Erro", "Email já cadastrado.", "error");
            return false;
        }

        if ((achou === true) && (emailPrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um email principal na lista.", "error");
            return false;
        }


        return true;
    }

    function ValidarEmail(email) {
        var emailPattern = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
        return emailPattern.test(email);
    }

    function addEmail() {
        var item = $("#formEmail").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEmail
        });

        if (item["sequencialEmail"] === '') {
            if (jsonEmailArray.length === 0) {
                item["sequencialEmail"] = 1;
            } else {
                item["sequencialEmail"] = Math.max.apply(Math, jsonEmailArray.map(function(o) {
                    return o.sequencialEmail;
                })) + 1;
            }
        } else {
            item["sequencialEmail"] = +item["sequencialEmail"];
        }

        var index = -1;
        $.each(jsonEmailArray, function(i, obj) {
            if (+$('#sequencialEmail').val() === obj.sequencialEmail) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEmailArray.splice(index, 1, item);
        else
            jsonEmailArray.push(item);

        $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
        fillTableEmail();
        clearFormEmail();

    };

    function processDataEmail(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "email")) {
            var valorEmail = $("#email").val();
            if (valorEmail !== '') {
                fieldName = "email";
            }
            return {
                name: fieldName,
                value: valorEmail
            };
        }

        if (fieldName !== '' && (fieldId === "emailPrincipal")) {
            var emailPrincipal = 0;
            if ($("#emailPrincipal").is(':checked') === true) {
                emailPrincipal = 1;
            }
            return {
                name: fieldName,
                value: emailPrincipal
            };
        }


        if (fieldName !== '' && (fieldId == "descricaoEmailPrincipal")) {
            var descricaoEmailPrincipal = "Não";
            if ($("#emailPrincipal").is(':checked') === true) {
                descricaoEmailPrincipal = "Sim";
            }
            return {
                name: fieldName,
                value: descricaoEmailPrincipal
            };
        }
        return false;
    }

    function fillTableEmail() {
        $("#tableEmail tbody").empty();
        for (var i = 0; i < jsonEmailArray.length; i++) {
            var row = $('<tr />');
            $("#tableEmail tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEmailArray[i].sequencialEmail + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaEmail(' + jsonEmailArray[i].sequencialEmail + ');">' + jsonEmailArray[i].email + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEmailArray[i].descricaoEmailPrincipal + '</td>'));
        }
    }

    function carregaEmail(sequencialEmail) {
        var arr = jQuery.grep(jsonEmailArray, function(item, i) {
            return (item.sequencialEmail === sequencialEmail);
        });

        clearFormEmail();

        if (arr.length) {
            var item = arr[0];
            $("#email").val(item.email);
            $("#sequencialEmail").val(item.sequencialEmail);
            $("#emailPrincipal").val(item.emailPrincipal);

            var email = $("#emailPrincipal").val();

            if (email == 1) {
                $('#emailPrincipal').prop('checked', true);
            } else if (email == 0) {
                $('#emailPrincipal').prop('checked', false);
            }
        }
    }

    function clearFormEmail() {

        $("#email").val('');
        $("#sequencialEmail").val('');
        $('#emailPrincipal[type=checkbox]').prop('checked', false);

    }

    // ---------------------------------------------Dependente--------------------------------------------------------------


    function validaDependente() {
        var existe = false;
        var achou = false;
        var dependente = $('#dependente').val();
        dependente = dependente.trim();
        var tipoDependente = $('#tipoDependente').val();
        var dependenteCpf = $('#cpfDependente').val();
        var dependenteDataNasc = $('#dataNascDependente').val();
        var sequencialDependente = +$('#sequencialDependente').val();
        var cpfFuncionario = $('#cpf').val()


        if (dependente === '') {
            smartAlert("Erro", "Informe o nome do dependente.", "error");
            return false;
        }

        if (tipoDependente === '') {
            smartAlert("Erro", "Informe um dependente.", "error");
            return false;
        }

        if (dependenteCpf == "" || dependenteCpf == '___.___.___-__') {
            smartAlert("Atenção", "Informe o CPF dependente", "error");
            $("#cpfDependente").val('');
            return false;
        }

        if (dependenteDataNasc === '') {
            smartAlert("Erro", "Informe a data de nascimento do dependente.", "error");
            return false;
        }

        if (!calculaIdadeDependente()) {
            $('#dataNascDependente').val('');
            return;
        }


        if (!(dependenteCpf)) {
            smartAlert("Erro", "Informe um dependente correto.", "error");
            return false;
        }

        if (dependenteCpf === cpfFuncionario) {
            smartAlert("erro", "informe um cpf diferente do funcionario.", "error");
            $("#dependente").val('');

            return false;
        }

        for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
            if (dependente === 1) {
                if ((jsonDependenteArray[i].dependente === 1) && (jsonDependenteArray[i].sequencialDependente !== sequencialDependente)) {
                    achou = true;
                    break;
                }
            }
            if (dependente !== "") {
                if ((jsonDependenteArray[i].dependente === dependente) && (jsonDependenteArray[i].sequencialDependente !== sequencialDependente)) {
                    existe = true;
                    break;
                }
            }

            if (dependente === cpfFuncionario) {
                if ((jsonDependenteArray[i].dependente === dependente) && (jsonDependenteArray[i].sequencialDependente !== sequencialDependente)) {
                    existe = true;
                    break;
                }
            }



        }

        for (i = jsonDependenteArray.length - 1; i >= 0; i--) {

            if (dependente !== "") {
                if ((jsonDependenteArray[i].dependente === dependente) && (jsonDependenteArray[i].sequencialDependente !== sequencialDependente)) {
                    existe = true;
                    break;
                }
            }
        }

        if (existe === true) {
            smartAlert("Erro", "Dependente já cadastrado.", "error");
            return false;
        }

        return true;
    }

    function calculaIdadeDependente() {

        var dependenteDataNasc = $('#dataNascDependente').val();

        var dataNascimentoDependente = dependenteDataNasc.split('/');

        var anoNascDependente = dependenteDataNasc.split('/');
        var diaNasc = anoNascDependente[0];
        var mesNasc = anoNascDependente[1];
        var anoNasc = anoNascDependente[2];

        var data = new Date();
        var dataVerificação = data.toLocaleDateString();

        var dia = data.getDate();
        var mes = data.getMonth();
        var anoAtual = data.getFullYear();


        var idade = anoAtual - anoNasc;

        var mesAtual = data.getMonth() + 1;

        //Se mes atual for menor que o nascimento, nao fez aniversario ainda;
        if (mesAtual < mesNasc) {
            idade--;
        } else {
            //Se estiver no mes do nascimento, verificar o dia
            if (mesAtual == mesNasc) {
                if (dia < diaNasc) {

                    //Se a data atual for menor que o dia de nascimento ele ainda nao fez aniversario
                    idade--;
                }
            }
        }

        var dataValida = moment(dataNascimentoDependente, 'DD/MM/YYYY').isValid();

        if (!dataValida) {
            smartAlert("Atenção", "DATA INVALIDA!", "error");
            $('#dataNascDependente').val('');
            return false;
        }
        if (moment(dataNascimentoDependente, 'DD/MM/YYYY').diff(moment()) > 0) {
            smartAlert("Atenção", "DATA NÃO PODE SER MAIOR QUE HOJE!", "error");
            $('#dataNascDependente').val('');
            return false;
        }

        if (idade > "100") {
            smartAlert("Atenção", "DATA NÃO PERMITIDA!", "error");
            $('#dataNascDependente').val('');
            return false;
        }

        return true;
    }


    function addDependente() {
        var item = $("#formDependente").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataDependente
        });

        if (item["sequencialDependente"] === '') {
            if (jsonDependenteArray.length === 0) {
                item["sequencialDependente"] = 1;
            } else {
                item["sequencialDependente"] = Math.max.apply(Math, jsonDependenteArray.map(function(o) {
                    return o.sequencialDependente;
                })) + 1;
            }
        } else {
            item["sequencialDependente"] = +item["sequencialDependente"];
        }

        item["descricaoDependente"] = $("#tipoDependente option:selected").text();

        var index = -1;
        $.each(jsonDependenteArray, function(i, obj) {
            if (+$('#sequencialDependente').val() === obj.sequencialDependente) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonDependenteArray.splice(index, 1, item);
        else
            jsonDependenteArray.push(item);

        $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
        fillTableDependente();
        clearFormDependente();

    };

    function processDataDependente(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "dependente")) {
            var valorDependente = $("#dependente").val();
            if (valorDependente !== '') {
                fieldName = "dependente";
            }
            return {
                name: fieldName,
                value: valorDependente
            };
        }
        if (fieldName !== '' && (fieldId === "tipoDependente")) {
            var valorTipoDependente = $("#tipoDependente").val();
            if (valorTipoDependente !== '') {
                fieldName = "tipoDependente";
            }
            return {
                name: fieldName,
                value: valorTipoDependente
            };
        }

        return false;
    }

    function fillTableDependente() {
        $("#tableDependente tbody").empty();
        for (var i = 0; i < jsonDependenteArray.length; i++) {
            var row = $('<tr />');
            $("#tableDependente tbody").append(row);
            var descricaoDependente = $("#tipoDependente option[value=" + jsonDependenteArray[i].tipoDependente + "]").text();
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonDependenteArray[i].sequencialDependente + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaDependente(' + jsonDependenteArray[i].sequencialDependente + ');">' + jsonDependenteArray[i].dependente + '</td>'));
            row.append($('<td class="text-nowrap">' + descricaoDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].cpfDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].dataNascDependente + '</td>'));

        }
    }

    function carregaDependente(sequencialDependente) {
        var arr = jQuery.grep(jsonDependenteArray, function(item, i) {
            return (item.sequencialDependente === sequencialDependente);
        });

        clearFormDependente();

        if (arr.length) {
            var item = arr[0];
            $("#dependente").val(item.dependente);
            $("#tipoDependente").val(item.tipoDependente);
            $("#cpfDependente").val(item.cpfDependente);
            $("#dataNascDependente").val(item.dataNascDependente);
            $("#sequencialDependente").val(item.sequencialDependente);

        }
    }

    function clearFormDependente() {


        $("#sequencialDependente").val('');
        $("#dependente").val('');
        $("#tipoDependente").val('');
        $("#cpfDependente").val('');
        $("#dataNascDependente").val('');
    }


    function testeCPFdependente(cpf) {
        if (typeof cpf !== "string") return false
        cpf = cpf.replace(/[\s.-]*/igm, '')
        if (
            !cpf ||
            cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999"
        ) {
            return false
        }
        var soma = 0
        var resto
        for (var i = 1; i <= 9; i++)
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i)
        resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11)) resto = 0
        if (resto != parseInt(cpf.substring(9, 10))) return false
        soma = 0
        for (var i = 1; i <= 10; i++)
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i)
        resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11)) resto = 0
        if (resto != parseInt(cpf.substring(10, 11))) {

            return false
        }
        return true
    }


    function verificaCpfDependenteRepetido() {
        var cpf = $('#cpfDependente').val();
        if (!cpf) {
            smartAlert("Atenção", "INFORME O CPF DEPENDENTE", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        verificarCpfRepetido(cpf,
            function(data) {
                if (data.indexOf("sucess") < 0) {
                    var piece = data.split("#"); // talvez tirar
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "INFORME UM CPF DIFERENTE DO FUNCIONÁRIO", "error");
                        $("#btnGravar").prop('disabled', true);
                        $("#cpfDependente").val('');
                    }
                    return;
                }
            }
        );
    }
</script>