<?php include ('xcrud.php');
header('Content-Type: text/html; charset=' . Xcrud_config::$mbencoding);
?>
<!--
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
    </head>
    <body >
    <div style=" font-size: smaller;">
        <div style=" display: inline-block;width: 32%; text-align: center;">
            Sté SOFETES Sarl<br>Salle des fêtes<br>Ksar Ezzit Echrek Birbouregba 8042<br>MF: 1527565 RAM 000<br>R.C: B07168712017
        </div>
        <div style="display: inline-block;width: 34%"><img src="./../assets/img/logo.png" alt="logo" style="display: block;margin-left: auto ;margin-right: auto; width:100px;"></div>
        <div style=" display: inline-block; width: 32%;text-align: center;">
            Site Web: www.sofetes.com<br>Email: contact@sofetes.com<br>Tel: 72 317 897<br>Fax: 72 317 896<br>GSM : 58 443 034
        </div>

    </div>*-->
<?php
echo Xcrud::get_requested_instance();
