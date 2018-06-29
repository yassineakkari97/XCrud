<?php
define('API_ACCESS_KEY', 'key=AIzaSyC7D7xI3REDbPoaqUJ6BzrR8XubfHvExl8');
function update_trace($postdata, $primary, $xcrud)
{

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = "INSERT INTO trace (id_user,ajout,modif,id_champ,nom_table)VALUES('" . $_SESSION['id'] . "','0','1','" . $xcrud->get('primary') . "','" . $xcrud->get_var('nom_table') . "')";
        $db->query($query);
    } elseif ($primary != null) {
        $db = Xcrud_db::get_instance();
        $query = "INSERT INTO trace (id_user,ajout,modif,id_champ,nom_table)VALUES('" . $_SESSION['id'] . "','1','0','" . $primary . "','" . $xcrud->get_var('nom_table') . "')";;
        $db->query($query);
    }
}


function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function inscription($postdata)
{
    $db = Xcrud_db::get_instance();
    $query = "SELECT  b.`prix`,b.prix_inscription FROM  sectionniveau b WHERE b.section='" . $postdata->get('section') . "'";
    $db->query($query);
    $res = $db->row();
    $prixSection = $res["prix"];
    $prixInscri = $res["prix_inscription"];
    $postdata->set("montant_inscri", $prixInscri);
    $postdata->set("montant_section", $prixSection);
    $postdata->set("montant_global", $prixInscri + $prixSection);

}

function profileinfo($postdata)
{
    require_once '../rest-api/include/PassHash.php';

    $password = generateRandomString(rand(5, 10));
    $postdata->set('password_hash', PassHash::hash($password));
    $postdata->set('password', $password);
    $postdata->set('api_key', md5(uniqid(rand(), true)));
}

function update_trace_remove($primary, $xcrud)
{

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = "INSERT INTO trace (id_user,ajout,modif,id_champ,nom_table,supp)VALUES('" . $_SESSION['id'] . "','0','0','" . $xcrud->get('primary') . "','" . $xcrud->get_var('nom_table') . "','1')";
        $db->query($query);
    } elseif ($primary != null) {
        $db = Xcrud_db::get_instance();
        $query = $query = "INSERT INTO trace (id_user,ajout,modif,id_champ,nom_table,supp)VALUES('" . $_SESSION['id'] . "','0','0','" . $primary . "','" . $xcrud->get_var('nom_table') . "','1')";;
        $db->query($query);
    }
}

function facture_detail($xcrud)
{
    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function publish_action($xcrud)
{
    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function unpublish_action($xcrud)
{
    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata, $primary, $xcrud)
{
    // get random field from $postdata
    $postdata_prepared = array_keys($postdata->to_array());
    shuffle($postdata_prepared);
    $random_field = array_shift($postdata_prepared);
    // set error message
    $xcrud->set_exception($random_field, 'This is a test error', 'error');
}

function test_column_callback($value, $fieldname, $primary, $row, $xcrud)
{
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud)
{
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload') {
        unlink($file_path);
        $xcrud->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}

function movetop($xcrud)
{
    if ($xcrud->get('primary') !== false) {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item) {
            if ($item['officeCode'] == $primary && $key != 0) {
                array_splice($result, $key - 1, 0, array($item));
                unset($result[$key + 1]);
                break;
            }
        }

        foreach ($result as $key => $item) {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}

function movebottom($xcrud)
{
    if ($xcrud->get('primary') !== false) {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item) {
            if ($item['officeCode'] == $primary && $key != $count - 1) {
                unset($result[$key]);
                array_splice($result, $key + 1, 0, array($item));
                break;
            }
        }

        foreach ($result as $key => $item) {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}

function show_description($value, $fieldname, $primary_key, $row, $xcrud)
{
    $result = '';
    if ($value == '1') {
        $result = '<i class="fa fa-check" />' . 'OK';
    } elseif ($value == '2') {
        $result = '<i class="fa fa-circle-o" />' . 'Pending';
    }
    return $result;
}

function custom_field($value, $fieldname, $primary_key, $row, $xcrud)
{
    return '<input type="text" readonly class="xcrud-input" name="' . $xcrud->fieldname_encode($fieldname) . '" value="' . $value .
    '" />';
}

function unset_val($postdata)
{
    $postdata->del('Paid');
}

function format_phone($new_phone)
{
    $new_phone = preg_replace("/[^0-9]/", "", $new_phone);

    if (strlen($new_phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $new_phone);
    elseif (strlen($new_phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $new_phone);
    else
        return $new_phone;
}

function before_list_example($list, $xcrud)
{
    var_dump($list);
}

function after_update_test($pd, $pm, $xc)
{
    $xc->search = 0;
}



function activate_action($xcrud)
{
    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE ' . $xcrud->get_var("nom_table") . ' SET `status` = 1 WHERE id = ' . $xcrud->get('primary');
        $db->query($query);
    }
}

function desactivate_action($xcrud)
{
    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE ' . $xcrud->get_var("nom_table") . ' SET `status` = 0 WHERE id = ' . $xcrud->get('primary');
        $db->query($query);
    }
}


function reloadPage($primary, $xcrud)
{
    echo "<script type='text/javascript'>";
    echo "location.reload();";
    echo "</script>";
}