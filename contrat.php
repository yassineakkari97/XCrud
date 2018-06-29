<?php

require_once 'rest-api/include/DbConnect.php';
include('xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
if (isset($_GET["id"])) {
    $db = new DbConnect();
    $conn = $db->connect();

    $id_reservation = $_GET["id"];
    $stmt = $conn->prepare("SELECT c.`nom`, c.`prenom`, c.`cin`,c.`cin_date`, c.`adresse`,c.`phone`,r.`id` , r.`date`,r.`heure_debut`,r.`heure_fin`, r.`observation`, r.`prix` FROM `agent` c, `reservation` r  WHERE r.`id` =? and r.`id_client` = c.`id`");
    $stmt->bind_param("s", $id_reservation);
    $stmt->execute();
    $stmt->bind_result($nom, $prenom, $cin, $cin_date, $adresse, $phone, $numero_r, $date_r, $start, $end, $observation, $prix);
    $stmt->store_result();
    $stmt->fetch();
    $stmt->close();
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <link rel="stylesheet" href="xcrud/themes/bootstrap/xcrud.css">
        <style>
            body {
                height: 842px;
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
    <body >
    <div style=" font-size: smaller;">
        <div style=" display: inline-block;width: 32%; text-align: center;">
            Sté SOFETES Sarl<br>Salle des fêtes<br>Ksar Ezzit Echrek Birbouregba 8042<br>MF: 1527565 RAM 000<br>R.C: B07168712017
        </div>
        <div style="display: inline-block;width: 34%"><img src="assets/img/logo.png" alt="logo" style="display: block;margin-left: auto ;margin-right: auto; width:100px;"></div>
        <div style=" display: inline-block; width: 32%;text-align: center;">
            Site Web: www.sofetes.com<br>Email: contact@sofetes.com<br>Tel: 72 317 897<br>Fax: 72 317 896<br>GSM : 58 443 034
        </div>

    </div>

    <div style="text-align: center; font-size: large;  font-weight: bold; margin-top: 20px "><br><br><?php echo('CONTRAT N°  ' . $numero_r); ?><br><br><br><br></div>
    <div>
        <p>
            <b><u>Désignation des Parties</u></b><br>
            Entre SOFETES représentée par Mme Yousfi Aouicha ou Mme Mansouri Maroua en qualité Gérantes d'une part et entre
            <?php echo('Mr (ou Mme) : <b>' . $nom . " " . $prenom . '</b>') ?>
            <?php echo(' titulaire de CIN n° : <b>' . $cin . '</b>');
            if ($cin_date <> NULL) {
                echo(' Délivrée le ' . $cin_date . ' à Tunis');
            } ?><br>
            <?php echo('Adresse : <b>' . $adresse . '</b>') ?><br>
            <?php echo('Numéro de téléphone : <b>' . $phone . '</b>') ?><br>
            <?php echo ('Date de manifestation : <b>' . $date_r) . '</b>' ?><br>
            <?php echo ('Prix de location : <b>' . $prix) . '  DT </b>' ?><br><br>

            <b><u>Mode de Règlement</u></b><br>
            ** 30% à la signature du contrat pour la reservation.<br>
            ** 70% une semaine avant la date de la cérémonie.<br>
            NB : le montant total y compris 4 serveurs, verres, carafes, plateaux...<br><br>

            <b><u>Détails</u></b><br>
            <?php echo('Démarrage de la soirée : <b>' . $start . '</b>') ?> <br>
            <?php echo('Cloture de la soirée : <b>' . $end . '</b>') ?> <br><br>

            <b><u>Procédure interne :</u></b><br>
            * Les Hotesses d'acceuil seront parmis les locataires de la salle pour recevoir les invités.<br>
            * Toutes fourniture exemple (jus,patisserie ou autres, seront deposés d'avance à notre économas et au moment
            de la distribution, le locataire a plein droit de recommander un(e) responsable pour le contrôle de service.<br>
            * Les boissons alcooliques sont srtictement interdit à l'interieur de la salle, au parking et à chaque coin
            de l'espace. En cas de dépassement, on cloture automatiquement la soirée.<br>
            * En cas d'annulation de la réservation l'accompte ne sera pas remboursé par le client quelque soit la
            raison. Sauf si la soirée elle-même sera transférer vers autre personne.<br>
            NB : l'annulation sera réclamer avant 60 jours minimum.<br><br>

            <b><u>Stationnement des voitures au parking</u></b><br>
            * Les invités sont obligés de respecter les procédures internes pour les stationnements.<br>
            * La fermeture des voitures est obligatoire.
        </p>
    </div>
    <div>
        <div style=" display: inline-block;width: 32%; text-align: center;">Lu et approuvé :<br> Mr/Mme</div>
        <div style="display: inline-block;width: 34%"></div>
        <div style=" display: inline-block; width: 32%;text-align: center;">Lu et approuvé :<br>Sté SOFETES</div>
    </div>


    <?php
    $stmt = $conn->prepare("SELECT  SUM(`prix`) FROM commande_article  WHERE `id_reservation`=? ");
    $stmt->bind_param("s", $id_reservation);
    $stmt->execute();
    $stmt->bind_result($article);
    $stmt->store_result();
    $stmt->fetch();
    $stmt->close();
    if ($article <> NULL) {
        ?>
        <!-- Divider -->
        <div style="height: 200px;
                width: 200px;
                /* to centre page on screen*/
                margin-left: auto;
                margin-right: auto;"></div>
        <!-- Contrat Fourniture -->
        <div style=" font-size: smaller;">
            <div style=" display: inline-block;width: 32%; text-align: center;">
                Sté SOFETES Sarl<br>Ksar Ezzit Echrek Birbouregba 8042<br>MF: 1527565 RAM 000<br>R.C: B07168712017
            </div>
            <div style="display: inline-block;width: 34%"><img src="assets/img/logo.png" alt="logo" style="display: block;margin-left: auto ;margin-right: auto; width:100px;"></div>
            <div style=" display: inline-block; width: 32%;text-align: center;">
                Site Web: www.sofetes.com<br>Email: contact@sofetes.com<br>Tel: 72 317 897<br>Fax: 72 317 896
            </div>

        </div>

        <div style="text-align: center; font-size: large;  font-weight: bold; margin-top: 20px "> <br><br>CONTRAT FOURNITURE<br>
        </div>
        <div align="center"
             style="align-content: center; font-size: small;  font-weight: bold; margin-top: 20px "><?php echo("Contrat n°  " . $id_reservation) ?><br><br><br><br>
        </div>
        <div>
            <p>
                <b><u>Désignation des Parties</u></b><br>
                Entre SOFETES représentée par Mme Yousfi Aouicha ou Mme Mansouri Maroua en qualité Gérantes d'une part
                et entre
                <?php echo('Mr (ou Mme) : <b>' . $nom . " " . $prenom . '</b>') ?>
                <?php echo(' titulaire de CIN n° : <b>' . $cin . '</b>');
                if ($cin_date <> NULL) {
                    echo(' Délivrée le ' . $cin_date . ' à Tunis');
                } ?><br>
                <?php echo('Adresse : <b>' . $adresse . '</b>') ?><br>
                <?php echo('Numéro de téléphone : <b>' . $phone . '</b>') ?><br>
                <?php echo ('Date de manifestation : <b>' . $date_r) . '</b>' ?><br>
                <br>
                <b><u>Détails</u></b><br>
                <?php echo('Démarrage de la soirée : <b>' . $start . '</b>') ?> <br>
                <?php echo('Cloture de la soirée : <b>' . $end . '</b>') ?> <br><br>
                <b><u>Service interne: Fourniture</u></b>
            <table class="xcrud-list table table-striped table-hover table-bordered">
                <thead>
                <tbody>
                <tr class="xcrud-th">
                    <th class="xcrud-column">Article</th>
                    <th class="xcrud-column">Quantite</th>
                    <th class="xcrud-column">Prix (dt)</th>
                </tr>
                </thead>
                <?php
                $stmt = $conn->prepare("SELECT c.`quantite`, c.`prix`, c.`id_article`, a.`nom`, a.`unite` FROM commande_article c, articles a WHERE c.`id_reservation`=? AND c.`id_article`=a.`id`");
                $stmt->bind_param("s", $id_reservation);

                if ($stmt->execute()) {
                    $stmt->bind_result($quantite, $prix, $id_article, $nom_a, $unite);
                    $i = 0;
                    while ($stmt->fetch()) {
                        echo '<tr class="xcrud-row xcrud-row-' . $i . '"><td>' . $nom_a . $unite . ' </td><td>' . $quantite . '</td><td>' . $prix . '</td></tr>';
                        if ($i == 0) {
                            $i = 1;
                        } else {
                            $i = 0;
                        }
                    }
                    $stmt->close();
                }
                ?>
                </tbody>
            </table>
            <?php
            echo("<b>Prix totale d'articles = " . $article . " (dt) </b> <br><br>");

            if ($observation <> NULL) {
                echo('<b><u>Observation :</u></b><br>' . $observation . ' <br><br>');
            }
            ?>
            </p>
        </div>
        <div class="uk-grid">
            <div style=" display: inline-block;width: 32%; text-align: center;">Lu et approuvé :<br> Mr/Mme</div>
            <div style="display: inline-block;width: 34%"></div>
            <div style=" display: inline-block; width: 32%;text-align: center;">Lu et approuvé :<br> Sté SOFETES</div>
        </div>
        <!-- Fin  Fourniture-->
        <?php
    }
    ?>
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
