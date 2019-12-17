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
			Nom du script: inscription
			Description: ce script proporse un formulaire d'inscription . Une fois le formulaire soumis, ce script 
			récupère les données, les vérifies. Si tout est ok  le login et le mot de passe crypté est ajouté à la base de données
			Version: 1.0
			Date:26/11/2019
			Auteur: ROYER Pierre
			
			******************************************************************/
			
			//on détermine si on doit afficher le formulaire ou traiter les données.
			
			if(!isset($_POST["valider"]))
			{
				// la variable $_POST["valider"] n'existe pas il faut afficher le formulaire 				  
			?>
			
			
			<h1>S'inscrire  </h1>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						<!-- zone du titre -->
						<label for="zoneLogin">Email: </label>
						<input type="email" id="zoneEmail" placeholder="Entrez votre email"
						  name = "zoneEmail" required>
					</div>
					<div>
						<!-- zone de l'auteur -->
						<label for="zoneMotDePasse">Mot de passe: </label>
						<input type="password" id="zoneMdp" placeholder="Entrez votre Mot de passe"
						  name = "zoneMdp" required>
					</div>
					<div>
						<!-- zone de l'auteur -->
						<label for="zoneConfirmationMdp">Confirmez mot de passe: </label>
						<input type="password" id="zoneConfirmationMdp" placeholder="Confirmez votre Mot de passe"
						  name = "zoneConfirmationMdp" required>
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
					$email_recu = utf8_decode($_POST["zoneEmail"]);
					$MotDePasse_recu = utf8_decode($_POST["zoneMdp"]);
					$ConfirmeMotDePasse_recu = utf8_decode($_POST['zoneConfirmationMdp']);
					
					$email_recu = sanitizeString ($email_recu);
					$MotDePasse_recu = sanitizeString ($MotDePasse_recu);
					$ConfirmeMotDePasse_recu = sanitizeString ($ConfirmeMotDePasse_recu);
					
					//on vérifie que les deux mots de passe sont identiqueset que l'email n'est pas vide
					if  (empty($email_recu) || empty ($MotDePasse_recu) || empty ($ConfirmeMotDePasse_recu) || ($MotDePasse_recu != $ConfirmeMotDePasse_recu))
					{ 
							echo ("un champ n'est pas remplie correctement");
					}
				
					
				$host 	= 'localhost';
				$user 	= 'User' ;   
				$passwd = 'snir@snir2019';
				$mabase = 'biblio2';
				
				
				//On crypte le mot de passe
				$motdepasseCrypte= password_hash($MotDePasse_recu, PASSWORD_DEFAULT);
				
				
				
				
				
				if ($conn = mysqli_connect($host,$user,$passwd,$mabase))
				{
					$reqInsert =" INSERT INTO connexion (email, password)
						           VALUES ('$email_recu','$motdepasseCrypte')";
		
					if($result = mysqli_query($conn, $reqInsert, MYSQLI_USE_RESULT))
					{
						
						echo 'vous êtes enregistré <a href="connexion.php"> connexion </a>'; 
						
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