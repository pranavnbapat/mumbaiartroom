<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$contact_us = '';
$contact_us_text = '';
$contact_name = '';
$contact_email = '';
$contact_phone = '';


if(isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<p style="color:green; font-weight:bold;">Contact information has been updated.</p>';
endif;

/* add contact us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
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
        $contact_us_text = trim($_POST['contact_us_text']);
        $contact_name = trim(htmlspecialchars($_POST['contact_name']));
        $contact_email = trim(htmlspecialchars($_POST['contact_email']));
        $contact_phone = trim(htmlspecialchars($_POST['contact_phone']));
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
    else:
        $update = "UPDATE contact_us SET status = 'archieved'";
        $mysqli->query($update);
        $insert_array['user_id'] = $user_info_row->id;
        $insert_array['contact_us_text'] = trim($_POST['contact_us_text']);
        $insert_array['contact_name'] = trim(strtolower(htmlspecialchars($_POST['contact_name'])));
        $insert_array['contact_email'] = trim(strtolower(htmlspecialchars($_POST['contact_email'])));
        $insert_array['contact_phone'] = trim(htmlspecialchars($_POST['contact_phone']));
        $insert_array['status'] = 'published';
        $insert_array['date_created'] = $curr_date_time;
        insert($mysqli, "contact_us", $insert_array);

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Contact us content added.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        $msg = '<p style="color:green; font-weight:bold;">Contact us information is successfully added.</p>';
    endif;
endif;
/* add contact us information */


/* get contact us */
$get_contact_us = 'SELECT cu.*, um.email FROM contact_us cu INNER JOIN user_master um ON um.id = cu.user_id ORDER BY cu.date_created DESC';
$contact_us_res = $mysqli->query($get_contact_us);
if ($contact_us_res->num_rows > 0):
    $i = $contact_us_res->num_rows;
    while ($contact_us_row = mysqli_fetch_object($contact_us_res)):
        if ($contact_us_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $contact_us_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $contact_us_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($contact_us_row->date_updated != '' && $contact_us_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $contact_us_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;

        $contact_us .= "<tr>
                        <td>{$i}</td>
                        <td>{$contact_us_row->email}</td>
                        <td>{$contact_us_row->contact_us_text}</td>
                        <td>{$contact_us_row->contact_name}</td>
                        <td>{$contact_us_row->contact_email}</td>
                        <td>{$contact_us_row->contact_phone}</td>
                        <td>{$status}</td>
                        <td>{$contact_us_row->date_created}</td>
                        <td>{$updated_date}</td>
                        <td><a href='contact-us-edit.php?id=" . $contact_us_row->id . "' class='edit btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a></td>
                    </tr>";
        $i--;
    endwhile;
endif;
/* get contact us */


$template->load("templates/contact-us.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("contact_us", $contact_us);
$template->replace("contact_us_text", $contact_us_text);
$template->replace("contact_name", $contact_name);
$template->replace("contact_email", $contact_email);
$template->replace("contact_phone", $contact_phone);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>