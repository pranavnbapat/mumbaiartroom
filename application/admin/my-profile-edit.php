<?php

include 'admin_header.php';
include 'admin_footer.php';


$msg = '';


/* get random thought */
$thought = '';
$get_thought = 'SELECT thought FROM food_for_thought WHERE status = "A" ORDER BY RAND() LIMIT 0,1';
$thought_res = $mysqli->query($get_thought);
if ($thought_res->num_rows > 0):
    $thought_row = mysqli_fetch_object($thought_res);
    $thought = $thought_row->thought;
else:
    $thought = 'Trust unto God, and he shall lead your path.';
endif;
/* get random thought */


/* Get user avatar */
$avatar = '';
$avatar_alt = 'no image';
if ($user_info_row->gender == 'm'):
    if ($user_info_row->avatar == ''):
        $avatar = 'img/avatar/business_user.png';
    else:
        $avatar = $user_info_row->avatar;
        $avatar_alt = $user_info_row->fname . ' ' . $user_info_row->lname . ' avatar';
    endif;
else:
    if ($user_info_row->avatar == ''):
        $avatar = 'img/avatar/female_business_user.png';
    else:
        $avatar = $user_info_row->avatar;
        $avatar_alt = $user_info_row->fname . ' ' . $user_info_row->lname . ' avatar';
    endif;
endif;
/* Get user avatar */


/* save profile info */
if (isset($_POST['info_submit']) && $_POST['info_submit'] == 'Save'):
    
//    $rules = array();
//
//    $rules[] = "required,fname,First name is required.";
//    $rules[] = "letters_only,fname,Only aplhabets are allowed for first name field.";
//    $rules[] = "length<50,fname,First name should be less than 50 characters.";
//
//    $rules[] = "required,lname,Last name is required.";
//    $rules[] = "letters_only,lname,Only aplhabets are allowed for last name field.";
//    $rules[] = "length<50,lname,Last name should be less than 50 characters.";
//
//    $rules[] = "required,email,Email is required.";
//    $rules[] = "valid_email,email,Please enter a valid email address.";
//    $rules[] = "length<50,email,Email should be less than 50 characters.";
//
//    $rules[] = "letters_only,country,Only alphabets are allowed for country field.";
//    $rules[] = "length<50,country,Country name should be less than 50 characters.";
//
//    $rules[] = "digits_only,mobile,Only digits are allowed for mobile field.";
//    $rules[] = "length=10,mobile,Mobile should be of 10 digits only.";
//
//    $errors = validateFields($_POST, $rules);
//
//    if (!empty($errors)):
//        $fields = $_POST;
//        $msg = '<div class="error" style="width:100%;">Please fix the following errors:<ul>';
//        foreach ($errors as $error):
//            $msg .= "<li>$error</li>";
//        endforeach;
//        $msg .= '</ul></div>';
//    else:
        $update = 'UPDATE user_master SET fname = "' . $_POST['fname'] . '", lname = "' . $_POST['lname'] . '", email = "' . strtolower($_POST['email']) . '", mobile = "' . $_POST['mobile'] . '", country = "' . strtolower($_POST['country']) . '", date_updated = "' . $curr_date_time . '" WHERE user_key = "' . $_SESSION['user_key'] . '"';
        $mysqli->query($update);
        $get_user_info = 'SELECT * FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
        $user_info_res = $mysqli->query($get_user_info);
        $user_info_row = mysqli_fetch_object($user_info_res);
        $msg = 'Information has been updated successfully.';
//    endif;
elseif (isset($_POST['pass_submit']) && $_POST['pass_submit'] == 'Save'):
    if (isset($_POST['new_password']) && $_POST['new_password'] != ''):
//        $rules[] = "required,current_password,Current password is required.";
//
//        $rules[] = "required,new_password,Password is required.";
//        $rules[] = "length>8,new_password,Password should at least be of 8 characters.";
//        $rules[] = "same_as,new_password,confirm_new_password,Passwords do not match.";
//
//        $errors = validateFields($_POST, $rules);
//
//        if (!empty($errors)):
//            $fields = $_POST;
//            $msg = '<div class="error" style="width:100%;">Please fix the following errors:<ul>';
//            foreach ($errors as $error):
//                $msg .= "<li>$error</li>";
//            endforeach;
//            $msg .= '</ul></div>';
//        else:
            $check_password = 'SELECT password FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
            $password_res = $mysqli->query($check_password);
            $password_row = mysqli_fetch_object($password_res);
            if ($password_row->password == crypt(trim($_POST['current_password']), $password_row->password)):
                $update = 'UPDATE user_master SET password = "' . crypt($_POST['new_password'], '$2y$12$' . $salt) . '" WHERE user_key = "' . $_SESSION['user_key'] . '"';
                $mysqli->query($update);
                $msg = 'Password has been updated successfully.';
            else:
                $msg = 'Current password is incorrect.';
            endif;
//        endif;
    elseif (isset($_FILES["change_avatar"]["name"]) && $_FILES["change_avatar"]["name"] != ''):
        $digits = 9;
        $count = 0;
        $path = 'img/avatar/';
        $newfilename = '';
        $max_file_size = 5120 * 100;
        $allowedExts = array("jpeg", "jpg", "png");
        $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $temp = explode(".", $_FILES["change_avatar"]["name"]);
        $extension = end($temp);
        $newfilename = $random_number . '_' . date('d_m_Y_H_i_s') . '.' . $extension;
        if (($_FILES["change_avatar"]["size"] > $max_file_size)):
            $msg = 'File size cannot exceed more than 500 KB.';
        elseif (!in_array($extension, $allowedExts)):
            $msg = 'Only JPG, JPEG, and PNG files are accepted.';
        elseif (strlen($_FILES["change_avatar"]["tmp_name"] > 65535)):
            $msg = 'Invalid avatar URL length.';
        else:
            $get_old_avatar = 'SELECT avatar FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
            $old_avatar_res = $mysqli->query($get_old_avatar);
            if ($old_avatar_res->num_rows > 0):
                $old_avatar_row = mysqli_fetch_object($old_avatar_res);
                if ($old_avatar_row->avatar != ''):
                    unlink($old_avatar_row->avatar);
                endif;
            endif;
            move_uploaded_file($_FILES["change_avatar"]["tmp_name"], $path . $newfilename);
            $update = 'UPDATE user_master SET avatar = "' . $path . $newfilename . '", date_updated = "' . date('Y-m-d H:i:s') . '" WHERE user_key = "' . $_SESSION['user_key'] . '"';
            $mysqli->query($update);
            $get_user_info = 'SELECT * FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
            $user_info_res = $mysqli->query($get_user_info);
            $user_info_row = mysqli_fetch_object($user_info_res);
            $avatar = $user_info_row->avatar;
            $msg = 'Avatar has been updated successfully.';
        endif;
    else:
        $rules = array();
        $msg = 'Nothing is updated.';
    endif;
endif;
/* save profile info */


$template = new Template;
$template->load("templates/my-profile-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("fname", ucwords($user_info_row->fname));
$template->replace("lname", ucwords($user_info_row->lname));
$template->replace("email", $user_info_row->email);
$template->replace("avatar", $avatar);
$template->replace("avatar_alt", $avatar_alt);
$template->replace("dob", ($user_info_row->dob == '') ? "Not Provided" : date_format(date_create($user_info_row->dob), 'd M Y'));
$template->replace("mobile", ($user_info_row->mobile == '') ? "0000000000" : $user_info_row->mobile);
$template->replace("country", ucwords($user_info_row->country));
$template->replace("thought", $thought);
$template->publish();
$db->mysqlclose();
?>