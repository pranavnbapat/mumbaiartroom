<?php

include 'admin_header.php';
include 'admin_footer.php';


/* declare variables */
$msg = '';
$project_content_1 = '';
$project_content_2 = '';
$project_date = '';
$project_title = '';
$projects_list = '';
$path = 'img/projects/';
$digits = 9;
$count = 0;
$image_layouts = '<option value = "0">Please select image layout</option>';
$project_sorting = '';
/* declare variables */


/* generate message */
if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content has been updated!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'added'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content has been added!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'canceled'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:#b94a48; font-weight:bold;">Content editing has been canceled!</p></div></div>';
endif;
/* generate message */


/* get image layouts */
$image_layouts_res = $mysqli->query('SELECT id, layout_name FROM image_layouts WHERE status = "enabled"');
if ($image_layouts_res->num_rows > 0):
    while ($image_layouts_row = mysqli_fetch_object($image_layouts_res)):
        $image_layouts .= '<option value = "' . $image_layouts_row->id . '">' . strtoupper($image_layouts_row->layout_name) . '</option>';
    endwhile;
endif;
/* get image layouts */


/* add project */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
    $rules = array();

    $rules[] = "required,project_title,Please enter project title";
    $rules[] = "length<101,project_title,Project title should be less than or equal to 100 characters";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $project_title = trim(htmlspecialchars(addslashes($_POST['project_title'])));
        $project_date = trim(htmlspecialchars(addslashes($_POST['project_date'])));
        $project_content_1 = trim(addslashes($_POST['project_content_1']));
        $project_content_2 = trim(addslashes($_POST['project_content_2']));
        $project_content_3 = trim(addslashes($_POST['project_content_3']));
        $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls">';
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
        $msg .= '</div></div>';
    else:
        if (isset($_FILES["media_1"]) && $_FILES["media_1"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_1"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_1"]["tmp_name"], $path . $newfilename);
            $media_1 = $newfilename;
        else:
            $media_1 = '';
        endif;

        if (isset($_FILES["media_2"]) && $_FILES["media_2"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $max_file_size = 5120 * 100;
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_2"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_2"]["tmp_name"], $path . $newfilename);
            $media_2 = $newfilename;
        else:
            $media_2 = '';
        endif;

        if (isset($_FILES["media_3"]) && $_FILES["media_3"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_3"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_3"]["tmp_name"], $path . $newfilename);
            $media_3 = $newfilename;
        else:
            $media_3 = '';
        endif;

        if (isset($_FILES["media_4"]) && $_FILES["media_4"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_4"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_4"]["tmp_name"], $path . $newfilename);
            $media_4 = $newfilename;
        else:
            $media_4 = '';
        endif;

        if (isset($_FILES["media_5"]) && $_FILES["media_5"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_5"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_5"]["tmp_name"], $path . $newfilename);
            $media_5 = $newfilename;
        else:
            $media_5 = '';
        endif;

        if (isset($_FILES["media_6"]) && $_FILES["media_6"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_6"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_6"]["tmp_name"], $path . $newfilename);
            $media_6 = $newfilename;
        else:
            $media_6 = '';
        endif;

        if (isset($_FILES["media_7"]) && $_FILES["media_7"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_7"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_7"]["tmp_name"], $path . $newfilename);
            $media_7 = $newfilename;
        else:
            $media_7 = '';
        endif;

        if (isset($_FILES["media_8"]) && $_FILES["media_8"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_8"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_8"]["tmp_name"], $path . $newfilename);
            $media_8 = $newfilename;
        else:
            $media_8 = '';
        endif;

        if (isset($_FILES["media_9"]) && $_FILES["media_9"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_9"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_9"]["tmp_name"], $path . $newfilename);
            $media_9 = $newfilename;
        else:
            $media_9 = '';
        endif;

        if (isset($_FILES["media_10"]) && $_FILES["media_10"]["name"]):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["media_10"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["media_10"]["tmp_name"], $path . $newfilename);
            $media_10 = $newfilename;
        else:
            $media_10 = '';
        endif;

        if (isset($_POST['is_home']) && $_POST['is_home'] == 'Y'):
            $set_new_home_page = 'SELECT * FROM projects WHERE is_home = "Y"';
            $new_home_page_res = $mysqli->query($set_new_home_page);
            if ($new_home_page_res->num_rows > 0):
                $update_home_page = 'UPDATE projects SET is_home = "N"';
                $mysqli->query($update_home_page);
            endif;
        endif;

        $get_last_order = 'SELECT max(project_order) as max_project_order FROM projects';
        $last_order_res = $mysqli->query($get_last_order);
        $last_order_row = mysqli_fetch_object($last_order_res);

        $insert_array['user_id'] = $user_info_row->id;
        $insert_array['project_title'] = trim(htmlspecialchars(addslashes($_POST['project_title'])));
        $insert_array['project_date'] = (trim(htmlspecialchars(addslashes($_POST['project_date']))) != '' ? trim(htmlspecialchars(addslashes($_POST['project_date']))) : '&nbsp;');
        $insert_array['project_content_1'] = trim(addslashes($_POST['project_content_1']));
        $insert_array['project_content_2'] = trim(addslashes($_POST['project_content_2']));
        $insert_array['project_content_3'] = trim(addslashes($_POST['project_content_3']));
        $insert_array['status'] = 'published';
        $insert_array['is_home'] = $_POST['is_home'];
        $insert_array['project_type'] = $_POST['type'];
        $insert_array['date_created'] = $curr_date_time;
        $insert_array['image_layout_id'] = $_POST['image_layout'];
        if (empty($_POST['image_layout_2'])):
            $insert_array['image_layout_id_2'] = 1;
        else:
            $insert_array['image_layout_id_2'] = $_POST['image_layout_2'];
        endif;
        $insert_array['image_1'] = $media_1;
        $insert_array['image_2'] = $media_2;
        $insert_array['image_3'] = $media_3;
        $insert_array['image_4'] = $media_4;
        $insert_array['image_5'] = $media_5;
        $insert_array['image_6'] = $media_6;
        $insert_array['image_7'] = $media_7;
        $insert_array['image_8'] = $media_8;
        $insert_array['image_9'] = $media_9;
        $insert_array['image_10'] = $media_10;
        $insert_array['image_link_1'] = trim(addslashes($_POST['image_link_1']));
        $insert_array['image_link_2'] = trim(addslashes($_POST['image_link_2']));
        $insert_array['image_link_3'] = trim(addslashes($_POST['image_link_3']));
        $insert_array['image_link_4'] = trim(addslashes($_POST['image_link_4']));
        $insert_array['image_link_5'] = trim(addslashes($_POST['image_link_5']));
        $insert_array['image_link_6'] = trim(addslashes($_POST['image_link_6']));
        $insert_array['image_link_7'] = trim(addslashes($_POST['image_link_7']));
        $insert_array['image_link_8'] = trim(addslashes($_POST['image_link_8']));
        $insert_array['image_link_9'] = trim(addslashes($_POST['image_link_9']));
        $insert_array['image_link_10'] = trim(addslashes($_POST['image_link_10']));
        $insert_array['image_caption_1'] = trim(addslashes($_POST['image_caption_1']));
        $insert_array['image_caption_2'] = trim(addslashes($_POST['image_caption_2']));
        $insert_array['image_caption_3'] = trim(addslashes($_POST['image_caption_3']));
        $insert_array['image_caption_4'] = trim(addslashes($_POST['image_caption_4']));
        $insert_array['image_caption_5'] = trim(addslashes($_POST['image_caption_5']));
        $insert_array['image_caption_6'] = trim(addslashes($_POST['image_caption_6']));
        $insert_array['image_caption_7'] = trim(addslashes($_POST['image_caption_7']));
        $insert_array['image_caption_8'] = trim(addslashes($_POST['image_caption_8']));
        $insert_array['image_caption_9'] = trim(addslashes($_POST['image_caption_9']));
        $insert_array['image_caption_10'] = trim(addslashes($_POST['image_caption_10']));
        $insert_array['links'] = trim(addslashes($_POST['project_links']));
        $insert_array['project_order'] = $last_order_row->max_project_order + 1;
        $last_insert_id = insert($mysqli, "projects", $insert_array);


        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Project has been added.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('location:projects.php?msg=added');
    endif;
endif;
/* add project */


/* show projects list */
$get_projects = 'SELECT * FROM projects';
$projects_res = $mysqli->query($get_projects);
if ($projects_res->num_rows > 0):
    $i = $projects_res->num_rows;
    while ($projects_row = mysqli_fetch_object($projects_res)):
        if ($projects_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $projects_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $projects_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($projects_row->date_updated != '' && $projects_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $projects_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;
        $edit_link = '<a href="project-edit.php?project_id=' . $projects_row->id . '" class="edit btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>';
        $delete_link = '<a class="btn btn-danger btn-xs" onclick="delete_record(' . $projects_row->id . ')"><i class="fa fa-trash-o"></i></a>';
        $projects_list .= ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $projects_row->project_title . '</td>
                                <td>' . $projects_row->project_date . '</td>
                                <td>' . $projects_row->is_home . '</td>
                                <td>' . $projects_row->date_created . '</td>
                                <td>' . $updated_date . '</td>
                                <td>' . $status . ' ' . $edit_link . ' ' . $delete_link . ' </td>
                            </tr>';
        $i--;
    endwhile;
endif;
/* show projects list */


/* get projects content for sorting */
//$query = 'SELECT p.* FROM projects p WHERE project_type = "project" ORDER BY p.project_order ASC';
//$res = $mysqli->query($query);
//if ($res->num_rows > 0):
//    while ($row = mysqli_fetch_object($res)):
//        $project_sorting .= '<li id = "array_order_' . $row->id . '">' . $row->project_title . ' -- ' . $row->project_type . '</li>';
//    endwhile;
//endif;
/* get projects content for sorting */


$template->load("templates/projects.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("project_title", $project_title);
$template->replace("project_content_1", $project_content_1);
$template->replace("project_content_2", $project_content_2);
$template->replace("project_date", $project_date);
$template->replace("projects_list", $projects_list);
$template->replace("image_layouts", $image_layouts);
$template->replace("project_sorting", $project_sorting);
$template->publish();
$db->mysqlclose();
?>