<?php
include('partials/header.php');
include ('rest-api/include/DbHandler.php');
include('xcrud/xcrud.php');
$db = new DbHandler();
$xcrud = Xcrud::get_instance();
$xcrud->table('reservation');

$xcrud->default_tab('reservation');

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

$xcrud->validation_required('date,heure_debut,heure_fin,id_client,prix');
$xcrud->relation('id_client','agent','id',array('nom','prenom','cin') , 'agent.type="client"'  );
$xcrud->relation('id_banque','banque','id',array('id','nom','addresse'));
$xcrud->label('id_client','client');
$xcrud->label('id','Numero');
$xcrud->fields('id',true);



$xcrud->pass_var('id',$db->getLastNumber(),'create');
$xcrud->after_insert("reloadPage");
$xcrud->subselect('Prix article','SELECT COALESCE (SUM(c.prix),0) FROM commande_article c WHERE c.id_reservation = {id}');
$xcrud->subselect('Total','{prix}+{Prix article}');
$xcrud->subselect('Paye','SELECT COALESCE (sum(montant),0) FROM payement t,reservation WHERE t.id_reserv={id}');
$xcrud->subselect('Reste a payer','{Total}-{Paye}');

$xcrud->label('heure_debut','Debut');
$xcrud->label('heure_fin','Fin');
$xcrud->label('Total','Total (DT)');
$xcrud->label('Paye','Payé (DT)');
$xcrud->label('Reste a payer','Reste (DT)');
$xcrud->change_type('Total','price','{prix}');
$xcrud->change_type('Prix article','price','0');
$xcrud->change_type('Paye','price','0');
$xcrud->change_type('Reste a payer','price','{Total}');
$xcrud->change_type('prix','price','0');
$xcrud->highlight('Paye','<','{Total}','#d2322d');
$xcrud->highlight('Paye','=','{Total}','#47a447');
$xcrud->highlight('Reste a payer','>','0','orange');
$xcrud->highlight('Reste a payer','=','0','#47a447');
$xcrud->button('payment.php?id={id}','Payer','glyphicon glyphicon-euro','btn-success');
$xcrud->button('articles.php?id={id}','Articles','glyphicon glyphicon-glass','btn-info');
$xcrud->button('contrat.php?id={id}','Contrat','glyphicon glyphicon-print ','',array('target'=>'_blank'));

$xcrud->unset_csv();
$xcrud->unset_print();
$xcrud->hide_button('save_new');
?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom ">Gestion Des Reservations</h3>
       <div class="md-card">
            <div class="md-card-content">
                <form method="post" action="reservation.php">
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
<!--
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
-->
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