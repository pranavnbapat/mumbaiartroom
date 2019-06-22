<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$gallery_address = '';
$gallery_status = '';
$timing_id = '';


/* edit contact us information */
if (isset($_GET['timing_id']) && $_GET['timing_id'] != '' && isValidNumber($_GET['timing_id'])):
    $get_timings = 'SELECT * FROM timing WHERE id = ' . trim(htmlspecialchars($_GET['timing_id']));
    $timings_res = $mysqli->query($get_timings);
    if ($timings_res->num_rows > 0):
        $timings_row = mysqli_fetch_object($timings_res);
        $timing_id = $timings_row->id;
        $gallery_address = $timings_row->gallery_address;
        $gallery_status = $timings_row->gallery_status;
    endif;
else:
//    echo '<script>sweetAlert("Error","Invalid input provided","error");</script>';
    $msg .= "<p style='color: #b94a48; font-weight:bold;'>Invalid input provided!</p>";
endif;
/* edit contact us information */

//var_dump($_POST);
//die();

/* update contact us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $rules = array();

    $rules[] = "required,address,Please enter gallery address.";
    $rules[] = "length<500,address,Gallery address content should be less than 500 characters.";
    
    $rules[] = "required,gallery_status,Please enter gallery status.";
    $rules[] = "length<100,gallery_status,Gallery status should be less than 100 characters.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $timing_id = $_POST['timing_id'];
        $gallery_address = trim(strtolower(htmlspecialchars($_POST['gallery_address'])));
        $gallery_status = trim(strtolower(htmlspecialchars($_POST['gallery_status'])));
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
    else:
        $update_array['gallery_address'] = trim(htmlspecialchars($_POST['gallery_address']));
        $update_array['gallery_status'] = trim(htmlspecialchars($_POST['gallery_status']));
        $update_array['date_updated'] = $curr_date_time;
        update($mysqli, "timing", $update_array, $_POST['timing_id'], 'id');

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Gallery timings updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('Location: timings.php?msg=edited');
    endif;
endif;
/* update contact us information */

$template->load("templates/timings-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("timing_id", $timing_id);
$template->replace("gallery_address", $gallery_address);
$template->replace("gallery_status", $gallery_status);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>