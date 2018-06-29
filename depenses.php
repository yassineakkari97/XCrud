<?php
include('partials/header.php');
include('xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();

$xcrud->table('depense');


$dt1 = '';
$dt2 = '';
$date1 = '';
$date2 = '';

if (isset($_POST['type'])){
    if ($_POST['type'] != 'all'){
        $xcrud->where('type = ',$_POST['type']);
        $type= $_POST['type'];
    }
}
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
        $xcrud->where('date >=',$date1);
    }
    elseif  ($_POST['date2']!=""){
        $date2 = $y2 . '-' . $m2 . '-' . $d2;
        $xcrud->where('date <=',$date2);
    }

}
/*$xcrud->columns('date,id_agent,montant,etat,mode_payment,id_banque');

$xcrud->where('operation =', 'Depense');

$xcrud->pass_default('id_reserv','2018-0001');

$xcrud->pass_default('operation','Depense');

$xcrud->fields('date,id_agent,montant,etat,mode_payment,id_banque,id_reserv', false, 'operation','id_reserv');




$xcrud->label('id_banque','Banque');
$xcrud->label('id_agent','Fournisseur');
$xcrud->label('id_reserv','Numero de réservation ');






/*$xcrud->validation_required('mode_payment', 'date' ,'montant');*/


 
$xcrud->relation('banque','banque','id',array('nom','addresse'));

$xcrud->relation('fournisseur','agent','id',array('nom','prenom','cin') , 'agent.type="fournisseur"'  );



$xcrud->unset_csv();
/*
$xcrud->validation_required(array('montant','type','date'));
$xcrud->change_type('montant','price','',array('prefix'=>'DT '));
$xcrud->sum('montant');
$xcrud->pass_var('etat','non_encaisse','create');*/
?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom ">Dépenses</h3>
        <div class="md-card">
            <div class="md-card-content">
                <form method="post" action="depenses.php">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-large-1-3 uk-width-1-1">
                            
                        </div>
                        <div class="uk-width-large-1-3 uk-width-1-1">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                <label for="uk_dp_start">Date de début</label>
                                <input class="md-input" type="text" id="uk_dp_start" name="date1" value="<?php echo $dt1 ?>">
                            </div>
                        </div>
                        <div class="uk-width-large-1-3 uk-width-medium-1-1">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                <label for="uk_dp_end">Date de fin</label>
                                <input class="md-input" type="text" id="uk_dp_end" name="date2" value="<?php echo $dt2 ?>" >
                            </div>
                        </div>
                        <div class="uk-width-large-1-3 uk-width-medium-1-1">
                            <div class="uk-input-group">
                                <button id="btn_filter" type="submit" class="md-btn md-btn-primary">Flitrer</button>
                                <a target="_blank" href="print_prevision.php?" class="md-btn "><i class="uk-icon-print"></i> Imprimer</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
<!-- altair common functions/helpers -->
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
                //format:'YYYY-MM-DD'
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