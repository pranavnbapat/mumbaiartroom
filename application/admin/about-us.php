<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$about_us = '';

if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<p style="color:green; font-weight:bold;">About us content is successfully edited!</p>';
endif;



if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
    $rules = array();

    $rules[] = "required,about_us_content,Please enter about us content.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
    else:
        $update = "UPDATE about_us SET status = 'archieved'";
        $mysqli->query($update);
        $insert_array['about_us'] = trim($_POST['about_us_content']);
        $insert_array['user_id'] = $user_info_row->id;
        $insert_array['status'] = 'published';
        $insert_array['date_created'] = $curr_date_time;
        insert($mysqli, "about_us", $insert_array);

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'About us content added.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        $msg = '<p style="color:green; font-weight:bold;">Content is successfully added!</p>';
    endif;
endif;


$get_about_us = "SELECT au.*, um.email FROM about_us au INNER JOIN user_master um ON um.id = au.user_id ORDER BY au.date_created DESC";
$about_us_res = $mysqli->query($get_about_us);
if ($about_us_res->num_rows > 0):
    $about_us = "";
    $i = $about_us_res->num_rows;
    while ($about_us_row = mysqli_fetch_object($about_us_res)):
        if ($about_us_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $about_us_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $about_us_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($about_us_row->date_updated != '' && $about_us_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $about_us_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;

        $about_us .= "<tr>
                        <td>{$i}</td>
                        <td>{$about_us_row->email}</td>
                        <td>{$about_us_row->about_us}</td>
                        <!--<td>" . ucfirst($about_us_row->status) . "</td>-->
                        <td>{$status}</td>
                        <td>{$about_us_row->date_created}</td>
                        <td>{$updated_date}</td>
                        <td><a href='about-us-edit.php?id=" . $about_us_row->id . "' class='edit btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a></td>
                    </tr>";
        $i--;
    endwhile;
endif;

$template->load("templates/about-us.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("about_us", $about_us);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>