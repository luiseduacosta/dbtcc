<?php

$usuario   = $_COOKIE['usuario'];
$senha     = $_COOKIE['senha'];
$http_host = $_SERVER['HTTP_HOST'];
$url       = $_SERVER['SERVER_NAME'];

if(empty($usuario) or (empty($senha)))
{
    header("Location:http://$url/tcc/login.php");
}
?>