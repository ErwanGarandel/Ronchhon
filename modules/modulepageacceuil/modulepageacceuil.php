<?php
if (!defined('_PS_VERSION_'))
	exit;

class modulepageacceuil extends Module
{
	public function __construct()
	{
		$this->name = 'modulepageacceuil';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'GroupeProjetRonchhon';
		$this->need_instance = 0;
		$this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('ModulePageAcceuil');
		$this->description = $this->l('Affiche une image aléatoire sur la page d acceuil du site');
	}

	public function install()
	{
		return
			parent::install() &&
			$this->registerHook('displayBanner') &&
			$this->registerHook('displayHeader') &&
			$this->disableDevice(Context::DEVICE_MOBILE);
	}

	public function uninstall()
	{
		Configuration::deleteByName('BLOCKBANNER_DESC');
		return parent::uninstall();
	}

	public function hookDisplayTop($params)
	{
		return $this->display(__FILE__, 'moduelepageacceuil.tpl', $this->getCacheId());
	}

	public function hookDisplayBanner($params)
	{
		return $this->hookDisplayTop($params);
	}

	public function hookDisplayHeader($params)
	{
  	$this->context->controller->addJS($this->_path.'scrollingdiv.js', 'all');
	}

}
