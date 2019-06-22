<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$gallery_address = '';
$gallery_status = '';
$gallery_timing_comment = '';
$timings = '';

if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Gallery timings have been updated!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'added'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Gallery timings have been added!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'cancelled'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Gallery timings editng cancelled!</p></div></div>';
endif;

/* add timing information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
//    $rules = array();
//    $rules[] = "required,gallery_address,Please enter gallery address";
//    $rules[] = "length<500,gallery_address,Gallery address content should be less than 500 characters";
//    
//    $rules[] = "required,gallery_status,Please enter gallery status";
//    $rules[] = "length<100,gallery_status,Gallery status should be less than 100 characters";
//    $errors = validateFields($_POST, $rules);
//    if (!empty($errors)):
//        $gallery_address = trim(htmlspecialchars($_POST['gallery_address']));
//        $gallery_status = trim(htmlspecialchars($_POST['gallery_status']));
//        foreach ($errors as $error):
//            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
//        endforeach;
//    else:
    $update = "UPDATE timing SET status = 'archieved'";
    $mysqli->query($update);
    $insert_array['user_id'] = $user_info_row->id;
//        $insert_array['gallery_address'] = trim(htmlspecialchars($_POST['gallery_address']));
//        $insert_array['gallery_status'] = trim(htmlspecialchars($_POST['gallery_status']));
    $insert_array['gallery_timing_comment'] = trim(htmlspecialchars($_POST['gallery_timing_comment']));
    $insert_array['status'] = 'published';
    $insert_array['date_created'] = $curr_date_time;
    insert($mysqli, "timing", $insert_array);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'Gallery timings added.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;
    insert($mysqli, 'log_user_activity', $insert_log);

    header('location: timings.php?msg=added');
    $msg = '<p style="color:green; font-weight:bold;">Gallery timings information is successfully added.</p>';
//    endif;
endif;
/* add timing information */


/* get timing details */
$get_timings = 'SELECT t.* FROM timing t ORDER BY t.date_created DESC';
$timings_res = $mysqli->query($get_timings);
if ($timings_res->num_rows > 0):
    $i = $timings_res->num_rows;
    while ($timings_row = mysqli_fetch_object($timings_res)):
        if ($timings_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $timings_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $timings_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($timings_row->date_updated != '' && $timings_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $timings_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;

        $timings .= "<tr>
                        <td>{$i}</td>
                        <td>{$timings_row->gallery_timing_comment}</td>
                        <td>{$timings_row->date_created}</td>
                        <td>{$updated_date}</td>
                        <td><a href='timings-edit.php?timing_id=" . $timings_row->id . "' class='edit btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a> {$status} </td>
                    </tr>";
        $i--;
    endwhile;
endif;
/* get timing details */


$template->load("templates/timings.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("timings", $timings);
$template->replace("gallery_address", $gallery_address);
$template->replace("gallery_status", $gallery_status);
$template->replace("gallery_timing_comment", $gallery_timing_comment);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>