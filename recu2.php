<?php
require_once 'rest-api/include/DbConnect.php';
if (isset($_GET["id"]) and isset($_GET["payment"])) {
    $db = new DbConnect();
    $conn = $db->connect();
    $id_reservation = $_GET["id"];
    $id_payment = $_GET["payment"];
    $stmt = $conn->prepare("SELECT c.`nom`, c.`prenom`, c.`cin`,c.`cin_date`, c.`adresse`,c.`phone`, r.`date`,r.`heure_debut`,r.`heure_fin`,r.`prix` FROM `client` c, `reservation` r  WHERE r.`id` =? and r.`id_client` = c.`id`");
    $stmt->bind_param("s", $id_reservation);
    $stmt->execute();
    $stmt->bind_result($nom, $prenom, $cin, $cin_date, $adresse, $phone, $date_r, $start, $end, $prix);
    $stmt->store_result();
    $stmt->fetch();
    $stmt->close();
    // Payment
    $stmt = $conn->prepare("SELECT sum(montant) FROM payment where id_reservation = ?");
    $stmt->bind_param("s", $id_reservation);
    $stmt->execute();
    $stmt->bind_result($somme);
    $stmt->store_result();
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT montant  FROM payment where id_reservation = ? and id = ?");
    $stmt->bind_param("si", $id_reservation, $id_payment);
    $stmt->execute();
    $stmt->bind_result($montant);
    $stmt->store_result();
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT sum(prix) FROM commande_article where id_reservation = ?");
    $stmt->bind_param("s", $id_reservation);
    $stmt->execute();
    $stmt->bind_result($article);
    $stmt->store_result();
    $stmt->fetch();
    $stmt->close();
    $total = $prix + $article;
    $reste = $total - $somme;
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <style>
            body {
                height: 850px;
                width: 650px;
                /* to centre page on screen*/
                margin-left: auto;
                margin-right: auto;
            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
            }

            table {
                max-width: 100%;
                background-color: transparent;
            }

            th {
                text-align: left;
            }

            .table {
                width: 100%;
                margin-bottom: 20px;
            }

            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                padding: 8px;
                *vertical-align: top;
                border-top: 1px solid #dddddd;
            }

            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 2px solid #dddddd;
            }

            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }

            .table > tbody + tbody {
                border-top: 2px solid #dddddd;
            }

            .table .table {
                background-color: #ffffff;
            }

            .table-condensed > thead > tr > th,
            .table-condensed > tbody > tr > th,
            .table-condensed > tfoot > tr > th,
            .table-condensed > thead > tr > td,
            .table-condensed > tbody > tr > td,
            .table-condensed > tfoot > tr > td {
                padding: 5px;
            }

            .table-bordered {
                border: 1px solid #dddddd;
            }

            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
                border: 1px solid #dddddd;
            }

            .table-bordered > thead > tr > th,
            .table-bordered > thead > tr > td {
                border-bottom-width: 2px;
            }

            .table-striped > tbody > tr:nth-child(odd) > td,
            .table-striped > tbody > tr:nth-child(odd) > th {
                background-color: #f9f9f9;
            }

            table col[class*="col-"] {
                display: table-column;
                float: none;
            }

            table td[class*="col-"],
            table th[class*="col-"] {
                display: table-cell;
                float: none;
            }

            .panel > .table-bordered > thead > tr > th:first-child,
            .panel > .table-responsive > .table-bordered > thead > tr > th:first-child,
            .panel > .table-bordered > tbody > tr > th:first-child,
            .panel > .table-responsive > .table-bordered > tbody > tr > th:first-child,
            .panel > .table-bordered > tfoot > tr > th:first-child,
            .panel > .table-responsive > .table-bordered > tfoot > tr > th:first-child,
            .panel > .table-bordered > thead > tr > td:first-child,
            .panel > .table-responsive > .table-bordered > thead > tr > td:first-child,
            .panel > .table-bordered > tbody > tr > td:first-child,
            .panel > .table-responsive > .table-bordered > tbody > tr > td:first-child,
            .panel > .table-bordered > tfoot > tr > td:first-child,
            .panel > .table-responsive > .table-bordered > tfoot > tr > td:first-child {
                border-left: 0;
            }

            .panel > .table-bordered > thead > tr > th:last-child,
            .panel > .table-responsive > .table-bordered > thead > tr > th:last-child,
            .panel > .table-bordered > tbody > tr > th:last-child,
            .panel > .table-responsive > .table-bordered > tbody > tr > th:last-child,
            .panel > .table-bordered > tfoot > tr > th:last-child,
            .panel > .table-responsive > .table-bordered > tfoot > tr > th:last-child,
            .panel > .table-bordered > thead > tr > td:last-child,
            .panel > .table-responsive > .table-bordered > thead > tr > td:last-child,
            .panel > .table-bordered > tbody > tr > td:last-child,
            .panel > .table-responsive > .table-bordered > tbody > tr > td:last-child,
            .panel > .table-bordered > tfoot > tr > td:last-child,
            .panel > .table-responsive > .table-bordered > tfoot > tr > td:last-child {
                border-right: 0;
            }

            .panel > .table-bordered > thead > tr:last-child > th,
            .panel > .table-responsive > .table-bordered > thead > tr:last-child > th,
            .panel > .table-bordered > tbody > tr:last-child > th,
            .panel > .table-responsive > .table-bordered > tbody > tr:last-child > th,
            .panel > .table-bordered > tfoot > tr:last-child > th,
            .panel > .table-responsive > .table-bordered > tfoot > tr:last-child > th,
            .panel > .table-bordered > thead > tr:last-child > td,
            .panel > .table-responsive > .table-bordered > thead > tr:last-child > td,
            .panel > .table-bordered > tbody > tr:last-child > td,
            .panel > .table-responsive > .table-bordered > tbody > tr:last-child > td,
            .panel > .table-bordered > tfoot > tr:last-child > td,
            .panel > .table-responsive > .table-bordered > tfoot > tr:last-child > td {
                border-bottom: 0;
            }

        </style>
        <meta charset="utf-8">
    </head>
    <body>


    <!--==================== 1er recue ====================-->
    <div style=" font-size: smaller;">
        <div style=" display: inline-block;width: 32%; text-align: center;">
            <img src="assets/img/logo.png" alt="logo"
                 style="display: block;margin-left: auto ;margin-right: auto; width:150px;">
        </div>
        <div style="display: inline-block;  width: 34%"></div>
        <div style=" display: inline-block; width: 32%;text-align: center;">
            Sté SOFETES Sarl<br>Ksar Ezzit Echrek Birbouregba 8042<br>MF: 1527565 RAM 000<br>R.C: B07168712017

        </div>

    </div>
    <div style="text-align: center; margin-top:10px ">
        <span style="text-align: center; font-size: large;  font-weight: bold;  "><?php echo("RECU DE PAIMENT N°  " . $id_payment) ?></span><br>
        <span style="text-align: center; font-size: small;  font-weight: bold;  "><?php echo("Contrat n°  " . $id_reservation) ?>
    </span>
    </div>
    <div align="left" style="font-size: small">
        <p>
            <b><u>Désignation des Parties</u></b><br>
            Entre SOFETES et <?php echo(' Mr (ou Mme) : <b>' . $nom . " " . $prenom . '</b>') ?>
            <?php echo(' titulaire de CIN n° : <b>' . $cin . '</b>');
            if ($cin_date <> NULL) {
                echo(' Délivrée le ' . $cin_date . ' à Tunis');
            } ?> <br>
            <?php echo('Adresse : <b>' . $adresse . '</b>') ?><br>
            <?php echo('Numéro de téléphone : <b>' . $phone . '</b>') ?><br>
            <?php echo('Date de manifestation : <b>' . $date_r . '</b>') ?><br>
            <?php echo('Heure Début : <b>' . $start . '</b>,   Heure Fin : <b>' . $end . '</b>') ?><br><br>
            <b><u>Mode de Règlement</u></b>
        </p>
        <table class="xcrud-list table table-striped table-hover table-bordered">
            <thead>
            <tr class="xcrud-th">
                <th class="xcrud-column">Total de la soirée</th>
                <th class="xcrud-column">Avance</th>
                <th class="xcrud-column">Reste</th>
            </tr>
            </thead>
            <tbody>
            <?php
            echo '<tr class="xcrud-row xcrud-row-1"><td>' . $total . '  DT</td><td>' . $montant . '  DT</td><td>' . $reste . '  DT</td></tr>';
            ?>
            </tbody>
        </table>

        NB : Le reste du montant doit étre soldée une semaine avant la date de cérémonie.

    </div>
    <div>
        <div style=" display: inline-block;width: 32%; text-align: center;">Lu et approuvé :<br> Mr/Mme</div>
        <div style="display: inline-block;width: 34%"></div>
        <div style=" display: inline-block; width: 32%;text-align: center;">Lu et approuvé :<br> Sté SOFETES</div>
    </div>
    <br><br><br>
    <hr>
    <div style=" font-size: small; text-align: center">
        Site Web: www.sofetes.com - Email: contact@sofetes.com - Tel: 72 317 897 - Fax: 72 317 896 - GSM : 58 443 034
    </div>
    <!--==================== Fin de 1er recue ====================-->

    <hr>


    <!--==================== 2 emme recue ====================-->
    <div style=" font-size: smaller;">
        <div style=" display: inline-block;width: 32%; text-align: center;">
            <img src="assets/img/logo.png" alt="logo"
                 style="display: block;margin-left: auto ;margin-right: auto; width:150px;">
        </div>
        <div style="display: inline-block;  width: 34%"></div>
        <div style=" display: inline-block; width: 32%;text-align: center;">
            Sté SOFETES Sarl<br>Ksar Ezzit Echrek Birbouregba 8042<br>MF: 1527565 RAM 000<br>R.C: B07168712017

        </div>

    </div>
    <div style="text-align: center; margin-top:10px ">
        <span style="text-align: center; font-size: large;  font-weight: bold;  "><?php echo("RECU DE PAIMENT N°  " . $id_payment) ?></span><br>
        <span style="text-align: center; font-size: small;  font-weight: bold;  "><?php echo("Contrat n°  " . $id_reservation) ?>
    </span>
    </div>
    <div align="left" style="font-size: small">
        <b><u>Désignation des Parties</u></b><br>
        Entre SOFETES et <?php echo(' Mr (ou Mme) : <b>' . $nom . " " . $prenom . '</b>') ?>
        <?php echo(' titulaire de CIN n° : <b>' . $cin . '</b>');
        if ($cin_date <> NULL) {
            echo(' Délivrée le ' . $cin_date . ' à Tunis');
        } ?> <br>
        <?php echo('Adresse : <b>' . $adresse . '</b>') ?><br>
        <?php echo('Numéro de téléphone : <b>' . $phone . '</b>') ?><br>
        <?php echo('Date de manifestation : <b>' . $date_r . '</b>') ?><br>
        <?php echo('Heure Début : <b>' . $start . '</b>,   Heure Fin : <b>' . $end . '</b>') ?><br><br>
        <b><u>Mode de Règlement</u></b><br>
        <table class="xcrud-list table table-striped table-hover table-bordered">
            <thead>

            <tr class="xcrud-th">
                <th class="xcrud-column">Total de la soirée</th>
                <th class="xcrud-column">Avance</th>
                <th class="xcrud-column">Reste</th>
            </tr>
            </thead>
            <tbody>
            <?php
            echo '<tr class="xcrud-row xcrud-row-1"><td>' . $total . '  DT</td><td>' . $montant . '  DT</td><td>' . $reste . '  DT</td></tr>';
            ?>
            </tbody>
        </table>
        NB : Le reste du montant doit étre soldée une semaine avant la date de cérémonie.<br>

    </div>
    <div>
        <div style=" display: inline-block;width: 32%; text-align: center;">Lu et approuvé :<br> Mr/Mme</div>
        <div style="display: inline-block;width: 34%"></div>
        <div style=" display: inline-block; width: 32%;text-align: center;">Lu et approuvé :<br> Sté SOFETES</div>
    </div>
    <br><br><br>
    <hr>
    <div style=" font-size: smaller;">
        Site Web: www.sofetes.com - Email: contact@sofetes.com - Tel: 72 317 897 - Fax: 72 317 896 - GSM : 58 443 034
    </div>

    <!--==================== fin 2 emme recu ====================-->

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
