<?php

include("../../autentica.inc");

$id_prof       = $_POST['id_prof'];
$nome          = $_POST['nome'];
$sexo          = $_POST['sexo'];
$tipocargo     = $_POST['tipocargo'];
$motivoegresso = $_POST['motivoegresso'];
$email         = $_POST['email'];
$departamento  = $_POST['departamento'];

$sql  = "update professores set nome='$nome', ";
$sql .= " sexo='$sexo', ";
$sql .= " tipocargo='$tipocargo', ";
$sql .= " email='$email', ";
$sql .= " motivoegresso='$motivoegresso', ";
$sql .= " departamento='$departamento' ";
$sql .= "where id='$id_prof'";
// echo $sql . "<br>";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível atualizar a tabela professores");

// include("atualiza.php");
header("Location:atualiza.php?id_prof=$id_prof");

?>
