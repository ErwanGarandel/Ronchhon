<style type="text/css">
{literal}
/* this is an intersting idea for this section */
h1
{
    text-align:center;
}
h6
{
    text-align:right;
    size=15;
}
h3
{
    background-color:#e6e6e6;
    text-align:justify;
    color:black;
    font-size:1.5em;
    margin-left:15px;
    margin-right:15px;
    margin-bottom:15px;
    border-width:1px;
    border-style:solid;
    border-color:grey;
    border-width:1px 2px 3px 2px;
    padding: 10px 10px;
}
h4
{
    background-color:white;
    font-size:1.5em;
    margin-bottom:0px;
}
.ronchhon_module_news 
{
    background-color:#CCCCCC;
    margin-top:10px;
    border-radius: 10px 50px 10px 10px;
    border-width:2px;
    border-style:solid;
    border-color:black;

}


a
{
    text-decoration: none;
    color: grey;
}
{/literal}
</style>
 
<div class="ronchhon_module_news">
	{foreach from=$list_news item=news}
	
	<h1>{$news.titre}</h1>
    &nbsp;&nbsp;&nbsp;&nbsp;type : {$news.genre} 
	<p><h3>{$news.contenu}</h3></p><h6>posté le {$news.date|date_format:"%d/%m/%Y"}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
	<h4></br></h4>

	{/foreach}
</div>
