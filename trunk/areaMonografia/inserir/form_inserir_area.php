<?php

include("../../autentica.inc");

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>

<body>

<form action='verifica_inserir_area.php' name='inserir' id='inserir' method='POST'>
<p>Áreas das monografias:
<input type='text' name='area' id='area' size='35' maxlength='50'>
<input type='submit' name='submit' id='submit' value='Confirma'>
</p>
</form>

</body>
</html>
";

?>
