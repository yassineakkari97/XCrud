<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

/**
 * Classe pour gérer toutes les opérations de db
 * Cette classe aura les méthodes CRUD pour les tables de base de données
 *

 */
class DbHandler
{

    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        //Ouverture connexion db
        $db = new DbConnect();
        $this->conn = $db->connect();

    }

    /**
     * Vérification de connexion de l'utilisateur
     * @param String $email
     * @param String $password
     * @return boolean Le statut de connexion utilisateur réussite / échec
     */
    public function checkLogin($email, $password)
    {
        // Obtention de l'utilisateur par email
        $stmt = $this->conn->prepare("SELECT password_hash FROM utilisateurs WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->bind_result($password_hash);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Utilisateur trouvé avec l'e-mail
            // Maintenant, vérifier le mot de passe

            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password_hash, $password)) {
                // Mot de passe utilisateur est correcte
                return TRUE;
            } else {
                // mot de passe utilisateur est incorrect
                return FALSE;
            }
        } else {
            $stmt->close();

            // utilisateur n'existe pas avec l'e-mail
            return FALSE;
        }
    }

    /**
     * Obtention de l'identifiant de l'utilisateur par clé API
     * @param String $api_key
     */
    public function getUserId($api_key)
    {
        $stmt = $this->conn->prepare("SELECT id FROM utilisateurs WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();

            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    public function getUserIdByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();

            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    public function getUserEmailById($id)
    {
        $stmt = $this->conn->prepare("SELECT email FROM utilisateurs WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $stmt->bind_result($user_email);
            $stmt->fetch();

            $stmt->close();
            return $user_email;
        } else {
            return NULL;
        }
    }

    /**
     * Validation de la clé API de l'utilisateur
     * Si la clé API est là dans db, elle est une clé valide
     * @param String $api_key
     * @return boolean
     */


    public function isValidApiKey($api_key)
    {
        $stmt = $this->conn->prepare("SELECT id from utilisateurs WHERE api_key = ? and status = 1");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getAllReservation()
    {
        $year = date("Y", strtotime("-1 year"));
        $stmt = $this->conn->prepare('SELECT r.`id`, r.`date`, r.`heure_debut`, r.`heure_fin`, r.`prix` ,
concat (c.`nom`," ", c.`prenom`) as name, c.`phone`, c.`email`, c.`adresse`, c.`ville` FROM `reservation` r  ,`agent`  c   WHERE year(r.date) > ? AND c.`id`= r.`id_client`');
        $stmt->bind_param("i", $year);
        if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($id_reservation, $date, $h_debut, $h_fin, $prix, $client, $phone, $email, $adresse, $ville);
            while ($stmt->fetch()) {
                $tmp = array();
                $tmp["id"] = $id_reservation;
                $tmp["end"] = $date . " " . $h_fin;
                $tmp["start"] = $date . " " . $h_debut;
                $tmp["debut"] = $h_debut;
                $tmp["fin"] = $h_fin;
                $tmp["phone"] = $phone;
                $tmp["email"] = $email;
                $tmp["adresse"] = $adresse;
                $tmp["ville"] = $ville;
                $payment = $this->getPayment($id_reservation);
                $article = $this->getSommeArticle($id_reservation);
                $total = $prix + $article;
                $reste = $total - $payment;
                if ($reste == $total) {
                    $tmp["color"] = "#DC143C";
                } elseif ($reste == 0) {
                    $tmp["color"] = "#008000";
                } elseif ($reste < $total) {
                    $tmp["color"] = "#FF8C00";
                }
                $tmp["title"] = $client;
                array_push($res, $tmp);
            }
            $stmt->close();
            return $res;
        } else {
            return null;
        }
    }

    public function getPayment($id_reservation)
    {
        $db = new DbConnect();
        $conn = $db->connect();
        $stmt = $conn->prepare('SELECT  COALESCE(sum(montant),0) FROM payement WHERE id_reserv = ?');
        $stmt->bind_param("s", $id_reservation);
        if ($stmt->execute()) {
            $stmt->bind_result($montant);
            $stmt->fetch();
            $stmt->close();
            return $montant;
        } else {
            return null;
        }
    }

    public function getSommeArticle($id_reservation)
    {
        $db = new DbConnect();
        $conn = $db->connect();
        $stmt = $conn->prepare('SELECT  COALESCE (sum(prix),0)  FROM commande_article WHERE id_reservation = ?');
        $stmt->bind_param("s", $id_reservation);
        if ($stmt->execute()) {
            $stmt->bind_result($montant);
            $stmt->fetch();
            $stmt->close();
            return $montant;
        } else {
            return null;
        }
    }

    public function getReservationPrix($id_reservation)
    {
        $db = new DbConnect();
        $conn = $db->connect();
        $stmt = $conn->prepare('SELECT  prix  FROM reservation WHERE id = ?');
        $stmt->bind_param("s", $id_reservation);
        if ($stmt->execute()) {
            $stmt->bind_result($prix);
            $stmt->fetch();
            $stmt->close();
            return $prix;
        } else {
            return null;
        }
    }

    public function getPaidReservation()
    {
        $resv = $this->getAllReservation();
        $s = 0;
        foreach ($resv as $row){
            $id_reservation = $row["id"];
            $prix = $this->getReservationPrix($id_reservation);
            $payment = $this->getPayment($id_reservation);
            $article = $this->getSommeArticle($id_reservation);
            $total = $prix + $article;
            $reste = $total - $payment;
            if ($reste == 0 ){
                $s = $s + 1;
            }
        }

    return $s;

    }
    public function getUnPaidReservation()
    {
        $resv = $this->getAllReservation();
        $s = 0;
        foreach ($resv as $row){
            if ($this->getPayment($row["id"]) == 0){
                $s = $s +1;
            }
        }
        return $s;

    }




    public function getArticles()
    {
        $db = new DbConnect();
        $conn = $db->connect();

        $stmt = $conn->prepare('SELECT id , nom , unite, prix_unitaire FROM articles');
        if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($id, $nom, $unite, $prix_unitaire);
            while ($stmt->fetch()) {
                $tmp = array();
                $tmp['id'] = $id;
                $tmp['nom'] = $nom;
                $tmp['unite'] = $unite;
                $tmp['prix_unitaire'] = $prix_unitaire;
                array_push($res, $tmp);
            }
            $stmt->close();
            return $res;
        } else {
            return null;
        }
    }

    public function saveArticles($id_article,$id_reservation,$quantite,$prix){
        $db = new DbConnect();
        $conn = $db->connect();
        $stmt = $conn->prepare('INSERT INTO commande_article (id_article,id_reservation,quantite,prix) VALUES (?, ?, ?, ?)');
        $stmt->bind_param("issd",$id_article,$id_reservation,$quantite,$prix);
        $result = $stmt->execute();
        $stmt->close();
        //Vérifiez pour une insertion réussie
        if ($result) {
            // Utilisateur inséré avec succès
            return USER_CREATED_SUCCESSFULLY;
        } else {
            //Échec de la création de l'utilisateur
            return USER_CREATE_FAILED;
        }
    }

    /**
     * Mise à jour profil utilisateur
     */
    public function updateUser($id, $password)
    {
        $password_hash = PassHash::hash($password);
        $stmt = $this->conn->prepare("UPDATE utilisateurs  set  password_hash = ?   WHERE id= ?");
        $stmt->bind_param("si", $password_hash, $id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    public function getLastNumber()
    {
        $y = date("Y");

        $stmt = $this->conn->prepare("SELECT id FROM reservation WHERE id LIKE CONCAT(?,'-%') ORDER BY id DESC LIMIT 1");
        $stmt->bind_param('s', $y);
        if ($stmt->execute()) {
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            if ($num_rows == 0) {
                $id = $y . '-0001';
                return $id;
            } else {
                $stmt->bind_result($numero);
                $stmt->fetch();
                $stmt->close();
                $n = substr($numero, 5, 4);
                $i = (int)$n;
                $i++;
                $res = sprintf("%04d", $i);
                return $y . "-" . $res;
            }
        } else {
            return false;
        }
    }


}

?>
