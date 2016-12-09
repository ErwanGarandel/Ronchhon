<div class="ronchhon_module_news">
	{foreach from=$list_news item=news}
	<p>{$news.genre}</p>
	<strong>{$news.titre}</strong> écrit le {$news.date|date_format:"%d/%m/%Y"}<br />
	{$news.contenu}<br /><br />
	{/foreach}
</div>