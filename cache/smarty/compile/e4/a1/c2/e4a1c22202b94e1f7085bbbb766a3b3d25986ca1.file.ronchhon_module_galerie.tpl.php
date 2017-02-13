<?php /* Smarty version Smarty-3.1.19, created on 2017-02-13 23:36:19
         compiled from "C:\xampp\htdocs\websites\prestashop\modules\ronchhon_module_galerie\ronchhon_module_galerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:274005880ac15a84d20-42231496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4a1c22202b94e1f7085bbbb766a3b3d25986ca1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\modules\\ronchhon_module_galerie\\ronchhon_module_galerie.tpl',
      1 => 1487025377,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '274005880ac15a84d20-42231496',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5880ac15ab8871_47595778',
  'variables' => 
  array (
    'list_oeuvre' => 0,
    'oeuvre' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5880ac15ab8871_47595778')) {function content_5880ac15ab8871_47595778($_smarty_tpl) {?><div class="ronchhon_module_galerie">
	<p>La galerie</p>
	<?php  $_smarty_tpl->tpl_vars['oeuvre'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['oeuvre']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_oeuvre']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['oeuvre']->key => $_smarty_tpl->tpl_vars['oeuvre']->value) {
$_smarty_tpl->tpl_vars['oeuvre']->_loop = true;
?>
	<h1><?php echo $_smarty_tpl->tpl_vars['oeuvre']->value['nom'];?>
</h1><p>Type : <?php echo $_smarty_tpl->tpl_vars['oeuvre']->value['libelle'];?>
</p><br/>
	<img src="./ronchhon/galerie/img<?php echo $_smarty_tpl->tpl_vars['oeuvre']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['oeuvre']->value['format'];?>
"/>
	<p><?php echo $_smarty_tpl->tpl_vars['oeuvre']->value['desc'];?>
</p><br/>
	<?php } ?>
</div><?php }} ?>
