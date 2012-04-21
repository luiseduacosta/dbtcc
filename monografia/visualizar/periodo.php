<html>
    <head>
        <link href="../../css/tcc.css" rel="stylesheet" type="text/css">
        <title>Periodo</title>
    </head>

    <body>

        <div>
            <table summary='Tabela de monografias por periodo'>
                <caption><b>Tabela de monografias por período</b></caption>
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Monografias</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    include("../../include_db.inc");

                    $sql = "select periodo, count(*) as quantidade from monografia group by periodo order by periodo";

                    $resultado = $db->Execute($sql);

                    while (!$resultado->EOF) {
                        $periodo = $resultado->fields['periodo'];
                        $quantidade = $resultado->fields['quantidade'];

                        $sql_url = "select count(*) as quantidade from monografia where url <> '' and periodo = '$periodo'";
                        // echo $sql_url . "<br>";
                        $res_url = $db->Execute($sql_url);
                        $q_url = $res_url->fields['quantidade'];

                        // Para alternar as cores das linhas
                        if ($color === '1') {
                            echo "<tr class='resaltado' id='resaltado'>";
                            $color = '0';
                        } else {
                            echo "<tr class='natural' id='natural'>";
                            $color = '1';
                        }

                        echo "
	<td class='coluna_centralizada'><a href=periodo_mon.php?periodo=$periodo>$periodo</a></td>
	<td class='coluna_centralizada'>$quantidade</td>
	<td class='coluna_centralizada'>$q_url</td>
                        </tr>
	";
                        $total = $total + $quantidade;
                        $url_total = $url_total + $q_url;
                        $resultado->MoveNext();
                    }

                    echo "
<tr class='total'>
<td class='coluna_centralizada'>Total</td>
<td class='coluna_centralizada'>$total</td>
<td class='coluna_centralizada'>$url_total</td>
                    ";

                    $db->Close();
                    ?>

                </tbody>
            </table>
        </div>
    </body>
</html>
