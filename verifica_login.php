<?php

$nome_usuario  = $_POST['nome_usuario'];
$usuario_senha = $_POST['usuario_senha'];
if(empty($nome_usuario) or (empty($usuario_senha)))
{
    header("Location: login.php");
}
else
{
    include("include_db.inc");
    $sql = "select usuario,senha from usuarios where usuario='$nome_usuario' and senha='$usuario_senha'";
    // echo $sql . "<br>";
    $resultado = $db->Execute($sql);
    if($resultado === false) die ("Não foi possível consultar a tabela usuarios");
    while(!$resultado->EOF)
    {
	$g_usuario = $resultado->fields["usuario"];
	$g_senha   = $resultado->fields["senha"];
	$resultado->MoveNext();
    }
    $usuario_senha_passw = crypt(chop($usuario_senha),post);
    $usuario_senha_passw = substr($usuario_senha_passw,4);
    setcookie("usuario",$nome_usuario);
    setcookie("senha",$usuario_senha_passw);

    if($usuario_senha == $g_senha)
    {
	header("Location: capa.php");
    }
    else
    {
	header("Location: login.php");    
    }
}

?>