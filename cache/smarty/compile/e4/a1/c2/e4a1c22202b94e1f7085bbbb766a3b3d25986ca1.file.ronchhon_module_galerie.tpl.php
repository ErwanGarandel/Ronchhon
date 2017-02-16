<?php /* Smarty version Smarty-3.1.19, created on 2017-02-16 14:13:18
         compiled from "C:\xampp\htdocs\websites\prestashop\modules\ronchhon_module_galerie\ronchhon_module_galerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1836358a5a56e0e1447-93685774%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4a1c22202b94e1f7085bbbb766a3b3d25986ca1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\modules\\ronchhon_module_galerie\\ronchhon_module_galerie.tpl',
      1 => 1487250745,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1836358a5a56e0e1447-93685774',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list_oeuvre' => 0,
    'oeuvre' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58a5a56e0ed7c5_85708351',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a5a56e0ed7c5_85708351')) {function content_58a5a56e0ed7c5_85708351($_smarty_tpl) {?><div class="ronchhon_module_galerie">
	<div id="cadreZoom"><span id="numero"></span>
		<p id="titreZoom"></p>
		<img id="croixFerme" onclick="ferme()" src="./ronchhon/croix.png"/>
		<img id="imageZoom" src=""/>
		<p id="descZoom" ></p>
		<p onclick="precedant()">Précédant</p><p onclick="suivant()">Suivant</p>
	</div>
	<p>La galerie</p>
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
		
		cadre.style.width = "100%";
		cadre.style.height = "100%";
		cadre.style.display = "block";
		cadre.style.zIndex = "9999";
		cadre.style.backgroundColor = "black";
		
		image.src = "./ronchhon/galerie/img"+identifiant+"."+oeuvre[identifiant-1].format;
		
		titre.innerHTML = oeuvre[identifiant-1].nom;
		
		desc.innerHTML = oeuvre[identifiant-1].desc;
		
		id.innerHTML = identifiant;
		
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
	
	function ferme(){
		var cadre = document.getElementById("cadreZoom");
		var image = document.getElementById("imageZoom");
		var titre = document.getElementById("titreZoom");
		var desc = document.getElementById("descZoom");
		var id = document.getElementById("numero");
		
		cadre.style.width = "0";
		cadre.style.height = "0";
		cadre.style.display = "none";
		cadre.style.zIndex = "-1";
		cadre.style.backgroundColor = "";
		
		image.src = "";
		
		titre.innerHTML = "";
		
		desc.innerHTML = "";
		
		id.innerHTML = "";
		
		document.body.style.overflow = "auto";
	}
</script><?php }} ?>
