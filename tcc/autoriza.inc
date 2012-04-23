<?php

$usuario   = $_COOKIE['usuario'];
$senha     = $_COOKIE['senha'];
$http_host = $_SERVER['HTTP_HOST'];
$url       = $_SERVER['SERVER_NAME'];

if(empty($usuario) or (empty($senha))) {
	$sistema_autentica = 0; // Ususrio nao autorizado
    // header("Location:http://$url/tcc/login.php");
} else {
	$sistema_autentica = 1; // Ususrio autorizado    
}

?>