<?php

include('partials/header.php');
include('xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('utilisateurs');
$xcrud->relation('privilege', 'privilege', 'id', 'libelle');
$xcrud->set_var('nom_table','utilisateurs');
$xcrud->change_type('Titre','select','M.','M.,Mme,Mlle');
$xcrud->change_type('status','bool','1');
$xcrud->columns('password_hash,api_key', true);
$xcrud->fields('password,password_hash,api_key,created_at,updated_at', true);
$xcrud->label('password','Mot de passe par défaut');
$xcrud->label('created_at','Ajouté le');
$xcrud->label('updated_at',"mis à jour le");
$xcrud->label('status','Activé');
$xcrud->change_type('photo', 'image', '', array(
    'path' => '../rest-api/uploadedimages'));
$xcrud->before_insert ("profileinfo");
$xcrud->validation_pattern('email', 'email');
$xcrud->unset_remove();
$xcrud->unset_add($ajouter);
$xcrud->unset_edit($modifier);
$xcrud->unset_view($detail);
$xcrud->validation_required(array('nom','prenom','Titre','email','telephone','CIN/passport'));
$xcrud->create_action('activate', 'activate_action'); // action callback, function publish_action() in functions.php
$xcrud->create_action('desactivate', 'desactivate_action');
$xcrud->unset_csv();
if($supprimer==false){
$xcrud->button('#', 'Désactiver', 'icon-close glyphicon glyphicon-remove ', 'xcrud-action  btn-danger  btn-animate-demo',
    array(  // set action vars to the button
        'data-task' => 'action',
        'data-action' => 'desactivate',
        'data-primary' => '{id}'),
    array(  // set condition ( when button must be shown)
        'status',
        '=',
        '1')
);
$xcrud->button('#', 'Activer', 'icon-checkmark glyphicon glyphicon-ok', 'xcrud-action  btn-success ', array(
    'data-task' => 'action',
    'data-action' => 'activate',
    'data-primary' => '{id}'), array(
    'status',
    '=',
    '0'));
}
?>


<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom ">Gestion Des Utilisateurs</h3>

        <div class="md-card">
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
<!-- google web fonts -->
<script>
    WebFontConfig = {
        google: {
            families: [
                'Source+Code+Pro:400,700:latin',
                'Roboto:400,300,500,700,400italic:latin'
            ]
        }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>

<!-- common functions -->

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


<div id="style_switcher">
    <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
    <div class="uk-margin-medium-bottom">
        <h4 class="heading_c uk-margin-bottom">Colors</h4>
        <ul class="switcher_app_themes" id="theme_switcher">
            <li class="app_style_default active_theme" data-app-theme="">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_a" data-app-theme="app_theme_a">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_b" data-app-theme="app_theme_b">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_c" data-app-theme="app_theme_c">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_d" data-app-theme="app_theme_d">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_e" data-app-theme="app_theme_e">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_f" data-app-theme="app_theme_f">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_g" data-app-theme="app_theme_g">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
        </ul>
    </div>
</div>

<script>
    $(function() {
        var $switcher = $('#style_switcher'),
            $switcher_toggle = $('#style_switcher_toggle'),
            $theme_switcher = $('#theme_switcher'),
            $mini_sidebar_toggle = $('#style_sidebar_mini'),
            $boxed_layout_toggle = $('#style_layout_boxed'),
            $body = $('body');


        $switcher_toggle.click(function(e) {
            e.preventDefault();
            $switcher.toggleClass('switcher_active');
        });

        $theme_switcher.children('li').click(function(e) {
            e.preventDefault();
            var $this = $(this),
                this_theme = $this.attr('data-app-theme');

            $theme_switcher.children('li').removeClass('active_theme');
            $(this).addClass('active_theme');
            $body
                .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g')
                .addClass(this_theme);

            if(this_theme == '') {
                localStorage.removeItem('altair_theme');
            } else {
                localStorage.setItem("altair_theme", this_theme);
            }

        });

        // hide style switcher
        $document.on('click keyup', function(e) {
            if( $switcher.hasClass('switcher_active') ) {
                if (
                    ( !$(e.target).closest($switcher).length )
                    || ( e.keyCode == 27 )
                ) {
                    $switcher.removeClass('switcher_active');
                }
            }
        });

        // get theme from local storage
        if(localStorage.getItem("altair_theme") !== null) {
            $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
        }


        // toggle mini sidebar

        // change input's state to checked if mini sidebar is active
        if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
            $mini_sidebar_toggle.iCheck('check');
        }

        $mini_sidebar_toggle
            .on('ifChecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.setItem("altair_sidebar_mini", '1');
                location.reload(true);
            })
            .on('ifUnchecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.removeItem('altair_sidebar_mini');
                location.reload(true);
            });


        // toggle boxed layout

        // change input's state to checked if mini sidebar is active
        if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
            $boxed_layout_toggle.iCheck('check');
            $body.addClass('boxed_layout');
            $(window).resize();
        }

        // toggle mini sidebar
        $boxed_layout_toggle
            .on('ifChecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.setItem("altair_layout", 'boxed');
                location.reload(true);
            })
            .on('ifUnchecked', function(event){
                $switcher.removeClass('switcher_active');
                localStorage.removeItem('altair_layout');
                location.reload(true);
            });


    });
</script>
</body>
</html>