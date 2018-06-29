<?php
require_once 'rest-api/include/DbConnect.php';
require_once 'rest-api/include/PassHash.php';
//Ouverture connexion db
$db = new DbConnect();
$conn = $db->connect();
$email = $_POST["login_username"];
$password = $_POST["login_password"];
$stmt = $conn->prepare("SELECT u.id,u.password_hash,u.status,u.privilege,u.photo,x.nom,u.api_key FROM utilisateurs u, privilege p ,page x WHERE u.email =? and u.privilege=p.id and p.default_page=x.id");

$stmt->bind_param("s", $email);

$stmt->execute();

$stmt->bind_result($id, $password_hash,$status,$privilege,$photo,$default,$api_key);

$stmt->store_result();
$stmt->fetch();
if ($stmt->num_rows > 0) {
    // Utilisateur trouvé avec l'e-mail
    // Maintenant, vérifier le mot de passe
    if ($status == 1) {


        $stmt->close();

        if (PassHash::check_password($password_hash, $password)) {
            // Mot de passe utilisateur est correcte
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $id;
            $_SESSION['privilege'] = $privilege;
            $_SESSION['photo'] = $photo;
            $_SESSION['default']=$default;
            $_SESSION['api_key']=$api_key;
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
