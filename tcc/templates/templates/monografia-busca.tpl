<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css"/>
<title>Busca de monografia</title>
</head>
<body>

<h1>Busca monografia por título</h1>

<form name="busca" id="id_busca" action="#" method="POST">
Digite uma palavra <input type="text" name="titulo" id="id_titulo" size="15">
<input type="submit" name="Confirma">
</form>

{if $monografia}
	<table>
	<thead>
	<tr>
	<th>Id</th>
	<th>Título da monografia</th>
	</tr>
	</thead>
	
	<tbody>
	
	{assign var="n" value=1}
	{section name=i loop=$monografia}
	<tr>
	<td>{$n++}</td>
	<td>
	<a href="ver_monografia.php?codigo={$monografia[i].codigo}">{$monografia[i].titulo}</a> 
	</td>
	</tr>
	{/section}
	
	
	</tbody>
	</table>
{/if}

</body>
</html>