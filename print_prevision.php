<?php

$type = 'all';
$date1 = '';
$date2 = '';

include('xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();

$xcrud->table('payment');

$xcrud->unset_add();
$xcrud->unset_edit();
$xcrud->unset_remove();
$xcrud->unset_view();
$xcrud->unset_csv();
$xcrud->unset_limitlist();
$xcrud->unset_numbers();
$xcrud->unset_pagination();
$xcrud->unset_print();
$xcrud->unset_search();
$xcrud->unset_title();
$xcrud->unset_sortable();

$xcrud->relation('type', 'mode_pay', 'id', 'libelle');
$xcrud->columns('id_reservation,type,banque,numero,date_echeance,montant');
$xcrud->label('id_reservation', 'Reservation');
$xcrud->sum('montant');

if (isset($_GET["type"]) and isset($_GET['date1']) and isset($_GET['date2'])) {
    if ($_GET['type'] != 'all') {
        $xcrud->where('type = ', $_GET['type']);
        $type = $_GET['type'];
    } else {
        $type = 'all';
    }
    if ($_GET['date1'] != "" and $_GET['date2'] != "") {
        $date1 = $_GET['date1'];
        $date2 = $_GET['date2'];
        $xcrud->where('date_echeance >=', $date1);
        $xcrud->where('date_echeance <=', $date2);

    } elseif ($_GET['date2'] != "") {
        $date2 = $_GET['date2'];
        $xcrud->where('date_echeance <=', $date2);

    } elseif (($_GET['date1'] != "")) {
        $date1 = $_GET['date1'];
        $xcrud->where('date_echeance >=', $date1);
    }

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <div style=" font-size: smaller;">
        <div style=" display: inline-block;width: 32%; text-align: center;">
            Sté SOFETES Sarl<br>Salle des fêtes<br>Ksar Ezzit Echrek Birbouregba 8042<br>MF: 1527565 RAM 000<br>R.C:
            B07168712017
        </div>
        <div style="display: inline-block;width: 34%"><img src="assets/img/logo.png" alt="logo"
                                                           style="display: block;margin-left: auto ;margin-right: auto; width:100px;">
        </div>
        <div style=" display: inline-block; width: 32%;text-align: center;">
            Site Web: www.sofetes.com<br>Email: contact@sofetes.com<br>Tel: 72 317 897<br>Fax: 72 317 896<br>GSM : 58
            443 034
        </div>
    </div>
    <div>
        <br><br>
        <?php
        $y1 = substr($date1, 0, 4);
        $m1 = substr($date1, 5, 2);
        $d1 = substr($date1, 8, 2);
        $dt1 = $d1 . '/' . $m1 . '/' . $y1;

        $y2 = substr($date2, 0, 4);
        $m2 = substr($date2, 5, 2);
        $d2 = substr($date2, 8, 2);
        $dt2 = $d2 . '/' . $m2 . '/' . $y2;

        if ($date1 != '') {
            echo 'Date de Début : ' . $dt1 . '<br>';
        }
        if ($date2 != '') {
            echo 'Date de Fin : ' . $dt2;
        }

        echo $xcrud->render(); ?>
    </div>
    </body>
    </html>
    <?php
} else {
    header("location:dashboard.php");
}
?>
<script>
    window.print();
</script>
