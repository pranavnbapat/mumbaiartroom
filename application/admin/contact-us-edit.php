<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$contact_id = '';
$contact_us_text = '';
$contact_name = '';
$contact_email = '';
$contact_phone = '';


/* edit contact us information */
if (isset($_GET['id']) && $_GET['id'] != '' && isValidNumber($_GET['id'])):
    $get_contact_us = 'SELECT * FROM contact_us WHERE id = ' . $_GET['id'];
    $contact_us_res = $mysqli->query($get_contact_us);
    if ($contact_us_res->num_rows > 0):
        $contact_us_row = mysqli_fetch_object($contact_us_res);
        $contact_id = $contact_us_row->id;
        $contact_us_text = $contact_us_row->contact_us_text;
        $contact_name = $contact_us_row->contact_name;
        $contact_email = $contact_us_row->contact_email;
        $contact_phone = $contact_us_row->contact_phone;
    endif;
endif;
/* edit contact us information */

//var_dump($_POST);
//die();

/* update contact us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $rules = array();

    $rules[] = "required,contact_us_text,Please enter contact us text.";
    $rules[] = "length<255,contact_us_text,Contact us content should be less than 255 characters.";

    $rules[] = "required,contact_name,Please enter contact name.";
    $rules[] = "length<255,contact_name,Contact name should be less than 255 characters.";
    $rules[] = "letters_only,contact_name,Only alphabets are allowed for contact name.";

    $rules[] = "required,contact_email,Please enter contact email.";
    $rules[] = "valid_email,contact_email,Please enter valid contact email.";
    $rules[] = "length<255,contact_email,Contact email should be less than 255 characters.";

    $rules[] = "required,contact_phone,Please enter contact phone.";
    $rules[] = "length<255,contact_phone,Contact phone should be less than 255 characters.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $contact_id = $_POST['contact_id'];
        $contact_us_text = trim(htmlspecialchars($_POST['contact_us_text']));
        $contact_name = trim(htmlspecialchars($_POST['contact_name']));
        $contact_email = trim(htmlspecialchars($_POST['contact_email']));
        $contact_phone = trim(htmlspecialchars($_POST['contact_phone']));
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
    else:
        $update_array['contact_us_text'] = trim(htmlspecialchars($_POST['contact_us_text']));
        $update_array['contact_name'] = trim(strtolower(htmlspecialchars($_POST['contact_name'])));
        $update_array['contact_email'] = trim(strtolower(htmlspecialchars($_POST['contact_email'])));
        $update_array['contact_phone'] = trim(htmlspecialchars($_POST['contact_phone']));
        $update_array['date_updated'] = $curr_date_time;
        update($mysqli, "contact_us", $update_array, $_POST['contact_id'], 'id');

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Contact us content updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('Location: contact-us.php?msg=edited');
    endif;
endif;
/* update contact us information */

$template->load("templates/contact-us-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("contact_id", $contact_id);
$template->replace("contact_us_text", $contact_us_text);
$template->replace("contact_name", $contact_name);
$template->replace("contact_email", $contact_email);
$template->replace("contact_phone", $contact_phone);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>