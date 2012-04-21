<?php

/* Script que faz a consulta ao servidor */
$id_professor = $_REQUEST['id_professor'];
// echo $id_professor . "<br>";

// function areaProfessor($id_professor) {

    require_once("../../include_db.inc");

    $sql = "select areas.numero as id_area, areas.area from prof_area "
    . " inner join areas on prof_area.num_area = areas.numero "
    . " where num_prof='$id_professor' "
    . " order by area";
    // echo $sql . "<br>";
    $resultado = $db->Execute($sql);
    if ($resultado === false) die ("Não foi possível consultar a tabela prof_area e areas");
    $areaProfessor  = "Área do professor: ";
    $areaProfessor .= "<select name=\"id_areaProfessor\" id=\"id_areaProfessor\" size=\"1\">";
    $areaProfessor .= "<option value=0>Selecione área do professor</option>";
    while (!$resultado->EOF) {
    	$id_area = $resultado->fields['id_area'];
	$area = $resultado->fields['area'];
	$areaProfessor .= "<option value=$id_area>$area</option>";
	$resultado->MoveNext();
    }
    $areaProfessor .= "<option value=99>Não corresponde a nenhuma destas áreas</option>";
    $areaProfessor .= "</select>";
//    return $areaProfessor;
// }
   echo $areaProfessor; 

$db->Close();

?>
