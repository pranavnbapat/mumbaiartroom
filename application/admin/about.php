<?php

include 'admin_header.php';
include 'admin_footer.php';


$msg = '';
$about = '';


if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content is successfully edited!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'added'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content is successfully added!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'canceled'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:#b94a48; font-weight:bold;">Content editing canceled!</p></div></div>';
endif;


/* add about content */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
    $update = "UPDATE about SET status = 'archieved'";
    $mysqli->query($update);
    $insert_array['about_content'] = trim(addslashes($_POST['about_content']));
    $insert_array['user_id'] = $user_info_row->id;
    $insert_array['status'] = 'published';
    $insert_array['date_created'] = $curr_date_time;
    insert($mysqli, "about", $insert_array);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'About content added.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;
    insert($mysqli, 'log_user_activity', $insert_log);

    header('location:about.php?msg=added');
endif;
/* add about content */


/* get about content */
$get_about = "SELECT a.* FROM about a ORDER BY a.date_created DESC";
$about_res = $mysqli->query($get_about);
if ($about_res->num_rows > 0):
    $about = "";
    $i = $about_res->num_rows;
    while ($about_row = mysqli_fetch_object($about_res)):
        if ($about_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $about_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $about_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($about_row->date_updated != '' && $about_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $about_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;

        $about .= "<tr>
                        <td>{$i}</td>
                        <td>{$about_row->about_content}</td>
                        <td>{$about_row->date_created}</td>
                        <td>{$updated_date}</td>
                        <td>{$status} <a href='about-edit.php?about_id=" . $about_row->id . "' class='edit btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a> <a class='btn btn-danger btn-xs' onclick='delete_record(" . $about_row->id . ")'><i class='fa fa-trash-o'></i></a></td>
                    </tr>";
        $i--;
    endwhile;
endif;
/* get about content */


$template->load("templates/about.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("about", $about);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>