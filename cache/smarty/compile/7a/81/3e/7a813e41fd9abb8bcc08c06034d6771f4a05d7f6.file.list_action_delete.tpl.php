<?php /* Smarty version Smarty-3.1.19, created on 2017-03-02 14:00:58
         compiled from "C:\xampp\htdocs\websites\prestashop\admin302c5s224\themes\default\template\helpers\list\list_action_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:397558b8178ae02220-72044944%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a813e41fd9abb8bcc08c06034d6771f4a05d7f6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\admin302c5s224\\themes\\default\\template\\helpers\\list\\list_action_delete.tpl',
      1 => 1460106276,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '397558b8178ae02220-72044944',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'confirm' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58b8178ae0fb12_39576614',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b8178ae0fb12_39576614')) {function content_58b8178ae0fb12_39576614($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if (isset($_smarty_tpl->tpl_vars['confirm']->value)) {?> onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')){return true;}else{event.stopPropagation(); event.preventDefault();};"<?php }?> title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="delete">
	<i class="icon-trash"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
