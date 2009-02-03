<?php

$palavra = $_POST['palavra'];
include_once("../../setup.php");

/*
$sql = "select tcc_alunos.numero, alunos.nome, alunos.registro, alunos.email 
from tcc_alunos 
left outer join alunos  
using (registro) 
where alunos.nome like '%$palavra%' 
order by alunos.nome";
*/

$sql = "select tcc_alunos.numero, tcc_alunos.nome, tcc_alunos.registro 
from tcc_alunos 
where tcc_alunos.nome like '%$palavra%' 
order by tcc_alunos.nome";

// echo $sql . "<br>";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Não foi possïvél consultar a tabela alunos");
$quantidade = $resultado->RecordCount();
echo $quantidade . "<br>";
if($quantidade === 0) {
    echo "Não há registros com a palavra: $palavra";
    exit;
} else {
    $i = 0;
    while(!$resultado->EOF) {
		$alunos[$i]['id_aluno'] = $resultado->fields['numero'];
		$alunos[$i]['nome']     = $resultado->fields['nome'];
		$alunos[$i]['registro'] = $resultado->fields['registro'];
		$alunos[$i]['email']    = $resultado->fields['email'];
		// echo $i . "<br>";
		$i++;
		$resultado->MoveNext();
    }
    $smarty = new template_tcc;
    $smarty->assign("alunos",$alunos);
    $smarty->display("alunos-busca_resultado.tpl");
}

exit;

?>