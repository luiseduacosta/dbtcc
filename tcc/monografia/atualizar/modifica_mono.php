<?php

include("../../autentica.inc");
// include("../../include_db.inc");
include("../../setup.php");

$servidor = $_SERVER['SERVER_NAME'];
// echo $_SERVER[HTTP_REFERER];

$codigo = $_REQUEST['codigo'];

$sql = "select monografia.codigo, monografia.catalogo, monografia.titulo, monografia.resumo, "
        . " monografia.num_prof, monografia.num_co_orienta, monografia.num_area, monografia.areamonografia, monografia.data, monografia.periodo, monografia.url, "
        . " monografia.data_defesa, monografia.banca1, monografia.banca2, monografia.banca3, monografia.convidado, "
        . " professores.nome, areasmonografia.id as id_areamonografia, areasmonografia.areamonografia, "
        . " areas.numero as id_area, areas.area "
        . " from monografia "
        . " inner join professores on monografia.num_prof = professores.id "
        . " left outer join areasmonografia on monografia.areamonografia = areasmonografia.id "
        . " left outer join areas on monografia.num_area = areas.numero "
        . " where codigo = $codigo";
// echo $sql. "<br>";

$resposta = $db->Execute($sql);
if ($resposta === false) die("Nao foi possivel consultar a tabela monografia");

while (!$resposta->EOF) {
    $codigo = $resposta->fields['codigo'];
    $catalogo = $resposta->fields['catalogo'];
    $titulo = $resposta->fields['titulo'];
    $resumo = $resposta->fields['resumo'];
    $data_sql = $resposta->fields['data'];
    $periodo = $resposta->fields['periodo'];
    $id_professor = $resposta->fields['num_prof'];
    $professor = $resposta->fields['nome'];
    $id_co_orienta = $resposta->fields['num_co_orienta'];
    $id_areaprofessor = $resposta->fields['num_area'];
    $id_areamonografia = $resposta->fields['id_areamonografia'];
    $areamonografia = $resposta->fields['areamonografia'];
    $area = $resposta->fields['area'];
    $url = $resposta->fields['url'];
    $data_defesa_sql = $resposta->fields['data_defesa'];
    $banca1 = $resposta->fields['banca1'];
    $banca2 = $resposta->fields['banca2'];
    $banca3 = $resposta->fields['banca3'];
    $convidado = $resposta->fields['convidado'];

    if (empty($areamonografia)) {
        $areamonografia = "Selecione área";
    }

    /* Ajusto as datas */
    if ($data_sql != 0) {
        $data = date('d-m-Y', strtotime($data_sql));
    } else {
        $data = "s/d";
    }

    if ($data_defesa_sql != 0) {
        $data_defesa = date('d-m-Y', strtotime($data_defesa_sql));
    } else {
        $data_defesa = "s/d";
    }

    $resposta->MoveNext();
}
// print_r($catalogo);

/* Professores */
$sql = "select * from professores order by nome";
$resposta_sql = $db->Execute($sql);
if ($resposta_sql === false) die("Nao foi possivel consultar a tabela professores");
$i = 0;
while (!$resposta_sql->EOF) {
    $professores[$i]['id']   = $resposta_sql->fields['id'];
    $professores[$i]['nome'] = $resposta_sql->fields['nome'];

    $i++;
    $resposta_sql->MoveNext();
}
/* Nome do professor co-orientador */
$sql_co_orienta = "select nome from professores where id=$id_co_orienta";
$res_co_orienta = $db->Execute($sql_co_orienta);
$co_orientador = $res_co_orienta->fields['nome'];
// print_r($professores);

/* * ******** */
/* Alunos */
/* * ******** */
$sql = "select * from tcc_alunos where num_monografia='$codigo' order by nome";
// echo $sql. "<br>";
$resposta = $db->Execute($sql);
if ($resposta === false) die("Nao foi possivel consultar a tabela alunos");
$q_alunos = $resposta->RecordCount();
// echo 'q ' . $q_alunos . "<br>";
$i = 0;
while (!$resposta->EOF) {
    $alunostcc[$i]['aluno'] = 'id_aluno' . strval($i);
    $alunostcc[$i]['nome']  = $resposta->fields['nome'];
    $alunostcc[$i]['id']    = $resposta->fields['numero'];
    $i++;
    $resposta->MoveNext();
}

/* Todos os alunos para o select */
$sql_alunos = "select numero, nome, registro from tcc_alunos order by nome";
// echo $sql_alunos;
$res_alunos = $db->Execute($sql_alunos);

$alunos[0]['id'] = "";
$alunos[0]['nome'] = "Seleciona estudante";
$i = 1;
while (!$res_alunos->EOF) {
    // Somente os estudantes que tem numero de registro
    if (strlen($res_alunos->fields['registro'] >= 8)) {
        $alunos[$i]['id'] = $res_alunos->fields['numero'];
        $alunos[$i]['nome'] = $res_alunos->fields['nome'];

        $i++;
    }
    $res_alunos->MoveNext();
}
// print_r($alunostcc);
// print_r($alunos);

/* * ******** */
/* Areas ** */
/* * ******** */
$sql_prof_area = "select * from prof_area 
join areas on prof_area.num_area = areas.numero
where prof_area.num_prof='$id_professor'";
// echo $sql_prof_area . "<br>";
$resposta_prof_area = $db->Execute($sql_prof_area);
if ($resposta_prof_area === false) die("Nao foi possivel consultar a tabela prof_area");
$quantidade_area = $resposta_prof_area->RecordCount();
$i = 0;
while (!$resposta_prof_area->EOF) {
    $areas[$i]['id']   = $resposta_prof_area->fields['num_area'];
    $areas[$i]['area'] = $resposta_prof_area->fields['area']; 
    
    $i++;
    $resposta_prof_area->MoveNext();
}
/* Acrescento mais uma area para o professor */
$areas[$i]['id'] = '99';
$areas[$i]['area'] = 'No corresponde';
// print_r($areas);
// die();
/* * ********************
 * Area da monografia
 * ******************* */
$sql = "select * from areasmonografia order by areamonografia";
// echo $sql . "<br>";
$res_areamonografia = $db->Execute($sql);
if ($res_areamonografia === false) die("Nao foi possivel consultar a tabela areasmonografia");
$quantidade_area = $res_areamonografia->RecordCount($sql);
$i = 0;
while (!$res_areamonografia->EOF) {
    $area_monografia[$i]['id']   = $res_areamonografia->fields['id'];
    $area_monografia[$i]['area'] = $res_areamonografia->fields['areamonografia'];
    $i++;
    $res_areamonografia->MoveNext();
}
/* Capturo o nome do orientador que preside a banca */
$sql_orientador = "select nome from professores where id='$banca1'";
$res_orientador = $db->Execute($sql_orientador);
$professorbanca1 = $res_orientador->fields['nome'];
/* Capturo o nome do segundo integrante da banca */
$sql_orientador = "select nome from professores where id='$banca2'";
$res_orientador = $db->Execute($sql_orientador);
$professorbanca2 = $res_orientador->fields['nome'];
/* Capturo o nome do terceiro integrante da banca */
$sql_orientador = "select nome from professores where id='$banca3'";
$res_orientador = $db->Execute($sql_orientador);
$professorbanca3 = $res_orientador->fields['nome'];
// print_r($area_monografia);

$smarty = new template_tcc;
// $smarty->debugging = true;
$smarty->assign('codigo', $codigo);
$smarty->assign('catalogo', $catalogo);
$smarty->assign('titulo', $titulo);
$smarty->assign('id_professor', $id_professor);
$smarty->assign('professor', $professor);
$smarty->assign('professores', $professores);
$smarty->assign('id_co_orientador', $id_co_orientador);
$smarty->assign('co_orientador', $co_orientador);
$smarty->assign('alunostcc', $alunostcc);
$smarty->assign('alunos', $alunos);
$smarty->assign('resumo', $resumo);
$smarty->assign('url', $url);
$smarty->assign('area', $area);
$smarty->assign('id_areaprofessor', $id_areaprofessor);
$smarty->assign('areas', $areas);
$smarty->assign('id_areamonografia', $id_areamonografia);
$smarty->assign('area_monografia', $area_monografia);
$smarty->assign('periodo', $periodo);
$smarty->assign('data_defesa', $data_defesa);
$smarty->assign('banca1', $banca1);
$smarty->assign('professorbanca1', $professorbanca1);
$smarty->assign('banca2', $banca2);
$smarty->assign('professorbanca2', $professorbanca2);
$smarty->assign('banca3', $banca3);
$smarty->assign('professorbanca3', $professorbanca3);
$smarty->assign('convidado', $convidado);
$smarty->display('file:'. RAIZ . 'monografia/atualizar/mono.tpl');

?>