<html>
    <head>
        <title>Tabela de Monografias</title>
        <script language="JavaScript" type="text/javascript">
            function janela(numero){
                var controle = window.open("../../professor/visualizar/ver_professor.php?id_prof=" + numero, "janela1", "width=500,height=250,screenX=150,screenY=200,scrollbars=yes,resizable=yes,dependent=yes");
            }
        </script>
        <style type="text/css">
            #pager {
                top: 10px;
            }
        </style>
        <script type="text/javascript" src="../../lib/jquery.js">
        </script>

        <script type="text/javascript" src="../../lib/tablesorter/jquery.tablesorter.min.js">
        </script>

        <script type="text/javascript" src="../../lib/tablesorter/addons/pager/jquery.tablesorter.pager.js">
        </script>

        <script type="text/javascript" src="../../lib/jquery.quicksearch.js">
        </script>

        <script language="JavaScript" type="text/javascript" src="../../lib/jquery.tablehover.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
            
                $("#monografias").tableHover();
                
                $("#monografias").tablesorter({
                    widthFixed: true,
                    stripingRowClass: ['resaltado', 'normal'],
                    stripeRowsOnStartUp: true
                });
                $('#monografias tbody tr td.professor').quicksearch({
                    hideElement: 'parent',
                    position: 'prepend',
                    attached: '#busca',
                    focusOnLoad: true,
                    stripeRowClass: ['resaltado', 'normal'],
                    loaderText: 'Aguarde...',
                    labelText: 'Pesquise pelo orientador:'
                });

                $("#monografias").tablesorterPager({
                    container: $("#pager")
                 });
                 
                $(".alterna_cores tr").mouseover(function(){
                    $(this).addClass("over");
                });
                $(".alterna_cores tr").mouseout(function(){
                    $(this).removeClass("over");
                });
                
                $(".alterna_cores tr:even").addClass("alt");
                
            });
        </script>
        <link href='../../tcc.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <?php

function matriz($ordem) {
	$i = 0;
	$sql = "select * from monografia order by titulo";
	include("../../include_db.inc");
	$resultado = $db->Execute($sql);
	if($resultado === false) die ("Nos foi possivel consultar a tabela monografia");

	while(!$resultado->EOF) {
		$codigo   = $resultado->fields['codigo'];
		$catalogo = $resultado->fields['catalogo'];
		$titulo   = $resultado->fields['titulo'];
		$arquivo  = $resultado->fields['url'];
		$num_prof = $resultado->fields['num_prof'];
		$periodo  = $resultado->fields['periodo'];

		$resultado->MoveNext();

		// Para ordenar
		if(empty($ordem))
		    $ordem = "titulo";
		else
		    $indice = $ordem;

		$matriz[$i][$ordem] = $$indice;
		// Fim da ordena��o

		include("alunos.inc");
		$matriz[$i]['aluno'] = $aluno;

		$sql_professores = "select * from professores where id='$num_prof'";
		$resultado_professores = $db->Execute($sql_professores);
		if($resultado_professores === false) die ("N�o foi possivel consultar a tabela professores");
		while(!$resultado_professores->EOF) {
			$professor = $resultado_professores->fields['nome'];
			$resultado_professores->MoveNext();
		}

		$sql_alunos  = "select numero from tcc_alunos where num_monografia=$codigo";
		// echo $sql_alunos . "<br>";
		$resultado_alunos = $db->Execute($sql_alunos);
		$id_aluno = $resultado_alunos->fields['numero'];

		$matriz[$i]['id_aluno']		 = $id_aluno;
		$matriz[$i]['codigo']	     = $codigo;
		$matriz[$i]['catalogo']      = $catalogo;
		$matriz[$i]['titulo']        = $titulo;
		$matriz[$i]['url']           = $arquivo;
		$matriz[$i]['professor']     = $professor;
		$matriz[$i]['num_professor'] = $num_prof;
		$matriz[$i]['periodo']       = $periodo;

		$i++;

	} // Fin do loop while monografia

	$db->close();

	return($matriz);
}

echo "

<div id='busca'></div>

<div align='center'>
<table id='monografias' class='alterna_cores'>
<caption>Tabela de monografias por alunos, professores e periodos</caption>
<thead>
<!--
<th>ID</th>
<th><a href='?ordem=catalogo'>Cat&aacute;logo</a></th>
<th><a href='?ordem=titulo'>Titulo</a></th>
<th><a href='?ordem=url'>PDF</a></th>
<th><a href='?ordem=aluno'>Aluno(s)</a></th>
<th width='25%'><a href='?ordem=professor'>Professor</a></th>
<th><a href='?ordem=periodo'>Periodo</a></th>
//-->
<th>ID</th>
<th>Cat&aacute;logo</th>
<th>Titulo</th>
<th>PDF</th>
<th>Aluno(s)</th>
<th>Professor</th>
<th>Per�odo</th>
</thead>
<tbody>
";
$servidor = $_SERVER['SERVER_NAME'];
$ordem = $_REQUEST['ordem'];
$matriz = matriz($ordem);
reset($matriz);
sort($matriz);

$j = 1;
for($i=0; $i<sizeof($matriz); $i++) {
	$id_aluno	   = $matriz[$i]['id_aluno'];
	$codigo        = $matriz[$i]['codigo'];
	$catalogo      = $matriz[$i]['catalogo'];
	$titulo        = $matriz[$i]['titulo'];
	$artigo        = $matriz[$i]['url'];	
	$aluno         = $matriz[$i]['aluno'];
	$professor     = $matriz[$i]['professor'];
	$num_professor = $matriz[$i]['num_professor'];
	$periodo       = $matriz[$i]['periodo'];

    // Para alternar as cores das linhas
	/*
    if($color === '1') {
		echo "<tr class='resaltado' id='resaltado'>";
		$color = '0';
    } else {
		echo "<tr class='natural' id='natural'>";
		$color = '1';
    }
	*/

	echo "
	<td style='text-align:right'>$j</td>
	<td style='text-align:right'>$catalogo</td>
	<td class='tab_titulo'><a href='ver_monografia.php?codigo=$codigo'>$titulo</a></td>
	";
	if(empty($artigo)) {
		echo "<td>&nbsp;</td>";
		} else {
		echo "<td><a href='http://$servidor/monografias/$artigo'>PDF</a></td>";
	}
	echo "	
	<td><a href='../../alunos/visualizar/aluno.php?id_aluno=$id_aluno'>$aluno</td>
	<div id='aluno'></div>
	<td class='professor'><a href='../../professor/visualizar/ver_professor.php?id_prof=$num_professor'>$professor</a></td>
	<td class='coluna_centralizada'>$periodo</td>
	</tr>
	";
	$j++;
}

echo "
</tbody>
</table>
</div>

<div id='pager' class='pager'>
	<form>
		<img src='../../lib/tablesorter/addons/pager/icons/first.png' class='first'/>
		<img src='../../lib/tablesorter/addons/pager/icons/prev.png' class='prev'/>
		<input type='text' class='pagedisplay'/>
		<img src='../../lib/tablesorter/addons/pager/icons/next.png' class='next'/>
		<img src='../../lib/tablesorter/addons/pager/icons/last.png'' class='last'/>
		<select class='pagesize'>
		<option selected='selected' value='5'>5</option>
		<option value='10'>10</option>
		<option value='20'>20</option>
		<option value='30'>30</option>
		<option value='40'>40</option>
		</select>
	</form>
</div>
";

?>
    </body>
</html>
