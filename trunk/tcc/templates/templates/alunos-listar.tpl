<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Listar</title>
    </head>
	{literal}
    <style type="text/css">
        #pager {
            top: 10px;
        }
    </style>

    <script type="text/javascript" src="../../lib/jquery.js">
    </script>
    <script type="text/javascript" src="../../lib/tablesorter/jquery.tablesorter.min.js">
    </script>
    <script type="text/javascript" src="../../lib/tablesorter/jquery.tablesorter.js">
    </script>
    <script type="text/javascript" src="../../lib/tablesorter/addons/pager/jquery.tablesorter.pager.js">
    </script>
    <script type="text/javascript" src="../../lib/jquery.quicksearch.js">
    </script>
    <!--
    <script language="JavaScript" type="text/javascript" src="../../lib/jquery.tablehover.js"></script>
    //-->
    <script type="text/javascript">
		function get_valor() {
		
			var periodo=document.getElementById('periodo').value;
			window.location="?periodo="+periodo;
			return false;

		}

        $(document).ready(function(){
        
            /* $("#alunos").tableHover(); */
            
            $("#alunos").tablesorter({
                widthFixed: true,
                stripingRowClass: ['resaltado', 'normal'],
                stripeRowsOnStartUp: true
            });
            
            $('#alunos tbody tr td.nome').quicksearch({
                hideElement: 'parent',
                position: 'prepend',
                attached: '#busca',
                focusOnLoad: true,
                stripeRowClass: ['resaltado', 'normal'],
                loaderText: 'Aguarde...',
                labelText: 'Busca nome:'
            });

			$('#alunos tbody tr td.tab_titulo').quicksearch({
                hideElement: 'parent',
                position: 'prepend',
                attached: '#busca_titulo',
                focusOnLoad: true,
                stripeRowClass: ['resaltado', 'normal'],
                loaderText: 'Aguarde...',
                labelText: 'Busca titulo:'
            });
			
        });
    </script>
	{/literal}
    <link href='../../tcc.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
    	
        <div id='busca'>
        </div>
		<div id='busca_periodo'>
        </div>
		<div id='busca_titulo'>
        </div>
        
        <select name='periodo' id='periodo' size='1' onChange='return get_valor();'>
        <option value={$periodo}>{$periodo}</option>
        {section name='i' loop=$periodos}
		<option value={$periodos[i].periodo}>{$periodos[i].periodo}</option>
		{/section}
        </option>
        
        </select>
        		
        <div align='center'>
            <table id='alunos' class='alterna_cores'>
                <caption>
                    Alunos
                </caption>
                <thead>
                    <th>
                        ID
                    </th>
                    <th>
                        Registro
                    </th>
                    <th>
                        Nome
                    </th>
                    <th>
                        Cat&aacute;logo
                    </th>
                    <th>
                        T&iacute;tulo
                    </th>
                    <th>
                        PDF
                    </th>							
                    <th>
                        Periodo
                    </th>
                </thead>
                <tbody>
                	{assign var=i value=1}
                    {section name=id loop=$alunos}
                    <tr>
                        <td>
                        	{$i++}
                        </td>
                        <td>
                            {$alunos[id].registro}
                        </td>
                        <td class='nome'>
                            <a href='../atualizar/atualiza.php?id_aluno={$alunos[id].id}'>{$alunos[id].nome}</a>
                        </td>
                        <td>
                            {$alunos[id].catalogo}
                        </td>
                        <td class="tab_titulo">
                            {$alunos[id].titulo}
                        </td>
						{if empty($alunos[id].url)}
						<td></td>
						{else}
                        <td>
                            <a href='http://{$servidor}/monografias/{$alunos[id].url}'>PDF</a>:
                        </td>
						{/if}
                        <td class='periodo'>
                            {$alunos[id].periodo}
                        </td>
                    </tr>
                    {/section}
                </tbody>
            </table>
        </div>

    </body>
</html>
