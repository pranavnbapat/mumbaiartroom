<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$page_id = '';
$page_name = '';
$title = '';
$keywords = '';
$description = '';


/* edit about us information */
if (isset($_GET['id']) && $_GET['id'] != '' && isValidNumber($_GET['id'])):
    $get_seo = 'SELECT * FROM page_master WHERE id = ' . $_GET['id'];
    $seo_res = $mysqli->query($get_seo);
    if ($seo_res->num_rows > 0):
        $seo_row = mysqli_fetch_object($seo_res);
        $page_id = $seo_row->id;
        $page_name = $seo_row->page_display_name;
        $title = $seo_row->seo_title;
        $keywords = $seo_row->seo_keywords;
        $description = $seo_row->seo_description;
    endif;
endif;
/* edit about us information */


/* update about us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $rules = array();

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
    else:
        $update_array['seo_title'] = trim(htmlspecialchars($_POST['title']));
        $update_array['seo_keywords'] = trim(htmlspecialchars($_POST['keywords']));
        $update_array['seo_description'] = trim(htmlspecialchars($_POST['description']));
        $update_array['date_updated'] = $curr_date_time;
        update($mysqli, "page_master", $update_array, $_POST['page_id'], 'id');

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'SEO for page id ' . $_POST['page_id'] . ' updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('Location: seo.php?msg=edited');
    endif;
endif;
/* update about us information */

$template->load("templates/seo-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("page_id", $page_id);
$template->replace("page_name", $page_name);
$template->replace("title", $title);
$template->replace("keywords", $keywords);
$template->replace("description", $description);
$template->publish();
$db->mysqlclose();
?>