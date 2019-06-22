<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$about_id = '';
$about_us_content = '';


/* edit about us information */
if (isset($_GET['id']) && $_GET['id'] != '' && isValidNumber($_GET['id'])):
    $get_about_us = 'SELECT * FROM about_us WHERE id = ' . $_GET['id'];
    $about_us_res = $mysqli->query($get_about_us);
    if ($about_us_res->num_rows > 0):
        $about_us_row = mysqli_fetch_object($about_us_res);
        $about_id = $about_us_row->id;
        $about_us_content = $about_us_row->about_us;
    endif;
endif;
/* edit about us information */


/* update about us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $rules = array();

    $rules[] = "required,about_us_content,Please enter about us content.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $about_id = $_POST['about_id'];
        $about_us_content = trim(htmlspecialchars($_POST['about_us_content']));
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
    else:
        $update_array['about_us'] = trim(htmlspecialchars($_POST['about_us_content']));
        $update_array['date_updated'] = $curr_date_time;
        update($mysqli, "about_us", $update_array, $_POST['about_id'], 'id');

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'About us content updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('Location: about-us.php?msg=edited');
    endif;
endif;
/* update about us information */

$template->load("templates/about-us-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("about_id", $about_id);
$template->replace("about_us_content", $about_us_content);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>