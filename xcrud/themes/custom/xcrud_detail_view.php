<?php echo $this->render_table_name($mode); ?>
<div class="xcrud-top-actions btn-group">
    <?php
    echo $this->render_button('save_return','save','list','btn btn-primary','','create,edit');
    echo $this->render_button('save_new','save','create','btn btn-default','','create,edit');
    echo $this->render_button('save_edit','save','edit','btn btn-default','','create,edit');
    echo $this->render_button('return','list','','btn btn-warning'); ?>
</div>
<div class="xcrud-view">
<?php echo $mode == 'view' ? $this->render_fields_list($mode,array('tag'=>'table','class'=>'table')) : $this->render_fields_list($mode,'div','div','label','div'); ?>
</div>
<div class="xcrud-nav">
    <?php echo $this->render_benchmark(); ?>
</div>


<script>
    $("select[data-type='select']").chosen();
    var montant = parseFloat(sessionStorage.getItem("reste"));

    $("#montant").change(function () {
        var tmp = $("#montant").val();
        //console.log(tmp);
        //console.log( montant);
        //console.log( tmp >  montant);
        if(tmp >  montant){
            $("#montant").val(montant);
        }
    });
</script>

<script >  altair_md.init();  </script>