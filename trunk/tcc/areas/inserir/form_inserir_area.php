<?php

include("../../autentica.inc");

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>

<form action='verifica_inserir_area.php' name='inserir' method='POST'>
<p>Area:
<input type='text' name='area' size='50' maxlength='30'>
<input type='submit' name='submit' value='Enviar'>
</form>
</body>
</html>
";

?>
