<?php

include 'admin_header.php';
include 'admin_footer.php';


/* declare variables */
$msg = '';
$project_id = '';
$project_content_1 = '';
$project_content_2 = '';
$project_content_3 = '';
$project_date = '';
$project_title = '';
$image_1 = '';
$image_2 = '';
$image_3 = '';
$image_4 = '';
$image_5 = '';
$image_6 = '';
$image_7 = '';
$image_8 = '';
$image_9 = '';
$image_10 = '';
$image_link_1 = '';
$image_link_2 = '';
$image_link_3 = '';
$image_link_4 = '';
$image_link_5 = '';
$image_link_6 = '';
$image_link_7 = '';
$image_link_8 = '';
$image_link_9 = '';
$image_link_10 = '';
$image_caption_1 = '';
$image_caption_2 = '';
$image_caption_3 = '';
$image_caption_4 = '';
$image_caption_5 = '';
$image_caption_6 = '';
$image_caption_7 = '';
$image_caption_8 = '';
$image_caption_9 = '';
$image_caption_10 = '';
$is_home = '';
$type = '';
$path = 'img/projects/';
$digits = 9;
$count = 0;
$project_links = '';
$image_layouts = '';
$image_layouts_2 = '';
/* declare variables */


/* edit prjoect information */
if (isset($_GET['project_id']) && $_GET['project_id'] != '' && isValidNumber($_GET['project_id'])):
    $get_project = 'SELECT * FROM projects WHERE id = "' . trim($_GET['project_id']) . '"';
    $project_res = $mysqli->query($get_project);
    if ($project_res->num_rows > 0):
        $project_row = mysqli_fetch_object($project_res);
        if ($project_row->is_home == 'Y'):
            $is_home = '<option value="Y">Yes</option><option value="N">No</option>';
        else:
            $is_home = '<option value="N">No</option><option value="Y">Yes</option>';
        endif;


        if ($project_row->project_type == 'exhibition'):
            $type = '<option value="exhibition" selected>Exhibition</option><option value="project">Project</option><option value="event">Event</option>';
        elseif ($project_row->project_type == 'event'):
            $type = '<option value="exhibition">Exhibition</option><option value="project">Project</option><option value="event" selected>Event</option>';
        elseif ($project_row->project_type == 'project'):
            $type = '<option value="exhibition">Exhibition</option><option value="project" selected>Project</option><option value="event">Event</option>';
        endif;

        $get_image_layout = 'SELECT * FROM image_layouts WHERE status = "enabled"';
        $image_layout_res = $mysqli->query($get_image_layout);
        if ($image_layout_res->num_rows > 0):
            while ($image_layout_row = mysqli_fetch_object($image_layout_res)):
                if ($project_row->image_layout_id == $image_layout_row->id):
                    $image_layouts .= '<option value="' . $image_layout_row->id . '" selected>' . strtoupper($image_layout_row->layout_name) . '</option>';
                else:
                    $image_layouts .= '<option value="' . $image_layout_row->id . '">' . strtoupper($image_layout_row->layout_name) . '</option>';
                endif;
            endwhile;
        endif;

        $get_image_layout_2 = 'SELECT * FROM image_layouts WHERE status = "enabled"';
        $image_layout_res_2 = $mysqli->query($get_image_layout_2);
        if ($image_layout_res_2->num_rows > 0):
            while ($image_layout_row_2 = mysqli_fetch_object($image_layout_res_2)):
                if ($project_row->image_layout_id_2 == $image_layout_row_2->id):
                    $image_layouts_2 .= '<option value="' . $image_layout_row_2->id . '" selected>' . strtoupper($image_layout_row_2->layout_name) . '</option>';
                else:
                    $image_layouts_2 .= '<option value="' . $image_layout_row_2->id . '">' . strtoupper($image_layout_row_2->layout_name) . '</option>';
                endif;
            endwhile;
        endif;

        if ($project_row->image_layout_id == 'exhibition'):
            $type = '<option value="exhibition" selected>Exhibition</option><option value="project">Project</option><option value="event">Event</option>';
        elseif ($project_row->project_type == 'event'):
            $type = '<option value="exhibition">Exhibition</option><option value="project">Project</option><option value="event" selected>Event</option>';
        elseif ($project_row->project_type == 'project'):
            $type = '<option value="exhibition">Exhibition</option><option value="project" selected>Project</option><option value="event">Event</option>';
        endif;

        $project_id = $project_row->id;
        $project_content_1 = $project_row->project_content_1;
        $project_content_2 = $project_row->project_content_2;
        $project_content_3 = $project_row->project_content_3;
        $project_title = $project_row->project_title;
        $project_date = $project_row->project_date;
        $image_caption_1 = $project_row->image_caption_1;
        $image_caption_2 = $project_row->image_caption_2;
        $image_caption_3 = $project_row->image_caption_3;
        $image_caption_4 = $project_row->image_caption_4;
        $image_caption_5 = $project_row->image_caption_5;
        $image_caption_6 = $project_row->image_caption_6;
        $image_caption_7 = $project_row->image_caption_7;
        $image_caption_8 = $project_row->image_caption_8;
        $image_caption_9 = $project_row->image_caption_9;
        $image_caption_10 = $project_row->image_caption_10;


        /* get images */
        if (empty($project_row->image_1)):
            $image_1 = 'no_image.jpeg';
        else:
            $image_1 = $project_row->image_1;
        endif;
        if (empty($project_row->image_2)):
            $image_2 = 'no_image.jpeg';
        else:
            $image_2 = $project_row->image_2;
        endif;
        if (empty($project_row->image_3)):
            $image_3 = 'no_image.jpeg';
        else:
            $image_3 = $project_row->image_3;
        endif;
        if (empty($project_row->image_4)):
            $image_4 = 'no_image.jpeg';
        else:
            $image_4 = $project_row->image_4;
        endif;
        if (empty($project_row->image_5)):
            $image_5 = 'no_image.jpeg';
        else:
            $image_5 = $project_row->image_5;
        endif;
        if (empty($project_row->image_6)):
            $image_6 = 'no_image.jpeg';
        else:
            $image_6 = $project_row->image_6;
        endif;
        if (empty($project_row->image_7)):
            $image_7 = 'no_image.jpeg';
        else:
            $image_7 = $project_row->image_7;
        endif;
        if (empty($project_row->image_8)):
            $image_8 = 'no_image.jpeg';
        else:
            $image_8 = $project_row->image_8;
        endif;
        if (empty($project_row->image_9)):
            $image_9 = 'no_image.jpeg';
        else:
            $image_9 = $project_row->image_9;
        endif;
        if (empty($project_row->image_10)):
            $image_10 = 'no_image.jpeg';
        else:
            $image_10 = $project_row->image_10;
        endif;

        $image_link_1 = $project_row->image_link_1;
        $image_link_2 = $project_row->image_link_2;
        $image_link_3 = $project_row->image_link_3;
        $image_link_4 = $project_row->image_link_4;
        $image_link_5 = $project_row->image_link_5;
        $image_link_6 = $project_row->image_link_6;
        $image_link_7 = $project_row->image_link_7;
        $image_link_8 = $project_row->image_link_8;
        $image_link_9 = $project_row->image_link_9;
        $image_link_10 = $project_row->image_link_10;
        /* get images */


        /* get links */
        $project_links = $project_row->links;
    /* get links */
    endif;
endif;
/* edit contact us information */


/* update contact us information */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $rules = array();

    $rules[] = "required,project_title,Please enter project title";
    $rules[] = "length<101,project_title,Project title should be less than or equal to 100 characters";

//    $rules[] = "required,project_date,Please enter project date";
//    $rules[] = "length<51,project_date,Project date should be less than or equal to 50 characters";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $project_title = trim(htmlspecialchars(stripslashes($_POST['project_title'])));
        $project_date = trim(htmlspecialchars(stripslashes($_POST['project_date'])));
        $project_id = trim($_POST['project_id']);
        $project_content_1 = trim($_POST['project_content_1']);
        $project_content_2 = trim($_POST['project_content_2']);
        $project_content_3 = trim($_POST['project_content_3']);
        $image_caption_1 = trim(htmlspecialchars(stripslashes($_POST['image_caption_1'])));
        $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls">';
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
        $msg .= '</div></div>';
    else:
        $get_project_images = 'SELECT * FROM projects WHERE id = "' . trim($_POST['project_id']) . '"';
        $project_images_res = $mysqli->query($get_project_images);
        if ($project_images_res->num_rows > 0):
            $project_images_row = mysqli_fetch_object($project_images_res);
            $image_1 = $project_images_row->image_1;
            $image_2 = $project_images_row->image_2;
            $image_3 = $project_images_row->image_3;
            $image_4 = $project_images_row->image_4;
            $image_5 = $project_images_row->image_5;
            $image_6 = $project_images_row->image_6;
            $image_7 = $project_images_row->image_7;
            $image_8 = $project_images_row->image_8;
            $image_9 = $project_images_row->image_9;
            $image_10 = $project_images_row->image_10;
        endif;

        if (isset($_FILES['image_1']) && $_FILES["image_1"]["name"]):
            $date = new DateTime();
            unlink($path . $image_1);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_1"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_1"]["tmp_name"], $path . $newfilename);
            $image_1 = $newfilename;
        else:
            if ($_POST['image_1'] == 'no_image.jpeg'):
                $image_1 = '';
            else:
                $image_1 = $_POST['image_1'];
            endif;
        endif;

        if (isset($_FILES['image_2']) && $_FILES["image_2"]["name"]):
            $date = new DateTime();
            unlink($path . $image_2);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_2"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_2"]["tmp_name"], $path . $newfilename);
            $image_2 = $newfilename;
        else:
            if ($_POST['image_2'] == 'no_image.jpeg'):
                $image_2 = '';
            else:
                $image_2 = $_POST['image_2'];
            endif;
        endif;

        if (isset($_FILES['image_3']) && $_FILES["image_3"]["name"]):
            $date = new DateTime();
            unlink($path . $image_3);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_3"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_3"]["tmp_name"], $path . $newfilename);
            $image_3 = $newfilename;
        else:
            if ($_POST['image_3'] == 'no_image.jpeg'):
                $image_3 = '';
            else:
                $image_3 = $_POST['image_3'];
            endif;
        endif;

        if (isset($_FILES['image_4']) && $_FILES["image_4"]["name"]):
            $date = new DateTime();
            unlink($path . $image_4);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_4"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_4"]["tmp_name"], $path . $newfilename);
            $image_4 = $newfilename;
        else:
            if ($_POST['image_4'] == 'no_image.jpeg'):
                $image_4 = '';
            else:
                $image_4 = $_POST['image_4'];
            endif;
        endif;

        if (isset($_FILES['image_5']) && $_FILES["image_5"]["name"]):
            $date = new DateTime();
            unlink($path . $image_5);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_5"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_5"]["tmp_name"], $path . $newfilename);
            $image_5 = $newfilename;
        else:
            if ($_POST['image_5'] == 'no_image.jpeg'):
                $image_5 = '';
            else:
                $image_5 = $_POST['image_5'];
            endif;
        endif;

        if (isset($_FILES['image_6']) && $_FILES["image_6"]["name"]):
            $date = new DateTime();
            unlink($path . $image_6);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_6"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_6"]["tmp_name"], $path . $newfilename);
            $image_6 = $newfilename;
        else:
            if ($_POST['image_6'] == 'no_image.jpeg'):
                $image_6 = '';
            else:
                $image_6 = $_POST['image_6'];
            endif;
        endif;

        if (isset($_FILES['image_7']) && $_FILES["image_7"]["name"]):
            $date = new DateTime();
            unlink($path . $image_7);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_7"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_7"]["tmp_name"], $path . $newfilename);
            $image_7 = $newfilename;
        else:
            if ($_POST['image_7'] == 'no_image.jpeg'):
                $image_7 = '';
            else:
                $image_7 = $_POST['image_7'];
            endif;
        endif;

        if (isset($_FILES['image_8']) && $_FILES["image_8"]["name"]):
            $date = new DateTime();
            unlink($path . $image_8);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_8"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_8"]["tmp_name"], $path . $newfilename);
            $image_8 = $newfilename;
        else:
            if ($_POST['image_8'] == 'no_image.jpeg'):
                $image_8 = '';
            else:
                $image_8 = $_POST['image_8'];
            endif;
        endif;

        if (isset($_FILES['image_9']) && $_FILES["image_9"]["name"]):
            $date = new DateTime();
            unlink($path . $image_9);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_9"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_9"]["tmp_name"], $path . $newfilename);
            $image_9 = $newfilename;
        else:
            if ($_POST['image_9'] == 'no_image.jpeg'):
                $image_9 = '';
            else:
                $image_9 = $_POST['image_9'];
            endif;
        endif;

        if (isset($_FILES['image_10']) && $_FILES["image_10"]["name"]):
            $date = new DateTime();
            unlink($path . $image_10);
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["image_10"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["image_10"]["tmp_name"], $path . $newfilename);
            $image_10 = $newfilename;
        else:
            if ($_POST['image_10'] == 'no_image.jpeg'):
                $image_10 = '';
            else:
                $image_10 = $_POST['image_10'];
            endif;
        endif;

        if ($_POST['is_home'] == 'Y'):
            $is_home = 'Y';
            $mysqli->query('UPDATE projects SET is_home = "N"');
            $mysqli->query('UPDATE projects SET is_home = "Y" WHERE id = ' . $_POST['project_id']);
        else:
            $is_home = 'N';
        endif;

        $update_array['project_title'] = trim(htmlspecialchars(addslashes($_POST['project_title'])));
        $update_array['project_date'] = (trim(htmlspecialchars(addslashes($_POST['project_date']))) != '' ? trim(htmlspecialchars(addslashes($_POST['project_date']))) : '&nbsp;');
        $update_array['project_content_1'] = trim(addslashes($_POST['project_content_1']));
        $update_array['project_content_2'] = trim(addslashes($_POST['project_content_2']));
        $update_array['project_content_3'] = trim(addslashes($_POST['project_content_3']));
        $update_array['image_1'] = $image_1;
        $update_array['image_2'] = $image_2;
        $update_array['image_3'] = $image_3;
        $update_array['image_4'] = $image_4;
        $update_array['image_5'] = $image_5;
        $update_array['image_6'] = $image_6;
        $update_array['image_7'] = $image_7;
        $update_array['image_8'] = $image_8;
        $update_array['image_9'] = $image_9;
        $update_array['image_10'] = $image_10;
        $update_array['image_link_1'] = trim(addslashes($_POST['image_link_1']));
        $update_array['image_link_2'] = trim(addslashes($_POST['image_link_2']));
        $update_array['image_link_3'] = trim(addslashes($_POST['image_link_3']));
        $update_array['image_link_4'] = trim(addslashes($_POST['image_link_4']));
        $update_array['image_link_5'] = trim(addslashes($_POST['image_link_5']));
        $update_array['image_link_6'] = trim(addslashes($_POST['image_link_6']));
        $update_array['image_link_7'] = trim(addslashes($_POST['image_link_7']));
        $update_array['image_link_8'] = trim(addslashes($_POST['image_link_8']));
        $update_array['image_link_9'] = trim(addslashes($_POST['image_link_9']));
        $update_array['image_link_10'] = trim(addslashes($_POST['image_link_10']));
        $update_array['image_caption_1'] = trim(addslashes($_POST['image_caption_1']));
        $update_array['image_caption_2'] = trim(addslashes($_POST['image_caption_2']));
        $update_array['image_caption_3'] = trim(addslashes($_POST['image_caption_3']));
        $update_array['image_caption_4'] = trim(addslashes($_POST['image_caption_4']));
        $update_array['image_caption_5'] = trim(addslashes($_POST['image_caption_5']));
        $update_array['image_caption_6'] = trim(addslashes($_POST['image_caption_6']));
        $update_array['image_caption_7'] = trim(addslashes($_POST['image_caption_7']));
        $update_array['image_caption_8'] = trim(addslashes($_POST['image_caption_8']));
        $update_array['image_caption_9'] = trim(addslashes($_POST['image_caption_9']));
        $update_array['image_caption_10'] = trim(addslashes($_POST['image_caption_10']));
        $update_array['links'] = trim(addslashes($_POST['project_links']));
        $update_array['is_home'] = $is_home;
        $update_array['project_type'] = $_POST['type'];
        $update_array['image_layout_id'] = $_POST['image_layout'];
        $update_array['image_layout_id_2'] = $_POST['image_layout_2'];
        $update_array['date_updated'] = $curr_date_time;
        update($mysqli, "projects", $update_array, trim($_POST['project_id']), 'id');

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Project with id ' . trim($_POST['project_id']) . ' updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('Location: projects.php?msg=edited');
    endif;
endif;
/* update contact us information */


$template->load("templates/project-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("project_title", $project_title);
$template->replace("project_content_1", $project_content_1);
$template->replace("project_content_2", $project_content_2);
$template->replace("project_content_3", $project_content_3);
$template->replace("project_date", $project_date);
$template->replace("project_id", $project_id);
$template->replace("image_1", $image_1);
$template->replace("image_2", $image_2);
$template->replace("image_3", $image_3);
$template->replace("image_4", $image_4);
$template->replace("image_5", $image_5);
$template->replace("image_6", $image_6);
$template->replace("image_7", $image_7);
$template->replace("image_8", $image_8);
$template->replace("image_9", $image_9);
$template->replace("image_10", $image_10);
$template->replace("image_link_1", $image_link_1);
$template->replace("image_link_2", $image_link_2);
$template->replace("image_link_3", $image_link_3);
$template->replace("image_link_4", $image_link_4);
$template->replace("image_link_5", $image_link_5);
$template->replace("image_link_6", $image_link_6);
$template->replace("image_link_7", $image_link_7);
$template->replace("image_link_8", $image_link_8);
$template->replace("image_link_9", $image_link_9);
$template->replace("image_link_10", $image_link_10);
$template->replace("image_caption_1", $image_caption_1);
$template->replace("image_caption_2", $image_caption_2);
$template->replace("image_caption_3", $image_caption_3);
$template->replace("image_caption_4", $image_caption_4);
$template->replace("image_caption_5", $image_caption_5);
$template->replace("image_caption_6", $image_caption_6);
$template->replace("image_caption_7", $image_caption_7);
$template->replace("image_caption_8", $image_caption_8);
$template->replace("image_caption_9", $image_caption_9);
$template->replace("image_caption_10", $image_caption_10);
$template->replace("project_links", $project_links);
$template->replace("is_home", $is_home);
$template->replace("type", $type);
$template->replace("image_layouts", $image_layouts);
$template->replace("image_layouts_2", $image_layouts_2);
$template->publish();
$db->mysqlclose();
?>