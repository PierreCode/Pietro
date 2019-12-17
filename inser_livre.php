<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title> Accueil du site </title>
<link rel="stylesheet" type="text/css" href="monstyle.css">
<head>
<body>
<?php		

			/********************************************************************
			Nom du script: inser.livre
			Description: Insérer livre
			Version: 1.0
			Date:26/11/2019
			Auteur: ROYER Pierre
			
			******************************************************************/
			
			//on détermine si on doit afficher le formulaire ou traiter les données.
			
			if(!isset($_POST["valider"]))
			{
				// la variable $_POST["valider"] n'existe pas il faut afficher le formulaire 				  
			?>
			
			
			<h1>Ajouter livre  </h1>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						<!-- zone du titre -->
						<label for="zonetitre">Titre : </label>
						<input type="text" id="zonetitre" placeholder="Entrez le titre du livre"
						  name = "zonetitre" required>
					</div>
					<div>
						<!-- zone de l'auteur -->
						<label for="zoneauteur">Auteur : </label>
						<input type="text" id="zoneauteur" placeholder="Entrez l'auteur"
						  name = "zoneauteur" required>
					</div>
					<div>
						<!-- Menu déroulant pour le genre-->
						<label for="zonegenre">Genre : </label>
						<select id= "zonegenre" name = "zonegenre" size = "1">
							<option value = "roman">Roman </option>
							<option value ="poesie">Poèsie  </option>
							<option value ="nouvelles">Nouvelles  </option>
							<option value ="autres">Autres  </option>
						</select>
					</div>
					<div>
						<!-- Zone du prix -->
						<label for="zonePrix">Prix : </label>
						<input type="number" id="zoneprix" placeholder="Entrez le prix"
						  name = "zoneprix" required>
						  </div>
						  <div>
					<button type="submit" name="valider"> valider </button>
					</div>
					</form>
					<?php
					}
						else
						{
							
						/* Le formulaire a été validé il faut traiter les données
						traitement: -récupérer les données et les stockées dans des variables locales
						-se connecter au serveur de base de données
						- préparer une requête d'insertion des données
						-envoyer la requête 
						-appeler le script "affiche_livre.php"
						*/
					$titre_recu = utf8_decode($_POST['zonetitre']);
					$auteur_recu = utf8_decode($_POST['zoneauteur']);
					$genre_recu = utf8_decode($_POST['zonegenre']);
					$prix_recu = $_POST['zoneprix'];
					
					$titre_recu = sanitizeString ($titre_recu);
					$auteur_recu = sanitizeString ($auteur_recu);
					$genre_recu = sanitizeString ($genre_recu);
					$prix_recu = sanitizeString($prix_recu);
					
				
					
				$host 	= 'localhost';
				$user 	= 'User' ;   
				$passwd = 'snir@snir2019';
				$mabase = 'biblio2';
				
				if ($conn = mysqli_connect($host,$user,$passwd,$mabase))
				{
					$reqInsert =" INSERT INTO livre (titre, auteur, genre, prix )
						           VALUES ('$titre_recu','$auteur_recu','$genre_recu','$prix_recu')";
		
					if($result = mysqli_query($conn, $reqInsert, MYSQLI_USE_RESULT))
					{
						
						require_once 'affiche_livre.php';
						
					}
						
					else
						{
							echo $reqInsert;
							die ("erreur d'envois de requête");
						}
				}
						else
						{ 
						
							die ("erreur de connection");
						}
						}
						
						function sanitizeString ($var)
						{
							if (get_magic_quotes_gpc())
							{
								$var=stripslashes($var);
							}
							$var = strip_tags ($var);
							
							$var = htmlentities ($var);
							return $var;
						}
						
						function sanitizeMySQL($connexion, $var)
						{
							$var = $connexion->real_escape_string($var);
							$var = sanitizeString($var);
							return $var;
						}
							
				?>
			
					
		
						
</body>
</html>