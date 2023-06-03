<?php
  
//db config
$servername="localhost";
$username="root";
$password="";
$dbname="h20_helper";

  //connexion
 $lien=mysqli_connect($servername,$username,$password,$dbname);

  //verifier la connexion 
  if(!mysqli_connect_error())
  {
    echo"La connexion a echoue ! <br>" ;
  }

 

  //connexion a un compte existant
  if (isset($_POST['submit'])) //verifier que les checkbox sont bien check
  { 
if (isset($_POST['check'])) //verifier que les checkbox sont bien check
 {  
  $choix = $_POST['check']; //user ou fournisseur ?

  //utilisateur
 if ($choix == 'utilisateur') {
	
	$email_u=$_POST['mail'];
	$password_u = $_POST['pass'];
		$query = "SELECT * FROM utilisateur WHERE email_u='$email_u' AND mot_passe_u='$password_u'";
	    $resultat = mysqli_query($lien, $query);
		//true
		   if (mysqli_num_rows($resultat) ==1) {
			    // redirection  
				session_start(); 
			    header("Location: +compte.php?email_u=$email_u");
			    exit;}
		//false
		   else {
			     echo "<p > email ou mot de passe invalide.</p>";
				 echo "<a href='javascript:history.go(-1)'>Cliquez ici pour revenir</a>.";
		    }
			  }
	
 //fournisseur
else if ($choix == 'fournisseur') {

	$email_f=$_POST['mail'];
	$password_f = $_POST['pass'];

		$query = "SELECT * FROM founisseur WHERE email_f='$email_f' AND mot_passe_f='$password_f'";
	    $resultat = mysqli_query($lien, $query);
		//true
		   if (mysqli_num_rows($resultat) ==1) {
			    // redirection  
				session_start(); 
			    header("Location: fourn2.php?email_f=$email_f");
			    exit;}
		//false
		   else {
			     echo "<p > email ou mot de passe invalide.</p>";
				 echo "<a href='javascript:history.go(-1)'>Cliquez ici pour revenir</a>.";
		    }
	    }
}
else{
	header("Location: index.html");
	exit;}
}

  


//creation de compte
if (isset($_POST['submiti'])) //verifier que les checkbox sont bien check
{ 
if (isset($_POST['checki'])) //verifier que les checkbox sont bien check
{  
$choix = $_POST['checki']; //user ou fournisseur ?

//utilisateur
if ($choix == 'utilisateur') {
  
  $email_u=$_POST['maili'];
  $password_u = $_POST['passi'];

	   // Vérifier si l'e-mail existe déjà dans la base de données
  $sql_check = "SELECT * FROM utilisateur WHERE email_u = '$email_u'";
  $result_check = mysqli_query($lien, $sql_check);
  if (mysqli_num_rows($result_check) ==1) {
	  // L'e-mail existe déjà, afficher un message d'erreur et arrêter l'exécution
	  echo "L'e-mail existe déjà. Veuillez en choisir un autre.<br>";
	  echo "<br><a href='javascript:history.go(-1)'>Cliquez ici pour revenir</a>.";
	  exit();
  }else{
			  // redirection  
			  session_start(); 
			  header("Location: user.html");
			  exit();}
			}
   //fournisseur
else if ($choix == 'fournisseur') {

  $email_f=$_POST['maili'];
  $password_f = $_POST['passi'];

  // Vérifier si l'e-mail existe déjà dans la base de données
  $sql_check = "SELECT * FROM founisseur WHERE email_f = '$email_f'";
  $result_check = mysqli_query($lien, $sql_check);
  if (mysqli_num_rows($result_check) ==1) {
	  // L'e-mail existe déjà, afficher un message d'erreur et arrêter l'exécution
	  echo "L'e-mail existe déjà. Veuillez en choisir un autre.<br>";
	  echo "<br><a href='javascript:history.go(-1)'>Cliquez ici pour revenir</a>.";
	  exit();
  }else{
			  // redirection  
			  session_start(); 
			  header("Location: fournisseur.html");
			  exit;}
	  }
}
else{
header("Location: index.html");
exit;}
}



//partie creation de compte

//user
if (isset($_POST['user'])) {
	// recuperer les donnees
	$nom_u=$_POST['nom_u'];
	$prenom_u=$_POST['prenom_u'];
	$email_u=$_POST['email_u'];
	$mdp_u=$_POST['password_u'];
	$pwd_hash= password_hash($mdp_u,PASSWORD_DEFAULT);
	$dn_u=$_POST['date_naissance_u'];
	$poids_u=$_POST['poids_u'];
	$taille_u=$_POST['taille_u'];
	$imc_u=(($poids_u -20)*15+1500)/1000;
	
	
	// insert into BDD
	$sql = "INSERT INTO utilisateur (nom_u, prenom_u, email_u, mot_passe_u, date_naissance_u, poids_u, taille_u) VALUES ('$nom_u', '$prenom_u', '$email_u', '$mdp_u','$dn_u', '$poids_u', '$taille_u')";
	if (mysqli_query($lien, $sql)) {
		// redirection
		session_start(); 
		header("Location: +compte.php?email_u=$email_u");
		exit();
	} else {
		echo "Erreur: " . $sql . "<br>" . mysqli_error($lien);
		echo "<br><a href='javascript:history.go(-1)'>Cliquez ici pour revenir</a>.";
	}
}

//fournisseur
if (isset($_POST['fournisseur'])) {
	// recuperer les donnees
	$nom_f=$_POST["nom_f"];
	$prenom_f=$_POST["prenom_f"];
	$email_f=$_POST["email_f"];
	$mdp_f=$_POST["password_f"];
	$pwd_hash2= password_hash($mdp_f,PASSWORD_DEFAULT);
	$wilaya_f=$_POST["wilaya_f"];

	// insert into BDD
	$sql = "INSERT INTO founisseur (nom_f, prenom_f, email_f, mot_passe_f, wilaya_f) VALUES ('$nom_f', '$prenom_f', '$email_f', '$mdp_f', '$wilaya_f')";
	if (mysqli_query($lien, $sql)) {
		// redirection
		session_start(); 
// Redirection vers le deuxième fichier PHP en incluant les données encodées dans l'URL
header("Location: fourn2.php?email_f=$email_f");
		exit();
	} else {
		echo "Erreur: " . $sql . "<br>" . mysqli_error($lien);
		echo "<br> <a href='javascript:history.go(-1)'>Cliquez ici pour revenir</a>.";
	}
}






//logout
if (isset($_POST['logout_u'])) {
	session_destroy();
	header('Location: index.html');
	exit();

}

if (isset($_POST['logout_f'])) {
	session_destroy();
	header('Location: index.html');
	exit();
}





//bouton ajouter
if(isset($_POST['ajt_marques_f']))
{
  header('Location: ajteau.html');
  exit();
}




//ajouter une eau pour un fournisseur
if (isset($_POST['ajouteau'])) {
	
	session_start(); 
	$sessionid = $_SESSION['malak'];
	$email_f;

$nom_e=$_POST['nom_e'];
$logo=$_POST['logo'];
$disponibilite=$_POST['litre'];
$potassium=$_POST['potassium'];
$calcium=$_POST['calcium'];
$magnesium=$_POST['magnesium'];
$sodium=$_POST['sodium'];
$bicarbonate=$_POST['bicarbonate'];
$sulfates=$_POST['sulfates'];
$chlorure=$_POST['chlorure'];
$nitrate=$_POST['nitrate'];
$nitrite=$_POST['nitrite'];
$ph=$_POST['ph'];

    $sql1="SELECT email_f FROM founisseur WHERE IDF='$sessionid'";
	$result = $lien->query($sql1);

	if ($result->num_rows ==1) {
		while ($row = $result->fetch_assoc()) {
			 $email_f=$row['email_f'] ;
		}}



		// insert into BDD
		$sql = "INSERT INTO marque_eau (IDF,Nom,Logo,Disponibilite,Potassium,Calcium,Magnesium,Sodium,Bicarbonate,Sulfates,Chlorure,Nitrate,Nitrite,PH) VALUES ('$sessionid','$nom_e', '$logo', '$disponibilite', '$potassium', '$calcium', '$magnesium', '$sodium', '$bicarbonate', '$sulfates', '$chlorure', '$nitrate', '$nitrite', '$ph')";
		$query=mysqli_query($lien, $sql);
		if ($query) {
			// redirection
			header("Location: fourn2.php?email_f=$email_f");
			exit();}
		 else {
			echo "Erreur: " . $sql . "<br>" . mysqli_error($lien);
			echo "<a href='javascript:history.go(-1)'>Cliquez ici pour revenir</a>.";
		}
}




mysqli_close($lien); //ferme le flux de connexion


?>
