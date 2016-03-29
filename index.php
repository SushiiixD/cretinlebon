<?php
	ob_start();
	include('php/bibli_generale.php');
	echo '<!DOCTYPE HTML>',
			'<html>',
				'<head>',
					'<meta charset="UTF-8">',
					'<link rel="stylesheet" href="styles/index.css" type="text/css">',
					'<title>Cuiteur | Connexion</title>',
				'</head>',
				'<body>',
					'<div id="bcPage">',
					'<img id="megaphone" class="photoDroite" src="../images/photos/megaphone.jpg">',
					'<form method="POST" action="inscription.php">',
					'<h1>Connectez-vous</h1>',
					'<p>Pour vous connecter à Cuiteur, il faut vous identifier :</p>',
					'<table>',
						'<tr>',
							'<td>',
								'Pseudo',
							'</td>',
							'<td>',
								'<input type="text" name="txtPseudo" size="20">',
							'</td>',
						'</tr>',
						'<tr>',
							'<td>',
								'Mot de passe',
							'</td>',
							'<td>',
								'<input type="password" name="txtPasse" size="20">',
							'</td>',
						'</tr>',
						'<tr>',
							'<td>',	
							'</td>',
							'<td>',
								'<input type="submit" name="btnValider" value="Connexion">',
							'</td>',
						'</tr>',
					'</table>',
					'<p>Pas encore de compte ? <a href="php/inscription.php">Inscrivez-vous</a> sans plus tarder !</p>',
					'<p>Vous hésitez à vous inscrire ? Laissez-vous séduire par une <a href="html/presentation.html">présentation</a> des possibilités de Cuiteur.</p>',
					'</div>',
				'</body>',
				'<footer>',
				'<ul id="bcPied">',
					'<li><a href="../../index.html">A propos</a></li>',
					'<li><a href="../../index.html">Publicit&eacute;</a></li>',
					'<li><a href="../../index.html">Patati</a></li>',
					'<li><a href="../../index.html">Aide</a></li>',
					'<li><a href="../../index.html">Patata</a></li>',
					'<li><a href="../../index.html">Stages</a></li>',
					'<li><a href="../../index.html">Emplois</a></li>',
					'<li><a href="../../index.html">Confidentialit&eacute;</a></li>',				
				'</ul>',
				'</footer>',
			'</html>';
?>