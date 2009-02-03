<?php

// Defino a variavel _DIRETORIO como constante

define("_DIRETORIO","/usr/local/htdocs/html/tcc");

$enviar_data = $_REQUEST['enviar_data'];
$dia = $_REQUEST['dia'];
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

if($enviar_data == "Alterar") {
	// Recebe o resultado do formulario e grava no arquivo
	// Escrever data em arquivo
	$data_arquivo = $dia . "/" . $mes . "/" . $ano;
	$diretorio = constant("_DIRETORIO");
	$arquivo = fopen("$diretorio"."/data.txt","w");
	fwrite($arquivo,$data_arquivo);
	fclose($arquivo);
	$enviar_data == "0";
}

// Leer data gravada no arquivo
$diretorio = constant("_DIRETORIO");
$arquivo_data = fopen("$diretorio"."/data.txt","r");
$tamanho = filesize("$diretorio"."/data.txt");
$data_arquivo = fread($arquivo_data,$tamanho);
fclose($arquivo_data);
$data_arquivo_array = split("/",$data_arquivo);
$dia_arquivo = $data_arquivo_array[0];
$mes_arquivo = $data_arquivo_array[1];
$ano_arquivo = $data_arquivo_array[2];

// Leer data do sistema
$data_sistema = date('d/m/Y');

echo "
<div align='center'>
<table>
<tr><td>Ultimo aceso foi em:</td><td>$data_arquivo</td></tr>
<tr><td>Data do sistema:</td><td> $data_sistema</td></tr>
<tr><td colspan=2 align='center'>Altere a data</td></tr>
</table>
</div>
";

echo "
<form name='data' action='#' method='post'>
<div align='center'>
<table>
<tr><td>Dia</td>
    <td><input type='text' name='dia' size='2' value=$dia_arquivo></td>
    <td>Mes</td>
    <td><input type='text' name='mes' size='2' value=$mes_arquivo></td>
    <td>Ano</td>
    <td><input type='text' name='ano' size='4' value=$ano_arquivo></td>
    <td><input type='submit' name='enviar_data' value='Alterar'></td>
</tr>
</table>
</div>
</form>
";

?>