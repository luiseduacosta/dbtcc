<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<table>
<caption>Monografias da área: {$area}</caption>
<tbody>
<tr>
<th>Titulo</th>
<th>Período</th>
<th>Professor</th>
</tr>

{section name=elemento loop=$monografia}
<tr>
<td><a href="monografia.php?codigo={$monografia[elemento].codigo}">{$monografia[elemento].titulo}</a></td>
<td>{$monografia[elemento].periodo}</td>
<td>{$monografia[elemento].professor}</td>
</tr>
{/section}

</tbody>
</table>

</body>
</html>
