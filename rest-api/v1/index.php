<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// ID utilisateur - variable globale
$user_id = NULL;


/**
 * Ajout de Couche intermédiaire pour authentifier chaque demande
 * Vérifier si la demande a clé API valide dans l'en-tête "Authorization"
 */
function authenticate(\Slim\Route $route)
{
    // Obtenir les en-têtes de requêtes

    $response = array();
    $app = \Slim\Slim::getInstance();
    $headers =$app->request->headers;
    // Vérification de l'en-tête d'autorisation
    if (isset($headers['Authorizations'])) {
        $db = new DbHandler();

        // Obtenir la clé d'api
        $api_key = $headers['Authorizations'];
        // Valider la clé API
        if (!$db->isValidApiKey($api_key)) {
            //  Clé API n'est pas présente dans la table des utilisateurs

            $response["error"] = true;
            $response["api-key-error"] =true;
            $response["message"] = "Accès Refusé. Clé API invalide";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;

            // Obtenir l'ID utilisateur (clé primaire)
            $user_id = $db->getUserId($api_key);

        }
    } else {

        // Clé API est absente dans la en-tête
        $response["error"] = true;
        $response["message"] = "Clé API est manquante";

        echoRespnse(400, $response);
        $app->stop();
    }
}

$app->get('/reservation', 'authenticate', function() {

    $response = array();
    $db = new DbHandler();

    // aller chercher toutes les tâches de l'utilisateur
    $result = $db->getAllReservation();
    if($result){
        $response["reservation"] = $result;
        $response["error"] = false;

    }
    else{
        $response["error"] = true;
        $response["message"] = " une erruer est survenu veillez ressayer plus tard ";

    }
    // boucle au travers du résultat et de la préparation du tableau des tâches


    echoRespnse(200, $response);
});

$app->put('/password', 'authenticate', function()use($app) {
    verifyRequiredParams(array("password","newPassword"));
    global $user_id;
    $response = array();
    $password = $app->request->put('password');
    $newPassword = $app->request->put('newPassword');
    $db=new DbHandler();
    $email = $db->getUserEmailById($user_id);
    if ($db->checkLogin($email, $password)){
        if($db->updateUser($user_id,$newPassword)){
            $response['error'] = false;
            $response['message'] = 'Mise à jour avec succès';
            echoRespnse(200, $response);
        }else{

            $response['error'] = true;
            $response['message'] = 'Échec de la mise à jour du mot de passe, veuillez essayer plus tard';
            echoRespnse(200, $response);
        }
    }else {
        // identificateurs de l'utilisateur sont erronés
        $response['error'] = true;
        $response['message'] = 'Échec de la connexion. identificateurs incorrectes';
        echoRespnse(401, $response);
    }

});


$app->post('/article', 'authenticate', function()use($app) {

    verifyRequiredParams(array('id_article', 'id_reservation', 'quantite','prix'));
    $id_article = $app->request->post('id_article');
    $id_reservation = $app->request->post('id_reservation');
    $quantite = $app->request->post('quantite');
    $prix = $app->request->post('prix');

    $db=new DbHandler();
    $result = $db->saveArticles($id_article,$id_reservation,$quantite,$prix);

    if($result == USER_CREATED_SUCCESSFULLY){
        $response['error'] = false;
        $response['message'] = 'Ajouté avec succès';
        echoRespnse(200, $response);
    }else{

        $response['error'] = true;
        $response['message'] = 'Échec d ajout , veuillez essayer plus tard';
        echoRespnse(200, $response);
    }



});
/**
 * Vérification params nécessaires posté ou non
 */
function verifyRequiredParams($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Manipulation paramsde la demande PUT
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        //Champ (s) requis sont manquants ou vides
        // echo erreur JSON et d'arrêter l'application
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Champ(s) requis ' . substr($error_fields, 0, -2) . ' est (sont) manquant(s) ou vide(s)';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validation adresse e-mail
 */
function validateEmail($email)
{
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = "Adresse e-mail n'est pas valide";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Faisant écho à la réponse JSON au client
 * @param String $status_code Code de réponse HTTP
 * @param Int $response response Json
 */
function echoRespnse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    // Code de réponse HTTP
    $app->status($status_code);

    // la mise en réponse type de contenu en JSON
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->notFound(function () use ($app) {
    $app->redirect('http://www.tuto-info.tn');

});
$app->run();
?>