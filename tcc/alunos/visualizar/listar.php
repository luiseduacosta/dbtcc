<?php

$ordem = $_REQUEST['ordem'];
if(empty($ordem)) $ordem = 'nome';

// include_once("../../include_db.inc");
include_once("../../setup.php");

$sql  = "select numero, registro, nome, num_monografia, catalogo, titulo, periodo, monografia.url ";
$sql .= " from tcc_alunos ";
$sql .= " inner join monografia on tcc_alunos.num_monografia = monografia.codigo ";
$sql .= " order by $ordem";
// echo $sql . "<br>";
$resultado = $db->Execute($sql);
if($resultado == falso) die ("Nao foi possivel consultar a tabela tcc_alunos");
$i = 0;
while(!$resultado->EOF) {
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

$smarty = new template_tcc;
$smarty->assign('alunos',$alunos);
$smarty->assign('servidor',$_SERVER['SERVER_NAME']);
$smarty->display('alunos-listar.tpl');

?>