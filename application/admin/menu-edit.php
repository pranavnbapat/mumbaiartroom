<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$menu_id = '';
$menu_name = '';
$menu_order = '';

/* edit contact us information */
if (isset($_GET['id']) && $_GET['id'] != '' && isValidNumber($_GET['id'])):
    $get_menu = 'SELECT * FROM menu_master WHERE id = ' . $_GET['id'];
    $menu_res = $mysqli->query($get_menu);
    if ($menu_res->num_rows > 0):
        $menu_row = mysqli_fetch_object($menu_res);
        $menu_id = $menu_row->id;
        $menu_name = strtoupper($menu_row->menu_display_name);
        $menu_order = $menu_row->menu_order;
    endif;
endif;
/* edit contact us information */

//var_dump($_POST);
//die();

/* update contact us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $rules = array();

    $rules[] = "required,menu_name,Please enter menu name";
    $rules[] = "length<21,menu_name,Menu name should be less than or equal to 20 characters";
    $rules[] = "letters_only,menu_name,Only alphabets are allowed for menu name";

    $rules[] = "required,menu_order,Please enter menu order.";
    $rules[] = "length<3,menu_order,Mene order should be less than or equal to 2 characters.";
    $rules[] = "digits_only,menu_order,Only digits are allowed for menu order";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $menu_id = $_POST['menu_id'];
        $menu_order = trim(htmlspecialchars($_POST['menu_order']));
        $menu_name = trim(htmlspecialchars($_POST['menu_name']));
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
    else:
        $update_array['menu_display_name'] = trim(htmlspecialchars($_POST['menu_name']));
        $update_array['menu_order'] = trim(strtolower(htmlspecialchars($_POST['menu_order'])));
        $update_array['date_updated'] = $curr_date_time;
        update($mysqli, "menu_master", $update_array, $_POST['menu_id'], 'id');

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Menu updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('Location: menu.php?msg=edited');
    endif;
endif;
/* update contact us information */

$template->load("templates/menu-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("menu_id", $menu_id);
$template->replace("menu_name", $menu_name);
$template->replace("menu_order", $menu_order);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>