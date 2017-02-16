<?php /* Smarty version Smarty-3.1.19, created on 2017-02-16 10:52:56
         compiled from "C:\xampp\htdocs\websites\prestashop\admin302c5s224\themes\default\template\helpers\list\list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1869958a57678a92527-00154105%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e95079f9c89aaf25a3fdf472d5be9c8f2f2218aa' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\admin302c5s224\\themes\\default\\template\\helpers\\list\\list_action_edit.tpl',
      1 => 1460106276,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1869958a57678a92527-00154105',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58a57678a9b6c6_75362274',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a57678a9b6c6_75362274')) {function content_58a57678a9b6c6_75362274($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
