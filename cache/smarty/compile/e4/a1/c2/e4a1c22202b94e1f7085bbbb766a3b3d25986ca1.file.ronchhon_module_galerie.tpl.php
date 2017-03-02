<?php /* Smarty version Smarty-3.1.19, created on 2017-03-02 14:01:04
         compiled from "C:\xampp\htdocs\websites\prestashop\modules\ronchhon_module_galerie\ronchhon_module_galerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1056958b817903b5294-16087209%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4a1c22202b94e1f7085bbbb766a3b3d25986ca1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\modules\\ronchhon_module_galerie\\ronchhon_module_galerie.tpl',
      1 => 1488459563,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1056958b817903b5294-16087209',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'genre_oeuvre' => 0,
    'genre' => 0,
    'list_oeuvre' => 0,
    'oeuvre' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58b817903c7228_55533845',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b817903c7228_55533845')) {function content_58b817903c7228_55533845($_smarty_tpl) {?><div class="ronchhon_module_galerie">
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
	<li><a href="<?php echo $_SERVER['PHP_SELF'];?>
?id_cms=8&controller=cms">Toutes les oeuvres</a></li>
	<?php  $_smarty_tpl->tpl_vars['genre'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['genre']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['genre_oeuvre']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['genre']->key => $_smarty_tpl->tpl_vars['genre']->value) {
$_smarty_tpl->tpl_vars['genre']->_loop = true;
?>
		<li><a href="<?php echo $_SERVER['PHP_SELF'];?>
?id_cms=8&controller=cms&genre=<?php echo $_smarty_tpl->tpl_vars['genre']->value['genre_oeuvre_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['genre']->value['genre_oeuvre_libelle'];?>
</a></li>
	<?php } ?>
	</ul>
</div>
	<?php  $_smarty_tpl->tpl_vars['oeuvre'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['oeuvre']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_oeuvre']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['oeuvre']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['oeuvre']->key => $_smarty_tpl->tpl_vars['oeuvre']->value) {
$_smarty_tpl->tpl_vars['oeuvre']->_loop = true;
 $_smarty_tpl->tpl_vars['oeuvre']->iteration++;
?>
	<?php if ($_smarty_tpl->tpl_vars['oeuvre']->iteration%4==1) {?>
	<div style="clean:both;height:300px;width:100%;margin:auto;text-align:center"><?php }?>
	<div style="width:25%;margin:0;padding:0;display:inline-block;float:left" id="mini<?php echo $_smarty_tpl->tpl_vars['oeuvre']->iteration;?>
">
	<img id="oeuvre<?php echo $_smarty_tpl->tpl_vars['oeuvre']->iteration;?>
" onclick="info(<?php echo $_smarty_tpl->tpl_vars['oeuvre']->iteration;?>
)" src="./ronchhon/galerie/mini<?php echo $_smarty_tpl->tpl_vars['oeuvre']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['oeuvre']->value['format'];?>
"/>
	</div>
	<?php if ($_smarty_tpl->tpl_vars['oeuvre']->iteration%4==0) {?>
	</div><?php }?>
	<?php } ?>
</div>
<script type="text/javascript">
	function info(identifiant){
		var oeuvre = <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['list_oeuvre']->value);?>
;
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
		if(identifiant <= <?php echo $_smarty_tpl->tpl_vars['oeuvre']->iteration;?>
-1){
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
</script><?php }} ?>
