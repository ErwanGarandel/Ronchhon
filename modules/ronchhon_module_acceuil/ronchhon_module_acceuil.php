<?php

if (!defined('_PS_VERSION_'))
	exit;

class ronchhon_module_acceuil extends Module
{
	public function __construct()
	{
		$this->name = 'ronchhon_module_acceuil';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'GroupeProjetRonchhon';
		$this->need_instance = 0;
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Ronchhon Module Acceuil');
		$this->description = $this->l('Affiche une image aléatoirement lors de l\'arrivée d\'un visiteur');
	}

	public function install()
	{
		return
			parent::install() &&
			$this->registerHook('displayBanner') &&
			$this->registerHook('displayHeader');
	}

	public function uninstall()
	{
		Configuration::deleteByName('ronchhon_module_acceuil');
		return parent::uninstall();
	}

	public function hookDisplayTop($params)
	{
		if (!$this->isCached('ronchhon_module_acceuil.tpl', $this->getCacheId()))
		{
			$this->smarty->assign(array(
				'ronchhon_module_acceuil' => Configuration::get('ronchhon_module_acceuil')
			));
		}
		return $this->display(__FILE__, 'ronchhon_module_acceuil.tpl', $this->getCacheId());
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
