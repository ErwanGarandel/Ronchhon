<div class="ronchhon_module_galerie">
	<div id="cadreZoom"><span id="numero"></span><span id="taille">0</span>
		<p id="titreZoom"></p>
		<img id="croixFerme" onclick="ferme()" src="./ronchhon/croix.png"/>
		<img id="imageZoom" style="max-width: 80%;max-height: 80%;" onclick="realSize()" src=""/>
		<p id="descZoom" ></p>
		<p onclick="precedant()">Précédant</p><p onclick="suivant()">Suivant</p>
	</div>
	<p>La galerie</p>
<div id="cadreMenu">
	<ul id="listeMenu">
	<li><a href="{$smarty.server.PHP_SELF}?id_cms=8&controller=cms">Toutes les oeuvres</a></li>
	{foreach from=$genre_oeuvre item=genre}
		<li><a href="{$smarty.server.PHP_SELF}?id_cms=8&controller=cms&genre={$genre.genre_oeuvre_id}">{$genre.genre_oeuvre_libelle}</a></li>
	{/foreach}
	</ul>
</div>
	{foreach from=$list_oeuvre item=oeuvre}
	{if $oeuvre@iteration % 4 eq 1}
	<div style="clean:both;height:300px;width:100%;margin:auto;text-align:center">{/if}
	<div style="width:25%;margin:0;padding:0;display:inline-block;float:left" id="mini{$oeuvre@iteration}">
	<img id="oeuvre{$oeuvre@iteration}" onclick="info({$oeuvre@iteration})" src="./ronchhon/galerie/mini{$oeuvre.id}.{$oeuvre.format}"/>
	</div>
	{if $oeuvre@iteration % 4 eq 0}
	</div>{/if}
	{/foreach}
</div>
<script type="text/javascript">
	function info(identifiant){
		var oeuvre = {$list_oeuvre|json_encode};
		var cadre = document.getElementById("cadreZoom");
		var image = document.getElementById("imageZoom");
		var titre = document.getElementById("titreZoom");
		var desc = document.getElementById("descZoom");
		var id = document.getElementById("numero");
		var taille = document.getElementById("taille");
		
		cadre.style.width = "100%";
		cadre.style.height = "100%";
		cadre.style.display = "block";
		cadre.style.zIndex = "9999";
		cadre.style.backgroundColor = "black";
		
		image.src = "./ronchhon/galerie/img"+identifiant+"."+oeuvre[identifiant-1].format;
		
		titre.innerHTML = oeuvre[identifiant-1].nom;
		
		desc.innerHTML = oeuvre[identifiant-1].desc;
		
		id.innerHTML = identifiant;
		
		taille.innerHTML = "0";
		
		document.body.style.overflow = "hidden";
	}
	
	function suivant(){
		var identifiant = document.getElementById("numero").innerHTML;
		if(identifiant <= {$oeuvre@iteration}-1){
			info(parseInt(identifiant)+1);
		}
	}
	
	function precedant(){
		var identifiant = document.getElementById("numero").innerHTML;
		if(identifiant >= 0){
			info(parseInt(identifiant)-1);
		}
	}
	
	function realSize(){
		var taille = document.getElementById("taille");
		var image = document.getElementById("imageZoom");
		
		if(taille.innerHTML == 0){
			taille.innerHTML = 1;
			
			var imgTmp = new Image();
			imgTmp.src = image.src;
			largeurImg = imgTmp.width
			hauteurImg = imgTmp.height
			
			image.style.width = largeurImg+"px";
			image.style.height = hauteurImg+"px";
			image.style.maxWidth = "";
			image.style.maxHeight = "";
		}
		else{
			taille.innerHTML = 0;
			image.style.width = "auto";
			image.style.height = "auto";
			image.style.maxWidth = "80%";
			image.style.maxHeight = "80%";
		}
	}
	
	function ferme(){
		var cadre = document.getElementById("cadreZoom");
		var image = document.getElementById("imageZoom");
		var titre = document.getElementById("titreZoom");
		var desc = document.getElementById("descZoom");
		var id = document.getElementById("numero");
		var taille = document.getElementById("taille");
		
		cadre.style.width = "0";
		cadre.style.height = "0";
		cadre.style.display = "none";
		cadre.style.zIndex = "-1";
		cadre.style.backgroundColor = "";
		
		image.src = "";
		
		titre.innerHTML = "";
		
		desc.innerHTML = "";
		
		id.innerHTML = "";
		
		taille.innerHTML = 0;
		image.style.width = "auto";
		image.style.height = "auto";
		image.style.maxWidth = "80%";
		image.style.maxHeight = "80%";
		
		document.body.style.overflow = "auto";
	}
</script>