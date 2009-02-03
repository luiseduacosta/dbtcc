<html>
<head>
<link href="../../tcc.css" rel="stylesheet" type="text/css">
</head>

<?php $opcao = $_REQUEST['opcao']; ?>

<body>
<form name="select_departamentos" method="POST" action="ver_todos_professores.php">

<select name="departamento" size="1">
	<option value="sem informação">Selecione o departamento</option>
	<option value="fundamentos">Fundamentos</option>
	<option value="metodos e tecnicas">Métodos e técnicas</option>
	<option value="politica social">Políticas</option>
	<option value="sem informação">Sem informação</option>
</select>

<input type="hidden" name="escolha" value="nome">
<input type="hidden" name="opcao" value="<?php echo $opcao; ?>">
<input type="submit" name="submit" value="Confirma">

</form>

</body>
</html>
