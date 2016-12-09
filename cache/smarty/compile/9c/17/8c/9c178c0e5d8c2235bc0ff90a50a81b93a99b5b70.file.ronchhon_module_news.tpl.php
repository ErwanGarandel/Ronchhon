<?php /* Smarty version Smarty-3.1.19, created on 2016-10-19 16:10:13
         compiled from "C:\wamp64\www\prestashop\modules\ronchhon_module_news\ronchhon_module_news.tpl" */ ?>
<?php /*%%SmartyHeaderCode:347558077ec54f8302-93729986%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c178c0e5d8c2235bc0ff90a50a81b93a99b5b70' => 
    array (
      0 => 'C:\\wamp64\\www\\prestashop\\modules\\ronchhon_module_news\\ronchhon_module_news.tpl',
      1 => 1476875566,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '347558077ec54f8302-93729986',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list_news' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58077ec554fad7_43677997',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58077ec554fad7_43677997')) {function content_58077ec554fad7_43677997($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\wamp64\\www\\prestashop\\tools\\smarty\\plugins\\modifier.date_format.php';
?><div class="ronchhon_module_news">
       <h1> Mon super système de news </h1>
	<?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['news']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value) {
$_smarty_tpl->tpl_vars['news']->_loop = true;
?>
	<strong><?php echo $_smarty_tpl->tpl_vars['news']->value['titre'];?>
</strong> écrit le <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['news']->value['date'],"%d/%m/%Y");?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['news']->value['contenu'];?>
<br /><br />
	<?php } ?>
</div><?php }} ?>
