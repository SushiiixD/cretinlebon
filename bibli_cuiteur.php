<?php
	
	define('SC_BD_URL', 'localhost');
	define('SC_BD_NOM', 'cretin_cuiteur');
	define('SC_BD_USER', 'cretin_u');
	define('SC_BD_PASS', 'cretin_p');

	//_______________________________________________________________
	/**
	* Connexion à la base de données.
	*
	* @return resource	connecteur à la base de données
	*/
	function sc_bd_connexion() {
		$bd = mysqli_connect(SC_BD_URL, SC_BD_USER, SC_BD_PASS, SC_BD_NOM);

		if ($bd !== FALSE) {
			return $bd;		// Sortie connexion OK
		}

		// Erreur de connexion
		// Collecte des informations facilitant le debugage
		$msg = '<h4>Erreur de connexion base MySQL</h4>'
				.'<div style="margin: 20px auto; width: 350px;">'
				.'BD_SERVEUR : '.SC_BD_URL
				.'<br>BD_USER : '.SC_BD_USER
				.'<br>BD_PASS : '.SC_BD_PASS
				.'<br>BD_NOM : '.SC_BD_NOM
				.'<p>Erreur MySQL num&eacute;ro : '.mysqli_connect_errno($bd)
				.'<br>'.mysqli_connect_error($bd)
				.'</div>';

		sc_bd_erreurExit($msg);
	}

	//___________________________________________________________________
	/**
	 * Arrêt du script si erreur base de données.
	 * Affichage d'un message d'erreur si on est en phase de
	 * développement, sinon stockage dans un fichier log.
	 *
	 * @param string	$msg	Message affiché ou stocké.
	 */
	function sc_bd_erreurExit($msg) {
		ob_end_clean();		// Supression de tout ce qui
							// a pu être déja généré

		echo '<!DOCTYPE html><html><head><meta charset="ISO-8859-1"><title>',
				'Erreur base de données</title></head><body>',
				$msg,
				'</body></html>';
		exit();
	}
	//___________________________________________________________________
	/**
	 * Gestion d'une erreur de requête à la base de données.
	 *
	 * @param resource	$bd		Connecteur sur la bd ouverte
	 * @param string	$sql	requête SQL provoquant l'erreur
	 */
	function sc_bd_erreur($bd, $sql) {
		$errNum = mysqli_errno($bd);
		$errTxt = mysqli_error($bd);

		// Collecte des informations facilitant le debugage
		$msg = '<h4>Erreur de requ&ecirc;te</h4>'
				."<pre><b>Erreur mysql :</b> $errNum"
				."<br> $errTxt"
				."<br><br><b>Requ&ecirc;te :</b><br> $sql"
				.'<br><br><b>Pile des appels de fonction</b>';

		// Récupération de la pile des appels de fonction
		$msg .= '<table border="1" cellspacing="0" cellpadding="2">'
				.'<tr><td>Fonction</td><td>Appel&eacute;e ligne</td>'
				.'<td>Fichier</td></tr>';

		$appels = debug_backtrace();
		for ($i = 0, $iMax = count($appels); $i < $iMax; $i++) {
			$msg .= '<tr align="center"><td>'
					.$appels[$i]['function'].'</td><td>'
					.$appels[$i]['line'].'</td><td>'
					.$appels[$i]['file'].'</td></tr>';
		}

		$msg .= '</table></pre>';

		sc_bd_erreurExit($msg);
	}
	//_______________________________________________________________
	/**
	* Transformation d'un date amj en clair.
	*
	* Aucune vérification n'est faite sur la validité de la date car
	* on considère que c'est bien une date valide sous la forme aaaammjj
	*
	* @param integer	$amj		La date sous la forme aaaammjj
	*
	* @return string	La date sous la forme jj mois aaaa (1 janvier 2000)
	*/
	function sc_amj_clair($amj) {
		$mois = array('', ' janvier ', ' f&eacute;vier ', ' mars ', ' avril ', ' mai ', ' juin ',
					' juillet ', ' a&ocirc;ut ', ' septembre ', ' octobre ', ' novembre ', ' d&eacute;cembre ');

		$jj = (int) substr($amj, -2);
		$mm = (int) substr($amj, 4, 2);

		return $jj.$mois[$mm].substr($amj, 0, 4);
	}

	//_______________________________________________________________
	/**
	 * Génération et affichage du début de la page HTML.
	 *
	 * @param string	$titre	Titre de la page (tag title)
	 * @param string	$css	Fichier feuille de styles CSS
	 */
	function sc_html_debut($titre, $css = '') {

		if ($css != '') {
			$css = "<link rel='stylesheet' href='../styles/$css' type='text/css'>";
		}

		echo '<!DOCTYPE html">',
			'<html>',
				'<head>',
					'<meta charset="iso-8859-1">',
					'<title>', $titre, '</title>',
					$css,
					'<link rel="shortcut icon" href="../images.favicon.ico" type="image/x-icon">',
				'</head>',
				'<body>',
					'<div id="bcPage">';
	}

	//_______________________________________________________________
	// fonction à faire pour l'étape 7
	//

	/**
	* Affichages des résultats des SELECT des blablas d'un utilisateur.
	*
	* La fonction gére la boucle de lecture des résultats et affiche
	* les données sélectionnées avec des balise HTML.
	*
	* @param resource	$R			Pointeur des résultats de la requête
	* @param string		$titre		Titre de la liste
	*/
	/*
	function sc_aff_blablas($R, $titre) {
		echo '<h2>', $titre, '</h2>',
			'<ul>';

		// Boucle de traitement
		while ($D = mysqli_fetch_assoc($R)) {
			echo '<li>', htmlentities("{$D['usPseudo']} - {$D['usNom']}, ENT_QUOTES, 'ISO-8859-1'),
					'<br>', htmlentities($D['blTexte'], ENT_QUOTES, 'ISO-8859-1'),
					'<br>', $D['blDate'], ' - ', $D['blHeure'],
				'</li>';
		}

		echo '</ul>';
	}
	*/

	//_______________________________________________________________
	// fonction modifie à l'étape 8
	//

	/**
	* Affichages des résultats des SELECT des blablas d'un utilisateur.
	*
	* La fonction gére la boucle de lecture des résultats et affiche
	* les données sélectionnées avec des balise HTML.
	*
	* @param resource	$R			Pointeur des résultats de la requête
	* @param string		$titre		Titre de la liste
	*/
	function sc_aff_blablas($R, $titre) {
		echo '<h2>', $titre, '</h2>',
			'<ul>';

		// Boucle de traitement
		while ($D = mysqli_fetch_assoc($R)) {
			$hh = (int) substr($D['blHeure'], 0, 2);

			 // Affichage image, pseudo, texte et date
			echo '<li>',
					'<img src="../upload/', $D['usID'], '.jpg" class="imgAuteur">',
					'<a href="" title="Voir la bio"><strong>',
						htmlentities($D['usPseudo'], ENT_QUOTES, 'ISO-8859-1'),
					'</strong></a> ',
					'<span class="nomUser">',
						htmlentities($D['usNom'], ENT_QUOTES, 'ISO-8859-1'),
					'</span><br>',
					htmlentities($D['blTexte'], ENT_QUOTES, 'ISO-8859-1'),
					'<p class="finMessage">Le ', sc_amj_clair($D['blDate']),
					' &agrave; ', $hh, 'h', substr($D['blHeure'], 3, 2), '</p>',
				'</li>';
		}

		echo '</ul>';
	}


	function sc_aff_entete($contenu, $bConnecte = TRUE) {
		if ($bConnecte) {
			echo '<div id="bcEntete">',
					'<a id="btnDeconnexion" href="deconnexion.php" title="Se déconnecter de cuiteur"></a>',
					 '<a id="btnHome" href="cuiteur.php" title="Ma page d\'accueil"></a>',
					 '<a id="btnCherche" href="recherche.php" title="Rechercher des personnes &agrave; suivre"></a>',
					 '<a id="btnConfig" href="compte.php" title="Modifier mes informations personnelles"></a>',
					$contenu,
				'</div>';
			return;
		}

        if (isset($_SESSION['auth_type']) && $_SESSION['auth_type'] == "admin") {
			echo '<div id="bcEntete">',
					 '<a id="btnHome" href="../cuiteur.php" title="Ma page d\'accueil"></a>',
					$contenu,
				'</div>';
            return;    
        }

		// Entete quand l'utilisateur n'est pas connecté
		echo '<div id="bcEnteteDec">',
				$contenu,
			'</div>';
	}

	//_______________________________________________________________
	/**
	* Pied de page des pages (info copyright + bloc réseaux sociaux).
	*/
	function sc_aff_pied() {
		echo '<ul id="bcPied">',
				'<li><a href="#">A propos</a></li>',
				'<li><a href="#">Publicit&eacute;</a></li>',
				'<li><a href="#">Patati</a></li>',
				'<li><a href="#">Aide</a></li>',
				'<li><a href="#">Patata</a></li>',		
				'<li><a href="#">Stages</a></li>',
				'<li><a href="#">Emplois</a></li>',
				'<li><a href="#">Confidentialit&eacute;</a></li>',
			'</ul>',
			'</div>',
			'</body>',
			'</html>';
	}

	//_______________________________________________________________
	/**
	* Affichage du bloc d'informations :
	*  - Utilisateur (avatar, abonnés, abonnements)
	*  - Tendances
	*  - Suggestions
	* @param boolean	$avecInfo	Indique si on affiche les infos ou
	* 								simplement un bloc vide (pour les pages
	* 								quand l'utilisateur n'est pas encore loggé)
	*/
	function sc_aff_infos($avecInfo=TRUE) {
		if (! $avecInfo) {
			echo '<div id="bcInfos"></div>';
			return;
		}

		echo '<div id="bcInfos">';
	}

?>
