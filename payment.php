<?php
require_once 'rest-api/include/DbConnect.php';
include('partials/header.php');
include('xcrud/xcrud.php');
$id_reservation = $_GET['id'];


$db = new DbConnect();
$conn = $db->connect();
$stmt = $conn->prepare("SELECT sum(montant) FROM payement where id_reserv= ? ");
$stmt ->bind_param( "s" ,$id_reservation);
$stmt->execute();
$stmt->bind_result($somme);
$stmt->store_result();
$stmt->fetch();
$stmt->close();
$stmt = $conn->prepare("SELECT prix FROM reservation where id = ?");
$stmt ->bind_param( "s" ,$id_reservation);
$stmt->execute();
$stmt->bind_result($prix);
$stmt->store_result();
$stmt->fetch();
$stmt->close();
$stmt = $conn->prepare("SELECT sum(prix) FROM commande_article where id_reservation = ?");
$stmt ->bind_param( "s" ,$id_reservation);
$stmt->execute();
$stmt->bind_result($article);
$stmt->store_result();
$stmt->fetch();
$stmt->close();
$difference = ( $prix+$article) - $somme;

$xcrud = Xcrud::get_instance();
$xcrud->table('payement');
$xcrud->relation('id_agent','agent','id',array('nom','prenom','cin') , 'agent.type="client"'  );
$xcrud->relation('id_banque','banque','id',array('id','nom','addresse'));
$xcrud->after_insert("reloadPage");
$xcrud->where('id_reserv = ',$id_reservation);
$xcrud->change_type('montant','price',$difference,array('prefix'=>'DT '));
$xcrud->pass_default('id_reserv',"".$id_reservation);
$xcrud->relation('type','mode_pay','id',array('libelle'));
if ( $somme >= $prix+$article) {
    $xcrud->unset_add();
} else{
    $xcrud->set_attr("montant",array("max" => $difference ,"id" => 'montant'));
}
$xcrud->validation_required(array('id_reserv','montant','type','date'));
$xcrud->disabled('id_reserv');
$xcrud->pass_var('id_reserv',"".$id_reservation);
$xcrud->button('recu.php?id={id_reserv}&payment={id}','Recue','glyphicon glyphicon-print ','',array('target'=>'_blank'));
$xcrud->label('id_reserv','Numero reservation');
$xcrud->label('id_agent','Client');
$xcrud->label('id_banque','Banque');
$xcrud->label('mode_payment','Mode de payement');

$xcrud->unset_remove();
$xcrud->unset_csv();
$xcrud->columns('banque,numero,date_echeance,etat', true);
$xcrud->fields('etat',true,true,'create,edit');
//$xcrud->pass_var('date', date('Y-m-d'));
$xcrud->pass_var('etat','non_encaisse');
//$xcrud->where('type =','1');
?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom ">Gestion De Payment</h3>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <?php
                        echo $xcrud->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/altair_admin_common.min.js"></script>
<script>
    $(function() {
        // enable hires images
        altair_helpers.retina_images();
        // fastClick (touch devices)
        if(Modernizr.touch) {
            FastClick.attach(document.body);
        }
    });
</script>
</body>
</html>