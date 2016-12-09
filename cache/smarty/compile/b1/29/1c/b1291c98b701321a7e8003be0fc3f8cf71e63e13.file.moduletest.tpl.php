<?php /* Smarty version Smarty-3.1.19, created on 2016-10-13 17:38:53
         compiled from "C:\wamp64\www\prestashop\modules\moduletest\moduletest.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1970957fea8b8acb351-97187574%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1291c98b701321a7e8003be0fc3f8cf71e63e13' => 
    array (
      0 => 'C:\\wamp64\\www\\prestashop\\modules\\moduletest\\moduletest.tpl',
      1 => 1476373130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1970957fea8b8acb351-97187574',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57fea8b8b0de21_97169079',
  'variables' => 
  array (
    'list_news' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fea8b8b0de21_97169079')) {function content_57fea8b8b0de21_97169079($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\wamp64\\www\\prestashop\\tools\\smarty\\plugins\\modifier.date_format.php';
?><?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['news']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value) {
$_smarty_tpl->tpl_vars['news']->_loop = true;
?>
<?php } ?>
<div class="moduletest">
       <h1> Dernières actus </h1>
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
</div>
<?php }} ?>
