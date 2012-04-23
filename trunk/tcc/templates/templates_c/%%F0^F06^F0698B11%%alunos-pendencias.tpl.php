<?php /* Smarty version 2.6.22, created on 2012-01-26 14:54:18
         compiled from alunos-pendencias.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Alunos pendentes</title>
        <link href="../../css/tcc.css" rel="stylesheet" type="text/css"/>
    </head>
	<?php echo '
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
                stripingRowClass: [\'resaltado\', \'normal\'],
                stripeRowsOnStartUp: true
            });
            
            $(\'#alunos tbody tr td.nome\').quicksearch({
                hideElement: \'parent\',
                position: \'prepend\',
                attached: \'#busca\',
                focusOnLoad: true,
                stripeRowClass: [\'resaltado\', \'normal\'],
                loaderText: \'Aguarde...\',
                labelText: \'Busca nome:\'
            });
			
			$(\'#alunos tbody tr td.periodo\').quicksearch({
                hideElement: \'parent\',
                position: \'prepend\',
                attached: \'#busca_periodo\',
                focusOnLoad: true,
                stripeRowClass: [\'resaltado\', \'normal\'],
                loaderText: \'Aguarde...\',
                labelText: \'Busca periodo:\'
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
	'; ?>

    </head>
    <body>
        <div id='busca'>
        </div>
		<div id='busca_periodo'>
        </div>
        <div>
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
                	<?php $this->assign('i', 1); ?>
                    <?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['alunos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['id']['show'] = true;
$this->_sections['id']['max'] = $this->_sections['id']['loop'];
$this->_sections['id']['step'] = 1;
$this->_sections['id']['start'] = $this->_sections['id']['step'] > 0 ? 0 : $this->_sections['id']['loop']-1;
if ($this->_sections['id']['show']) {
    $this->_sections['id']['total'] = $this->_sections['id']['loop'];
    if ($this->_sections['id']['total'] == 0)
        $this->_sections['id']['show'] = false;
} else
    $this->_sections['id']['total'] = 0;
if ($this->_sections['id']['show']):

            for ($this->_sections['id']['index'] = $this->_sections['id']['start'], $this->_sections['id']['iteration'] = 1;
                 $this->_sections['id']['iteration'] <= $this->_sections['id']['total'];
                 $this->_sections['id']['index'] += $this->_sections['id']['step'], $this->_sections['id']['iteration']++):
$this->_sections['id']['rownum'] = $this->_sections['id']['iteration'];
$this->_sections['id']['index_prev'] = $this->_sections['id']['index'] - $this->_sections['id']['step'];
$this->_sections['id']['index_next'] = $this->_sections['id']['index'] + $this->_sections['id']['step'];
$this->_sections['id']['first']      = ($this->_sections['id']['iteration'] == 1);
$this->_sections['id']['last']       = ($this->_sections['id']['iteration'] == $this->_sections['id']['total']);
?>
                    <tr>
                        <td>
                        	<?php echo $this->_tpl_vars['i']++; ?>

                        </td>
                        <td>
                            <?php echo $this->_tpl_vars['alunos'][$this->_sections['id']['index']]['registro']; ?>

                        </td>
                        <td class='nome'>
                            <?php echo $this->_tpl_vars['alunos'][$this->_sections['id']['index']]['nome']; ?>

                        </td>
                        <td style='text-align:center'>
                            <?php echo $this->_tpl_vars['alunos'][$this->_sections['id']['index']]['nivel']; ?>

                        </td>
                        <td class='periodo'>
                            <?php echo $this->_tpl_vars['alunos'][$this->_sections['id']['index']]['periodo']; ?>

                        </td>
                    </tr>
                    <?php endfor; endif; ?>
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