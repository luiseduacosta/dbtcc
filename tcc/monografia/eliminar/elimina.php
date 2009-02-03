<?php

function seleciona_elimina() {
	echo "
	<html>
	<head>
        <link href='../../tcc.css' rel='stylesheet' type='text/css'>	
	</head>
	<body>";
	
	$sql = "SELECT * FROM monografia ORDER BY titulo";
	include("../../include_db.inc");
	$resposta = $db->Execute($sql);
	if($resposta == false) die ("N�o foi poss�vel consultar a tabela monografia");
		
	echo "
	<div align='left'>
	<form name='eliminar' method='POST' action='main.php'>
	
	<p>
	<select name='codigo' size='1'>
	<option value='0'>Selecione registro a ser eliminado</option>
	";
	
	while(!$resposta->EOF){
		$codigo = $resposta->fields['codigo'];
		$titulo = $resposta->fields['titulo'];
		$titulo_pequeno = substr($titulo,0,60);
		echo "
		<option value='$codigo'>$titulo_pequeno</option>
		";
		$resposta->MoveNext();
		}
	
	echo "
	</select>

	<input type='hidden' name='fazer' value='elimina'>	
	<input type='submit' name='enviar' value='Confirmar'>
	</form>
	</div>
	</body>
	</html>
	";
	
	$db->Close();
	}

function elimina($codigo) {
	echo "
	<html>
	<head>
	<link href='../../tcc.css' rel='stylesheet' type='text/css'>
	</head>
	<body>";
	include("../../include_db.inc");	
	// Capturo a url do documento arquivado
	$sql_url = "select url from monografia where codigo='$codigo'";
	$resposta_url = $db->Execute($sql_url);
	if($resposta_url == false) die ("N�o foi poss�vel consultar a tabela monografia");
	$url = $resposta_url->fields['url'];
	// echo "URL " . $url . "<br>";

	$sql = "DELETE FROM monografia WHERE codigo = '$codigo'";
	$resposta = $db->Execute($sql);
	if($resposta == false) die ("N�o foi poss�vel consultar a tabela monograifa para elimina��o de registro");
	$sql_alunos = "select * from tcc_alunos where num_monografia='$codigo'";
	$resposta_alunos = $db->Execute($sql_alunos);
	if($resposta_alunos == false) die ("N�o foi possivel consultar a tabela aluno");
	// $j = 0;
	while(!$resposta_alunos->EOF) {
		$num_aluno  = $resposta_alunos->fields['numero'];
		$nome_aluno = $resposta_alunos->fields['nome'];
		echo "Aluno(s) associados a esta monografia: $nome_aluno tamb�m ser�o exclu�dos!!<br>";
		$sql_alunos_outro = "delete from tcc_alunos where num_monografia='$codigo'";
		$resposta_alunos_outro = $db->Execute($sql_alunos_outro);
		if($resposta_alunos_outro == false) die ("N�o foi possivel consultar a tabela alunos para eliminar registros");
		// $j = $j + 1;
		$resposta_alunos->MoveNext();
		}

	$db->Close();

	// Excluo o arquivo tambem
	if(!empty($url)) {
		$file = "/usr/local/htdocs/html/monografias/" . $url;
		// echo "Arquivo: ". $file . "<br>";
		if(file_exists("$file")) {
			if(unlink("$file")) {
				echo "File was successfully deleted";
			} else {
				echo "File was not deleted.";
			}
		} else {
			echo "File does not exist.";
		}
	}
}
	
?>
