<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Funcionario</th>
                    <th class="text-left" style="min-width:35px;">Projeto</th>
                    <th class="text-left" style="min-width:35px;">Realizacao ASO</th>
                    <th class="text-left" style="min-width:35px;">Situação</th>
                    

                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT ASO.codigo,ASO.funcionario,P.descricao,F.nome,ASO.projeto,ASO.ativo,ASOD.dataRealizacaoAso, ASOD.situacao FROM funcionario.atestadoSaudeOcupacional ASO
                INNER JOIN funcionario.atestadoSaudeOcupacionalDetalhe ASOD ON ASOD.atestadoSaudeOcupacional = ASO.codigo
                INNER JOIN ntl.funcionario F ON F.codigo = ASO.funcionario
                INNER JOIN ntl.projeto P ON P.codigo = ASO.projeto WHERE (0 = 0)   ";


                $codigo = (int)$_GET["codigo"];
                $funcionario = (int)$_GET["funcionario"];
                $projeto = (int)$_GET["projeto"];
                $dataRealizacaoAso = $_GET["dataRealizacaoAso"];
                $situacao = $_GET["situacao"];
                $campo = $dataRealizacaoAso;
                if ($campo === $dataRealizacaoAso) {
                    if($campo != "") {
                    $dataRealizacaoAso = str_replace('/', '-', $dataRealizacaoAso);
                    $dataRealizacaoAso = date("Y-m-d", strtotime($dataRealizacaoAso));
                    }
                }


                if ($codigo > 0) {
                    $where .= $where . " AND codigo = " . $codigo;
                }

                if ($funcionario > 0) {
                    $where .= $where . " AND funcionario = " . $funcionario;
                }

                if ($projeto > 0) {
                    $where .= $where . " AND projeto = " . $projeto;
                }
                if ($dataRealizacaoAso != "") {
                    $where .= $where . " AND ASOD.dataRealizacaoAso = " . "'" . $dataRealizacaoAso .  "'";
                }

                if ($situacao != "") {
                    $where .= $where . " AND ASOD.situacao = " . "'" . $situacao .  "'";
                }

                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id = (int) $row['codigo'];
                    $nomeFuncionario = (string)$row['nome'];
                    $projeto = (string)$row['descricao'];
                    $dataRealizacaoAso = $row['dataRealizacaoAso'];
                    $situacao = $row['situacao'];


                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else {
                        $ativo = "Não";
                    }
                    
                    if ($situacao == 'A') {
                        $situacao = "Aberto";
                    } else if ($situacao == 'P') {
                        $situacao = "Pendente";
                    } else {
                        $situacao = "Fechado";
                    };

                    $dataRealizacaoAso = explode("-",$dataRealizacaoAso);
                    $diaCampo = explode(" ",$dataRealizacaoAso[2]);
                    $dataRealizacaoAso = $diaCampo[0] . "/" .$dataRealizacaoAso[1] . "/" .$dataRealizacaoAso[0];
                    

                    echo '<tr >';
                    echo '<td class="text-left"><a href="funcionario_atestadoSaudeOcupacional.php?codigo=' . $id . '">' . $nomeFuncionario . '</a></td>';
                    echo '<td class="text-left">' . $projeto . '</td>';
                    echo '<td class="text-left">' . $dataRealizacaoAso . '</td>';
                    echo '<td class="text-left">' . $situacao . '</td>';
                    
                    echo '</tr >';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<!--script src="js/plugin/datatables/dataTables.tableTools.min.js"></script-->
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="js/plugin/Buttons-1.5.2/css/buttons.dataTables.min.css" />

<script type="text/javascript" src="js/plugin/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function() {
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({

            // Tabletools options:
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'B'l'C>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                //"sLengthMenu": "_MENU_ Resultados por página",
                "sLengthMenu": "_MENU_",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "buttons": [
                //{extend: 'copy', className: 'btn btn-default'},
                //{extend: 'csv', className: 'btn btn-default'},
                {
                    extend: 'excel',
                    className: 'btn btn-default'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-default'
                },
                //{extend: 'print', className: 'btn btn-default'}
            ],
            "autoWidth": true,

            "preDrawCallback": function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

        /* END TABLETOOLS */
    });
</script>