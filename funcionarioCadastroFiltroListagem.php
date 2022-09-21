<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Nome</th>
                    <th class="text-left" style="min-width:30px;">Data de nascimento</th>
                    <th class="text-left" style="min-width:30px;">CPF</th>
                    <th class="text-left" style="min-width:30px;">RG</th>
                    <th class="text-left" style="min-width:30px;">Ativo</th>
                    <th class="text-left" style="min-width:30px;">Gênero</th>
                    <th class="text-left" style="min-width:30px;">Estado civil</th>
                    <th class="text-left" style="min-width:10px;">PDF</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $where = " WHERE (0 = 0) ";

                $nomeUsuario = $_GET["nomeFiltro"];
                $ativoFiltro = $_GET["ativoFiltro"];
                $cpfFiltro = $_GET["cpfFiltro"];
                $dataInicial = $_GET["dataInicial"];
                $dataFinal = $_GET["dataFinal"];
                $genero = $_GET["generoFiltro"];
                $estadoCivil = $_GET["estadoCivilFiltro"];

                $sql = "SELECT F.codigo, F.nome, F.dataNascimento, F.cpf, F.ativo, F.rg, G.genero, E.estadoCivil
                        FROM dbo.Funcionarios AS F LEFT JOIN dbo.genero AS G ON F.genero = G.codigo
                        LEFT JOIN dbo.estadoCivil AS E ON F.estadoCivil = E.codigo";

                if ($nomeUsuario) {
                    $where = $where  . " AND F.nome like '%" . $nomeUsuario . "%' ";
                }

                if ($ativoFiltro == 1) {
                    $where = $where  . " AND F.ativo = 1 ";
                } else if ($ativoFiltro == 0) {
                    $where = $where  . " AND F.ativo = 0 ";
                }

                if ($cpfFiltro) {
                    $where = $where  . " AND F.cpf = '$cpfFiltro'";
                }

                if ($genero) {
                    $where = $where  . " AND F.genero = $genero";
                }

                if ($estadoCivil) {
                    $where = $where  . " AND F.estadoCivil = $estadoCivil";
                }

                if ($dataInicial) {
                    //criar o explode (formatar a data em formato americano)
                    $dataInicial = (explode("/", $dataInicial, 3)); //30/11/1998
                    $dataAno = $dataInicial[2];
                    $dataMes = $dataInicial[1];
                    $dataDia = $dataInicial[0];
                    $dataInicial = $dataAno . '-' . $dataMes . '-' . $dataDia; //1998 - 11 - 30
                    $where = $where  . " AND F.dataNascimento >= '$dataInicial'";
                }

                if ($dataFinal) {
                    //criar o explode (formatar a data em formato americano)
                    $dataFinal = (explode("/", $dataFinal, 3)); //30/11/1998
                    $dataAno = $dataFinal[2];
                    $dataMes = $dataFinal[1];
                    $dataDia = $dataFinal[0];
                    $dataFinal = $dataAno . '-' . $dataMes . '-' . $dataDia; //1998 - 11 - 30
                    $where = $where  . " AND F.dataNascimento <= '$dataFinal'";
                }
                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $codigo = (int)$row['codigo'];
                    $nomeUsuario = (string)$row['nome'];
                    $dataNascimento = (string)$row['dataNascimento'];

                    $dataNascimento = (explode("-", $dataNascimento, 3));
                    $dataDia = $dataNascimento[2];
                    $dataMes = $dataNascimento[1];
                    $dataAno = $dataNascimento[0];

                    $dataNascimento = $dataDia . '/' . $dataMes . '/' . $dataAno;

                    $cpf = (string)$row['cpf'];
                    $rg = (string)$row['rg'];
                    $ativo = (int)$row['ativo'];
                    $genero = (string)$row['genero'];
                    $estadoCivil = (string)$row['estadoCivil'];

                    

                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else if ($ativo == 0) {
                        $ativo = "Não";
                    }

                    echo '<tr >';
                    echo "<td class='text-left'><a href='funcionarioCadastro.php?id=$codigo'>" . $nomeUsuario . "</a></td>";

                    echo '<td class="text-left">' . $dataNascimento . '</td>';
                    echo '<td class="text-left">' . $cpf . '</td>';
                    echo '<td class="text-left">' . $rg . '</td>';
                    echo '<td class="text-left">' . $ativo . '</td>';
                    echo '<td class="text-left">' . $genero . '</td>';
                    echo '<td class="text-left">' . $estadoCivil . '</td>';
                    echo "<td class='text-left'><a  type='button' class='btn btn-danger' target='_blank' id='PdfIndividual' value= btnPdf  href='folhaRelatorioIndividual.php?id=$codigo'> <span class='fa fa-file-pdf-o'> </a></td>";

                    echo '</tr >';
                //     echo '<td class="text-left">  <input   pull-right" title="Pdf">
                //    </span>
                // </input> </td>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script>
    
    $(document).ready(function() {
        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({
            // Tabletools options: 
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sLengthMenu": "_MENU_ Resultados por página",
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
            "oTableTools": {
                "aButtons": ["copy", "csv", "xls", {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }
                ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
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
    });    
</script>