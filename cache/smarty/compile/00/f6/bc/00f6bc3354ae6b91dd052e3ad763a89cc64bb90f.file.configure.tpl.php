<?php /* Smarty version Smarty-3.1.19, created on 2016-12-01 13:13:49
         compiled from "C:\xampp\htdocs\websites\prestashop\modules\example\views\templates\admin\configure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7646584013fd181250-93822686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00f6bc3354ae6b91dd052e3ad763a89cc64bb90f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\modules\\example\\views\\templates\\admin\\configure.tpl',
      1 => 1435305435,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7646584013fd181250-93822686',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errors' => 0,
    'error' => 0,
    'request_uri' => 0,
    'path' => 0,
    'EXAMPLE_CONF' => 0,
    'submitName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_584013fd1e7670_15432572',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584013fd1e7670_15432572')) {function content_584013fd1e7670_15432572($_smarty_tpl) {?>

<?php if (count($_smarty_tpl->tpl_vars['errors']->value)>0) {?>
	<div class="error">
		<ul>
			<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
				<li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
			<?php } ?>
		</ul>
	</div>
<?php }?>

<form action="<?php echo $_smarty_tpl->tpl_vars['request_uri']->value;?>
" method="post">
	<fieldset>
		<legend><img src="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
logo.gif" alt="" title="" /><?php echo smartyTranslate(array('s'=>'Settings','mod'=>'example'),$_smarty_tpl);?>
</legend>
		<label><?php echo smartyTranslate(array('s'=>'Your label','mod'=>'example'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="text" size="20" name="EXAMPLE_CONF" value="<?php echo $_smarty_tpl->tpl_vars['EXAMPLE_CONF']->value;?>
" />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'e.g. something','mod'=>'example'),$_smarty_tpl);?>
</p>
		</div>
		<center><input type="submit" name="<?php echo $_smarty_tpl->tpl_vars['submitName']->value;?>
" value="<?php echo smartyTranslate(array('s'=>'Save','mod'=>'example'),$_smarty_tpl);?>
" class="button" /></center>
	</fieldset>
</form><?php }} ?>
