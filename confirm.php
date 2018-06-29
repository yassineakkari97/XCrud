

<?php
require_once 'rest-api/include/PassHash.php';

$pass_actuel=$_POST["pass_actuel"];
$nv_email=$_POST["nv_email"];
$ancien_email=$_POST["ancien_email"];

$base =mysql_connect('localhost', 'root', ''); 
mysql_select_db('sofetes', $base); 

$sql = 'SELECT email, password,password_hash,api_key FROM utilisateurs';

$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

while ($data = mysql_fetch_array($req)) {
	// on affiche les résultats
	$password= $data['password'];
	$email= $data['email'];
	$password_hash=$data['password_hash'];
}

 if (PassHash::check_password($password_hash, $pass_actuel))

 		{
 			if( $email==$ancien_email)
 			{
 				$sql = "UPDATE utilisateurs SET email='$nv_email' ";
 				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
 				header('location:dashboard.php');


 			}
 			else
 			{
 					header('location:email.php');
 			}
		 }

else {
	header('location:email.php');
}

	

?>