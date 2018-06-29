<?php
require_once 'rest-api/include/DbConnect.php';
require_once 'rest-api/include/PassHash.php';
//Ouverture connexion db
$db = new DbConnect();
$conn = $db->connect();
$email = $_POST["username"];
$password = $_POST["password"];
$stmt = $conn->prepare("SELECT * FROM utilisateur  WHERE email ='$email' and password='$password'");

$stmt->bind_param("s", $email);

$stmt->execute();

$stmt->bind_result( $password,$email);

$stmt->store_result();
$stmt->fetch();
if ($stmt->num_rows > 0) {
    // Utilisateur trouvé avec l'e-mail
    // Maintenant, vérifier le mot de passe
    if ($status == 1) {


        $stmt->close();

        if (mysqli_num_rows($result)==1) {
            // Mot de passe utilisateur est correcte
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
           
            header("location:".$default);
        } else {
            // mot de passe utilisateur est incorrect
            header("location:index.php?error='mot de passe incorrect'");
        }
    }else{
        header("location:index.php?error='Compte Désactivé'");
    }
} else {
    $stmt->close();

    // utilisateur n'existe pas avec l'e-mail
    header("location:index.php?error='E-mail invalide'");
}
?>
