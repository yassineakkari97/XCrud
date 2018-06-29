<?php
function buildMenu($menuList)
{
    // Get the link name
    $pieces = explode('/', $_SERVER['REQUEST_URI']);
    $page = end($pieces);

    foreach ($menuList as $val => $node) {
        $active = (strpos($page, $node['link']) !== false) ? "act_item current_section" : " ";

        //Running array for Main parent links
        if (!empty($node['children'])) {
            echo " <li class='submenu_trigger'><a>
            <span class='menu_icon'><i class='fa fa-" . $node['icon'] . " fa-lg'></i></span>
            <span class='menu_title'>" . $node['title'] . "</span>
          </a>";
        } else {
            echo "     <li class='" . $active . "' title='" . $node['title'] . "'>
                <a href='" . $node['link'] . "'>
                    <span class='menu_icon'><i class='fa fa-" . $node['icon'] . "'></i></span>
                    <span class='menu_title'>" . $node['title'] . "</span>
                </a>
            </li>";
        }


        // Running submenu
        if (!empty($node['children'])) {
            echo "<ul>";
            buildMenu($node['children']);
            echo "</ul>";
        }
        echo "</li>";
    }
}

$menuList = Array(
    0 => Array(
        'title' => 'Tableau de Bord ',
        'link' => 'dashboard.php',
        'icon' => 'dashboard',
        'children' => Array()
    ),
    1 => Array(
        'title' => "Admimistration Générale",
        'link' => '#',
        'icon' => 'cog',
        'children' => Array(

         
            0 => Array(
                'title' => "Gestion d'articles",
                'link' => 'gestionArticles.php',
                'icon' => 'shopping-cart',
                'children' => Array()
            )

        )
    ),

    2 => Array(
        'title' => 'Clients',
        'link' => 'client.php',
        'icon' => 'users',
        'children' => Array()
    ),
    3 => Array(
        'title' => 'Fournisseurs',
        'link' => 'fournisseurs.php',
        'icon' => 'users',
        'children' => Array()
    ),
    4 => Array(
        'title' => 'Réservations',
        'link' => 'reservation.php',
        'icon' => 'briefcase',
        'children' => Array()
    ),
    5 => Array(
        'title' => 'Caisse',
        'link' => '#',
        'icon' => 'dollar',
        'children' => Array(
            0=> Array(
                'title' => 'Dépenses',
                'link' => 'depenses.php',
                'icon' => 'archive ',
                'children' => Array(),
            ),

            1 => Array(
                'title' => 'Solde',
                'link' => 'caisse.php',
                'icon' => 'money',
                'children' => Array()
            ),
        )
    ),
    6 => Array(
        'title' => "Etat de Prévision",
        'link' => '#',
        'icon' => 'dollar',
        'children' => Array(

            0=> Array(
                'title' => 'Tous',
                'link' => 'prevision.php',
                'icon' => 'archive ',
                'children' => Array(),
            ),

            1 => Array(
                'title' => 'Chèque',
                'link' => 'cheque.php',
                'icon' => 'money',
                'children' => Array()
            ),
            2 => Array(
                'title' => "Traite",
                'link' => 'traite.php',
                'icon' => 'credit-card',
                'children' => Array()
            ),

             3 => Array(
                'title' => "Espèce",
                'link' => 'espece.php',
                'icon' => 'credit-card',
                'children' => Array()
            ),
              4 => Array(
                'title' => "Virement",
                'link' => 'virement.php',
                'icon' => 'credit-card',
                'children' => Array()
            )

        )
    ),
    7 => Array(
        'title' => 'Mot de passe',
        'link' => 'profil.php',
        'icon' => 'edit',
        'children' => Array()
    ),
     8 => Array(
        'title' => 'E_mail',
        'link' => 'email.php',
        'icon' => 'edit',
        'children' => Array()
    ),

    9=> Array(
        'title' => 'Déconnexion',
        'link' => 'logout.php',
        'icon' => 'power-off',
        'children' => Array()
    )
);

?>
