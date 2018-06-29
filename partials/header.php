<?php
$ajouter = false;
$supprimer = false;
$detail = false;
$modifier = false;
ini_set('display_errors','off');
session_start();
if (!(isset($_SESSION['email']))) {
    header("location:index.php");
} else if ($_SESSION['privilege'] != 1) {
    require_once 'rest-api/include/DbConnect.php';
    $db = new DbConnect();
    $conn = $db->connect();
    $stmt = $conn->prepare("select pr.ajouter , pr.modifier ,pr.supprimer ,pr.detail
  from privilege_page pr ,page p where pr.id= ? and pr.page_id=p.id and p.nom=?");
$session=$_SESSION['privilege'];
    $nom_page=basename($_SERVER['PHP_SELF']);
    $stmt->bind_param("ss", $session, $nom_page);
    $stmt->execute();
    $stmt->bind_result($add, $update, $remove, $detail);
    $stmt->store_result();
    $stmt->fetch();
    if (!($stmt->num_rows > 0)) {
        header("location:".$_SESSION['default']);
    } else {
        if ($add == 0) {
            $ajouter = true;
        }
        if ($supprimer == 0) {
            $supprimer = true;
        }
        if ($modifier == 0) {
            $modifier = true;
        }
        if ($detail == 0) {
            $detail = true;
        }
    }
}

// inactive in seconds
$inactive = 900;
if (!isset($_SESSION['timeout']))
    $_SESSION['timeout'] = time() + $inactive;

$session_life = time() - $_SESSION['timeout'];

if ($session_life > $inactive) {
    session_destroy();
    header("Location:index.php");
}

$_SESSION['timeout'] = time() + $inactive;

include('menu-builder.php');
?>
<!doctype html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png">
    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <title>Sofetes</title>


    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

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
    <script src="assets/js/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/chosen.min.css" media="all"

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
<!-- main header -->
<aside id="sidebar_main">

    <div class="sidebar_main_header">
        <div class="sidebar_logo">
            <?php
            $user = "assets/img/avatars/user.png";
            if ($_SESSION["photo"] != null && $_SESSION["photo"] != "") {
                $user = "rest-api/uploadedimages/" . $_SESSION["photo"];

            }
            ?>
            <a href="dashboard.php" class="sSidebar_hide"><img class="circle responsive-img" src="<?php echo $user ?>"
                                                            alt="" height="80" width="80"/></a>
            <a href="dashboard.php" class="sSidebar_show"><img class="circle responsive-img" src="<?php echo $user ?>"
                                                            alt="" height="80" width="80"/></a>
        </div>

    </div>

    <div class="menu_section">
        <ul>
            <?php buildMenu($menuList); ?>
        </ul>
    </div>
</aside>
<header id="header_main">

    <div class="header_main_search_form">
        <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
        <form class="uk-form">
            <input type="text" class="header_main_search_input"/>
            <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i>
            </button>
        </form>
    </div>
    <div class="header_main_content">
        <nav class="uk-navbar" style="text-align: center;color: white; align-items: center;">

            <!-- main sidebar switch -->
            <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                <span class="sSwitchIcon"></span>
            </a>

            <div style="align-self: center; font-size: xx-large">
               Panneau d'administration
                <div/>


        </nav>
    </div>
</header><!-- main header end -->
<!-- main sidebar -->
<!-- main sidebar end -->
