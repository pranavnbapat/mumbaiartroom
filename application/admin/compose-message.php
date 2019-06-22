<?php

include 'admin_header.php';
include 'admin_footer.php';

error_reporting(0);

$msg = '';

/* get user list */
$get_user_list = 'SELECT id, email, fname, lname FROM user_master WHERE status = "A" AND email_verified = "Y" AND role_id != 5 AND user_key != "' . $_SESSION['user_key'] . '"';
$user_list_res = $mysqli->query($get_user_list);
$user_list = '';
if ($user_list_res->num_rows > 0):
    while ($user_list_row = mysqli_fetch_object($user_list_res)):
        $user_list .= '<option value = "' . $user_list_row->id . '">' . ucwords($user_list_row->fname) . ' ' . ucwords($user_list_row->lname) . ' - ' . strtolower($user_list_row->email) . '</option>';
    endwhile;
else:
    $user_list = '';
endif;
/* get user list */


/* insert message */
if (isset($_POST['submit']) && $_POST['submit'] == 'Send'):
//    var_dump($_POST['user_list']);
    $msg = '';
    if (isset($_POST['user_list']) == null):
        $msg .= 'Please select at least one receiver.<br />';
    endif;

    $rules = array();

    $rules[] = "required,message_subject,Please enter message subject.";
    $rules[] = "length<255,message_subject,Only 255 characters are allowed for message subject";

    $rules[] = "required,message_text,Please enter message body.";
    $rules[] = "length<=1000000,message_subject,Message text is too long.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        foreach ($errors as $error):
            $msg .= "$error<br />";
        endforeach;
    else:
        if (isset($_POST['user_list'])):
            if ($_FILES["file"]["name"]):
                $digits = 9;
                $count = 0;
                $path = 'shared_files/';
                $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                $temp = explode(".", $_FILES["file"]["name"]);
                $extension = end($temp);
                $newfilename = $random_number . '_' . date('d_m_Y_H_i_s') . '.' . $extension;
                move_uploaded_file($_FILES["file"]["tmp_name"], $path . $newfilename);
                $file_path = $path . $newfilename;
            else:
                $file_path = '';
                $newfilename = '';
            endif;

            for ($i = 0; $i < count($_POST['user_list']); $i++):
                $insert_array['message_uid'] = number_format(microtime(true), 0, '.', '') . generateUserKey() . number_format(microtime(true) * 1000000, 0, '.', '');
                $insert_array['sender_id'] = $user_info_row->id;
                $insert_array['receiver_id'] = $_POST['user_list'][$i];
                $insert_array['message_subject'] = trim($_POST['message_subject']);
                $insert_array['message'] = $_POST['message_text'];
                $insert_array['file'] = $newfilename;
                $insert_array['sent_date'] = $curr_date_time;
                insert($mysqli, 'user_message_master', $insert_array);

                $insert_log['user_id'] = $user_info_row->id;
                $insert_log['message'] = 'Message is sent to ' . $_POST['user_list'][$i];
                $insert_log['activity_from'] = get_client_ip();
                $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
                $insert_log['user_platform'] = $browser->getPlatform();
                $insert_log['date_created'] = $curr_date_time;
                insert($mysqli, 'log_user_activity', $insert_log);
            endfor;
            $msg = 'Message sent.';
        endif;
    endif;

endif;
/* insert message */


$template = new Template;
$template->load("templates/compose-message.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("user_list", $user_list);
$template->replace("msg", $msg);
if (isset($_POST['message_subject'])):
    $template->replace("message_subject", trim($_POST['message_subject']));
else:
    $template->replace("message_subject", "");
endif;
if (isset($_POST['message_text'])):
    $template->replace("message_text", trim($_POST['message_text']));
else:
    $template->replace("message_text", "");
endif;
$template->publish();
$db->mysqlclose();
?>