<?php

include('partials/header.php');
include('xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('payement');

$xcrud->relation('id_banque','banque','id',array('id','nom','addresse'));
$xcrud->label('id_banque','Banque');
 

$xcrud->label('id_agent','Client');

$xcrud->label('id_reserv','Réservation');


$xcrud->where('mode_payment =', 'Espèce');



$dt1 = '';
$dt2 = '';
$date1 = '';
$date2 = '';
if (isset($_POST['date1']) and isset($_POST['date2']) ){

    $dt1 = $_POST['date1'];
    $d1 = substr($dt1, 0, 2);
    $m1 = substr($dt1, 3, 2);
    $y1 = substr($dt1, 6, 4);

    $dt2 = $_POST['date2'];
    $d2 = substr($dt2, 0, 2);
    $m2 = substr($dt2, 3, 2);
    $y2 = substr($dt2, 6, 4);

    if ($_POST['date1'] !="" and $_POST['date2']!=""){
        $date1 = $y1 . '-' . $m1 . '-' . $d1;
        $date2 = $y2 . '-' . $m2 . '-' . $d2;
        $xcrud->where('date >=',$date1);
        $xcrud->where('date <=',$date2);
    }
    elseif(($_POST['date1']!="")){
        $date1 = $y1 . '-' . $m1 . '-' . $d1;
        $xcrud->where('date>=',$date1);
    }
    elseif  ($_POST['date2']!=""){
        $date2 = $y2 . '-' . $m2 . '-' . $d2;
        $xcrud->where('date <=',$date2);
    }

}
$xcrud->unset_add();
$xcrud->unset_search();
$xcrud->unset_remove();
$xcrud->unset_csv();
$xcrud->unset_edit();
/*
$xcrud->hide_button('save_edit');
$xcrud->unset_print();
$xcrud->relation('type','mode_pay','id','libelle');
$xcrud->columns('id_reservation,banque,numero,date_echeance,etat,montant');
$xcrud->fields('id_reservation,type,banque,numero,date_echeance,description,date,montant',true,true,'edit');
$xcrud->label('id_reservation','Reservation');
$xcrud->sum('montant');
$xcrud->highlight('etat', '=', 'encaisse', 'lightgreen');
$xcrud->highlight('etat', '=', 'non_encaisse', 'orange');
$xcrud->change_type('montant','price','',array('prefix'=>'DT '));*/
?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom ">Etat de prévision</h3>

        <div class="md-card">
            <div class="md-card-content">
                <form method="post" action="espece.php">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-large-1-3 uk-width-1-1">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                <label for="uk_dp_start">Date de début</label>
                                <input class="md-input" type="text" id="uk_dp_start" name="date1" value="<?php echo $dt1 ?>" >
                            </div>
                        </div>
                        <div class="uk-width-large-1-3 uk-width-medium-1-1">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                <label for="uk_dp_end">Date de fin</label>
                                <input class="md-input" type="text" id="uk_dp_end" name="date2" value="<?php echo $dt2 ?>">
                            </div>
                        </div>
                        <div class="uk-width-large-1-3 uk-width-medium-1-1">
                            <div class="uk-input-group">
                                <button id="btn_filter" type="submit" class="md-btn md-btn-primary">Flitrer</button>
                                <a target="_blank" href="print_prevision.php?<?php echo 'type='.$type.'&date1='.$date1.'&date2='.$date2 ?>" class="md-btn "><i class="uk-icon-print"></i> Imprimer</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <?php echo $xcrud->render() ?>
            </div>
        </div>
    </div>
</div>

<!-- google web fonts -->

<!-- altair common functions/helpers -->
<script src="assets/js/altair_admin_common.min.js"></script>
<!-- common functions -->
<script>
    $(function() {
        // date range
        altair_form_adv.date_range();
    });

    altair_form_adv = {

        // date range
        date_range: function() {
            var $dp_start = $('#uk_dp_start'),
                $dp_end = $('#uk_dp_end');

            var start_date = UIkit.datepicker($dp_start, {
                format:'DD-MM-YYYY'
            });

            var end_date = UIkit.datepicker($dp_end, {
                format:'DD-MM-YYYY'
            });

            $dp_start.on('change',function() {
                end_date.options.minDate = $dp_start.val();
                setTimeout(function() {
                    $dp_end.focus();
                },300);
            });

            $dp_end.on('change',function() {
                start_date.options.maxDate = $dp_end.val();
            });
        }
    };
</script>
</body>
</html>