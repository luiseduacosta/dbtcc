<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("../../autentica.inc");
// include("../../include_db.inc");
include("../../setup.php");

/* Apaga todos os url */
$sql_atualiza_url = "update monografia set url = ''"; 
// echo $sql_atualiza_url . "<br>";
$res_atualiza_url = $db->Execute($sql_atualiza_url);
if ($res_atualiza_url === false) die("Não foi possível atualizar a tabela monografia");

/* Le todos os arquivos pdf no disco rígido */
$dir = "/usr/local/htdocs/html/monografias/";
$arquivos = scandir($dir);
// print_r($arquivos);
// echo sizeof($arquivos);
/* Localiza os registros e atualiza o url */
for ($i=2; $i<sizeof($arquivos); $i++) {
    $cada_arquivo = substr($arquivos[$i], 0, -4);
    $sql = "select registro, nome from tcc_alunos where registro = '$cada_arquivo'";
    // echo $sql . "<br>";
    $res = $db->Execute($sql);
    if ($res === false) die("Não foi possível consultar a tabela tcc_alunos");
    $registro = $res->fields['registro'];
    $nome = $res->fields['nome'];  
    // echo $nome . " " . $registro . "<br>";
    if (!empty($registro)) {
        
        $url = $registro . ".pdf";
        // echo $url . "<br>";
        $sql_monografia = "select num_monografia from tcc_alunos where registro = '$cada_arquivo'";
        // echo $sql_monografia . "<br>";
        $res_monografia = $db->Execute($sql_monografia);
        if ($res_monografia === false) die("Não foi possível consultar a tabela tcc_alunos");
        $num_monografia = $res_monografia->fields['num_monografia'];
        if (empty($num_monografia)) echo "Monografia sem autor!!" . "<br>";
        $sql_atualiza_url = "update monografia set url = '$url' where codigo = '$num_monografia'"; 
        // echo $sql_atualiza_url . "<br>";
        $res_atualiza_url = $db->Execute($sql_atualiza_url);
        if ($res_atualiza_url === false) die("Não foi possível atualizar a tabela monografia");

    }
}

/* Calcula a quantidade de monografias com pdf */
$sql = "select count(*) as quantidade from monografia where url <> ''";
$res = $db->Execute($sql);
$quantidade = $res->fields['quantidade'];
echo "Quantidade de monografias com pdf: ". $quantidade . "<br>";
$dir = "/usr/local/htdocs/html/monografias/";
$arquivos = scandir($dir);
echo "Quantidade de arquivos no disco rígido: " . sizeof($arquivos);

?>
