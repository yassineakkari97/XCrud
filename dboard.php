<?php
include('partials/header.php');
?>

<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">

<!-- ==================== chart css ====================  -->
<link rel="stylesheet" href="d/c3.css">
<link rel="stylesheet" href="d/metricsgraphics.css">
<link rel="stylesheet" href="d/chartist.css">

<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom ">Tableau de bord</h3>

        <!-- ==================== statistics (small charts) ==================== -->
        <div class="uk-grid uk-grid-width-large-1-5 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,2,4,3</span></div>
                        <span class="uk-text-muted uk-text-small">Reservations</span>
                        <h2 class="uk-margin-remove"><span class="countUpMe">4<noscript>50</noscript></span></h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data ">75/100</span></div>
                        <span class="uk-text-muted uk-text-small">Reservations en cours </span>
                        <h2 class="uk-margin-remove"><span class="countUpMe">3<noscript>50</noscript></span></h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">25/100</span></div>
                        <span class="uk-text-muted uk-text-small">Reservation passé</span>
                        <h2 class="uk-margin-remove"><span class="countUpMe">1<noscript>50</noscript></span></h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">25/100</span></div>
                        <span class="uk-text-muted uk-text-small">Reservation payé</span>
                        <h2 class="uk-margin-remove"><span class="countUpMe">1<noscript>50</noscript></span></h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data peity_data" >75/100</span></div>
                        <span class="uk-text-muted uk-text-small">Reservation non payé</span>
                        <h2 class="uk-margin-remove"><span class="countUpMe">3<noscript>50</noscript></span></h2>
                    </div>
                </div>
            </div>

        </div>

        <!-- ==================== tasks ==================== -->
        <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
            <div class="uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-overflow-container">
                            <table class="uk-table">
                                <thead>
                                <tr>
                                    <th class="uk-text-nowrap">Nom</th>
                                    <th class="uk-text-nowrap">Attribut</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap"><a href="#">Clients</a></td>
                                    <td class="uk-width-2-10 uk-text-nowrap"><span class="uk-badge">4</span></td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap"><a href="#">Somme des réservations</a></td>
                                    <td class="uk-width-2-10 uk-text-nowrap"><span class="uk-badge">11 000 DT</span></td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap"><a href="#">Somme des paiments</a></td>
                                    <td class="uk-width-2-10 uk-text-nowrap"><span class="uk-badge uk-badge-success">8 000 DT</span></td>
                                </tr>
                                <tr class="uk-table-middle">
                                    <td class="uk-width-3-10 uk-text-nowrap"><a href="#">Reste à payer</a></td>
                                    <td class="uk-width-2-10 uk-text-nowrap"><span class="uk-badge uk-badge-danger">3 000 DT</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a uk-margin-bottom">Statistiques</h3>
                        <div id="ct-chart" class="chartist"></div>
                    </div>
                </div>
            </div>
        </div>

        <!--
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-1-1">
                            </div>
                        </div>
                    </div>
                </div>
        -->


        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <div>
                            <br>
                            <div id="calendar_selectable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== charts Init ==================== -->
<script>
    $(function() {
        // dashboard init functions
        altair_dashboard.init();
    });
    altair_dashboard = {
        init: function () {
            'use strict';
            // small charts
            altair_dashboard.peity_charts();

            // large graph
            altair_dashboard.chartist_charts();
        },
        // small charts
        peity_charts: function () {
            $(".peity_orders").peity("donut", {
                height: 24,
                width: 24,
                fill: ["#8bc34a", "#eee"]
            });
            $(".peity_visitors").peity("bar", {
                height: 28,
                width: 48,
                fill: ["#d84315"],
                padding: 0.2
            });
            $(".peity_sale").peity("line", {
                height: 28,
                width: 64,
                fill: "#d1e4f6",
                stroke: "#0288d1"
            });
            $(".peity_conversions_large").peity("bar", {
                height: 64,
                width: 96,
                fill: ["#d84315"],
                padding: 0.2
            });
            var $peity_live = $('.peity_live');
            if ($peity_live.length) {
                // live update
                var peityLive = $peity_live.peity("line", {
                    height: 28,
                    width: 64,
                    fill: "#efebe9",
                    stroke: "#5d4037"
                });
                // fix for "startVal or endVal is not a number" error
                $('#peity_live_text').text('0');

                function getRandomVal(min, max) {
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }

                setInterval(function () {
                    var random = Math.round(Math.random() * 10);
                    var values = peityLive.text().split(",");
                    values.shift();
                    values.push(random);

                    peityLive
                        .text(values.join(","))
                        .change();

                    var countFrom = parseInt($('#peity_live_text').text()),
                        countTo = getRandomVal(20, 100);

                    if(countFrom == countTo) {
                        var countTo = getRandomVal(20, 120);
                    }

                    var numAnim = new CountUp('peity_live_text', countFrom, countTo, 0, 1.2);
                    numAnim.start();

                }, 2000)
            }
        },
        // chartist
        chartist_charts: function() {

            new Chartist.Bar('#ct-chart', {
                labels: ['Semaine 1', 'Semaine 2', 'Semaine 3', 'Semaine 4'],
                series: [
                    [5, 2, 4, 3]
                ]
            }, {
                // Default mobile configuration
                stackBars: true,
                axisX: {
                    labelInterpolationFnc: function(value) {
                        return value.split(/\s+/).map(function(word) {
                            return word[0];
                        }).join('');
                    }
                },
                axisY: {
                    offset: 20
                }
            }, [
                // Options override for media > 400px
                ['screen and (min-width: 400px)', {
                    reverseData: true,
                    horizontalBars: true,
                    axisX: {
                        labelInterpolationFnc: Chartist.noop
                    },
                    axisY: {
                        offset: 60
                    }
                }],
                // Options override for media > 800px
                ['screen and (min-width: 800px)', {
                    stackBars: false,
                    seriesBarDistance: 10
                }],
                // Options override for media > 1000px
                ['screen and (min-width: 1000px)', {
                    reverseData: false,
                    horizontalBars: false,
                    seriesBarDistance: 15
                }]
            ]);
        }

    };
</script>

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
<script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src='bower_components/fullcalendar/dist/locale/fr.js'></script>
<script src="bower_components/fullcalendar/dist/moment.min.js"></script>

<!-- ==================== chart ====================
 <script src="d/c3.js"></script>
 <script src="d/d3.js"></script>
 <script src="d/metricsgraphics.js"></script>
 <script src="d/jquery.easypiechart.js"></script>
<script src="d/dashboard.js"></script>
 -->
<script src="d/jquery.peity.js"></script>
<script src="d/countUp.min.js"></script>
<script src="d/chartist.js"></script>

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
            lang: 'fr',
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
            eventClick: function(calEvent, jsEvent, view) {
                /*
                alert('Event: ' + calEvent.title);
                alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                alert('View: ' + view.name);
                */
                UIkit.modal.dialog('  <div class="">\n' +
                    '                            <h4 class="heading_c uk-margin-small-bottom">Contact Info</h4>\n' +
                    '                            <ul class="md-list md-list-addon">\n' +
                    '                                <li>\n' +
                    '                                    <div class="md-list-addon-element">\n' +
                    '                                        <i class="md-list-addon-icon material-icons">account_box</i>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="md-list-content">\n' +
                    '                                        <span class="md-list-heading">'+calEvent.title+'</span>\n' +
                    '                                        <span class="uk-text-small uk-text-muted">Nom et Prenom</span>\n' +
                    '                                    </div>\n' +
                    '                                </li>\n' +
                    '                                <li>\n' +
                    '                                    <div class="md-list-addon-element">\n' +
                    '                                        <i class="md-list-addon-icon material-icons">&#xE0CD;</i>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="md-list-content">\n' +
                    '                                        <span class="md-list-heading">'+calEvent.phone+'</span>\n' +
                    '                                        <span class="uk-text-small uk-text-muted">Telephone</span>\n' +
                    '                                    </div>\n' +
                    '                                </li>\n' +
                    '                                <li>\n' +
                    '                                    <div class="md-list-addon-element">\n' +
                    '                                        <i class="md-list-addon-icon material-icons">&#xE158;</i>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="md-list-content">\n' +
                    '                                        <span class="md-list-heading">'+calEvent.email+'</span>\n' +
                    '                                        <span class="uk-text-small uk-text-muted">Email</span>\n' +
                    '                                    </div>\n' +
                    '                                </li>\n' +
                    '\n' +
                    '                                <li>\n' +
                    '                                    <div class="md-list-addon-element">\n' +
                    '                                        <i class="md-list-addon-icon material-icons">alarm</i>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="md-list-content">\n' +
                    '                                        <span class="md-list-heading">'+calEvent.debut+' --> '+calEvent.fin+'</span>\n' +
                    '                                        <span class="uk-text-small uk-text-muted">Horaire de manifestation</span>\n' +
                    '                                    </div>\n' +
                    '                                </li>\n' +
                    '                            </ul>\n' +
                    '                        </div>').show();
            },
            events: json
        })
    };



    $(document).ready(function() {
        // page is now ready, initialize the calendar..
        $.ajax({
            type: "GET",
            headers:{"Authorizations":"<?php echo $_SESSION['api_key']; ?>"},
            url: "rest-api/v1/reservation" ,
            success: function (result) {
                calender(result.reservation)
            }
        });
    });

</script>

</body>
</html>