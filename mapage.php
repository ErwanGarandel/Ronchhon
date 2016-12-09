<?php
include(dirname(__FILE__).'/config/config.inc.php');
if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
        $rewrited_url = __PS_BASE_URI__;
include(dirname(__FILE__).'/header.php');

global $cookie; 
$client=1;

if(empty($client))

{header('Location:index.php');}

$adresse=Db::getInstance()->ExecuteS('select * from '._DB_PREFIX_.'address where id_customer='.$client);

	echo "<form method=\"post\" action=\"commentaires.php\">

		<h1>Mon super blog</h1>
		

		</br><a href=\"http://localhost/openclassroom/bdd/admin/ajouter.php\">Ajouter un article</a></br>
		Derniers articles :
		<!--<label for=\"pseudo\">Pseudo</label> : <input type=\"text\" name=\"pseudo\"/><br/>
		<br/>
		<label for=\"message\">Laisser un commentaire</label> : <textarea name=\"message\" id=\"message\" rows=\"5\" cols=\"25\">

			
		</textarea><br/>
		<br/>
		<input type=\"submit\" value=\"Envoyer\" /> 	
<input type=\"button\" value=\"Rafraichir\" id=\"refresh\" />-->


	</form>";
try
{

$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'hugo', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Numérotation des pages

$messagesParPage=5; //Nous allons afficher 5 messages par page.
 
//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total=$bdd->query('SELECT COUNT(*) AS total FROM billets'); //Nous récupérons le contenu de la requête dans $retour_total             
$donnees=$retour_total->fetch(); //On range retour sous la forme d'un tableau.
$total=$donnees['total']; //On récupère le total pour le placer dans la variable $total.
 
//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);
 
if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);
 
     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     {
          $pageActuelle=$nombreDePages;
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1    
}
 
$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
 
// La requête sql pour récupérer les messages de la page actuelle.
$retour_messages=$bdd->query('SELECT id_billet,titre, contenu, date_format(date_création, \'%d/%m/%y\') as date_création from billets order by date_création  LIMIT '.$premiereEntree.', '.$messagesParPage.''); 
 
while($donnees=$retour_messages->fetch()) // On lit les entrées une à une grâce à une boucle
{
echo "
<div class=\"news\">";
 		echo "<h3>".strip_tags($donnees['titre'])." <i>le </i>".strip_tags($donnees['date_création'])."</h3><p>".strip_tags($donnees['contenu']);
	echo "
    <br />
    <em><a href=\"commentaires.php?billet=".$donnees['id_billet'].">";
    echo "Commentaires</a></em>
    </p>
</div>";
}

echo "<p align=\"center\">Page : "; //Pour l'affichage, on centre la liste des pages
for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
{
     //On va faire notre condition
     if($i==$pageActuelle) //Si il s'agit de la page actuelle...
     {
         echo ' [ '.$i.' ] '; 
     }	
     else //Sinon...
     {
          echo "<a href=\"index.php?page=".$i.">".$i."</a>";
     }
}
echo '</p>';

$smarty->assign('adresses',$adresse);

$smarty->display(_PS_THEME_DIR_.'mapage.tpl');

include(dirname(__FILE__).'/footer.php');
?>