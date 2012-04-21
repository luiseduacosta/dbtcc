<?php

function seleciona_monografia()
	{
	$sql = "SELECT * FROM monografia ORDER BY titulo";
	include("../../include_db.inc");
	$resposta = $db->Execute($sql);
	if ($resposta === false) die ("Nao foi possível consultar a tabela monografia");

	echo "
	<head>
	<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
	<form name='modifica_mono' action='modifica_mono.php' method='POST'>
	<select name='codigo' size='1'>
		<option value='0'>Seleccione a monografia</option>
	";
	while (!$resposta->EOF)
		{
		$codigo      = $resposta->fields['codigo'];
		$titulo      = $resposta->fields['titulo'];
		$resposta->MoveNext();
		$pequeno_titulo = substr($titulo,0,60);
		echo "
		<option value='$codigo'>$pequeno_titulo</option>
		";
		}

	echo "
	</select>

	<input type='hidden' name='opcao' value='atualiza'>
	<input type='submit' name='submit' value='Confirma'>
	";

	$db->Close();

	}

seleciona_monografia();

?>