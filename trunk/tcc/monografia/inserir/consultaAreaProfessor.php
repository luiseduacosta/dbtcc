<?php

/* Script que faz a consulta ao servidor */

require_once("ajaxAreaProfessor.php");

$id_professor = $_REQUEST['id_professor'];

function areaProfessor($id_professor) {

    $respostaXajax = new xajaxResponse();
    require_once("../../include_db.inc");

    $sql = "select areas.numero as id_area, areas.area from prof_area "
    . " inner join areas on prof_area.num_area = areas.numero "
    . " where num_prof=$id_professor "
    . " order by area";
    $resultado = $db->Execute($sql);
    if($resultado === false) die ("N�o foi poss�vel consultar a tabela prof_area e areas");
    $areaProfessor  = "�rea do professor: ";
    $areaProfessor .= "<select name=\"id_areaProfessor\" id=\"id_areaProfessor\" size=\"1\">";
    $areaProfessor .= "<option value=0>Selecione �rea do professor</option>";
    while(!$resultado->EOF) {
    	$id_area = $resultado->fields['id_area'];
	$area = $resultado->fields['area'];
	$areaProfessor .= "<option value=$id_area>$area</option>";
	$resultado->MoveNext();
    }
    $areaProfessor .= "<option value=99>N�o corresponde a nenhuma destas �reas</option>";
    $areaProfessor .= "</select>";
	// echo $areaProfessor . "<br>";
    $respostaXajax->addAssign("areaProfessor","innerHTML",$areaProfessor);
    return $respostaXajax;
}

$xajax->processRequests();

$db->Close();

?>
