<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Alunos pendentes</title>
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
			
			$('#alunos tbody tr td.periodo').quicksearch({
                hideElement: 'parent',
                position: 'prepend',
                attached: '#busca_periodo',
                focusOnLoad: true,
                stripeRowClass: ['resaltado', 'normal'],
                loaderText: 'Aguarde...',
                labelText: 'Busca periodo:'
            });
			
            /*
             $("#monografias").tablesorterPager({
             container: $("#pager")
             });
             */
			/*
            $(".alterna_cores tr").mouseover(function(){
                $(this).addClass("over");
            });
            $(".alterna_cores tr").mouseout(function(){
                $(this).removeClass("over");
            });
            $(".alterna_cores tr:even").addClass("alt");
            */            
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
        <div align='center'>
            <table id='alunos' class='alterna_cores'>
                <caption>
                    Tabela de alunos pendentes
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
                        Est&aacute;gio
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
                            {$alunos[id].nome}
                        </td>
                        <td style='text-align:center'>
                            {$alunos[id].nivel}
                        </td>
                        <td class='periodo'>
                            {$alunos[id].periodo}
                        </td>
                    </tr>
                    {/section}
                </tbody>
            </table>
        </div>
        <div id='pager' class='pager'>
            <form>
                <img src='../../lib/tablesorter/addons/pager/icons/first.png' class='first'/><img src='../../lib/tablesorter/addons/pager/icons/prev.png' class='prev'/><input type='text' class='pagedisplay'/><img src='../../lib/tablesorter/addons/pager/icons/next.png' class='next'/><img src='../../lib/tablesorter/addons/pager/icons/last.png'' class='last'/>
                <select class='pagesize'>
                    <option selected='selected' value='5'>5</option>
                    <option value='10'>10</option>
                    <option value='20'>20</option>
                    <option value='30'>30</option>
                    <option value='40'>40</option>
                </select>
            </form>
        </div>
    </body>
</html>
