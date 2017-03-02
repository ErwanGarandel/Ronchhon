<?php
if (!defined('_PS_VERSION_'))
	exit;

class ronchhon_module_galerie extends Module
{
public function __construct()
	{
		$this->name = 'ronchhon_module_galerie';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'GroupeProjetRonchhon';
		$this->need_instance = 0;
		$this->bootstrap = true;
		$this->bdd = $this->connexionBase();
		parent::__construct();
		
		$this->displayName = 'Ronchhon Galerie';
		$this->description = 'Galerie pour l\'artiste Ronchhon';
	}

	public function install(){

		$this->_clearCache('ronchhon_module_galerie.tpl');
		
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
			$parent_id = $parent_tab->id;
		}
		else{
			$parent_id = $moduleRonchhonInstaller;
		}
		$tab = new Tab();
		// Need a foreach for the language
		$tab->name[$this->context->language->id] = $this->l('Galerie');
		$tab->class_name = 'AdminRonchhonGalerie';
		$tab->id_parent = $parent_id;
		$tab->module = $this->name;
		$tab->add();
		
		return (parent::install()
				&& Configuration::updateValue('ronchhon_module_galerie', '')
				//&& $this->registerHook('displayHome')
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
			$bdd = new PDO('mysql:host=localhost;dbname=ronchhon;charset=utf8', 'root', 'vs4d8tm5', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e){
			die('Erreur : '.$e->getMessage());
		}
		return $bdd;
	}
	
	private function uploadImage($id){
		$gal_image = $_FILES['gal_image'];
		
		if(!file_exists("../ronchhon")){
			$bool = mkdir("../ronchhon");
			if($bool == false){
				$messageErreur = "Erreur lors de la création des dossiers.";
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
			}
		}
		if(!file_exists("../ronchhon/galerie")){
			$bool = mkdir("../ronchhon/galerie");
			if($bool == false){
				$messageErreur = "Erreur lors de la création des dossiers.";
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
			}
		}
		$target_dir = "../ronchhon/galerie/";
		$target_file = $target_dir . basename($gal_image['name']);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$target_file = $target_dir . 'img'.$id.'.'.$imageFileType;
		// Check if image file is a actual image or fake image
		$check = getimagesize($gal_image['tmp_name']);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
			$this->retirerImage($id);
			if (move_uploaded_file($gal_image['tmp_name'], $target_file)) {
				$this->retirerMiniature($id);
				$this->resize($imageFileType,$target_file,$id);
			} else {
				$messageErreur = "Erreur lors de l'upload de l'image.";
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
			}
		} else {
			$messageErreur = "Erreur, le fichier sélectionné n'est pas une image.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
			$uploadOk = 0;
		}
		return $imageFileType;
	}
	
	private function resizeJpg($nomImage, $id){
	$source = imagecreatefromjpeg($nomImage); // La photo est la source
	$destination = imagecreatetruecolor(200, 150); // On crée la miniature vide

	// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);

	// On crée la miniature
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

	// On enregistre la miniature sous le nom "mini_<nom>.jpg"
	imagejpeg($destination, "../ronchhon/galerie/mini".$id.".jpg");

}

private function resizeGif($nomImage, $id){
	$source = imagecreatefromgif($nomImage); // La photo est la source
	$destination = imagecreatetruecolor(200, 150); // On crée la miniature vide

	// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);

	// On crée la miniature
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

	// On enregistre la miniature sous le nom "mini_<nom>.jpg"
	imagegif($destination, "../ronchhon/galerie/mini".$id.".gif");

}

private function resizePng($nomImage, $id){
	$source = imagecreatefrompng($nomImage); // La photo est la source
	$destination = imagecreatetruecolor(200, 150); // On crée la miniature vide

	// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);

	// On crée la miniature
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

	// On enregistre la miniature sous le nom "mini_<nom>.jpg"
	imagepng($destination, "../ronchhon/galerie/mini".$id.".png");

}
	
private function resize($extension,$nomImage,$id){

	switch ($extension) {
    case 'jpg':
        $this->resizeJpg($nomImage, $id);
        break;
    case 'png':
       	$this->resizePng($nomImage, $id);
        break;
    case 'gif':
        $this->resizeGif($nomImage, $id);
        break;
    default:
       $messageErreur = "Extension non acceptée.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
	}
}

	
	private function retirerImage($id){
		$target_file = "../ronchhon/galerie/img".$id;
		if(file_exists($target_file.".png")) unlink($target_file.".png");
		if(file_exists($target_file.".jpg")) unlink($target_file.".jpg");
		if(file_exists($target_file.".gif")) unlink($target_file.".gif");
	}
	
	private function retirerMiniature($id){
		$target_file = "../ronchhon/galerie/mini".$id;
		if(file_exists($target_file.".png")) unlink($target_file.".png");
		if(file_exists($target_file.".jpg")) unlink($target_file.".jpg");
		if(file_exists($target_file.".gif")) unlink($target_file.".gif");
	}
	
	private function imageExiste($id){
		$resRequete = $this->bdd->query('SELECT count(gal_id) as MAX FROM ron_galerie where gal_id = '.$id);
		$existe = $resRequete->fetch(PDO::FETCH_ASSOC);
		if($existe["MAX"] == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	private function liensNavigation($id){
		return "<div style=\"text-align:center;width:80%;margin:auto;\" id=\"".$id."\">
		<a style=\"display:inline-block;width:50%\" href=\"#genreOeuvre\">Genre Oeuvre</a><a style=\"display:inline-block;width:50%\" href=\"#oeuvre\">Liste des Oeuvres</a></div>";
	}
	
	private function soumissionFormulaireGenreOeuvre($operation){
		
		$genre_oeuvre_id = strval(Tools::getValue('genre_oeuvre_id'));
		$genre_oeuvre_libelle = strval(Tools::getValue('genre_oeuvre_libelle'));
		
		if(empty($genre_oeuvre_id) || empty($genre_oeuvre_libelle)){
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else{
			if($operation == 'update'){
				$chg=$this->bdd->prepare('update ron_genre_oeuvre set genre_oeuvre_libelle = :libelle where genre_oeuvre_id = '.$genre_oeuvre_id);
				$chg->execute(array(
					':libelle' => $genre_oeuvre_libelle
				));
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
			else if($operation == 'ajouter'){
				$max = $this->getIdGenreOeuvre();
				if($max != $genre_oeuvre_id){
					Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
				}
				else{
					$chg=$this->bdd->prepare('Insert into ron_genre_oeuvre (genre_oeuvre_id, genre_oeuvre_libelle) values (:id, :libelle)');
					$chg->execute(array(
					':id' => $genre_oeuvre_id,
					':libelle' => $genre_oeuvre_libelle,
					));
					Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
				}
			}
			else{
				$messageErreur = "Une erreur inconnue est survenue.";
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&genreOeuvre&'.$operation.'&genre_news_id='.$genre_news_id.'&error='.$messageErreur);
			}
		}
	}
	
	private function soumissionFormulaireGalerie($operation){
		
		$gal_id = strval(Tools::getValue('gal_id'));
		$gal_nom = strval(Tools::getValue('gal_nom'));
		$gal_description = strval(Tools::getValue('gal_description'));
		$gal_date_r = strval(Tools::getValue('gal_date_r'));
		$genre_oeuvre_id = strval(Tools::getValue('gal_genre'));
		$gal_image = $_FILES['gal_image'];
		
		if(empty($gal_date_r)){$gal_date_r = null;}
		if(empty($gal_description)){$gal_description = null;}
		
		if(empty($gal_id) || empty($genre_oeuvre_id) || empty($gal_nom)){
			$messageErreur = "Veuillez remplir tout les champs obligatoires.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
		}
		else if($gal_date_r > date('Y-m-d',time())){
			$messageErreur = "La date de réalisation ne peut être supérieure à la date actuelle.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
		}
		else if($gal_image['error'] != 0 && !$this->imageExiste($gal_id)){
			$messageErreur = "Une erreur est survenue lors de l'envoi de l'image.";
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
		}
		else{
			if($operation == 'update'){
				if($gal_image['error'] == 0){
					$imageFileType = $this->uploadImage($gal_id);
					$chg=$this->bdd->prepare('update ron_galerie set gal_nom = :nom, gal_description = :description, gal_date_r = :date_r, genre_oeuvre_id = :genre, gal_format = :format where gal_id = '.$gal_id);
					$chg->execute(array(
						':nom' => $gal_nom,
						':description' => $gal_description,
						':date_r' => $gal_date_r,
						':genre' => $genre_oeuvre_id,
						':format' => $imageFileType,
					));
					Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
				}
				else{
					$chg=$this->bdd->prepare('update ron_galerie set gal_nom = :nom, gal_description = :description, gal_date_r = :date_r, genre_oeuvre_id = :genre where gal_id = '.$gal_id);
					$chg->execute(array(
						':nom' => $gal_nom,
						':description' => $gal_description,
						':date_r' => $gal_date_r,
						':genre' => $genre_oeuvre_id,
					));
					Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
				}
			}
			else if($operation == 'ajouter'){
				$max = $this->getIdGalerie();
				if($max != $gal_id){
					$messageErreur = "Une erreur est survenue, veuillez réessayer.";
					Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&'.$operation.$this->name.'&gal_id='.$gal_id.'&error='.$messageErreur);
				}
				else{
					$imageFileType = $this->uploadImage($gal_id);
					$chg=$this->bdd->prepare('Insert into ron_galerie (gal_id, gal_nom, gal_description, gal_date_r, genre_oeuvre_id, gal_format) values (:id, :nom, :description, :date_r, :genre, :format)');
					$chg->execute(array(
						':id' => $gal_id,
						':nom' => $gal_nom,
						':description' => $gal_description,
						':date_r' => $gal_date_r,
						':genre' => $genre_oeuvre_id,
						':format' => $imageFileType,
					));
					Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
				}
			}
			else{
				$messageErreur = "Une erreur inconnue est survenue.";
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&galerie&'.$operation.'&gal_id='.$genre_news_id.'&error='.$messageErreur);
			}
		}
	}
	
	private function traitementRecherche($colonne, $valeur){
		if(preg_match("#^ronchhon_module_galerieFilter_g#",$colonne)){
				if(!empty($_POST[$colonne])){
					$colValeur = substr($colonne,30);
					switch($colValeur){
						case 'gal_id':
							$valCherche = htmlentities($valeur);
							$valCherche = str_replace('\'','\'\'',$valCherche);
							$recherche = " ".$colValeur."='".$valCherche."' ";
							return $recherche;
							break;
						case 'gal_nom':
							$valCherche = htmlentities($valeur);
							$valCherche = str_replace('\'','\'\'',$valCherche);
							$valCherche = strtoupper($valCherche);
							$recherche = " ".$colValeur." LIKE '%".$valCherche."%' ";
							return $recherche;
							break;
						case 'gal_date_r':
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
						case 'genre_oeuvre_libelle':
							$valCherche = htmlentities($valeur);
							$valCherche = str_replace('\'','\'\'',$valCherche);
							$valCherche = strtoupper($valCherche);
							$recherche = " ".$colValeur." LIKE '%".$valCherche."%' ";
							return $recherche;
							break;
						case 'gal_format':
							$valCherche = htmlentities($valeur);
							$valCherche = str_replace('\'','\'\'',$valCherche);
							$valCherche = strtoupper($valCherche);
							$recherche = " ".$colValeur." LIKE '%".$valCherche."%' ";
							return $recherche;
							break;
						default:
							break;
					}
				}
		}
	}
	
	public function getContent(){
		$output = null;
		
		if(Tools::isSubmit('error')){
			$output.= $this->displayError($this->l(Tools::getValue('error')));
		}
		
		if(Tools::isSubmit('submit'.$this->name)){
			if(Tools::isSubmit('genre_oeuvre_id')){
				if(Tools::isSubmit('ajouter'.$this->name)){
					$this->soumissionFormulaireGenreOeuvre('ajouter');
				}
				else if(Tools::isSubmit('update'.$this->name)){
					$this->soumissionFormulaireGenreOeuvre('update');
				}
			}
			else if(Tools::isSubmit('gal_id')){
				if(Tools::isSubmit('ajouter'.$this->name)){
					$this->soumissionFormulaireGalerie('ajouter');
				}
				else if(Tools::isSubmit('update'.$this->name)){
					$this->soumissionFormulaireGalerie('update');
				}
			}
		}
		
		if(Tools::isSubmit('ajouter'.$this->name) || Tools::isSubmit('update'.$this->name)){
			if(Tools::isSubmit('genreOeuvre') || Tools::isSubmit('genre_oeuvre_id')){
				return $output.$this->formulaireGenreOeuvre();
			}
			else if(Tools::isSubmit('galerie') || Tools::isSubmit('gal_id')){
				return $output.$this->formulaireGalerie();
			}
			else{
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
		}
		
		if(Tools::isSubmit('delete'.$this->name)){
			if(Tools::isSubmit('genre_oeuvre_id')){
				
				$chg=$this->bdd->prepare('update ron_galerie set genre_oeuvre_id = :genre where genre_oeuvre_id = '.Tools::getValue('genre_oeuvre_id'));
				$chg->execute(array(
					':genre' => 'null'
				));
				$chg=$this->bdd->prepare('delete from ron_genre_oeuvre where genre_oeuvre_id = '.Tools::getValue('genre_oeuvre_id'));
				$chg->execute();
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
			else if(Tools::isSubmit('gal_id')){
				$this->retirerImage(Tools::getValue('gal_id'));
				$this->retirerMiniature(Tools::getValue('gal_id'));
				$chg=$this->bdd->prepare('delete from ron_galerie where gal_id = '.Tools::getValue('gal_id'));
				$chg->execute();
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
			else{
				Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
			}
		}
		
		if(Tools::isSubmit('submitReset'.$this->name)){
			Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		
		return $this->liensNavigation("oeuvre").$output.$this->listeGalerie().$this->liensNavigation("genreOeuvre").$this->listeGenreOeuvre();
	}
	
	private function listeGalerie(){

	//Listage des champs présents dans la liste. Une ligne de la liste sera rempli par les valeurs d'une news, valeurs extraites de la base
    $this->fields_list = array(
        'gal_id' => array(
            'title' => 'Numéro de l\'Oeuvre',
            'width' => 'auto',
            'type' => 'text',
        ),
        'gal_nom' => array(
            'title' => 'Nom de l\'oeuvre',
            'width' => 'auto',
            'type' => 'text',
        ),
		'gal_description' => array(
            'title' => 'Description',
            'width' => 'auto',
            'type' => 'text',
			'search' => false,
        ),
		'gal_date_r' => array(
            'title' => 'Date de réalisation',
            'width' => 'auto',
            'type' => 'date',
        ),
		'genre_oeuvre_libelle' => array(
            'title' => 'Genre',
            'width' => 'auto',
            'type' => 'text',
        ),
		'gal_format' => array(
            'title' => 'Format',
            'width' => 'auto',
            'type' => 'text',
        ),
		'image' => array(
            'title' => $this->l('Photo'),
            'type' => 'bool',
        	'float' => true,
            'orderby' => false,
            'filter' => false,
            'search' => false
        ),
    );
    $helper = new HelperList();
     
    $helper->shopLinkType = '';
     
    $helper->simple_header = false;
     
    // Actions to be displayed in the "Actions" column
    $helper->actions = array('edit', 'delete');
    $helper->identifier = 'gal_id';
    $helper->show_toolbar = true;
    $helper->title = 'Liste des oeuvres de la galerie';
    $helper->table = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
	$helper->toolbar_btn['new'] = array(
		'href' => $helper->currentIndex.'&token='.$helper->token.'&galerie&ajouter'.$this->name,
		'desc' => 'Ajouter'
	);
	
	$contenuListe = $this->listeOeuvreGalerie();
	$helper->listTotal = count($contenuListe);
    return $helper->generateList($contenuListe,$this->fields_list);
}
	
	private function listeGenreOeuvre(){
	
	//Listage des champs présents dans la liste. Une ligne de la liste sera rempli par les valeurs d'une news, valeurs extraites de la base
    $this->fields_list = array(
        'genre_oeuvre_id' => array(
            'title' => 'Identifiant du genre',
            'width' => 'auto',
            'type' => 'text',
			'search' => false,
        ),
        'genre_oeuvre_libelle' => array(
            'title' => 'Libelle du genre',
            'width' => 'auto',
            'type' => 'text',
			'search' => false,
        )
    );
    $helper = new HelperList();
     
    $helper->shopLinkType = '';
     
    $helper->simple_header = false;
     
    // Actions to be displayed in the "Actions" column
    $helper->actions = array('edit', 'delete');
	
	
	
    $helper->identifier = 'genre_oeuvre_id';
    $helper->show_toolbar = true;
    $helper->title = 'Liste des genre d\'oeuvres de la galerie';
    $helper->table = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
	$helper->toolbar_btn['new'] = array(
		'href' => $helper->currentIndex.'&token='.$helper->token.'&genreOeuvre&ajouter'.$this->name,
		'desc' => 'Ajouter'
	);
	
	$contenuListe = $this->listeGenreOeuvreGalerie();
		
	$helper->listTotal = count($contenuListe);
    return $helper->generateList($contenuListe,$this->fields_list);
}
	
	public function listeOeuvreGalerie(){
		$ordre = ''; $recherche = ''; $conditions = false;
		if(Tools::isSubmit('ronchhon_module_galerieOrderby') && Tools::isSubmit('ronchhon_module_galerieOrderway')){
			$ordre = ' order by '.Tools::getValue('ronchhon_module_galerieOrderby').' '.Tools::getValue('ronchhon_module_galerieOrderway');
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
		$resRequete = $this->bdd->query('Select gal_id, genre_oeuvre_libelle, gal_nom, gal_description, gal_date_r, gal_format, CONCAT(\'<img src="../ronchhon/galerie/mini\',gal_id,\'.\',gal_format,\'">\') as \'image\' from ron_galerie left join ron_genre_oeuvre using(genre_oeuvre_id) '.$recherche.$ordre);
		$listeOeuvre = $resRequete->fetchAll();
		if(count($content) == 0){
			$retour_total=$this->bdd->query('SELECT news_id, news_titre, news_contenu, news_date_p, news_date_m FROM ron_news');
			$content=$retour_total->fetchAll();
			$this->displayError("Probleme");
		}
		return $listeOeuvre;
	}
	
	public function listeGenreOeuvreGalerie(){
		$resRequete = $this->bdd->query('Select genre_oeuvre_id, genre_oeuvre_libelle from ron_genre_oeuvre');
		$listeGenreOeuvre = $resRequete->fetchAll();
		return $listeGenreOeuvre;
	}
	
	public function formulaireGalerie(){
		// Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
		if(Tools::isSubmit('error')){
			$typeErreur = Tools::getValue('error');
		}
		
		// Init Fields form array
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => 'Informations Oeuvre',
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => 'Identifiant de l\'image',
					'name' => 'gal_id',
					'required' => true,
					'readonly' => true,
					'size' => 20,
				),
				array(
					'type' => 'text',
					'label' => 'Nom',
					'name' => 'gal_nom',
					'required' => true,
					'size' => 20,
				),
				array(
					'type' => 'textarea',
					'label' => 'Description de l\'image',
					'name' => 'gal_description',
				),
				array(
					'type' => 'date',
					'label' => 'Date de réalisation',
					'name' => 'gal_date_r',
					'size' => 20,
				),
				array(
					'type' => 'select',
					'label' => 'Genre de l\'oeuvre',
					'name' => 'gal_genre',
					'options' => array(
						'query' => array(),
						'id' => 'id_option',
						'name' => 'name' 
	               )
				),
				array(
					'type' => 'file',
					'required' => true,
					'label' => 'Fichier de l\'oeuvre',
					'name' => 'gal_image',
					'display_image' => true,
				),
		),
			'submit' => array(
				'title' => 'Enregistrer',
				'class' => 'btn btn-default pull-right'
			)
		);
		
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
		
		$contenuListeGenre = $this->listeGenreOeuvreGalerie();
		if(Tools::isSubmit('ajouter'.$this->name)){
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&token=".$helper->token."&ajouter".$this->name;
			$max = $this->getIdGalerie();
			$helper->fields_value['gal_id'] = $max;
			
			$optionSupp = array(
					'id_option' => 'null',
					'name' => 'Aucun'
				);
			array_push($fields_form[0]['form']['input'][4]['options']['query'],$optionSupp);
			
			for($i = 0; $i < count($contenuListeGenre);$i++){
				$optionSupp = array(
					'id_option' => $contenuListeGenre[$i]['genre_oeuvre_id'],
					'name' => $contenuListeGenre[$i]['genre_oeuvre_libelle']
				);
			array_push($fields_form[0]['form']['input'][4]['options']['query'],$optionSupp);
			}
			
		}
		else{
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&token=".$helper->token."&update".$this->name;
			$content = $this->getGalerieValues();
			$helper->fields_value = $content;
			$helper->fields_value['gal_genre'] = $content[0]['genre_oeuvre_id'];
			
			for($i = 0; $i < count($contenuListeGenre);$i++){
				$optionSupp = array(
					'id_option' => $contenuListeGenre[$i]['genre_oeuvre_id'],
					'name' => $contenuListeGenre[$i]['genre_oeuvre_libelle']
				);
			if($helper->fields_value['genre_oeuvre_id'] == $contenuListeGenre[$i]['genre_oeuvre_id']){
					$optionSupp['id_option'] = $contenuListeGenre[$i]['genre_oeuvre_id']."\" selected=\"true";
			}
			array_push($fields_form[0]['form']['input'][4]['options']['query'],$optionSupp);
			}
			
		}
		return $helper->generateForm($fields_form);
	}

	public function formulaireGenreOeuvre(){
		// Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
		if(Tools::isSubmit('error')){
			$typeErreur = Tools::getValue('error');
		}
		
		// Init Fields form array
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => 'Informations Genre d\'Oeuvre',
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => 'Identifiant du genre',
					'name' => 'genre_oeuvre_id',
					'readonly' => true,
					'size' => 20,
				),
				array(
					'type' => 'text',
					'label' => 'Libellé du genre',
					'name' => 'genre_oeuvre_libelle',
					'size' => 20,
				),
		),
			'submit' => array(
				'title' => 'Enregistrer',
				'class' => 'btn btn-default pull-right'
			)
		);
		
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
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&token=".$helper->token."&ajouter".$this->name;
			$max = $this->getIdGenreOeuvre();
			$helper->fields_value['genre_oeuvre_id'] = $max;
		}
		else{
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name."&token=".$helper->token."&update".$this->name;
			$helper->fields_value = $this->getGenreOeuvreValues();
		}
		
		return $helper->generateForm($fields_form);
		}

	private function getGenreOeuvreValues(){
		$resRequete = $this->bdd->query('SELECT genre_oeuvre_id, genre_oeuvre_libelle FROM ron_genre_oeuvre where genre_oeuvre_id = '.Tools::getValue('genre_oeuvre_id'));
		$content = $resRequete->fetchAll(PDO::FETCH_ASSOC);
		return $content[0];
	}
	
	private function getGalerieValues(){
		$resRequete = $this->bdd->query('SELECT gal_id, genre_oeuvre_id, gal_nom, gal_description, gal_date_r, gal_format FROM ron_galerie where gal_id = '.Tools::getValue('gal_id'));
		$content = $resRequete->fetchAll(PDO::FETCH_ASSOC);
		return $content[0];
	}
	
	private function getIdGalerie(){
		$resRequete = $this->bdd->query('Select max(gal_id) as MAX from ron_galerie');
		$max = $resRequete->fetch(PDO::FETCH_ASSOC);
		return $max['MAX']+1;
	}
	
		private function getIdGenreOeuvre(){
		$resRequete = $this->bdd->query('Select max(genre_oeuvre_id) as MAX from ron_genre_oeuvre');
		$max = $resRequete->fetch(PDO::FETCH_ASSOC);
		return $max['MAX']+1;
	}
	
	public function hookDisplayArchive($params)
    {
		if(Tools::getValue('id_cms') == 8){
					if (!$this->isCached('ronchhon_module_galerie.tpl', $this->getCacheId()))
	{	
		global $smarty;
		$smarty->assign(array(
			'ronchhon_module_galerie' => Configuration::get('ronchhon_module_galerie')
		));
		//lancement de smmarty
		
		$genre_oeuvres = $this->listeGenreOeuvreGalerie();
		
		$query = $this->bdd->prepare("SELECT * FROM ron_galerie left join ron_genre_oeuvre using(genre_oeuvre_id)");
		$query->execute();
		$list_oeuvre = array();
		$i = 0;
		
		while($data = $query->fetch()){
			if(Tools::isSubmit('genre')){
				if(Tools::getValue('genre') == $data['GENRE_OEUVRE_ID']){
					$list_oeuvre[$i]['id'] = $data['GAL_ID'];
					$list_oeuvre[$i]['nom'] = $data['GAL_NOM'];
					$list_oeuvre[$i]['desc'] = $data['GAL_DESCRIPTION'];
					$list_oeuvre[$i]['format'] = $data['GAL_FORMAT'];
					$list_oeuvre[$i]['libelle'] = $data['GENRE_OEUVRE_LIBELLE'];
					$i++;
				}
			}
			else{
				$list_oeuvre[$i]['id'] = $data['GAL_ID'];
				$list_oeuvre[$i]['nom'] = $data['GAL_NOM'];
				$list_oeuvre[$i]['desc'] = $data['GAL_DESCRIPTION'];
				$list_oeuvre[$i]['format'] = $data['GAL_FORMAT'];
				$list_oeuvre[$i]['libelle'] = $data['GENRE_OEUVRE_LIBELLE'];
				$i++;
			}
		}

		$smarty->assign('list_oeuvre', $list_oeuvre);
		$smarty->assign('genre_oeuvre', $genre_oeuvres);
					}
		return $this->display(__FILE__, 'ronchhon_module_galerie.tpl', $this->getCacheId());
				}
	}
	
	}
?>