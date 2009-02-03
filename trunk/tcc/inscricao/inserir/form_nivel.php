<html>
<head>
<title><?php echo $_SERVER[PHP_SELF]; ?></title>
<link href="../../tcc.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.primeira_linha_tabela {text-align: center}
.ultima_linha_tabela {text-align: center}
//-->
</style>

<script language="JavaScript" type="text/javascript">
<!--
function teste()
	{
	if(document.inserirNivel1.numero.value.length==0)
		{
		alert("O campo numero é de preenchimento obrigatório");
		document.inserirNivel1.numero.focus();
		return false;
		}

	if(document.inserirNivel1.aluno.value.length==0)
		{
		alert("O campo nome é de preenchimento obrigatório");
		document.inserirNivel1.aluno.focus();
		return false;
		}
	
	return true;
	}

function periodo() 
{
	var data;
	var dia;
	var mes;
	var ano;
	var periodo;
	data = new Date;
	dia = data.getDate();
	if(dia < 10)
		dia = '0' + dia;
	mes = data.getMonth();
	if(mes < 10)
		mes = '0' + mes;
	ano = data.getFullYear();
	fecha= dia + '/' + mes + '/' + ano;
	document.inserirNivel1.data.value=fecha;
	if(mes >= 1 && mes <= 6)
		{
		periodo = ano + '-1';
		document.inserirNivel1.periodo.value=periodo;
		} 
	if(mes >= 7 && mes <= 12)
		{
		periodo = ano + '-2';
		document.inserirNivel1.periodo.value=periodo;
		}
	}

function janelaArea()
	{
	var selecionado;
	var numero;
	selecionado=document.inserirNivel1.area_nova.selectedIndex;
	numero=document.inserirNivel1.area_nova.options[selecionado].value;	
	window.open("../../professor/visualizar/areasprofessor.php?num_area="+numero,"Areas","width=500,height=250,left=15,top=420,scrollbars=yes,resizable=yes,dependent=yes");
	}

function janelaProfessor()
	{
	var selecionado;
	var numero;
	selecionado=document.inserirNivel1.professor.selectedIndex;
	numero=document.inserirNivel1.professor.options[selecionado].value;
	window.open("../../professor/visualizar/ver_professor.php?num_prof="+numero,"Professor","width=500,height=250,left=520,top=420,scrollbars=yes,resizable=yes,dependent=yes");
	}

//-->
</script>

</head>

<?php

require_once("../../include_db.inc");

$nivel = $_REQUEST['nivel'];

if($nivel=="1")
	{
	echo "

	<body onLoad='periodo()'>

	<h1>Inscrição na disciplina Seminário de TCC - nivel $nivel</h1>

	<form name='inserirNivel1' id='inserirNivel1' action='verifica.php' method='post' onSubmit='return teste()'>

	<div align='center'>
	<table width='600' border='1'>

	<tr>
	<td width='50'>Numero:</td>
	<td width='550'><input type='text' name='numero' id='numero' size='10'>
	(Digite 99 para indicar \"sem informação\")</td>
	</tr>

	<tr>
	<td width='50'>Aluno:</td>
	<td width='550'><input type='text' name='aluno' id='aluno' size='50'></td>
	</tr>

	<tr>
	<td width='50'>Area:</td>
	<td width='550'>
	<select name='area_nova' id='area_nova' size='1' onChange='janelaArea();'>
	<option value='0'>Selecione area</option>
	";
	$sql_area = "select * from areas order by area";
	$resultado = $db->Execute($sql_area);
	if($resultado === false) die ("Não foi possível consultar a tabela areas");
	while (!$resultado->EOF)
		{
		$num_area = $resultado->fields['numero'];
		$area     = $resultado->fields['area'];
		$resultado->MoveNext();
    		echo "
		<option value=$num_area>$area</option>
		";
		}
		echo "
	</select>
	</td>

	<tr>
	<td width='50'>Orientador:</td>
	<td width='550'>
	<select name='professor' size='1' onChange='janelaProfessor();'>
	<option value='0'>Selecione o professor</option>
	";
	$sql_professor = "select * from professores order by nome";
	$resultado_professor = $db->Execute($sql_professor);
	while (!$resultado_professor->EOF)
		{
		$num_professor = $resultado_professor->fields["numero"];
		$professor     = $resultado_professor->fields["nome"];
		$resultado_professor->MoveNext();
		echo "
		<option value=$num_professor>$professor</option>
		";
		}
		echo "
	</select>
	</td>
	</tr>

	<tr>
	<td colspan='2'>
	A orientação já foi acordada com o professor?
	<input type='radio' value='s' name='acordo' checked>Sim
	<input type='radio' value='n' name='acordo'>Não
	</td>
	</tr>

	<tr>
		<td colspan='2'>
		Data: <input type='text' name='data' id='data' size='10' value='0'>
		Período: <input type='text' name='periodo' id='periodo' size='6' value='0'>
		</td>
	</tr>

	<input type='hidden' name='nivel' value=$nivel>

	<tr>
		<td colspan='2' class='ultima_linha_tabela'>
		<input type='submit' value='Enviar' name='envia'>
		<input type='reset' value='Limpar' name='limpa'>
		</td>
	</tr>

	</table>
	</div>
	
	</form>

	</body>
	";
	
	$db->Close;
	}

elseif($nivel=="2")
	{

	echo "

	<body>

	<h1>Inscrição na disciplina Seminário de TCC - nivel $nivel</h1>

	<div align=\"center\">
	<table border='1' width='80%'>
	
	<form name='inserirNivel2' id='inserirNivel2' action='nivel2.php' method='post'>

	<tr>
	<td colspan=2>Aluno: 
	<select name='numeroAluno' size='1'>
	<option value='0'>Selecione aluno</option>
	";
	$sql_inscricao = "select numero, nome from inscricao order by nome";
	$resultado = $db->Execute($sql_inscricao);
	if($resultado === false) die ("Não foi possível consultar a tabela inscricao");
	while(!$resultado->EOF)
		{
		$numero 	= $resultado->fields["numero"];		
		$nome_aluno = $resultado->fields["nome"];
		$resultado->MoveNext();
		echo "
		<option value=$numero>$nome_aluno</option>
		";
		}
	echo "
	</select>
	</td>
	
	<td colspan='3' class='ultima_linha_tabela'>
	<input type='hidden' name='nivel' value=$nivel>
	<input type='submit' name='envia' value='Confirma' >
	</td>

	</tr>

	</form>
	</table>
	</div>
	";
	
	$db->Close;
	}
else
    {
    echo "

    <body>
	
    <h1>Inscrição na disciplina Seminário de TCC</h1>

    <form name='inserir' action='$_SERVER[PHP_SELF]' method='post'>

    <div align='center'>
    <table border='1'>

    <tr><td class='primeira_linha_tabela'>Inscrição em:
    <input type='radio' value='1' name='nivel' checked>TCC I
    <input type='radio' value='2' name='nivel'>TCC II
    </td></tr>

    <tr><td class='ultima_linha_tabela'>
    <input type='submit' name='enviar' value='Confirma'>
    </td></tr>

    </table>
    </div>
    </form>

    ";
    }

?>
    
</body>

</html>