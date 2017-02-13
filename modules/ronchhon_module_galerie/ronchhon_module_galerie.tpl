<div class="ronchhon_module_galerie">
	<p>La galerie</p>
	{foreach from=$list_oeuvre item=oeuvre}
	<h1>{$oeuvre.nom}</h1><p>Type : {$oeuvre.libelle}</p><br/>
	<img src="./ronchhon/galerie/img{$oeuvre.id}.{$oeuvre.format}"/>
	<p>{$oeuvre.desc}</p><br/>
	{/foreach}
</div>