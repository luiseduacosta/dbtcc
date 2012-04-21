<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'/>
</head>

<body>
{if $id_area == "99" || $id_area == "91"}
	<table>
	<caption>Monografias classificadas como área: {$area}</caption>
	<tbody>
	<tr>
	<th><a href="?ordem=titulo&num_area={$id_area}">Título</a></th>
	<th><a href="?ordem=nome&num_area={$id_area}">Professor</a></td>
	<th><a href="?ordem=periodo&num_area={$id_area}">Período</a></th>
	</tr>

	{section name=i loop=$monografiaSem}
	{if $color == 0}
		<tr class="resaltado" id="resaltado">
		{assign var="color" value="1"}
	{else}
		<tr class="natural" id="natural">
		{assign var="color" value="0"}
	{/if}	
	<td><a href="../../areaMonografia/visualizar/monografia.php?codigo={$monografiaSem[i].codigo}">{$monografiaSem[i].titulo}</a></td>
	<td>{$monografiaSem[i].professor}</td>
	<td>{$monografiaSem[i].periodo}</td>
	</tr>
	{/section}

	</tbody>
	</table>
{else}
	<div>
	<table>
	<caption>Professores da área: {$area}</caption>
	<tbody>

	<tr>
	<th>Professor</th>
	<th>Departamento</th>
	<th>Condição</th>
	<th>E-mail</th>
	</tr>

	{section name=i loop=$professores}
	{if $color == 0}
		<tr class="resaltado" id="resaltado">
		{assign var="color" value="1"}
	{else}
		<tr class="natural" id="natural">
		{assign var="color" value="0"}
	{/if}	
	<td>{$professores[i].nome}</td>
	<td>{$professores[i].departamento}</td>
	<td>{$professores[i].condicao}</td>
	<td><a href="mailto:{$professores[i].email}">{$professores[i].email}</a></td>
	{/section}

	</tbody>
	</table>

	<br>

	<table>
	<caption>Monografias classificadas como área: {$area}</caption>
	<tbody>
	<tr>
	<th><a href="?ordem=titulo&num_area={$id_area}">Título</a></th>
	<th><a href="?ordem=nome&num_area={$id_area}">Professor</a></td>
	<th><a href="?ordem=periodo&num_area={$id_area}">Período</a></th>
	<th><a href="?ordem=area&num_area={$id_area}">Área</a></th>
	</tr>

	{section name=i loop=$monografias}
	{if $color == 0}
		<tr class="resaltado" id="resaltado">
		{assign var="color" value="1"}
	{else}
		<tr class="natural" id="natural">
		{assign var="color" value="0"}
	{/if}	
	<td><a href="../../areaMonografia/visualizar/monografia.php?codigo={$monografias[i].codigo}">{$monografias[i].titulo}</a></td>
	<td>{$monografias[i].nome}</td>
	<td>{$monografias[i].periodo}</td>
	<td>{$monografias[i].area}</td>
	</tr>
	{/section}
	
	</tbody>
	</table>
	</div>
{/if}

</body>
</html>
