<?
/**
 * Arquivo de Exemplo da classe AJAX/PHP AutoComplete
 * Example file for AJAX Powered PHP auto-complete
 *
 * @author Rafael Dohms <rafael at rafaeldohms dot com dot br>
 * @package dmsAutoComplete
 * @version 1.0
 */

/**
* Função de auxilio para exemplo, ela filtra o array
* retornando apenas as entradas que se iniciam com
* a string recebida
* 
* Filter function used in example, it filters an array
* returning only entries starting with the given string
*
* @param item
*/
/*
function arrfilter(&$item){
	return preg_match('/^'.utf8_decode($_POST['string']).'/',$item);
}
*/

include("database.inc");

if (class_exists('DOMDocument')){ //Adapta o script para PHP4

	//Criar documento XML atraves de DOM
	//Create XML Doc through DOM
	$xmlDoc = new DOMDocument('1.0', 'utf-8');
	$xmlDoc->formatOutput = true;

	//Criar elementos Ra�z do XML
	//Create root XML element
	$root = $xmlDoc->createElement('root');
	$root = $xmlDoc->appendChild($root);

}else{
	$xmlDoc  = '<?xml version="1.0" encoding="utf-8"?>';
	$xmlDoc .= '<root>';
}
/**
 * :pt-br:
 * Definir Lista (itens) a ser mostrada.
 * 
 * Neste passo podemos realizar buscas em banco de dados, filtrar arrays
 * Ou qualquer outra tarefa que retorne um resultado baseado no string
 * recebido
 * 
 * :en:
 * Define list to be returned
 * 
 * In this step we could do a database search, filter arryas or perform
 * other actions which would return a resultig list based on an input
 * string
 */

if ($_POST['string'] != ''){
	//Fazer filtro ou busca
	//Filter ou search
	//SQL, Array, etc...
	$sql = "select codigo, titulo from monografia where titulo like '%" . $_POST['string'] . "%' order by titulo";
	// echo $sql . "<br>";
	$resultado = $db->Execute($sql);
	if ($resultado == false) die ("Nao foi possivel consultar a tabela monografias");
	//  print_r($resultado);
	while (!$resultado->EOF) {

	//Construir elementos ITEM
	//built ITEM elements

		if (class_exists('DOMDocument')){
			//Cadastrar na lista
			//Add to list
			$item = $xmlDoc->createElement('item');
			$item = $root->appendChild($item);
			$item->setAttribute('id',$resultado->fields['codigo']);
			$item->setAttribute('label',rawurlencode($resultado->fields['titulo']));
			//rawurlencode evita problemas de charset
			//rawurlencode avoids charset problems
		}else{
			$xmlDoc .= '<item id="'.$resultado->fields['codigo'].'" label="'.rawurlencode($resultado->fields['titulo']).'"></item>';
		}
		$resultado->MoveNext();
	}
    } 

//Retornar XML de resultado para AJAX
//Return XML code for AJAX Request
header("Content-type:application/xml; charset=utf-8");
if (class_exists('DOMDocument')){
	echo $xmlDoc->saveXML();
}else{
	$xmlDoc .= '</root>';
	echo $xmlDoc;
}

?>