<?php	
	require_once('bibli_generale.php');
	require_once('bibli_cuiteur.php');
	ob_start();
	sc_html_debut('Cuiteur | Utilisateur','../styles/cuiteur.css');
	//On sélectionne tous les éléments de la table users
	$sql='SELECT users.*, eaIDUser, eaIDAbonne
		FROM users 
		LEFT JOIN estabonne ON eaIDAbonne = usID AND eaIDUser = usID ';
	$result = mysqli_query($sql) or sc_bd_erreur($sql);
	$enr = mysqli_fetch_assoc($result);
	$txt = '<h1>Le profil de'.htmlentities($enr['usNom']).'</h1>';
	sc_aff_entete($txt, false);
	sc_aff_infos(true);
	
	sc_aff_pied();
	ob_end_flush();
?>