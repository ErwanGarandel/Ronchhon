<?php /* Smarty version Smarty-3.1.19, created on 2017-01-04 18:23:31
         compiled from "C:\xampp\htdocs\websites\prestashop2\admin302c5s224\themes\default\template\helpers\modules_list\modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21187586d2f93a1b3e6-85013809%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b51d2c361d18f69ee4e71c76a098357d0e514b0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop2\\admin302c5s224\\themes\\default\\template\\helpers\\modules_list\\modal.tpl',
      1 => 1460106276,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21187586d2f93a1b3e6-85013809',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_586d2f93a1d8d6_10053809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_586d2f93a1d8d6_10053809')) {function content_586d2f93a1d8d6_10053809($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules and Services'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
