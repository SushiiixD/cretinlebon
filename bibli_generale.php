<?php
	/**
	* Génére le code d'une ligne de formulaire :
	*
	* @param string		$gauche		Contenu de la colonne de gauche
	* @param string		$droite		Contenu de la colonne de droite
	*
	* @return string Code HTML représentant une ligne de tableau
	*/
	function sc_form_ligne($gauche, $droite='') {
		if ($droite == '') {
			return "<tr><td colspan='2' class='tdGauche'>{$gauche}</td></tr>";
		}
		return "<tr><td class='tdGauche'>{$gauche}</td><td class='tdDroite'>{$droite}</td></tr>";
	}
	
	//_______________________________________________________________
	/**
	* Génére le code d'une zone input de formulaire (type input) :
	*
	* @param String		$type	le type de l'input ('text', 'hidden', ...)
	* @param string		$name	Le nom de l'input
	* @param String		$value	La valeur par défaut
	* @param integer	$size	La taille de l'input 
	*
	* @return string Code HTML de la zone de formulaire 
	*/
	function sc_form_input($type, $name, $value, $size=0) {
	   $value = htmlentities($value);
	   $size = ($size == 0) ? '' : "size='{$size}'";
	   $class = ($type == 'submit' || $type == 'reset') ? 'class="bouton"' : '';
	   return "<input type='{$type}' name='{$name}' {$size} value=\"{$value}\" {$class}>";
	}
	
	//_______________________________________________________________
	/**
	* Génére le code d'une zone de texte de formulaire (type textarea) :
	*
	* @param string		$name	Le nom de la zone de texte
	* @param string		$value	La valeur par dï¿½faut
	* @param integer	$cols	Le nombre de colonnes du textarea
	* @param integer	$rows	Le nombre de lignes du textarea
	* @param string		$style	Un style à appliquer (code CSS)
	*
	* @return string Code HTML de la zone de texte
	*/
    function sc_form_textarea($name, $value, $cols, $rows, $style='') {
        $value = htmlentities($value);
        return "<textarea name='{$name}' rows='{$rows}' cols='{$cols}' style='{$style}'>{$value}</textarea>";
	}
	
	
	//_______________________________________________________________	
	/**
	* Produit le code pour un ensemble de trois zones de sélection 
	* représentant les jours, mois et années
	*
	* @param string		$nom	Préfixe pour les noms des zones
	* @param integer	$jour 	Le jour sélectionné par défaut
	* @param integer	$mois 	Le mois sélectionné par défaut
	* @param integer	$annee	l'année sélectionnée par défaut
	*
	* @return string Le code HTML généré
	*/
	function sc_form_date($nom, $jour, $mois, $annee) {
		$tab_jours = array();
		
		for ($i = 1; $i <= 31; $i++) {
			$index = ($i < 10) ? "0{$i}" : $i;
			$tab_jours[$index] = $i;
		}
		
		$tab_mois = array('01' => 'janvier', '02' => 'février', '03' => 'mars', '04' => 'avril',
						  '05' => 'mai', '06' => 'juin', '07' => 'juillet', '08' => 'août', 
						  '09' => 'septembre', '10' => 'octobre', '11' => 'novembre', '12' => 'décembre');
						  
		$tab_annees = array();
		$annee_max = date('Y');
		$annee_min = $annee_max - 99;
		
		for ($i = $annee_min; $i <= $annee_max; $i++) {
			$tab_annees[$i] = $i;
		}
        $ret = sc_form_choix(0, "{$nom}_j", $tab_jours, $jour) . '&nbsp;' .
				sc_form_choix(0, "{$nom}_m", $tab_mois, $mois) . '&nbsp;' .
				sc_form_choix(0, "{$nom}_a", $tab_annees, $annee);
        return $ret;
	}
	function sc_form_choix($genre, $name, $options, $default, $sep='<br>') {
		$ret = '';
		switch ($genre) {
		case 0: 
			$ret = "<select name='{$name}'>";
			foreach ($options as $val => $label) {
				$label = htmlentities($label);
				$vdefault = ($val == $default) ? 'selected="yes"' : '';
				$ret .= "<option value='{$val}' {$vdefault}>{$label}</option>";
			}
			$ret .= '</select>';
			return $ret;
		}
		return $ret;
	}
	
	/**
	* Retourne une date en clair 
	* 
	* @param integer	$date	La date sur 8 entiers (AAAAMMJJ)
	*
	* @return string Une chaîne représentant la date sous la forme JJ mois AAAA. 
	*/
	function sc_date_claire($date) {
		$tab_mois = array(1 => 'janvier', 2 => 'f&eacute;vrier', 3 => 'mars', 4 => 'avril',
						  5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'ao&ucirc;t', 
						  9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'd&eacute;cembre');
		
		$amj = sc_date_amj($date);
		
		return "{$amj[2]} {$tab_mois[$amj[1]]} {$amj[0]}";
	}
	//_______________________________________________________________	
	/**
	* Retourne l'année, le moi et le jour d'un date 
	* 
	* @param integer	$date	La date sur 8 entiers (AAAAMMJJ)
	*
	* @return array Tableau[année, mois, jour] 
	*/
	function sc_date_amj($date) {
		$annee = floor($date / 10000);
		$mois = floor(($date % 10000) / 100);
		$jour = $date % 100;		
		
		return array($annee, $mois, $jour);
	}	
	//_______________________________________________________________		
	/**
	* Renvoie le temps écoulé entre maintenant et une date
	*
	* @param integer	$date	date issue d'un mktime 
	* 
	* @return string "il y a quelques secondes", "il y a N minutes/heures,jours,mois"
	*/
	function sc_date_diff($date) {
		$now = time();
		$diff = $now - $date;
		if ($diff < 60) {
			return 'Il y a quelques secondes';	
		}
		if ($diff < 3600) {
			$nbMin = (int)($diff/60);
			$s = ($nbMin == 1) ? '' : 's';
			return ($nbMin < 5) ? "Il y a quelques minutes" : "il y a $nbMin minute$s"; 	
		}
		if ($diff < 3600*24) {
			$nbHeures = (int)($diff/(60*60));
			$s = ($nbHeures == 1) ? '' : 's';
			return "Il y a $nbHeures heure{$s}"; 	
		}
		if ($diff < 3600*24*31) {
			$nbJours = (int)($diff/(60*60*24));
			$s = ($nbJours == 1) ? '' : 's';
			return "Il y a $nbJours jour{$s}"; 	
		}
		
		$nbMois = (int)($diff/(60*60*24*30));
		return "Il y a {$nbMois} mois"; 	
	}	
	/**
	* Vérifier une URL
	* 
	* @param string		$Url	L'url à tester
	*
	* @return boolean Vrai si l'url est valide, faux sinon. 
	*/
	function sc_ok_url($Url) {
		return preg_match('~((https?://(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4}))~',$Url);
	}
	//_______________________________________________________________
	/**
	 * Protection d'une chaine de caractêres avant de l'enregistrer dans une base de données
	 * 
	 * @param string		$txt	La chaîne à protêger
	 * 
	 * @return string La chaîne protégée
	 */
	function sc_bd_proteger($txt) {
		$txt = trim($txt);
		return mysql_real_escape_string($txt);
	}
?>