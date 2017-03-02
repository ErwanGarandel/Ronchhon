<?php /* Smarty version Smarty-3.1.19, created on 2017-03-02 14:06:35
         compiled from "C:\xampp\htdocs\websites\prestashop\modules\ronchhon_module_news\ronchhon_module_news.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2388758b818db9a2ca3-46449923%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08835c520e822b958e11315a3a90028b75038206' => 
    array (
      0 => 'C:\\xampp\\htdocs\\websites\\prestashop\\modules\\ronchhon_module_news\\ronchhon_module_news.tpl',
      1 => 1488459938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2388758b818db9a2ca3-46449923',
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
  'unifunc' => 'content_58b818db9aed69_10419584',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b818db9aed69_10419584')) {function content_58b818db9aed69_10419584($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\xampp\\htdocs\\websites\\prestashop\\tools\\smarty\\plugins\\modifier.date_format.php';
?><style type="text/css">

/* this is an intersting idea for this section */
h1
{
    text-align:center;
}
h6
{
    text-align:right;
    size=15;
}
h3
{
    background-color:#e6e6e6;
    text-align:justify;
    color:black;
    font-size:1.5em;
    margin-left:15px;
    margin-right:15px;
    margin-bottom:15px;
    border-width:1px;
    border-style:solid;
    border-color:grey;
    border-width:1px 2px 3px 2px;
    padding: 10px 10px;
}
h4
{
    background-color:white;
    font-size:1.5em;
    margin-bottom:0px;
}
.ronchhon_module_news 
{
    background-color:#CCCCCC;
    margin-top:10px;
    border-radius: 10px 50px 10px 10px;
    border-width:2px;
    border-style:solid;
    border-color:black;

}


a
{
    text-decoration: none;
    color: grey;
}

</style>
 
<div class="ronchhon_module_news">
	<?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['news']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value) {
$_smarty_tpl->tpl_vars['news']->_loop = true;
?>
	
	<h1><?php echo $_smarty_tpl->tpl_vars['news']->value['titre'];?>
</h1>
    &nbsp;&nbsp;&nbsp;&nbsp;type : <?php echo $_smarty_tpl->tpl_vars['news']->value['genre'];?>
 
	<p><h3><?php echo $_smarty_tpl->tpl_vars['news']->value['contenu'];?>
</h3></p><h6>posté le <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['news']->value['date'],"%d/%m/%Y");?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
	<h4></br></h4>

	<?php } ?>
</div>
<?php }} ?>
