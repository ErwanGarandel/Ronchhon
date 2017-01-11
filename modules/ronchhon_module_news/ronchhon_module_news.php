<?php
if (!defined('_PS_VERSION_'))
	exit;

class ronchhon_module_news extends Module
{
public function __construct()
	{
		$this->name = 'ronchhon_module_news';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'GroupeProjetRonchhon';
		$this->need_instance = 0;
		$this->bootstrap = true;
		$this->bdd = $this->connexionBase();
		parent::__construct();
		
		$this->displayName = 'Ronchhon Module de News';
		$this->description = 'Module de News pour l\'artiste Ronchhon';
	}

	public function install(){

		$this->_clearCache('ronchhon_module_news.tpl');
		
		$moduleRonchhonInstaller = Tab::getIdFromClassName('AdminRonchhon');
		if(empty($moduleRonchhonInstaller)){
		
			// Install Tabs
			$parent_tab = new Tab();
			// Need a foreach for the language
			$parent_tab->name[$this->context->language->id] = $this->l('Modules Ronchhon');
			$parent_tab->class_name = 'AdminRonchhon';
			$parent_tab->id_parent = 0; // Home tab
			$parent_tab->module = $this->name;
			$parent_tab->add();
		}

		$tab = new Tab();
		// Need a foreach for the language
		$tab->name[$this->context->language->id] = $this->l('News');
		$tab->class_name = 'AdminRonchhonNews';
		$tab->id_parent = $parent_tab->id;
		$tab->module = $this->name;
		$tab->add();
		
		return (parent::install()
				&& Configuration::updateValue('ronchhon_module_news', '')
				&& $this->registerHook('displayHome')
				&& $this->registerHook('displayArchive'));
	}
	public function uninstall(){
		Configuration::deleteByName('jsvalue');
		
		$moduleTabs = Tab::getCollectionFromModule($this->name);
		if (!empty($moduleTabs)) {
			foreach ($moduleTabs as $moduleTab) {
				$moduleTab->delete();
			}
		}
		
		if (!parent::uninstall()){
			return false;
		}
		return true;
	}
	
	public function connexionBase(){			//Ouverture de connexion à la base 'ronchhon' via PDO
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=ronchhon;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e){
			die('Erreur : '.$e->getMessage());
		}
		return $bdd;
	}
	
	public function getIdNouvelleNews(){			//Retourne le numéro de la dernière news écrite plus 1
		$resRequete=$this->bdd->query('SELECT MAX(news_id) as Max FROM ron_news');
		$IdMax=$resRequete->fetch(PDO::FETCH_ASSOC);
		return $IdMax['Max']+1;
	}
	
	public function getIdNouveauGenreNews(){			//Retourne le numéro de la dernière news écrite plus 1
		$resRequete=$this->bdd->query('SELECT MAX(genre_news_id) as Max FROM ron_genre_news');
		$IdMax=$resRequete->fetch(PDO::FETCH_ASSOC);
		return $IdMax['Max']+1;
	}
	
	private function getListContentNews(){			//retourne les données contenues dans la base concernant les news uniquement
		$ordre = ''; $recherche = ''; $conditions = false;
		if(Tools::isSubmit('ronchhon_module_newsOrderby') && Tools::isSubmit('ronchhon_module_newsOrderway') && substr(Tools::getValue('ronchhon_module_newsOrderby'),0,1) != 'g'){
			$ordre = ' order by '.Tools::getValue('ronchhon_module_newsOrderby').' '.Tools::getValue('ronchhon_module_newsOrderway');
		}
		if(Tools::isSubmit('submitFilter')){
			foreach($_POST as $cle=>$value){
				$rechercheTemp = $this->traitementRecherche($cle, $value);
				if(!empty($rechercheTemp) && $conditions){
					$recherche.= " and ".$rechercheTemp;
				}
				else if(!empty($rechercheTemp) && !$conditions){
					$conditions = true;
					$recherche.= " where ".$rechercheTemp;
				}
			}
		}
		$retour_total=$this->bdd->query('SELECT news_id, news_titre, news_contenu, news_date_p, news_date_m FROM ron_news'.$recherche.$ordre);
		$content=$retour_total->fetchAll();
		if(count($content) == 0){
			$retour_total=$this->bdd->query('SELECT news_id, news_titre, news_contenu, news_date_p, news_date_m FROM ron_news');
			$content=$retour_total->fetchAll();
			$this->displayError("Probleme");
		}
		return $content;
	}
	
	private function traitementRecherche($colonne, $valeur){
		if(preg_match("#^ronchhon_module_newsFilter_n#",$colonne)){
				if(!empty($_POST[$colonne])){
					$colValeur = substr($colonne,27);
					switch($colValeur){
						case 'news_id':
							$valCherche = htmlentities($valeur);
							$valCherche = str_replace('\'','\'\'',$valCherche);
							$recherche = " ".$colValeur."='".$valCherche."' ";
							return $recherche;
							break;
						case 'news_titre':
							$valCherche = htmlentities($valeur);
							$valCherche = str_replace('\'','\'\'',$valCherche);
							$valCherche = strtoupper($valCherche);
							$recherche = " ".$colValeur." LIKE '%".$valCherche."%' ";
							return $recherche;
							break;
						case 'news_date_p':
							$x = false;
							if(!empty($valeur[0])){
								$date = explode('-',$valeur[0]);
								$valCherche = $date[2]."/".$date[1]."/".$date[0];
								$recherche = " ".$colValeur." > str_to_date('".$valCherche."','%d/%m/%Y')";
								$x = true;
							}
							if(!empty($valeur[1])){
								if($x){
									$recherche .= " and ";
								}
								$date = explode('-',$valeur[1]);
								$valCherche = $date[2]."/".$date[1]."/".$date[0];
								$recherche .= " ".$colValeur." < str_to_date('".$valCherche."','%d/%m/%Y')";
							}
							return $recherche;
							break;
						case 'news_date_m':
							$x = false;
							if(!empty($valeur[0])){
								$date = explode('-',$valeur[0]);
								$valCherche = $date[2]."/".$date[1]."/".$date[0];
								$recherche = " ".$colValeur." > str_to_date('".$valCherche."','%d/%m/%Y')";
								$x = true;
							}
							if(!empty($valeur[1])){
								if($x){
									$recherche .= " and ";
								}
								$date = explode('-',$valeur[1]);
								$valCherche = $date[2]."/".$date[1]."/".$date[0];
								$recherche .= " ".$colValeur." < str_to_date('".$valCherche."','%d/%m/%Y')";
							}
							return $recherche;
							break;
						default:
							break;
					}
				}
		}
	}
	
	private function getListContentGenreNews(){			//retourne les données contenues dans la base concernant les genres de news uniquement
		$ordre = '';
		if(Tools::isSubmit('ronchhon_module_newsOrderby') && Tools::isSubmit('ronchhon_module_newsOrderway') && substr(Tools::getValue('ronchhon_module_newsOrderby'),0,1) == 'g'){
			$ordre = ' order by '.Tools::getValue('ronchhon_module_newsOrderby').' '.Tools::getValue('ronchhon_module_newsOrderway');
		}
		$retour_total=$this->bdd->query('SELECT genre_news_id, genre_news_libelle FROM ron_genre_news'.$ordre);
		$content=$retour_total->fetchAll(PDO::FETCH_ASSOC);
		return $content;
	}
	
	public function soumissionFormulaireNews($operation){
		
		$news_id = strval(Tools::getValue('news_id'));
		$new_titre = strval(Tools::getValue('news_titre'));
		$new_contenu = strval(Tools::getValue('news_contenu'));
		$new_datep = strval(Tools::getValue('news_date_p'));
		$new_genre = strval(Tools::getValue('news_genre'));
		$new_datem = date('Y-m-d',time());
		
		if(empty($new_titre) || empty($new_contenu) || empty($new_datep) || empty($news_id)){
			$messageErreur = "Veuillez remplir tout les champs obligatoires.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&news&configure='.$this->name.'&news_id='.$news_id.'&'.$operation.$this->name.'&error='.$messageErreur.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		
		if($operation == 'update'){
			$req1 = $this->bdd->query('select news_date_p as Date from ron_news where news_id = '.$news_id);
			$datePublicationBase = $req1->fetch(PDO::FETCH_ASSOC);
			$datePublicationBase = $datePublicationBase['Date'];

			if($new_datem > $new_datep && $datePublicationBase != $new_datep){
				$messageErreur = "La date de publication ne peut être inférieure à la date actuelle.";
				Tools::redirectAdmin(AdminController::$currentIndex.'&news&configure='.$this->name.'&news_id='.$news_id.'&'.$operation.$this->name.'&error='.$messageErreur.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
			else{
				$chg=$this->bdd->prepare('update ron_news set news_titre = :titre, news_contenu = :contenu, news_date_p = :date_p, news_date_m = :date_m, genre_news_id = :genre where news_id = '.$news_id);
				$chg->execute(array(
					':titre' => $new_titre,
					':contenu' => $new_contenu,
					':date_p' => $new_datep,
					':date_m' => $new_datem,
					':genre' => $new_genre
				));
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
		}
		else if($operation == 'ajouter'){

			if($new_datem > $new_datep){
				$messageErreur = "Message d'erreur";
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&'.$operation.$this->name.'&news&error='.$messageErreur.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
			else{
				$chg=$this->bdd->prepare('insert into ron_news (news_id, news_titre, news_contenu, news_date_p, news_date_m, genre_news_id) values (:id, :titre, :contenu, :date_p, :date_m, :genre)');
				$chg->execute(array(
					':id' => $news_id,
					':titre' => $new_titre,
					':contenu' => $new_contenu,
					':date_p' => $new_datep,
					':date_m' => $new_datem,
					':genre' => $new_genre
				));
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
		}
		else{
			$messageErreur = "Une erreur inconnue est survenue.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&news&configure='.$this->name.'&news_id='.$news_id.'&'.$operation.$this->name.'&error='.$messageErreur.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
	}
	
	public function soumissionFormulaireGenreNews($operation){
		
		$genre_news_id = strval(Tools::getValue('genre_news_id'));
		$genre_news_libelle = strval(Tools::getValue('genre_news_libelle'));
		
		if((empty($genre_news_id) && $genre_news_id != 0) || empty($genre_news_libelle)){
			$messageErreur = "Veuillez remplir tout les champs obligatoires.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&genre_news_id='.$genre_news_id.'&'.$operation.$this->name.'&error='.$messageErreur.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		
		if($operation == 'update'){
			$chg=$this->bdd->prepare('update ron_genre_news set genre_news_libelle = :libelle where genre_news_id = '.$genre_news_id);
			$chg->execute(array(
				':libelle' => $genre_news_libelle
			));
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else if($operation == 'ajouter'){
			
			$chg=$this->bdd->prepare('insert into ron_genre_news (genre_news_id, genre_news_libelle) values (:id, :libelle)');
			$chg->execute(array(
				':id' => $genre_news_id,
				':libelle' => $genre_news_libelle,
			));
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else{
			$messageErreur = "Une erreur inconnue est survenue.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&genre_news_id='.$genre_news_id.'&'.$operation.$this->name.'&error='.$messageErreur.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
	}
	
	
	public function getContent(){
		$output = null;
		
		if(Tools::isSubmit('submitReset'.$this->name)){
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		
		if (Tools::isSubmit('submit'.$this->name) && Tools::isSubmit('update'.$this->name) && Tools::isSubmit('news_id')){
			
			$this->soumissionFormulaireNews('update');
		
		}
		else if(Tools::isSubmit('submit'.$this->name) && Tools::isSubmit('ajouter'.$this->name) && Tools::isSubmit('news_id')){
		
			$this->soumissionFormulaireNews('ajouter');
		
		}
		else if (Tools::isSubmit('delete'.$this->name) && Tools::isSubmit('news_id')){
		
			$chg=$this->bdd->prepare('delete from ron_news where news_id = '.Tools::getValue('news_id'));
			$chg->execute();
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		
		}
		else if (Tools::isSubmit('submit'.$this->name) && Tools::isSubmit('update'.$this->name) && Tools::isSubmit('genre_news_id')){
		
			$this->soumissionFormulaireGenreNews('update');
		
		}
		else if(Tools::isSubmit('submit'.$this->name) && Tools::isSubmit('ajouter'.$this->name) && Tools::isSubmit('genre_news_id')){
		
			$this->soumissionFormulaireGenreNews('ajouter');
		
		}
		else if (Tools::isSubmit('delete'.$this->name) && Tools::isSubmit('genre_news_id')){
		
			$chg=$this->bdd->prepare('delete from ron_genre_news where genre_news_id = '.Tools::getValue('genre_news_id'));
			$chg->execute();
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		
		}
		if (Tools::isSubmit('submit'.$this->name)){
			$my_module_name = strval(Tools::getValue('news_id'));
			if (!$my_module_name
			  || empty($my_module_name)
			  || !Validate::isGenericName($my_module_name))
				$output .= $this->displayError($this->l('Invalid Configuration value'));
			else
			{
				Configuration::updateValue('ronchhon_module_news', $my_module_name);
				$output .= $this->displayConfirmation($this->l('Settings updated'));
			}
		}
		if(Tools::isSubmit('ajouter'.$this->name) || Tools::isSubmit('update'.$this->name)){
			if(Tools::isSubmit('error')){
				$output.= $this->displayError($this->l(Tools::getValue('error')));
			}
			if(Tools::isSubmit('news_id') || Tools::isSubmit('news')){
				return $output.$this->displayForm();
			}
			else{ return $output.$this->displayFormGenreNews();}
		}
		else{
			if(Tools::isSubmit('error')){
				$output.= $this->displayError($this->l(Tools::getValue('error')));
			}
			return $output.$this->initList().$output.$this->listeGenreNews();
		}
	}
	
	private function initList(){
	
	//Listage des champs présents dans la liste. Une ligne de la liste sera rempli par les valeurs d'une news, valeurs extraites de la base
    $this->fields_list = array(
        'news_id' => array(
            'title' => 'Numéro de la news',
            'width' => 'auto',
            'type' => 'text',
        ),
        'news_titre' => array(
            'title' => 'Titre',
            'width' => 'auto',
            'type' => 'text',
        ),
		'news_contenu' => array(
            'title' => 'Contenu',
            'width' => 'auto',
            'type' => 'text',
			'search' => false,
        ),
		'news_date_p' => array(
            'title' => 'Date de publication',
            'width' => 'auto',
            'type' => 'date',
        ),
		'news_date_m' => array(
            'title' => 'Date de dernière modification',
            'width' => 'auto',
            'type' => 'date',
        )
    );
    $helper = new HelperList();
     
    $helper->shopLinkType = '';
     
    $helper->simple_header = false;
     
    // Actions to be displayed in the "Actions" column
    $helper->actions = array('edit', 'delete');
    $helper->identifier = 'news_id';
    $helper->show_toolbar = true;
    $helper->title = 'Liste des news';
    $helper->table = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
	$helper->toolbar_btn['new'] = array(
		'href' => $helper->currentIndex.'&news&ajouter'.$this->name.'&token='.$helper->token,
		'desc' => 'Ajouter'
	);
		
	$contenuListe = $this->getListContentNews();
	$helper->listTotal = count($contenuListe);
    return $helper->generateList($contenuListe,$this->fields_list);
}
	
	private function listeGenreNews(){
	
	//Listage des champs présents dans la liste. Une ligne de la liste sera rempli par les valeurs d'une news, valeurs extraites de la base
    $this->fields_list = array(
        'genre_news_id' => array(
            'title' => 'Identifiant',
            'width' => 'auto',
            'type' => 'text',
        ),
        'genre_news_libelle' => array(
            'title' => 'Libellé du genre',
            'width' => 'auto',
            'type' => 'text',
        )
    );
    $helper = new HelperList();
     
    $helper->shopLinkType = '';
     
    $helper->simple_header = false;
     
    // Actions to be displayed in the "Actions" column
    $helper->actions = array('edit', 'delete');
    $helper->identifier = 'genre_news_id';
    $helper->show_toolbar = true;
    $helper->title = 'Liste des genre de news';
    $helper->table = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
	$helper->toolbar_btn['new'] = array(
		'href' => $helper->currentIndex.'&ajouter'.$this->name.'&token='.$helper->token,
		'desc' => 'Ajouter'
	);
		
	$contenuListe = $this->getListContentGenreNews();
	$helper->listTotal = count($contenuListe);
    return $helper->generateList($contenuListe,$this->fields_list);
}
	
	public function displayForm(){
		// Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
		if(Tools::isSubmit('error')){
			$typeErreur = Tools::getValue('error');
		}
		
		// Init Fields form array
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => 'Informations News',
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => 'Numéro du billet',
					'name' => 'news_id',
					'readonly' => true,
					'size' => 20,
				),
				array(
					'type' => 'text',
					'label' => 'Titre',
					'name' => 'news_titre',
					'required' => true,
				),
				array(
					'type' => 'textarea',
					'label' => 'Contenu',
					'name' => 'news_contenu',
					'class' => 'rte',
					'autoload_rte' => true,
					'required' => true,
				),
				array(
					'type' => 'date',
					'label' => 'Date de publication',
					'name' => 'news_date_p',
					'required' => true,
				),
				array(
					'type' => 'select',
					'label' => 'Genre de la news',
					'name' => 'news_genre',
					'options' => array(
						'query' => array(),
						'id' => 'id_option',
						'name' => 'name' 
	               )
				),
				array(
					'type' => 'hidden',
					'name' => 'news_date_m',
	               )
				),
			'submit' => array(
				'title' => 'Enregistrer',
				'class' => 'btn btn-default pull-right'
			)
		);
		
		$contenuListeGenre = $this->getListContentGenreNews();
		
		$helper = new HelperForm();

		// Module, token and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		
		// Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;

		// Title and toolbar
		$helper->title = $this->displayName;
		$helper->show_toolbar = true;        // false -> remove toolbar
		$helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
		$helper->submit_action = 'submit'.$this->name;
		
		if(Tools::isSubmit('ajouter'.$this->name)){
			
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&ajouter".$this->name;
			
			$max = $this->getIdNouvelleNews();
			$helper->fields_value['news_id'] = $max;
			for($i = 0; $i < count($contenuListeGenre);$i++){
				$optionSupp = array(
					'id_option' => $contenuListeGenre[$i]['genre_news_id'],
					'name' => $contenuListeGenre[$i]['genre_news_libelle']
				);
			array_push($fields_form[0]['form']['input'][4]['options']['query'],$optionSupp);
			}
		}
		else{
			
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&update".$this->name;
			
			$helper->fields_value = $this->getFormValues();
			
			for($i = 0; $i < count($contenuListeGenre);$i++){
				$optionSupp = array(
					'id_option' => $contenuListeGenre[$i]['genre_news_id'],
					'name' => $contenuListeGenre[$i]['genre_news_libelle'],
				);
				if($helper->fields_value['genre_news_id'] == $contenuListeGenre[$i]['genre_news_id']){
					$optionSupp['id_option'] = $contenuListeGenre[$i]['genre_news_id']."\" selected=\"true";
				}
				array_push($fields_form[0]['form']['input'][4]['options']['query'],$optionSupp);
			}
		}
		return $helper->generateForm($fields_form);
	}
	
	public function displayFormGenreNews(){
		// Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
		if(Tools::isSubmit('error')){
			$typeErreur = Tools::getValue('error');
		}
		
		// Init Fields form array
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => 'Informations Genre News',
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => 'Id du nouveau genre',
					'name' => 'genre_news_id',
					'readonly' => true,
					'size' => 20,
				),
				array(
					'type' => 'text',
					'label' => 'Libellé du genre',
					'name' => 'genre_news_libelle',
					'required' => true,
				),
			),
			'submit' => array(
				'title' => 'Enregistrer',
				'class' => 'btn btn-default pull-right'
				)
		);
		
		$contenuListeGenre = $this->getListContentGenreNews();
		
		$helper = new HelperForm();

		// Module, token and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		
		// Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;

		// Title and toolbar
		$helper->title = $this->displayName;
		$helper->show_toolbar = true;        // false -> remove toolbar
		$helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
		$helper->submit_action = 'submit'.$this->name;
		
		if(Tools::isSubmit('ajouter'.$this->name)){
			
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&ajouter".$this->name;
			
			$max = $this->getIdNouveauGenreNews();
			$helper->fields_value['genre_news_id'] = $max;
		}
		else{
			
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&update".$this->name;
			
			$helper->fields_value = $this->getFormValuesGenre();
		}
		
		return $helper->generateForm($fields_form);
	}
	
	public function getFormValues(){
		$id_info = (int)Tools::getValue('ronchhon_module_news');
		$retour_total=$this->bdd->query('SELECT news_id, news_titre, news_contenu, news_date_p, news_date_m, genre_news_id FROM ron_news where news_id = '.Tools::getValue('news_id'));
		$content=$retour_total->fetchAll(PDO::FETCH_ASSOC);
		return $content[0];
	}
	
	public function getFormValuesGenre(){
		$id_info = (int)Tools::getValue('ronchhon_module_news');
		$retour_total=$this->bdd->query('SELECT genre_news_id, genre_news_libelle FROM ron_genre_news where genre_news_id = '.Tools::getValue('genre_news_id'));
		$content=$retour_total->fetchAll(PDO::FETCH_ASSOC);
		return $content[0];
	}
	
	public function hookDisplayHome($params)
	{

		if (!$this->isCached('ronchhon_module_news.tpl', $this->getCacheId()))
	{	
		global $smarty;
		$smarty->assign(array(
			'ronchhon_module_news' => Configuration::get('ronchhon_module_news')
		));
			
			
			$anneeA = date('Y',time());
			$moisM = date('m',time());
			$jourJ = date('d',time());
$query = $this->bdd->prepare("SELECT * FROM ron_news join ron_genre_news using(genre_news_id) ORDER BY news_date_p DESC");
$query->execute();
$list_news = array();
$i = 0;
while($data = $query->fetch()){
	if($i < 5){
		$date = explode('-',$data['NEWS_DATE_P']);
		if($anneeA == $date[0]){
			if($moisM == $date[1]){
				if($jourJ < $date[2]){
				}
				else{
					$list_news[$i]['id'] = $data['NEWS_ID'];
			$list_news[$i]['genre'] = $data['GENRE_NEWS_LIBELLE'];
			$list_news[$i]['titre'] = $data['NEWS_TITRE'];
			$list_news[$i]['contenu'] = $data['NEWS_CONTENU'];
			$list_news[$i]['date'] = $data['NEWS_DATE_P'];
			$i++;
				}
			}
			else if($moisM < $date[1]){

			}
			else{
				$list_news[$i]['id'] = $data['NEWS_ID'];
			$list_news[$i]['genre'] = $data['GENRE_NEWS_LIBELLE'];
			$list_news[$i]['titre'] = $data['NEWS_TITRE'];
			$list_news[$i]['contenu'] = $data['NEWS_CONTENU'];
			$list_news[$i]['date'] = $data['NEWS_DATE_P'];
			$i++;
			}
		}
		else if($anneeA < $date[0]){

		}
		else{
			$list_news[$i]['id'] = $data['NEWS_ID'];
			$list_news[$i]['genre'] = $data['GENRE_NEWS_LIBELLE'];
			$list_news[$i]['titre'] = $data['NEWS_TITRE'];
			$list_news[$i]['contenu'] = $data['NEWS_CONTENU'];
			$list_news[$i]['date'] = $data['NEWS_DATE_P'];
			$i++;
		}
	}
}
//lancement de smmarty
$smarty->assign('list_news', $list_news);
			}
return $this->display(__FILE__, 'ronchhon_module_news.tpl', $this->getCacheId());
	}
	
	public function hookDisplayTop($params)
    {
		return $this->hookDisplayHome($params);
    }
	
	public function hookDisplayArchive($params)
    {
		if(Tools::getValue('id_cms') == 6){
					if (!$this->isCached('ronchhon_module_news.tpl', $this->getCacheId()))
	{	
		global $smarty;
		$smarty->assign(array(
			'ronchhon_module_news' => Configuration::get('ronchhon_module_news')
		));
			
			
$query = $this->bdd->prepare("SELECT * FROM ron_news join ron_genre_news using(genre_news_id) ORDER BY news_date_p DESC");
$query->execute();

$list_news = array();
$anneeA = date('Y',time());
			$moisM = date('m',time());
			$jourJ = date('d',time());
while($data = $query->fetch()){
		$date = explode('-',$data['NEWS_DATE_P']);
		if($anneeA == $date[0]){
			if($moisM == $date[1]){
				if($jourJ < $date[2]){
				}
				else{
			$list_news[$i]['id'] = $data['NEWS_ID'];
			$list_news[$i]['genre'] = $data['GENRE_NEWS_LIBELLE'];
			$list_news[$i]['titre'] = $data['NEWS_TITRE'];
			$list_news[$i]['contenu'] = $data['NEWS_CONTENU'];
			$list_news[$i]['date'] = $data['NEWS_DATE_P'];
			$i++;
				}
			}
			else if($moisM < $date[1]){

			}
			else{
				$list_news[$i]['id'] = $data['NEWS_ID'];
			$list_news[$i]['genre'] = $data['GENRE_NEWS_LIBELLE'];
			$list_news[$i]['titre'] = $data['NEWS_TITRE'];
			$list_news[$i]['contenu'] = $data['NEWS_CONTENU'];
			$list_news[$i]['date'] = $data['NEWS_DATE_P'];
			$i++;
			}
		}
		else if($anneeA < $date[0]){

		}
		else{
			$list_news[$i]['id'] = $data['NEWS_ID'];
			$list_news[$i]['genre'] = $data['GENRE_NEWS_LIBELLE'];
			$list_news[$i]['titre'] = $data['NEWS_TITRE'];
			$list_news[$i]['contenu'] = $data['NEWS_CONTENU'];
			$list_news[$i]['date'] = $data['NEWS_DATE_P'];
			$i++;
		}
}
//lancement de smmarty

$smarty->assign('list_news', $list_news);
			}
return $this->display(__FILE__, 'ronchhon_module_news.tpl', $this->getCacheId());
		}
    }
}


?>