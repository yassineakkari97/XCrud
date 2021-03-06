<!doctype html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="fr"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="fr"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>


    <link rel="icon"  href="assets/img/favicon-32x32.png" >

    <title>Sofetes</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="assets/css/login_page.min.css"/>
    <!-- uikit -->

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
    <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
    <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->


    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
</head>
<body class="login_page">
<?php if (isset($_GET['error'])) {
    ?>
    <script> UIkit.notify("Veuillez vérivier vos paramètres de connexion : <?php echo $_GET['error'] ?>", {
            status: 'danger',
            pos: 'bottom-center',
            timeout: 6500
        });</script>
    <?php
}
?>

<div class="login_page_wrapper">

    <div class="md-card" id="login_card" >
        <div class="md-card-content large-padding" id="login_form">
            <div class="login_heading">
                <div class="user_avatar"></div>
            </div>
            <form method="post" action="login.php" id="form_validation" class="uk-form-stacked" novalidate="">

                   
                     <label for="ancien"> Mot de passe actuel <span class="req">*</span></label>
                                <input id='ancien' class="md-input" type="password" name="ancien"
                                       data-parsley-trigger="keyup" data-parsley-minlength="4"
                                       data-parsley-validation-threshold="3"
                                       data-parsley-required-message="Champ requis"
                                       data-parsley-minlength-message="Le Mot de passe doit être supérieur à 4 caractères"
                                       required/>
                 <label for="nv"> Nouveau mot de passe<span class="req">*</span></label>
                                <input id='nv' class="md-input" type="password" name="nv" data-parsley-diff=""
                                       data-parsley-trigger="keyup" data-parsley-minlength="4"
                                       data-parsley-required-message="Champ requis"
                                       data-parsley-validation-threshold="3"
                                       data-parsley-minlength-message="Le Mot de passe doit être supérieur à 4 caractères"
                                       data-parsley-diff-message=" Votre nouveau mot de passe ne doit pas être identique au mot de passe actuel"

                                       required/>

                   <div class="uk-form-row parsley-row">
                                <label for="cnv">Confirmer le nouveau mot de passe<span class="req">*</span></label>
                                <input id='cnv' class="md-input" type="password" name="cnv" data-parsley-trigger="keyup"
                                       data-parsley-equalto="#nv"
                                       data-parsley-minlength="4" data-parsley-validation-threshold="3"
                                       data-parsley-required-message="Champ requis"
                                       data-parsley-equalto-message="Cette valeur doit etre la meme que celle du nouveaux mots de passe"
                                       data-parsley-minlength-message="Le Mot de passe doit être supérieur à 4 caractères"
                                       required/>
                            </div>

                <div class="uk-margin-medium-top">
                    <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Confirmer</button>
                </div>

            </form>
        </div>

    </div>

</div>

<!-- common functions -->
<script src="assets/js/common.min.js"></script>
<!-- uikit functions -->
<script src="assets/js/uikit_custom.min.js"></script>
<!-- altair common functions/helpers -->
<script src="assets/js/altair_admin_common.min.js"></script>

<!-- page specific plugins -->
<!-- parsley (validation) -->
<script>
    // load parsley config (altair_admin_common.js)
    altair_forms.parsley_validation_config();
</script>
<script src="bower_components/parsleyjs/dist/parsley.min.js"></script>

<script src="bower_components/parsleyjs/src/i18n/fr.js"></script>

<!--  forms validation functions -->
<script src="assets/js/pages/forms_validation.min.js"></script>

</body>
</html>