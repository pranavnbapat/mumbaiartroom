<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$about_id = '';
$about_content = '';


/* edit about us information */
if (isset($_GET['about_id']) && $_GET['about_id'] != '' && isValidNumber($_GET['about_id'])):
    $get_about = 'SELECT * FROM about WHERE id = ' . $_GET['about_id'];
    $about_res = $mysqli->query($get_about);
    if ($about_res->num_rows > 0):
        $about_row = mysqli_fetch_object($about_res);
        $about_id = $about_row->id;
        $about_content = $about_row->about_content;
    endif;
endif;
/* edit about us information */


/* update about us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $update_array['about_content'] = trim(addslashes($_POST['about_content']));
    $update_array['date_updated'] = $curr_date_time;
    update($mysqli, "about", $update_array, $_POST['about_id'], 'id');

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'About content updated.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;
    insert($mysqli, 'log_user_activity', $insert_log);

    header('Location: about.php?msg=edited');
endif;
/* update about information */


$template->load("templates/about-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("about_id", $about_id);
$template->replace("about_content", $about_content);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>