<?php

define('APP_BD_URL', 'localhost');
define('APP_BD_USER', 'lebon_u');
define('APP_BD_PASS', 'lebon_p');
define('APP_BD_NOM', 'lebon_cuiteur');


function jl_bd_connection() {
	$bd = mysqli_connect(APP_BD_URL, APP_BD_USER, APP_BD_PASS, APP_BD_NOM);
	if ($bd !== FALSE) {
		$GLOBALS['bd'] = $bd;
		return $GLOBALS['bd'];
	}

	$msg = '<h4>Erreur de connexion base MySQL</h4>'
			.'<div style="margin: 20px auto; width: 350px;">'
				.'APP_BD_URL : '.APP_BD_URL
				.'<br>APP_BD_USER : '.APP_BD_USER
				.'<br>APP_BD_PASS : '.APP_BD_PASS
				.'<br>APP_BD_NOM : '.APP_BD_NOM
				.'<p>Erreur MySQL num&eacute;ro : '.mysqli_connect_errno($bd)
				.'<br>'.mysqli_connect_error($bd)
			.'</div>';
	fd_bd_erreurExit($msg);
}

//___________________________________________________________________
/**
 * Gestion d'une erreur de requête base de données.
 *
 * @param resource	$bd		Connecteur sur la bd ouverte
 * @param string	$sql	requête SQL provoquant l'erreur
 */
function fd_bd_erreur($bd, $sql) {
	$errNum = mysqli_errno($bd);
	$errTxt = mysqli_error($bd);

	// Collecte des informations facilitant le debugage
	$msg = '<h4>Erreur de requête</h4>'
			."<pre><b>Erreur mysql :</b> $errNum"
			."<br> $errTxt"
			."<br><br><b>Requête :</b><br> $sql"
			.'<br><br><b>Pile des appels de fonction</b>';

	// Récupération de la pile des appels de fonction
	$msg .= '<table border="1" cellspacing="0" cellpadding="2">'
			.'<tr><td>Fonction</td><td>Appelée ligne</td>'
			.'<td>Fichier</td></tr>';

	$appels = debug_backtrace();
	for ($i = 0, $iMax = count($appels); $i < $iMax; $i++) {
		$msg .= '<tr align="center"><td>'
				.$appels[$i]['function'].'</td><td>'
				.$appels[$i]['line'].'</td><td>'
				.$appels[$i]['file'].'</td></tr>';
	}

	$msg .= '</table></pre>';

	fd_bd_erreurExit($msg);
}			
//___________________________________________________________________
/**
 * Arrêt du script si erreur base de données.
 * Affichage d'un message d'erreur si on est en phase de
 * développement, sinon stockage dans un fichier log.
 *
 * @param string	$msg	Message affiché ou stocké.
 */
function fd_bd_erreurExit($msg) {
	ob_end_clean();		// Supression de tout ce qui
					// a pu être déja généré

	echo '<!DOCTYPE html><html><head><meta charset="ISO-8859-1"><title>',
			'Erreur base de données</title></head><body>',
			$msg,
			'</body></html>';
	exit();
}

//____________________________________________________________________________

/**
 * Génération du code html de création d'une ligne d'un tableau utilisé pour un formulaire, contenant 2 colonnes (gauche et droite)
 * 
 * @param string   $gauche	Contenu de la colonne de gauche
 * @param string   $droite	Contenu de la colonne de droite
 * @return string			Code html de création d'une ligne contenant les deux colonnes
 */
function jl_form_ligne($gauche, $droite) {
	return ('<tr><td>'. $gauche. '</td><td>'. $droite. '</td></tr>');
}

/**
 * Génération du code html d'une zone de saisie (type text, password ou submit)
 * 
 * @param string   $type	Type de la zone
 * @param string   $name	Nom de la zone
 * @param string   $value	Valeur par défaut de la zone
 * @param int      $size	Taille de la zone (defaut = 0)
 * @return string			Code html de création de la zone de saisie
 */
function jl_form_input($type, $name, $value, $size = 0) {
	return ('<input type="'.$type.'" name="'.$name.'" size="'.$size.'" value="'.$value.'">');
}

//___________________________________________________________________
/**
 * 	Générer le code HTML pour les listes déroulantes date
 *  @param  $name 	Nom de la zone
 *  @param  $jour 	Jour pré-sélectionné
 *  @param  $mois 	Mois pré-sélectionné
 *  @param  $annee 	Année pré-sélectionnée
 *	@return $html 	code html généré
 */
 /*
function jl_form_date($name, $jour, $mois, $annee)
{
	//Cas où les valeurs jour/mois/année sont égales à 0
	//Jour
	if ($jour==0) {
		$jour=date("d");
	}
	//Mois
	if ($mois==0) {
		$mois=date("m");
	}
	//Année
	if ($annee==0) {
		$annee=date("Y");
	}

	//Nom des jours/mois/année
	$nameJ=$name."_j";
	$nameM=$name."_m";
	$nameA=$name."_a";

	//Creation du code html
	$html='<select name="'.$nameJ.'" value="'.$jour.'">';
	for ($i=1; $i <10 ; $i++) { 
		$html=$html.'<option value="0'.$i.'">'.$i.'</option>';
	}
	for ($i=10; $i <32 ; $i++) { 
		$html=$html.'<option value="'.$i.'">'.$i.'</option>';
	}
	$html=$html.'</select><select name="'.$nameM.'" value="'.$mois.'">';
	for ($i=1; $i <10 ; $i++) { 
		$html=$html.'<option value="0'.$i.'">'.$i.'</option>';
	}
	for ($i=10; $i <13 ; $i++) { 
		$html=$html.'<option value="'.$i.'">'.$i.'</option>';
	}
	$html=$html.'</select><select name="'.$nameA .'" value="'.$annee.'">';
	for ($i=date("Y"); $i >98 ; $i--) { 
		$html=$html.'<option value="'.$i.'">'.$i.'</option>';
	}
	$html=$html.'</select>';
	return $html;
}
*/
?>