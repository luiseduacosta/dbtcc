<?php

include("../../autentica.inc");
include("../../include_db.inc");

// Variaveis
$codigo = $_POST['codigo'];
$catalogo = $_POST['catalogo'];
$titulo = $_POST['titulo'];
$num_prof = $_POST['id_professor'];
$num_co_orienta = $_POST['num_co_orienta'];

$id_aluno0 = $_POST['id_aluno0'];
$id_aluno1 = $_POST['id_aluno1'];
$id_aluno2 = $_POST['id_aluno2'];
$id_atualizaid_aluno0 = $_POST['id_atualizaid_aluno0'];
$id_atualizaid_aluno1 = $_POST['id_atualizaid_aluno1'];
$id_atualizaid_aluno2 = $_POST['id_atualizaid_aluno2'];
$id_novoid_aluno0 = $_POST['id_novoid_aluno0'];
$id_novoid_aluno1 = $_POST['id_novoid_aluno1'];
$id_novoid_aluno2 = $_POST['id_novoid_aluno2'];

$resumo = $_POST['resumo'];
$url = $_POST['url'];
$num_area = $_POST['num_area'];
$id_areaProfessor = $_POST['id_areaProfessor'];
$id_areamonografia = $_POST['id_areamonografia'];
$periodo = $_POST['periodo'];
$data_defesa = $_REQUEST['data_defesa'];
$banca1 = $_REQUEST['banca1'];
$banca2 = $_REQUEST['banca2'];
$banca3 = $_REQUEST['banca3'];
$convidado = $_REQUEST['convidado'];

echo var_dump($_REQUEST);
// die();
// echo "Data: " .  $data . " Data defesa: " . $data_defesa. "<br>";
if ($data)
    $data = date('Y-m-d', strtotime($data));
if ($data_defesa)
    $data_defesa = date('Y-m-d', strtotime($data_defesa));
// echo "Data: " .  $data . " Data defesa: " . $data_defesa. "<br>";

/* Se mudou o professor capturo a nova area de orientação */
if ($id_areaProfessor)
    $num_area = $id_areaProfessor;

$obrigatorio = "Campo obrigatorio";
$numerros = 0;

// Verifica que os campos tenham sido preenchidos
if (empty($titulo)) {
    $error[$numerros] = "É obrigatório inserir o título";
    $numerros++;
}

/*
  if(empty($aluno))
  {
  $error[$numerros] = "É obrigatório inserir o nome de pelo menos um aluno";
  $numerros++;
  }


  if(empty($resumo))
  {
  $error[$numerros] = "É obrigatório inserir um resumo da monografia";
  $numerros++;
  }
 */

if (empty($periodo)) {
    $error[$numerros] = "É obrigatório inserir o periodo da monografia";
    $numerros++;
}

/*
  if (empty($data)) {
  $error[$numerros] = "É obrigatório inserir a data de entrega da monografia (seguramente é a data de hoje)";
  $numerros++;
  }
 */

if (empty($num_prof)) {
    $error[$numerros] = "É obrigatório inserir o nome de um professor";
    $numerros++;
}

if (empty($num_area)) {
    $error[$numerros] = "É obrigatório escolher uma area";
    $numerros++;
}

if ($numerros > 0) {
    echo "<p>Foram encontrados $numerros erro(s) nos dados informados.</p>";
    for ($i = 0; $i < $numerros; $i++) {
        echo "<p>$error[$i]</p>";
    }
    echo "<p>Favor retornar à pagina anterior para corregir os dados incorretos.</p>";
    exit;
}

// Se não tem erros actualiza os dados
if (empty($num_prof)) {
    $num_prof = 0;
}
if (empty($num_co_orienta)) {
    $num_co_orienta = 0;
}
if (empty($num_area)) {
    $num_area = 0;
}
if (empty($id_areamonografia)) {
    $id_areamonografia = 0;
}

/* Insero um arquivo de monografia
 * 
 */
if (isset($_FILES['monografia']) == false OR $_FILES['monografia']['error'] == UPLOAD_ERR_NO_FILE) {
    // echo "Sem arquivo da monografia";
} else {
    // No problems?
    if ($_FILES['monografia']['error'] != UPLOAD_ERR_OK) {
        die('Error occured during upload');
    }

    // Localizacao
    $path = '/usr/local/htdocs/html/monografias/';

    // Verifico se o arquivo eh pdf
    $arquivo = $_FILES['monografia']['name'];
    $ext = explode('.', $arquivo);
    $extension = $ext[count($ext) - 1];
    $tipo_extensao = strtolower($extension);
    // echo $tipo_extensao . "<br>";
    // Outra alternativa
    // $final = strrchr($_FILES['monografia']['name'],'.');
    // echo $final . "<br>";

    if ($tipo_extensao != "pdf") {
        die("Error! Somente s&atilde;o aceitos arquivos pdf");
    }

    // Preciso do numero de registro para armazenar o arquivo
    $sql_aluno = "select registro from tcc_alunos";
    $sql_aluno .= " where num_monografia='$codigo'";
    $sql_aluno .= " order by nome";
    echo $sql_aluno . "<br>";
    // die();
    $resultado_aluno = $db->Execute($sql_aluno);
    if ($resultado_aluno === false)
        die("Nao foi possivel consultar a tabela tcc_alunos");
    $quantidade_mono = $resultado_aluno->RecordCount();
    echo "Estudantes nesta Monografias: " . $quantidade_mono . "<br>";
    // die("Estudantes desta monografia");
    $registro = $resultado_aluno->fields['registro'];
    echo "Registro do estudante: " . $registro . "<br>";
    if (strlen($registro) < 8) {

        echo "161 - Estudante sem número de registro";
        header("Location: ../visualizar/ver_monografia.php?codigo=$codigo&error=sem_registro");
        die("Error: Estudante sem número de registro");
    }

    if ($id_novoid_aluno0) {
        $sql_id_aluno = "select registro from tcc_alunos where numero=$id_novoid_aluno0";
    } elseif ($id_atualizaid_aluno0) {
        $sql_id_aluno = "select registro from tcc_alunos where numero=$id_atualizaid_aluno0";
    } elseif ($id_aluno) {
        $sql_id_aluno = "select registro from tcc_alunos where numero=$id_aluno0";
    }
    $res_id_aluno = $db->Execute($sql_id_aluno);
    $registro_id_aluno = $res_id_aluno->fields['registro'];
    echo "Registro id aluno: " . $registro_id_aluno . "<br>";
    // die();
    /*
      if (strlen($registro) <= 1) {
      die("É necessario o número de registro para armazenar a monografia");
      };
     */
    $registro = $registro_id_aluno;
    echo strlen($registro) . "<br>";
    // die();
    if (strlen($registro) >= 8) {
        $tmp_arquivo = $_FILES['monografia']['tmp_name'];
        $novo_arquivo = $path . $registro . ".pdf";
        $file = explode('/', $novo_arquivo);
        $fichero = substr(strrchr($novo_arquivo, "/"), 1);
        $url = $fichero;
        // echo "Fichero: " . $fichero . " URL: " .  $url . "<br>";
        // $newfile = $path . $_FILES['monografia']['name'];
        // move_uploaded_file($_FILES['monografia']['tmp_name'], $newfile);
        move_uploaded_file($_FILES['monografia']['tmp_name'], $novo_arquivo);
        // die('Your file has been successfully uploaded.');
    } else {
        echo "198 Estudante sem número de registro: $registro";
        header("Location: ../visualizar/ver_monografia.php?codigo=$codigo&error=sem_registro");
        die("Error: Estudante sem número de registro");
    }
    // die();
}

/* Se nao foi mudado o link do pdf entao fica como estava */
// echo "Fichero " .  $fichero . " " . "Url " . $url . "<br>";
/*
  if ((!$fichero) and ($url))
  $fichero = $url;
 */

/* Atualiza monografia */
$sql = "UPDATE monografia SET ";
$sql .= "catalogo='$catalogo', ";
$sql .= "titulo='$titulo', ";
$sql .= "num_prof='$num_prof', ";
$sql .= "num_co_orienta='$num_co_orienta', ";
$sql .= "resumo='$resumo', ";
$sql .= "url='$url', ";
$sql .= "num_area=$num_area, ";
$sql .= "areamonografia=$id_areamonografia, ";
$sql .= "periodo='$periodo', ";
$sql .= "data_defesa='$data_defesa', ";
$sql .= "banca1='$banca1', ";
$sql .= "banca2='$banca2', ";
$sql .= "banca3='$banca3', ";
$sql .= "convidado='$convidado' ";
$sql .= "WHERE codigo='$codigo'";
echo $sql . "<br>";
// die($sql);
$resposta = $db->Execute($sql);
if ($resposta === false)
    die("Nao foi possivel atualizar a tabela monografia");

/* Atualizacao da tabela tcc_alunos */
echo "Id aluno0 " . $id_aluno0 . " Id atualiza id aluno0 " . $id_atualizaid_aluno0 . "<br>";
if (!empty($id_atualizaid_aluno0)) {
    echo $id_atualizaid_aluno0 . "<br>";
    // die();
    if ($id_atualizaid_aluno0 <> $id_aluno0) {
        echo "Atualiza estudante: $id_atualizaid_aluno0 -> $id_aluno0" . "<br>";
        $sql_atualiza0 = "update tcc_alunos set num_monografia = '$codigo' where numero = '$id_atualizaid_aluno0'";
        echo $sql_atualiza0 . "<br>";
        $res_atualiza0 = $db->Execute($sql_atualiza0);
        if ($res_atualiza0 === false)
            die("Nao foi possivel atualizar registro na tabela tcc_alunos");

        $sql_delete0 = "delete from tcc_alunos where numero = '$id_aluno0'";
        // echo $sql_delete0 . "<br>";
        // die("0 Excluíndo registro de monografia por alteração do estudante autor");
        $res_delete0 = $db->Execute($sql_delete0);
        if ($res_delete0 === false)
            die("Nao foi possivel excluir registro da tabela tcc_alunos");
    } else {
        echo "Permanece sem alterações <br>";
        // die();
    }
}

/* Esta é uma situação rara: inserir aluno novo */
echo $id_novoid_aluno0;
// die();
if (!empty($id_novoid_aluno0)) {
    echo "Inserir" . "<br>";
    $sql_seleciona = "select nome, num_monografia, registro from tcc_alunos where numero=$id_novoid_aluno0";
    $res_seleciona = $db->Execute($sql_seleciona);
    $nome = $res_seleciona->fields['nome'];
    $num_monografia = $res_seleciona->fields['num_monografia'];
    $registro = $res_seleciona->fields['registro'];
    echo "Numero de monografia " . $num_monografia . "<br>";
    // die();
    $sql_inserir = "insert into tcc_alunos(nome, num_monografia, registro) values(\"$nome\", $codigo, $registro)";
    echo $sql_inserir . "<br>";

    $res_inserir = $db->Execute($sql_inserir);
    if (($res_inserir === FALSE))
        die("Não foi possível inserir o registro na tabela tcc_alunos");

    $sql_delete0 = "delete from tcc_alunos where numero = '$id_novoid_aluno0'";
    // echo $sql_delete0 . "<br>";
    // die("1 Excluíndo registro de monografia por alteração do estudante autor");
    $res_delete0 = $db->Execute($sql_delete0);
    if ($res_delete0 === false)
        die("Nao foi possivel excluir registro da tabela tcc_alunos");
}

echo "Id aluno1 " . $id_novoid_aluno1 . "<br>";
if (!empty($id_novoid_aluno1)) {

    echo "Inserir" . "<br>";
    $sql_seleciona = "select nome, num_monografia, registro from tcc_alunos where numero=$id_novoid_aluno1";
    $res_seleciona = $db->Execute($sql_seleciona);
    $nome = $res_seleciona->fields['nome'];
    $num_monografia = $res_seleciona->fields['num_monografia'];
    $registro = $res_seleciona->fields['registro'];
    echo "Numero de monografia " . $num_monografia . "<br>";
    // die();
    if ($registro) {
        $sql_inserir = "insert into tcc_alunos(nome, num_monografia, registro) values(\"$nome\', $codigo, $registro)";
        echo $sql_inserir . "<br>";

        $res_inserir = $db->Execute($sql_inserir);
        if (($res_inserir === FALSE))
            die("Não foi possível inserir o registro na tabela tcc_alunos");

        $sql_delete0 = "delete from tcc_alunos where numero = '$id_novoid_aluno1'";
        // echo $sql_delete0 . "<br>";
        // die("1 Excluíndo registro de monografia por alteração do estudante autor");
        $res_delete0 = $db->Execute($sql_delete0);
        if ($res_delete0 === false)
            die("Nao foi possivel excluir registro da tabela tcc_alunos");
    } else {
        echo "Não foi possível inserir o estudante por falta do número de registro";
    }
}

if (!empty($id_atualizaid_aluno1)) {
    echo $id_atualizaid_aluno1 . "<br>";
    // die();
    if ($id_atualizaid_aluno1 <> $id_aluno1) {
        echo "Atualiza estudante: $id_atualizaid_aluno1 -> $id_aluno1" . "<br>";
        $sql_atualiza0 = "update tcc_alunos set num_monografia = '$codigo' where numero = '$id_atualizaid_aluno1'";
        echo $sql_atualiza0 . "<br>";
        $res_atualiza0 = $db->Execute($sql_atualiza0);
        if ($res_atualiza0 === false)
            die("Nao foi possivel atualizar registro na tabela tcc_alunos");

        $sql_delete0 = "delete from tcc_alunos where numero = '$id_aluno1'";
        // echo $sql_delete0 . "<br>";
        // die("0 Excluíndo registro de monografia por alteração do estudante autor");
        $res_delete0 = $db->Execute($sql_delete0);
        if ($res_delete0 === false)
            die("Nao foi possivel excluir registro da tabela tcc_alunos");
    } else {
        echo "Permanece sem alterações <br>";
        // die();
    }
}

echo "Id aluno2 " . $id_novoid_aluno2 . "<br>";
if (!empty($id_novoid_aluno2)) {

    echo "Inserir" . "<br>";
    $sql_seleciona = "select nome, num_monografia, registro from tcc_alunos where numero=$id_novoid_aluno2";
    $res_seleciona = $db->Execute($sql_seleciona);
    $nome = $res_seleciona->fields['nome'];
    $num_monografia = $res_seleciona->fields['num_monografia'];
    $registro = $res_seleciona->fields['registro'];
    echo "Numero de monografia " . $num_monografia . "<br>";
    // die();
    if ($registro) {
        $sql_inserir = "insert into tcc_alunos(nome, num_monografia, registro) values(\"$nome\", $codigo, $registro)";
        echo $sql_inserir . "<br>";
        $res_inserir = $db->Execute($sql_inserir);
        if (($res_inserir === FALSE))
            die("Não foi possível inserir o registro na tabela tcc_alunos");

        $sql_delete0 = "delete from tcc_alunos where numero = '$id_novoid_aluno2'";
        // echo $sql_delete0 . "<br>";
        // die("1 Excluíndo registro de monografia por alteração do estudante autor");
        $res_delete0 = $db->Execute($sql_delete0);
        if ($res_delete0 === false)
            die("Nao foi possivel excluir registro da tabela tcc_alunos");
    } else {
        echo "Não foi possível inserir o estudente por falta do número de registro)";
    }
}

/* Renomea os arquivos por mudança do nome do estudante autor */
if ($url) {
    echo "URL: " . $url . "<br>";
    // die();

    $sql_aluno0 = "select registro from tcc_alunos where num_monografia = $codigo order by nome";
    echo $sql_aluno0 . "<br>";
    // die();
    $res_aluno0 = $db->Execute($sql_aluno0);
    $registro_aluno0 = $res_aluno0->fields['registro'];
    echo $registro_aluno0 . "<br>";
    // die();
    if ($registro_aluno0) {

        $raiz = '/usr/local/htdocs/html';
        $nome_velho = $raiz . "/monografias/" . $url;
        $nome_novo = $raiz . "/monografias/" . $registro_aluno0 . ".pdf";
        echo "Nome velho: " . $nome_velho . " Nome novo: " . $nome_novo . "<br>";
        // die();
        rename($nome_velho, $nome_novo);

        $url_nova = $registro_aluno0 . ".pdf";
        $sql_url = "update monografia set url = '$url_nova' where codigo=$codigo";
        echo $sql_url . "<br>";
        // die();
        $res_url = $db->Execute($sql_url);
        if ($res_url === false)
            die("Não foi possível atualizar a url da tabela monografia");
    } else {

        echo "400 Estudante sem número de registro";
        header("Location: ../visualizar/ver_monografia.php?codigo=$codigo&error=sem_registro");
        die("Error: Estudante sem número de registro");
    }
}

$db->Close();

header("Location: ../visualizar/ver_monografia.php?codigo=$codigo");

?>