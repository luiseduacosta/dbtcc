<?php

require_once("../../include_db.inc");
require("../../autentica.inc");

$titulo            = $_POST['titulo'];
$catalogo          = $_POST['catalogo'];
$id_areaMonografia = $_POST['areamonografia'];
$num_professor     = $_POST['id_professor'];
$id_areaProfessor  = $_POST['id_areaProfessor'];
$num_co_orienta    = $_POST['co_orientador'];
$aluno1            = $_POST['aluno1'];
$aluno2            = $_POST['aluno2'];
$aluno3            = $_POST['aluno3'];
$numeroaluno1      = $_POST['numeroaluno1'];
$numeroaluno2      = $_POST['numeroaluno2'];
$numeroaluno3      = $_POST['numeroaluno3'];
$registro_aluno1   = $_POST['registro_aluno1'];
$registro_aluno2   = $_POST['registro_aluno2'];
$registro_aluno3   = $_POST['registro_aluno3'];
$resumo            = $_POST['resumo'];
$periodo           = $_POST['periodo'];
$data		   	   = $_POST['data'];
$area              = $_POST['area'];

$titulo            = trim($titulo);
$id_areaMonografia = trim($id_areaMonografia);
$num_professor     = trim($num_professor);
$id_areaProfessor  = trim($id_areaProfessor);
$num_co_orienta    = trim($num_co_orienta);
$aluno1            = trim($aluno1);
$aluno2            = trim($aluno2);
$aluno3            = trim($aluno3);
$numeroaluno1      = trim($numeroaluno1);
$numeroaluno2      = trim($numeroaluno2);
$numeroaluno3      = trim($numeroaluno3);
$resumo            = trim($resumo);
$periodo           = trim($periodo);
$data		       = trim($data);
$area              = trim($area);

// echo "Registro aluno 1: ". $registro_aluno1 . "<br>";
// Pego o nome a partir do registro para alunos cadastrados em estagio
if(!empty($registro_aluno1)) {
	$sql = "select registro, nome from alunos where registro=$registro_aluno1";
	// echo $sql . "<br>";
	$resposta_registro1 = $db->Execute($sql);
	$aluno1 = $resposta_registro1->fields['nome'];
	$numeroaluno1 = $resposta_registro1->fields['registro'];
}

if(!empty($registro_aluno2)) {
	$sql = "select nome from alunos where registro=$registro_aluno2";
	$resposta_registro2 = $db->Execute($sql);
	$aluno2 = $resposta_registro2->fields['nome'];
	$numeroaluno2 = $resposta_registro2->fields['registro'];
}

if(!empty($registro_aluno3)) {
	$sql = "select nome from alunos where registro=$registro_aluno3";
	$resposta_registro3 = $db->Execute($sql);
	$aluno3 = $resposta_registro3->fields['nome'];
	$numeroaluno3 = $resposta_registro3->fields['registro'];
}

// Catalogo
if($catalogo) {
	$sql_catalogo = "select catalogo from monografia where catalogo=$catalogo";
	$resposta_catalogo = $db->Execute($sql_catalogo);
	if($resposta_catalogo === null) die ("NÃ£o foi possÃ­vel consultar a tabela tcc_alunos");
	$quantidade = $resposta_catalogo->RecordCount();
	if($quantidade != 0) {
		echo "Número de católogo já¡ existe! <br>";
		exit;
	}
}

// Variaveis

$obrigatorio = "Campo obrigatorio";
$numerros = 0;

// Verifica que os campos tenham sido preenchidos

if(empty($titulo)) {
	$error[$numerros] = "É obrigatório inserir o título";
	$numerros++;
	}
else
	{
	for ($i=0;$i<strlen($titulo);$i++)
		{
		$char[$i] = substr($titulo,$i,1);
		$numero = ord($char[$i]);
		if ($numero == 34) $char[$i] = "*";
		if ($numero == 92) $char[$i] = "";
		}

	for ($i=0;$i<strlen($titulo);$i++)
		{
		$new_titulo .= $char[$i];
		}
	$titulo = $new_titulo;
	}

if(empty($catalogo)) {
	$error[$numerros] = "É obrigatório inserir o número de catálogo";
	$numerros++;
	}

if(empty($num_professor)) {
	$error[$numerros] = "É obrigatório inserir o nome do professor";
	$numerros++;
	}

if(empty($id_areaProfessor)) {
	$error[$numerros] = "É obrigatório inserir a área do professor";
	$numerros++;
	}

if(empty($aluno1)) {
	$error[$numerros] = "É obrigatório inserir o nome de pelo menos um aluno";
	$numerros++;
	}

if(empty($numeroaluno1)) {
	$error[$numerros] = "É obrigatório inserir o DRE do aluno";
	$numerros++;
	}
/*
if(empty($resumo))
	{
	$error[$numerros] = "É obrigatório inserir um resumo da monografia";
	$numerros++;
	}
*/
if(empty($periodo)) {
	$error[$numerros] = "É obrigatório inserir o período que corresponde a essa monografia";
	$numerros++;
} else {
	for ($i=0;$i<strlen($periodo);$i++) {
		$char[$i] = substr($periodo,$i,1);
		if (ord($char[4]) != 45) $char[4] = "-";
		}

	for ($i=0;$i<strlen($periodo);$i++) {
		$new_periodo .= $char[$i];
		}
	$periodo = $new_periodo;
	}
/*
if(empty($data))
	{
	$error[$numerros] = "É obrigatório inserir a data de entrega da monografia (seguramente é a data de hoje)";
	$numerros++;
	} else {
	$dia = substr($data,0,2);
	$mes = substr($data,3,2);
	$ano = substr($data,6,4);
	$data = $ano . "/" . $mes . "/" . $dia;
	}
*/
if($numerros > 0) {
	echo "<p>Foram encontrados $numerros erro(s) nos dados informados.</p>";
	for ($i = 0; $i < $numerros; $i++) {
		echo "<p>$error[$i]</p>";
		}
	echo "<p>Favor retornar para a pagina anterior para corregir os dados incorretos.</p>";
	exit;
	}

// Is the file there
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

	$tmp_arquivo = $_FILES['monografia']['tmp_name'];
	$novo_arquivo = $path . $numeroaluno1 . ".pdf";
	$file = explode('/', $novo_arquivo);
	$fichero = substr(strrchr($novo_arquivo,"/"), 1); 
	// echo $fichero . "<br>";
	
	// $newfile = $path . $_FILES['monografia']['name'];
	// move_uploaded_file($_FILES['monografia']['tmp_name'], $newfile);
	move_uploaded_file($_FILES['monografia']['tmp_name'], $novo_arquivo);
	// die('Your file has been successfully uploaded.');
}
	
// die("Aguarde");

require_once("inserir_tcc.php");

?>