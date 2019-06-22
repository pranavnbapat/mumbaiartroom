<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$publication_id = '';
$publication_content = '';
$publication_image = '';
$publication_title = '';
$path = 'img/publications/';
$fileLst = '';
$publication_file = '';


/* edit publication information */
if (isset($_GET['publication_id']) && $_GET['publication_id'] != '' && isValidNumber($_GET['publication_id'])):
    $get_publications = 'SELECT * FROM publications WHERE id = ' . $_GET['publication_id'];
    $publications_res = $mysqli->query($get_publications);
    if ($publications_res->num_rows > 0):
        $publications_row = mysqli_fetch_object($publications_res);
        $publication_id = $publications_row->id;
        $publication_content = $publications_row->publication_content;
        $publication_image = $publications_row->image;
        $publication_title = $publications_row->title;
        $publication_file = $publications_row->publication_file;
    endif;

    // get upload content list
    $dir = 'files/publications/';

    $results_array = array();

    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {
            //Notice the parentheses I added:
            while (($file = readdir($handle)) !== FALSE) {
                $results_array[] = $file;
            }
            closedir($handle);
        }
    }

    foreach ($results_array as $value) {
        if (is_file($dir . $value)):
            if ($publication_file == $value):
                $fileLst .= '<option value = "' . $value . '" selected>' . $value . '</option>';
            else:
                $fileLst .= '<option value = "' . $value . '">' . $value . '</option>';
            endif;
        endif;
    }
    $getPubContList = '';
endif;
/* edit publication information */


/* update publication information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):

    $rules = array();

    $rules[] = "required,publication_title,Please enter publication title";
    $rules[] = "length<201,publication_title,Publication title should be less than 200 characters.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $publication_id = $_POST['publication_id'];
        $publication_title = trim(htmlspecialchars($_POST['publication_title']));
        $publication_content = trim($_POST['publication_content']);
        $publication_image = $_POST['publication_image'];
        $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls">';
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
        $msg = '</div></div>';
    else:
        $get_publication_image = 'SELECT image, publication_file FROM publications WHERE id = ' . $_POST['publication_id'];
        $publication_image_res = $mysqli->query($get_publication_image);
        $publication_image_row = mysqli_fetch_object($publication_image_res);
        $publication_image = $publication_image_row->image;

        if (isset($_FILES['publication_image']) && $_FILES["publication_image"]["name"]):
            $date = new DateTime();
            unlink($path . $publication_image);
            $digits = 9;
            $count = 0;
            $max_file_size = 5120 * 100;
            $allowedExts = array("jpeg", "jpg", "png", "JPG", "JPEG", "PNG");
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["publication_image"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            if (!in_array($extension, $allowedExts)):
                $msg = 'Only JPG, JPEG, and PNG files are accepted.';
            else:
                move_uploaded_file($_FILES["publication_image"]["tmp_name"], $path . $newfilename);
                $publication_image = $newfilename;
            endif;
        else:
            $publication_image = $_POST['publication_image'];
        endif;

        $update_array['title'] = trim($_POST['publication_title']);
        $update_array['publication_content'] = trim($_POST['publication_content']);
        $update_array['image'] = $publication_image;
        $update_array['publication_file'] = $_POST['file_name'];
        $update_array['date_updated'] = $curr_date_time;
        update($mysqli, "publications", $update_array, $_POST['publication_id'], 'id');

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Publication content updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('Location: publication.php?msg=edited');
    endif;
endif;
/* update publication information */

$template->load("templates/publication-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("publication_id", $publication_id);
$template->replace("publication_content", $publication_content);
$template->replace("publication_image", $publication_image);
$template->replace("publication_title", $publication_title);
$template->replace("msg", $msg);
$template->replace("fileLst", $fileLst);
$template->publish();
$db->mysqlclose();
?>