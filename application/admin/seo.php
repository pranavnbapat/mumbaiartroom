<?php

include './admin_header.php';
include './admin_footer.php';

$msg = '';
$seo = '';
$title = '';
$keywords = '';
$description = '';
$page_names = '<option value = "0">Please select a page</option>';


if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<p style="color:green; font-weight:bold;">SEO has been updated!</p>';
endif;


/* get page names */
$get_page_names = 'SELECT pm.page_display_name pm.id FROM SEO s INNER JOIN menu_master pm ON pm.id = s.page_id';
//$get_page_names = 'SELECT pm.id, pm.page_display_name FROM menu_master pm INNER JOIN WHERE pm.`status` = "published"';
$page_name_res = $mysqli->query($get_page_names);
if ($page_name_res->num_rows > 0):
    while ($page_name_row = mysqli_fetch_object($page_name_res)):
        $page_names .= '<option value = "' . $page_name_row->id . '">' . $page_name_row->page_display_name . '</option>';
    endwhile;
endif;
/* get page names */


/* add seo */
//if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
//    $rules = array();
//
//    $rules[] = "length<300,title,Page title should be less than 300 characters.";
//    $rules[] = "is_alpha,title,Page title should contain only alphanumeric characters.";
//
//    $rules[] = "length<300,keywords,Keywords should be less than 300 characters.";
//
//    $rules[] = "length<1000,description,Page descrition should be less than 1000 characters.";
//
//    $errors = validateFields($_POST, $rules);
//
//    if (!empty($errors)):
//        $title = trim(htmlspecialchars($_POST['title']));
//        $keywords = trim(htmlspecialchars($_POST['keywords']));
//        $description = trim(htmlspecialchars($_POST['description']));
//        foreach ($errors as $error):
//            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
//        endforeach;
//    else:
//        $insert_array['user_id'] = $user_info_row->id;
//        $insert_array['page_id'] = $_POST['page_id'];
//        $insert_array['title'] = trim(htmlspecialchars($_POST['title']));
//        $insert_array['keywords'] = trim(htmlspecialchars($_POST['keywords']));
//        $insert_array['description'] = trim(htmlspecialchars($_POST['description']));
//        $insert_array['status'] = 'published';
//        $insert_array['date_created'] = $curr_date_time;
//        insert($mysqli, "seo", $insert_array);
//
//        $insert_log['user_id'] = $user_info_row->id;
////        $insert_log['message'] = 'SEO content for '..' added.';
//        $insert_log['activity_from'] = get_client_ip();
//        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
//        $insert_log['user_platform'] = $browser->getPlatform();
//        $insert_log['date_created'] = $curr_date_time;
//        insert($mysqli, 'log_user_activity', $insert_log);
//
//        $msg = '<p style="color:green; font-weight:bold;">SEO information is successfully added.</p>';
//    endif;
//endif;
/* add seo */


$get_seo = 'SELECT pm.* FROM menu_master pm WHERE pm.`status` = "published"';
$seo_res = $mysqli->query($get_seo);
if ($seo_res->num_rows > 0):
    $i = $seo_res->num_rows;
    while ($seo_row = mysqli_fetch_object($seo_res)):
        if ($seo_row->date_updated != '' && $seo_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $seo_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;
        $seo .= "<tr>
                        <td>{$i}</td>
                        <td>{$seo_row->page_display_name}</td>
                        <td>{$seo_row->seo_title}</td>
                        <td>{$seo_row->seo_keywords}</td>
                        <td>{$seo_row->seo_description}</td>
                        <td>{$seo_row->date_created}</td>
                        <td>{$updated_date}</td>
                        <td><a href='seo-edit.php?id=" . $seo_row->id . "' class='edit btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a></td>
                    </tr>";
        $i--;
    endwhile;
endif;


$template->load("templates/seo.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("title", $title);
$template->replace("keywords", $keywords);
$template->replace("description", $description);
$template->replace("seo", $seo);
$template->replace("page_names", $page_names);
$template->publish();
$db->mysqlclose();
?>