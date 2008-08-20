<?php

require_once("../../autentica.inc");

$nome         = $_POST['nome'];
$sexo         = $_POST['sexo'];
$departamento = $_POST['departamento'];
// $situacao     = $_POST['situacao'];
$condicao     = $_POST['condicao'];
$email        = $_POST['email'];

$sql  = "insert into professores(nome,sexo,departamento,tipocargo,email) ";
$sql .= "values('$nome','$sexo','$departamento','$condicao','$email')";
// echo $sql . "<br>";
include("../../include_db.inc");

$resposta = $db->Execute($sql);

if($resposta === false) die ("Não foi possível inserir registro na tabela professores");

// Pego o número do professor inserido
$db->SetFetchMode(ADODB_FETCH_NUM);
$resposta_num_prof = $db->Execute("select max(id) from professores");
while(!$resposta_num_prof->EOF) {
    $ultimo_prof = $resposta_num_prof->fields[0];
    $resposta_num_prof->MoveNext();
}
if (empty($num_area)) {
    $num_area = 91;
    }
    
$sql_prof_area = "insert into prof_area values($ultimo_prof,$num_area)";
// echo $sql_prof_area . "<br>";
$resposta_prof_area = $db->Execute($sql_prof_area);
if($resposta_prof_area === false) die ("Não foi possível inserir registro na tabela prof_area");

$db->Close();

header("Location: ../atualizar/atualiza.php?num_prof=$ultimo_prof&origem='seleciona_area'");

?>