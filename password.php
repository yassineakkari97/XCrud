
<?php

include('partials/header.php');


?>


<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom ">Changement de password</h3>

        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <form  id="form_pw" data-parsley-validate >
                            <div class="uk-form-row">
                                <label>Mot de passe actuelle</label>
                                <input type="text" class="md-input" required  />
                            </div>
                            <div class="uk-form-row">
                                <label>Nouvelle mot de passe</label>
                                <input type="text" class="md-input" required data-parsley-minlength="8" />
                            </div>
                            <div class="uk-form-row">
                                <label>Confirmation du mot de passe</label>
                                <input type="text" class="md-input"  required data-parsley-minlength="8" />
                            </div>
                            <div class="uk-form-row">
                                <button type="button" id="btn_change" class="md-btn md-btn-success md-btn-large">Modifier</button>
                            </div>
                        </form>
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
<!-- common functions -->
<script>
    // load parsley config (altair_admin_common.js)
    altair_forms.parsley_validation_config();
</script>
<script src="bower_components/parsleyjs/dist/parsley.min.js"></script>
<script src="bower_components/parsleyjs/src/i18n/fr.js"></script>
<!--  calendar functions -->


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
    function calender(json) {
        var t = $("#calendar_selectable"), a = $('<div id="calendar_colors_wrapper"></div>'),
            e = altair_helpers.color_picker(a).prop("outerHTML");
        t.length && t.fullCalendar({
            header: {
                left: "title today",
                center: "",
                right: "month,agendaWeek,agendaDay prev,next"
            },
            buttonIcons: {
                prev: "md-left-single-arrow",
                next: "md-right-single-arrow",
                prevYear: "md-left-double-arrow",
                nextYear: "md-right-double-arrow"
            },
            buttonText: {today: " ", month: " ", week: " ", day: " "},
            aspectRatio: 2.1,
            defaultDate: moment(),

            timeFormat: "(HH)(:mm)",
            events: json
        })
    };




    $(document).ready(function() {
        $('#btn_change').on("click" , function(e) {


            $('#form_pw').parsley().validate();

            if( $('#form_pw').parsley().isValid()){
                var data = $('#form_pw').serialize();
                $.ajax({
                    type: "PUT",
                    headers:{"Authorizations":"<?php echo $_SESSION['api_key']; ?>"},
                    url: "rest-api/v1/password" ,
                    data:
                    success: function (result) {
                    calender(result.reservation)
                }
            });


            }
        });
    });


</script>
</body>
</html>