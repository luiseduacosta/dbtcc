<?php

include("../../autentica.inc");
include("../../include_db.inc");

$id_aluno = $_REQUEST['id_aluno'];

$sql_alunos = "select * from tcc_alunos where numero='$id_aluno'";

$resultado = $db->Execute($sql_alunos);
if ($resultado === false) die ("Não foi possível consultar a tabela alunos");

while (!$resultado->EOF) {
	$nome           = $resultado->fields['nome'];
	$num_monografia = $resultado->fields['num_monografia'];
	$registro       = $resultado->fields['registro'];
	$resultado->MoveNext();
	// Obtenho a monografia desse aluno
	$sql_monografia = "select * from monografia where codigo='$num_monografia'";
	// echo $sql_monografia . "<br>";
	$resultado_monografia = $db->Execute($sql_monografia);
	if ($resultado_monografia == false) die ("Não foi possível consultar a tabela monografia");
	while (!$resultado_monografia->EOF) {
		$titulo  = $resultado_monografia->fields['titulo'];
		$periodo = $resultado_monografia->fields['periodo'];
		$resultado_monografia->MoveNext();
	}
}

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'/>
<script languaje=\"Javascript\" type=\"text/javascript\">
function confirma() {
    var codigo = document.getElementById('codigo').value;
	if (codigo == 0) {
		alert('Selecionando esta opção a relação entre o aluno e a monografia será desfeita e ambos podem ficar \"órfãos\"');
	} else {
		alert('Relacione o aluno com outra monografia');
	}
	return true;
}
</script>
<script language=\"JavaScript\" type=\"text/javascript\" src=\"../../lib/jquery.js\"></script>
<script language=\"JavaScript\" type=\"text/javascript\" src=\"../../lib/jquery.maskedinput-1.2.1.pack.js\"></script>
<script language=\"JavaScript\" type=\"text/javascript\">
$(function() {
	$('#periodo').mask('9999-9');
});
</script>

</head>
</body>

<form name='update_aluno' action='update.php' method='POST'>
<table>

<tr>
<td>
<p>Registro: 
</td>
<td>
<input type='text' name='registro' value='$registro' size='10' maxlength='10'>
</td>
</tr>

<tr>
<td>
<p>Nome:
</td>
<td>
<input type='text' name='nome' value='$nome' size='50' maxlength='50'>
</td>
</tr>

<tr>
<td>
<p>Titulo:  
</td>
<td>
<textarea name='titulo' cols='60' rows='3'>$titulo</textarea>
</td>
</tr>

<tr>
<td>
<p>Período:  
</td>
<td>
<input type='text' name='periodo' id='periodo' value='$periodo' size='6' maxlength='6'>
</td>
</tr>
";

$sql_mono = "SELECT * FROM monografia ORDER BY titulo";
$resultado_mono = $db->Execute($sql_mono);
if ($resultado_mono === false) die ("Não foi possível consultar a tabela monografia");

echo "
<tr>
<td colspan='2'>
<select name='codigo' id='codigo' size='1' onChange='return confirma();'>
<option value='0'>Para desfazer a atual relação da monografia com o aluno clique aqui</option>
";
while (!$resultado_mono->EOF) {
	$codigo  = $resultado_mono->fields['codigo'];
	$titulo  = $resultado_mono->fields['titulo'];
	$resultado_mono->MoveNext();
	$pequeno_titulo = substr($titulo,0,69);
	echo "
	<option value='$codigo'>$codigo $pequeno_titulo</option>
	";
	}

echo "
</select>
</td>
</tr>

<tr>
<td colspan='2'>
<input type='hidden' name='num_monografia' value='$num_monografia'>
<input type='hidden' name='id_aluno' value='$id_aluno'>

<div>
<input type='submit' name='submit' value='Enviar'>
</div>
</td>
</tr>

</table>
</form>
</body>
</html>
";

$db->Close();

?>