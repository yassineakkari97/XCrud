<?php
include('../rest-api/include/DbHandler.php');
echo $this->render_table_name($mode);
$db = new DbHandler();
$tar = $db->getArticles();
$id_reservation = $_GET['id'];
//var_dump($id_reservation);

//var_dump($tar); data-task="list"
?>

<div class="xcrud-top-actions btn-group">
    <a id="btn_save"   class="btn btn-primary">Enregistrer et liste</a>
    <?php

    echo $this->render_button('return', 'list', '', 'btn btn-warning'); ?>
</div>
<div class="xcrud-view">
    <div class="tab-content">
        <form id="article_form" class="form-horizontal" data-parsley-validate>
            <div class="form-group ">
                <label class="control-label col-sm-3">Article</label>
                <div class="col-sm-9 uk-form-row">
                    <div class="md-input-wrapper">
                        <select id="article" class="xcrud-input   md-input"  data-type="select" required>
                            <option>Selectionner</option>
                            <?php
                            foreach($tar as $key => $value) {
                                echo ("<option price='".$value["prix_unitaire"]."' value='".$value["id"]."'>".$value["nom"]." " .$value["unite"]."</option>");
                            }
                            ?>
                        </select>
                        <span class="md-input-bar"></span>
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-3">Quantité</label>
                <div class="col-sm-9 uk-form-row">
                    <div class=" uk-form-row parsley-row">
                        <input id="quantite" class=" md-input" type="text" required data-parsley-trigger="keyup"   data-parsley-required-message="Champ requis">
                        <span class="md-input-bar"></span>
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-3">Prix (DT)</label>
                <div class="col-sm-9 uk-form-row">
                    <div class="md-input-wrapper">
                        <input  id="prix" class="xcrud-input md-input" type="text" disabled>
                        <span class="md-input-bar"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<div class="xcrud-nav">
    <?php echo $this->render_benchmark(); ?>
</div>


<script>
    altair_md.init();
    // load parsley config (altair_admin_common.js)
    altair_forms.parsley_validation_config();
</script>
<script src="bower_components/parsleyjs/dist/parsley.min.js"></script>
<script src="bower_components/parsleyjs/src/i18n/fr.js"></script>

<script>
    var $formValidate = $('#article_form');

    $formValidate
        .parsley()
        .on('form:validated',function() {
            altair_md.update_input($formValidate.find('.md-input-danger'));
        })
        .on('field:validated',function(parsleyField) {
            if($(parsleyField.$element).hasClass('md-input')) {
                altair_md.update_input( $(parsleyField.$element) );
            }
        });
    $("select[data-type='select']").chosen();

var ir = localStorage.getItem("id_r");
var pu = 0;
var pf = 0;
    $(function() {
        $("#article").change(function(){
            var element = $(this).find('option:selected');
             pu = element.attr("price");
            pf = pu * $("#quantite").val();
            $('#prix').val(pf);
        });
    });

    $(function() {
        $("#quantite").bind( 'input' ,function(){

           pf = pu * $("#quantite").val();
            $('#prix').val(pf);
        });
    });

    $(function () {

        $("#btn_save").click(function () {
            $('#article_form').parsley().validate();

            if ( $('#article_form').parsley().isValid()){
                var q = $("#quantite").val();
                var a = $('#article').find(":selected").val();
                console.log("pf =" +pf);
                console.log("ir = " +ir);
                $.ajax({
                    type: "POST",
                    headers:{"Authorizations":"<?php echo $_SESSION['api_key']; ?>"},
                    data: {"id_article": a , "id_reservation": ir , "quantite": q, "prix": pf},
                    url: "rest-api/v1/article" ,
                    success: function (result) {
                        location.reload();
                    },
                    error: function (result) {
                        console.log(result);
                    }
                });
            }
        })
    })



</script>

<script>   </script>