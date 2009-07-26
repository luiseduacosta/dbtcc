<html>
<head>
<link href="../../tcc.css" rel="stylesheet" type="text/css">
<title><?php echo $SERVER['PHP_SELF']; ?></title>
</head>

<body>

<?php

$ordem        = $_REQUEST['ordem'];
$departamento = $_REQUEST['departamento'];
$opcao        = $_REQUEST['opcao'];
$escolha      = $_REQUEST['escolha'];

echo"
<div align='center'>
<table>
";

if($departamento === "metodos")
    $departamento = "metodos e tecnicas";
elseif($departamento === "sem")
    $departamento = "sem informa��o";

if($opcao)
	{
	$sql = "select * from professores where departamento='$departamento' order by nome";
	echo "
	<thead>
	<caption>
	Professores do departamento de $departamento ordenados por nome
	</caption>
	";
	}
else
	{
	$sql = "select * from professores order by nome";
	echo "
	<thead>
	<caption>
	Professores da ESS ordenados por $escolha
	</caption>	
	";
	}
	
require_once("../../include_db.inc");
$resposta = $db->Execute($sql);
if($resposta == false) die ("N�o foi poss�vel consultar a tabela professores");

echo "
<tr>
<th><a href=?ordem=nome&opcao=$opcao&departamento=$departamento>Nome</a></th>
<th><a href=?ordem=departamento&opcao=$opcao&departamento=$departamento>Departamento</a></th>
<th><a href=?ordem=tipocargo&opcao=$opcao&departamento=$departamento>Condi��o</a></th>
<th><a href=?ordem=situacao&opcao=$opcao&departamento=$departamento>Situa��o</a></th>
<th><a href=?ordem=email&opcao=$opcao&departamento=$departamento>E-mail</a></th>
</tr>
</thead>

<tfoot></tfoot>

<tbody>
";
$j = 0;
while (!$resposta->EOF) {
	$numero       = $resposta->fields['id'];
	$nome         = $resposta->fields['nome'];
	$sexo         = $resposta->fields['sexo'];
	$condicao     = $resposta->fields['tipocargo'];
	$situacao     = $resposta->fields['motivoegresso'];
	$email        = $resposta->fields['email'];
	$departamento = $resposta->fields['departamento'];
	// echo $situacao . "<br>";
	
	if(empty($ordem))
	    $ordem = 'nome';
	else
	    $ordem = $ordem;

	$matriz[$j][$ordem] = $$ordem;

	$matriz[$j]['numero']       = $numero;
	$matriz[$j]['nome']         = $nome;
	$matriz[$j]['sexo']         = $sexo;
	$matriz[$j]['condicao']     = $condicao;
	$matriz[$j]['situacao']     = $situacao;
	$matriz[$j]['email']        = $email;
	$matriz[$j]['departamento'] = $departamento;

	$j++;

	$resposta->MoveNext();

	} // Fim do loop while

reset($matriz);
sort($matriz);

for($i=0;$i<sizeof($matriz);$i++) {

    $numero       = $matriz[$i]['numero'];
    $nome         = $matriz[$i]['nome'];
    $sexo         = $matriz[$i]['sexo'];
    $condicao     = $matriz[$i]['condicao'];
    $situacao     = $matriz[$i]['situacao'];
    $email        = $matriz[$i]['email'];
    $departamento = $matriz[$i]['departamento'];

    // Para alternar as cores das linhas
    if($color === '1') {
		echo "<tr class='resaltado' id='resaltado'>";
		$color = '0';
    } else {
		echo "<tr class='natural' id='natural'>";
		$color = '1';
    }
	
    echo "
    <td>
    <a href='../atualizar/atualiza.php?id_prof=$numero&origem=$_SERVER[PHP_SELF]'><b>$nome</b></a>
    </td>
    <td>$departamento</td>
    <td>$condicao</td>
    <td>$situacao</td>
    <td><a href=mailto:'$email'>$email</a></td>
    </tr>
    ";

}

?>

</tbody>
</table>
</div>

</body>
</html>
