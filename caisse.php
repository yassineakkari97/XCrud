<?php
include('partials/header.php');
include('xcrud/xcrud.php');
$db = Xcrud_db::get_instance();
$xcrud = Xcrud::get_instance();
$xcrud->table('banque');
$xcrud->columns('id,nom,addresse,montant,date_echeance,operation');
$xcrud->relation('type', 'payement', 'id', array('mode_payment'));
$xcrud->label('nom','Nom de Banque');
//$xcrud->validation_required('type,montant,operation,date');
$xcrud->unset_remove();
$xcrud->unset_edit();
$xcrud->unset_csv();
$xcrud->change_type('montant','price','',array('prefix'=>'DT '));
$xcrud->sum('montant');
$xcrud->after_insert("reloadPage");
$db->query('select sum(montant) from payement where (  etat <> "non encaisse" )  ');
$payment = $db -> row()['sum(montant)'];

$db->query('select sum(montant) from depense where ( etat <> "non encaisse" ) ');
$depense = $db -> row()['sum(montant)'];

$db->query('select sum(montant) from banque where operation = "reception"');
$banque_out = $db -> row()['sum(montant)'];

$db->query('select sum(montant) from banque where operation = "transfert"');
$banque_in = $db -> row()['sum(montant)'];
?>

<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom ">Caisse</h3>
        <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
            <!--
            <div class="uk-width-medium-1-1">
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a uk-margin-bottom">Date</h3>
                        <form method="post" action="caisse.php">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-large-1-3 uk-width-1-3">
                                    <div class="uk-input-group">
                                    <span class="uk-input-group-addon"><i
                                                class="uk-input-group-icon uk-icon-calendar"></i></span>
                                        <label for="uk_dp_start">Date de début</label>
                                        <input class="md-input" type="text" id="uk_dp_start" name="date1"
                                               value="<?php //echo $dt1 ?>">
                                    </div>
                                </div>
                                <div class="uk-width-large-1-3 uk-width-medium-1-3">
                                    <div class="uk-input-group">
                                    <span class="uk-input-group-addon"><i
                                                class="uk-input-group-icon uk-icon-calendar"></i></span>
                                        <label for="uk_dp_end">Date de fin</label>
                                        <input class="md-input" type="text" id="uk_dp_end" name="date2"
                                               value="<?php //echo $dt2 ?>">
                                    </div>
                                </div>
                                <div class="uk-width-large-1-3 uk-width-medium-1-3">
                                    <div class="uk-input-group">
                                        <button id="btn_filter" type="submit" class="md-btn md-btn-primary">Flitrer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            -->
            <div class="uk-width-medium-1-3">
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a uk-margin-bottom">Transactions</h3>
                        <div class="uk-overflow-container">
                            <table class="uk-table">
                                <thead>
                                <tr>
                                    <th class="uk-text-nowrap">Type</th>
                                    <th class="uk-text-nowrap">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Paiments clients</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-success">+ <?php if ($payment!= null){echo $payment;}else{echo '0';}?> DT</td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Dépenses</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-danger">- <?php if ($depense!= null){echo $depense;}else{echo '0';}?> DT</td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Solde</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-primary"><?php if ($payment-$depense!= null){echo $payment-$depense;}else{echo '0';}?> DT</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-medium-1-3">
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a uk-margin-bottom">Transactions bancaires</h3>
                        <div class="uk-overflow-container">
                            <table class="uk-table">
                                <thead>
                                <tr>
                                    <th class="uk-text-nowrap">Type</th>
                                    <th class="uk-text-nowrap">Total</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Transfert Banquaire</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-success">+ <?php if ($banque_in != null){echo $banque_in;}else{echo '0';}?> DT</td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Rapatriement Banquaire</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-danger">- <?php if ($banque_out != null){echo $banque_out;}else{echo '0';}?> DT</td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Solde</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-primary"><?php if($banque_in-$banque_out != null){echo $banque_in-$banque_out;}else{echo '0';}?> DT</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-medium-1-3">
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a uk-margin-bottom">Caisse</h3>
                        <div class="uk-overflow-container">
                            <table class="uk-table">
                                <thead>
                                <tr>
                                    <th class="uk-text-nowrap">Type</th>
                                    <th class="uk-text-nowrap">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Réceptions</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-success">+ <?php if ($payment+$banque_out!= null){echo $payment+$banque_out;}else{echo '0';}?> DT</td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Transfert</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-danger">- <?php if ($depense+$banque_in != null){echo $depense+$banque_in;}else{echo '0';}?> DT</td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap">Solde</td>
                                    <td class="uk-width-2-10 uk-text-nowrap uk-text-primary"><?php if (($payment+$banque_out)-($depense+$banque_in)!= null){echo ($payment+$banque_out)-($depense+$banque_in);}else{echo '0';}?> DT</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">Transactions bancaires</h3>
            </div>
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <?php echo $xcrud->render();
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="assets/js/altair_admin_common.min.js"></script>
<script>
    $(function () {
        // enable hires images
        altair_helpers.retina_images();
        // fastClick (touch devices)
        if (Modernizr.touch) {
            FastClick.attach(document.body);
        }
    });
</script>
</body>
</html>