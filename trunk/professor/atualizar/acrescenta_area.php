<?php

$submit        = $_POST['submit'];
$id_prof       = $_POST['id_prof'];
$nome          = $_POST['nome'];
$sexo          = $_POST['sexo'];
$tipocargo     = $_POST['tipocargo'];
$motivoegresso = $_POST['motivoegresso'];
$email         = $_POST['email'];
$departamento  = $_POST['departamento'];
$num_area      = $_POST['num_area'];

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
if($resultado == false) die ("N�o foi poss�vel atualizar a tabela professores (acrescentar �rea)");

$sql_prof_area = "insert into prof_area values('$id_prof','$num_area')";
// echo $sql_prof_area . "<br>";
$resultado_prof_area = $db->Execute($sql_prof_area);
if($resultado_prof_area == false) die ("N�o foi poss�vel inserir registro na tabela prof_area");

include("atualiza.php");

?>
