<?php
include('partials/header.php');
include('xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('agent');
$xcrud->where('type =', 'fournisseur');

$xcrud->fields('type', true);
$xcrud->pass_default('type','fournisseur');
$xcrud->unset_csv();

/*$xcrud->default_tab('personne');
$xcrud->validation_required(array('nom', 'prenom', 'id', 'phone', 'cin', 'adresse', 'code-postale', 'ville'));
$xcrud->validation_pattern(array('nom' => '[a-zA-Z]{3,14}', 'prenom' => '[a-zA-Z]{3,14}', 'phone' => 'numeric', 'cin'=> 'numeric' , 'email'=> 'email', 'adresse' => '[a-zA-Z]{3,14}', 'code-postale'=> 'numeric' , 'ville'=> 'alpha'));

$xcrud->unset_csv();
/*
$xcrud->hide_button('save_new,save_edit');
$depenses = $xcrud->nested_table("Dépenses","id","depense","fournisseur");
$depenses->columns('fournisseur',true);
$depenses->relation('type','mode_pay','id','libelle');
$depenses->sum('montant');
$depenses->unset_add();
$depenses->unset_edit();
$depenses->unset_remove();
$depenses->unset_view();
$depenses->unset_csv();
$depenses->unset_limitlist();
$depenses->unset_numbers();
$depenses->unset_pagination();
$depenses->unset_print();
$depenses->unset_search();
$depenses->unset_title();
$depenses->unset_sortable();
$depenses->change_type('montant','price','',array('prefix'=>'DT '));*/
?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom ">Gestion Des Fournisseurs</h3>
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
</body>
</html>