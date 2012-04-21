<?php

require_once("../../setup.php");
// require_once("../../data.php");

if ($data) {
    $data = $data_arquivo;
    $data_nova = explode('/', $data);
// echo $data_nova . "<br>";
    $mes = $data_nova[1];
    $ano = $data_nova[2];
// echo $mes . " " . $ano . "<br>";

    if ($mes >= 1 AND $mes <= 6) {
        $ano = $ano - 1;        // Ano passado
        $periodo_atual = $ano . "-2"; // Segundo periodo do ano passado
    }
    if ($mes >= 7 AND $mes <= 12) {
        $periodo_atual = $ano . "-1"; // Primeiro periodo deste ano
    }
}
// echo "Data sistema " . $data_sistema . "<br>";
// Catalogo

if (date('m') >=1 AND date('m') <=6) {
    $ano = date('Y') - 1;
    $periodo_atual = $ano . "-2";
} elseif (date('m') >= 7 and date('m') <=12) {
    $periodo_atual = date('Y') . "-1";
}
// echo "Período atual: " . $periodo_atual . "<br>";

$sql_catalogo = "select max(catalogo) as num_catalogo from monografia";
$resposta_catalogo = $db->Execute($sql_catalogo);
if ($resposta_catalogo === null)
    die("Nao foi possiível consultar a tabela tcc_alunos");
$catalogo = $resposta_catalogo->fields['num_catalogo'];

// Area da monografia
$sql_areaMonografia = "select id, areamonografia from areasmonografia order by areamonografia";
// echo $sql_areaMonografia . "<br>";
$resultado = $db->Execute($sql_areaMonografia);
if ($resultado === false)
    die("Nao foi possivel consultar a tabela areasmonografias");
$i = 0;
while (!$resultado->EOF) {
    $id_area = $resultado->fields['id'];
    $areamonografia = $resultado->fields['areamonografia'];

    $area_monografia[$i]['id_area'] = $id_area;
    $area_monografia[$i]['areamonografia'] = $areamonografia;

    $i++;
    $resultado->MoveNext();
}

// Orientadores
$sql_professores = "select id, nome from professores order by nome";
$resultado = $db->Execute($sql_professores);
if ($resultado === false)
    die("Não foi possível consultar a tabela professores");
$i = 0;
while (!$resultado->EOF) {
    $id_professor = $resultado->fields['id'];
    $professor = $resultado->fields['nome'];

    $professores[$i]['id_professor'] = $id_professor;
    $professores[$i]['nome'] = $professor;

    $i++;
    $resultado->MoveNext();
}

// Alunos
// Seleciono os alunos que ja finalizaram o estagio
$sql_aluno = "SELECT registro, nome, nivel, periodo FROM alunos inner join estagiarios using (registro) where estagiarios.nivel = 4 order by nome";
$resposta_aluno = $db->Execute($sql_aluno);
if ($resposta_aluno == false)
    die("Nao foi possiível consultar a tabela alunos");
$j = 0;
while (!$resposta_aluno->EOF) {
    $registro = $resposta_aluno->fields['registro'];
    $nome = $resposta_aluno->fields['nome'];
    $nivel = $resposta_aluno->fields['nivel'];
    $periodo = $resposta_aluno->fields['periodo'];

    // Seleciono os alunos que ainda nao entregaram a monografia
    $sql_tcc = "select registro from tcc_alunos where registro=$registro";
    // echo $sql_tcc . "<br>";
    $resposta_tcc = $db->Execute($sql_tcc);
    $quantidade = $resposta_tcc->RecordCount();
    // echo $quantidade . "<br>";

    if ($quantidade === 0) {
        $alunos[$j]['registro'] = $registro;
        $alunos[$j]['nome'] = $nome;
        $j++;
        // echo $j . " " . $registro ." ". $nome . " " . $nivel . " ". $periodo .  "<br>";
    }

    $resposta_aluno->MoveNext();
}
// echo "Hoje " . date('d/m/Y');
$smarty = new template_tcc;
// $smarty->debugging = true;
$smarty->assign('catalogo', $catalogo);
$smarty->assign('areamonografia', $area_monografia);
$smarty->assign('professores', $professores);
$smarty->assign('alunos', $alunos);
// $smarty->assign('periodo', $periodo_atual);
// $smarty->assign('data', $data);
$smarty->assign('hoje', date('d/m/Y'));
$smarty->display('alunos-inserir_formulario.tpl');
?>
