<?php

include("../../autentica.inc");

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
<script language='JavaScript' type='text/javascript'>
<!--
function elimina()
{
    var confirma;
    confirma==confirm('Tem certeza?');
    if(confirma=true)
	return true;
    else
	return false;
}
//-->
</script>
</head>
<body>
";

// Recebo o valor da vari�vel
$num_area = $_POST['num_area'];

// Consulto a tabela prof_area para saber que professores est�o associados a esta �rea
$sql = "select * from prof_area where num_area='$num_area'";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("N�o foi poss�vel consultar a tabela prof_area");
while(!$resultado->EOF)
{
	$num_professor = $resultado->fields['num_prof'];
	$num_area      = $resultado->fields['num_area'];
	$sql_prof_area = "select * from prof_area where num_prof='$num_professor'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("N�o foi poss�vel consultar a tabela prof_area");
	$nrows = $resultado_prof_area->RecordCount();
		
	// Si a �rea a ser eliminada � a �nica �rea de um professor ent�o n�o pode ser eliminada
	if($nrows == '1')
	{
		$sql_professores = "select nome from professores where numero='$num_professor'";
		$resultado_professores = $db->Execute($sql_professores);
		if($resultado_professores == false) die ("N�o foi poss�vel consultar a tabela professores");
		while(!$resultado_professores->EOF)
		{
			$nome = $resultado_professores->fields['nome'];
			$resultado_professores->MoveNext();
		}
		echo "Esta area e a unica area do professor <b>$nome</b> <br>";
		echo "Primeiro acrescente uma outra area para o professor, para logo eliminar esta.<br>";
		exit;

	}
	$resultado->MoveNext();		
}

// Agora passo a consultar a tabela monografias para saber
// si alguma delas est� associada a esta area
$sql_monografia = "select num_area from monografia where num_area='$num_area'";
$resultado_monografia = $db->Execute($sql_monografia);
if($resultado_monografia == false) die ("Nao foi possivel consultar a tabela monografia");
$nrows = $resultado_monografia->RecordCount();

// N�o excluir a �rea N�o corresponde e sem/dados
if ($num_area == '99' || $num_area == '91') {
    echo "<p>�rea(s) 'N�o corresponde' e 's/d' n�o podem ser exclu�das</p>";
    exit;
}
// Si existe uma monografia associada a esta area n�o pode ser eliminada
if($nrows != 0)
{
	echo "<p>Nao � poss�vel eliminar esta area por estar associada a uma monografia. <br>";
	exit;
}
// Em caso contr�rio si posso eliminar a area da tabela
else 
{
	$sql = "delete from areas where numero='$num_area'";
	$resultado = $db->Execute($sql);
	if($resultado == false) die ("N�o foi poss�vel eliminar o registro da tabela areas");

	echo "<p>Registro eliminado <br>";
}
	
$db->Close();

echo "
</body>
</html>
";

?>
