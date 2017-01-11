<?php /* Smarty version Smarty-3.1.19, created on 2017-01-11 15:57:11
         compiled from "C:\xampp\htdocs\websites\prestashop\modules\ronchhon_module_news\ronchhon_module_news.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8846580784998aa163-20434525%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08835c520e822b958e11315a3a90028b75038206' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\modules\\ronchhon_module_news\\ronchhon_module_news.tpl',
      1 => 1484146629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8846580784998aa163-20434525',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580784998b6f80_45660997',
  'variables' => 
  array (
    'list_news' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580784998b6f80_45660997')) {function content_580784998b6f80_45660997($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\xampp\\htdocs\\websites\\prestashop\\tools\\smarty\\plugins\\modifier.date_format.php';
?><div class="ronchhon_module_news">
	<?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['news']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value) {
$_smarty_tpl->tpl_vars['news']->_loop = true;
?>
	<p><?php echo $_smarty_tpl->tpl_vars['news']->value['genre'];?>
</p>
	<strong><?php echo $_smarty_tpl->tpl_vars['news']->value['titre'];?>
</strong> écrit le <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['news']->value['date'],"%d/%m/%Y");?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['news']->value['contenu'];?>
<br /><br />
	<?php } ?>
</div><?php }} ?>
