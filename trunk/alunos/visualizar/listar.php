<?php

// include_once("../../include_db.inc");
include_once("../../setup.php");

$periodo = isset($_REQUEST['periodo']) ? $_REQUEST['periodo'] : NULL;
$ordem = $_REQUEST['ordem'];
if(empty($ordem)) $ordem = 'nome';

if (!$periodo) {
	$sql_max_periodo = "select max(periodo) as periodo from monografia group by periodo";
	// echo $sql_max_periodo . "<br>";
	$res_max_periodo = $db->Execute($sql_max_periodo);
	$periodo = $res_max_periodo->fields['periodo'];
}

$sql  = "select numero, registro, nome, num_monografia, catalogo, titulo, periodo, monografia.url ";
$sql .= " from tcc_alunos ";
$sql .= " inner join monografia on tcc_alunos.num_monografia = monografia.codigo ";
if ($periodo) $sql .= " where periodo='$periodo' ";
$sql .= " order by $ordem";
// echo $sql . "<br>";
$resultado = $db->Execute($sql);
if ($resultado == falso) die ("Nao foi possivel consultar a tabela tcc_alunos");
$i = 0;
while (!$resultado->EOF) {
    $alunos[$i]['id'] = $resultado->fields['numero'];
    $alunos[$i]['registro'] = $resultado->fields['registro'];
    $alunos[$i]['nome'] = $resultado->fields['nome'];

    $id = $resultado->fields['numero'];

    $alunos[$i]['catalogo'] = $resultado->fields['catalogo'];
    $alunos[$i]['titulo'] = $resultado->fields['titulo'];
    $alunos[$i]['url'] = $resultado->fields['url'];	
    $alunos[$i]['periodo'] = $resultado->fields['periodo'];

	// echo "URL: " . $resultado->fields['url'];	

    $i++;
    $resultado->MoveNext();
}

$sql_periodo = "select periodo from monografia group by periodo";
$res_periodo = $db->Execute($sql_periodo);
while (!$res_periodo->EOF) {
	$periodos[$j]['periodo'] = $res_periodo->fields['periodo'];

	$j++;
	$res_periodo->MoveNext();	

}

$smarty = new template_tcc;
$smarty->assign('periodo',$periodo);
$smarty->assign('periodos',$periodos);
$smarty->assign('alunos',$alunos);
$smarty->assign('servidor',$_SERVER['SERVER_NAME']);
$smarty->display('alunos-listar.tpl');

?>