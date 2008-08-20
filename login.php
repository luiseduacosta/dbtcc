<?php

setcookie("usuario");
setcookie("senha");

$host = $_SERVER[HTTP_HOST];

?>
<html>
<head>
<title>Menu lateral</title>
<link href="tcc.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php

echo "

<div align='center'>
<strong>
<font size='+1'>UNIVERSIDADE FEDERAL DO RIO DE JANEIRO</font>
</strong>
</div>

<br>

<div align='center'>
<strong>
<font size='+1'>ESCOLA DE SERVIÇO SOCIAL</font>
</strong>
</div>

<br>

<div align='center'>
<strong>
<font size='+1'>Comissão de TCC</font>
</strong>
</div>

<br>

<form name='login' id='login' action='verifica_login.php' method='post'>
<table align='center'>

<tr>
<td>Usuário</td>
<td><input type='text' name='nome_usuario' id='nome_usuario' size='15'></td>
</tr>

<tr>
<td>Senha</td>
<td><input type='password' name='usuario_senha' id='usuario_senha' size='10'></td>
</tr>

<tr>
<td colspan='2'>
<p class=coluna_centralizada>
<input type='submit' name='submit' value='Confirma'>
</td>
</tr>

</table>

</form>

</div>

<!--
<table>
<tr>
<td>Host</td>
<td><?php echo $host; ?></td>
</tr>
</table>
//-->
";

?>

</body>
</html>