<?php

include("../../autentica.inc");
include("../../include_db.inc");

// Variaveis
$codigo            = $_POST['codigo'];
$catalogo          = $_POST['catalogo'];
$titulo            = $_POST['titulo'];
$num_prof          = $_POST['num_prof'];
$num_co_orienta    = $_POST['num_co_orienta'];
$resumo            = $_POST['resumo'];
$num_area          = $_POST['num_area'];
$id_areamonografia = $_POST['id_areamonografia'];
$periodo           = $_POST['periodo'];
$data              = $_POST['data'];
// $url               = $_POST['url'];

$id_aluno1 = $_POST['id_aluno0'];
$id_aluno2 = $_POST['id_aluno1'];
$id_aluno3 = $_POST['id_aluno2'];

$old_aluno1 = $_POST['num_aluno0'];
$old_aluno2 = $_POST['num_aluno1'];
$old_aluno3 = $_POST['num_aluno2'];

// echo "id_aluno1 " . $id_aluno1 . "<br>";
// echo "old_aluno1 " . $old_aluno1 . "<br>";

$data_sql = split("-",$data);
$ano = $data_sql[2];
$mes = $data_sql[1];
$dia = $data_sql[0];
$data = $ano . "-" . $mes . "-" . $dia;
$obrigatorio = "Campo obrigatorio";
$numerros = 0;

// Verifica que os campos tenham sido preenchidos

if(empty($titulo)) {
	$error[$numerros] = "É obrigatório inserir o título";
	$numerros++;
	}

/*
if(empty($aluno))
	{
	$error[$numerros] = "ï¿½ obrigatï¿½rio inserir o nome de pelo menos um aluno";
	$numerros++;
	}


if(empty($resumo))
	{
	$error[$numerros] = "ï¿½ obrigatï¿½rio inserir um resumo da monografia";
	$numerros++;
	}
*/

if(empty($periodo))	{
	$error[$numerros] = "É obrigatório inserir o periodo da monografia";
	$numerros++;
	}

if(empty($data)) {
	$error[$numerros] = "É obrigatório inserir a data de entrega da monografia (seguramente ï¿½ a data de hoje)";
	$numerros++;
	}
/*
if(empty($num_prof))
	{
	$error[$numerros] = "ï¿½ obrigatï¿½rio inserir o nome de um professor";
	$numerros++;
	}
*/
if(empty($num_area)) {
	$error[$numerros] = "É obrigatório escolher uma area";
	$numerros++;
	}

if($numerros > 0) {
	echo "<p>Foram encontrados $numerros erro(s) nos dados informados.</p>";
	for ($i = 0; $i < $numerros; $i++)
		{
		echo "<p>$error[$i]</p>";
		}
	echo "<p>Favor retornar à pagina anterior para corregir os dados incorretos.</p>";
	exit;
	}

// Se nï¿½o tem erros actualiza os dados
if (empty($num_prof)) {
    $num_prof = 0;
}
if (empty($num_co_orienta)) {
    $num_co_orienta = 0;
}
if (empty($num_area)) {
    $num_area = 0;
}
if (empty($id_areamonografia)) {
    $id_areamonografia = 0;
}

// Insero um arquivo de monografia
if (isset($_FILES['monografia']) == false OR $_FILES['monografia']['error'] == UPLOAD_ERR_NO_FILE) {
    // echo "Sem arquivo da monografia";
} else {
	// No problems?
	if ($_FILES['monografia']['error'] != UPLOAD_ERR_OK) {
        die('Error occured during upload');
		}

	// Localizacao
	$path = '/usr/local/htdocs/html/monografias/';

	// Verifico se o arquivo eh pdf
	$arquivo = $_FILES['monografia']['name'];
	$ext = explode('.', $arquivo);
	$extension = $ext[count($ext)-1];
	$tipo_extensao = strtolower($extension);
	// echo $tipo_extensao . "<br>";
	// Outra alternativa
	// $final = strrchr($_FILES['monografia']['name'],'.');
	// echo $final . "<br>";

	if($tipo_extensao !="pdf") {
		die("Error! Somente s&atilde;o aceitos arquivos pdf");
		}

	// Preciso do numero de registro para armazenar o arquivo
	$sql_aluno = "select registro from tcc_alunos ";
	$sql_aluno .= "where num_monografia='$codigo' ";
	// echo $sql_aluno . "<br>";
	$resultado_aluno = $db->Execute($sql_aluno);
	if($resultado_aluno === false) die ("Nao foi possivel consultar a tabela tcc_alunos");
	$registro = $resultado_aluno->fields['registro'];
	// echo $registro . "<br>";
	if(strlen($registro) <= 1) {
		die("É necessario o número de registro para armazenar a monografia");
	};
	if(!empty($registro)) {
		$tmp_arquivo = $_FILES['monografia']['tmp_name'];
		$novo_arquivo = $path . $registro . ".pdf";
		$file = explode('/', $novo_arquivo);
		$fichero = substr(strrchr($novo_arquivo,"/"), 1);
		// echo $fichero . "<br>";

		// $newfile = $path . $_FILES['monografia']['name'];
		// move_uploaded_file($_FILES['monografia']['tmp_name'], $newfile);
		move_uploaded_file($_FILES['monografia']['tmp_name'], $novo_arquivo);
		// die('Your file has been successfully uploaded.');
	} else {
		die("É necessário o número de registro para armazenar a monografia");
	}
}

$sql  = "UPDATE monografia SET titulo='$titulo', ";
$sql .= "catalogo='$catalogo', ";
$sql .= "resumo='$resumo', ";
$sql .= "data='$data', ";
$sql .= "periodo='$periodo', ";
$sql .= "num_prof=$num_prof, ";
$sql .= "num_co_orienta=$num_co_orienta, ";
$sql .= "num_area=$num_area, ";
$sql .= "areamonografia=$id_areamonografia, ";
$sql .= "url='$fichero' ";
$sql .= "WHERE codigo='$codigo'";
// echo $sql . "<br>";

$resposta = $db->Execute($sql);
if($resposta === false) die ("Nao foi possivel atualizar a tabela monografia");

if ($id_aluno1 != 0) {
	if(!empty($old_aluno1)) {
		$sqlAtualiza1 = "update tcc_alunos set num_monografia = '' where numero = $old_aluno1";
		// echo $sqlAtualiza1 . "<br>";
		$resposta1 = $db->Execute($sqlAtualiza1);
		if($resposta1 === false) die ("Nao foi possivel atualizar a tabela monografia");
	}
	$sqlAtualiza2 = "update tcc_alunos set num_monografia = '$codigo' where numero = $id_aluno1";
	// echo $sqlAtualiza2 . "<br>";	
	$resposta2 = $db->Execute($sqlAtualiza2);
	if($resposta2 === false) die ("Nao foi possivel atualizar a tabela monografia");
}
if ($id_aluno2 != 0) {
	if(!empty($old_aluno2)) {
		$sqlAtualiza1 = "update tcc_alunos set num_monografia = '' where numero = $old_aluno2";
		// echo $sqlAtualiza1 . "<br>";
		$resposta1 = $db->Execute($sqlAtualiza1);
		if($resposta1 === false) die ("Nao foi possivel atualizar a tabela monografia");
	}
	$sqlAtualiza2 = "update tcc_alunos set num_monografia = '$codigo' where numero = $id_aluno2";
	// echo $sqlAtualiza2 . "<br>";	
	$resposta2 = $db->Execute($sqlAtualiza2);
	if($resposta2 === false) die ("Nao foi possivel atualizar a tabela monografia");
}
if ($id_aluno3 != 0) {
	if(!empty($old_aluno3)) {
		$sqlAtualiza1 = "update tcc_alunos set num_monografia = '' where numero = $old_aluno3";
		// echo $sqlAtualiza1 . "<br>";
		$resposta1 = $db->Execute($sqlAtualiza1);
		if($resposta1 === false) die ("Nao foi possivel atualizar a tabela monografia");
	}
	$sqlAtualiza2 = "update tcc_alunos set num_monografia = '$codigo' where numero = $id_aluno3";
	// echo $sqlAtualiza2 . "<br>";	
	$resposta2 = $db->Execute($sqlAtualiza2);
	if($resposta2 === false) die ("Nao foi possivel atualizar a tabela monografia");
}

$db->Close();

header("Location: ../visualizar/ver_monografia.php?codigo=$codigo");

?>