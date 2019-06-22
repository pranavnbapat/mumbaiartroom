<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$title = '';
$publications = '';
$path = 'img/publications/';
$publication_image = '';
$digits = 9;
$count = 0;
//$publication_document = '';
$publication_sorting = '';


if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content has been updated!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'added'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content successfully added!</p></div></div>';
endif;


/* add publication content */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
    $rules = array();

    $rules[] = "length<101,title,Title should be less than or equal to 100 characters.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $download_link = trim($_POST['download_link']);
        $title = trim($_POST['title']);

        $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls">';
        foreach ($errors as $error):
            $msg .= "<p style='color: #b94a48; font-weight:bold;'>$error<br /></p>";
        endforeach;
        $msg .= '</div></div>';
    else:
        if (isset($_FILES["publication_image"]["name"]) && $_FILES["publication_image"]["name"] != ''):
            $date = new DateTime();
            $newfilename = '';
            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $temp = explode(".", $_FILES["publication_image"]["name"]);
            $extension = end($temp);
            $newfilename = $random_number . '_' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
            move_uploaded_file($_FILES["publication_image"]["tmp_name"], $path . $newfilename);
            $publication_image = $newfilename;
        endif;

//        if (isset($_FILES["publication_document"]["name"]) && $_FILES["publication_document"]["name"] != ''):
//            $date = new DateTime();
//            $newfilename = '';
//            $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
//            $temp = explode(".", $_FILES["publication_document"]["name"]);
//            $extension = end($temp);
//            $newfilename = $random_number . '_' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
//            move_uploaded_file($_FILES["publication_document"]["tmp_name"], 'files/publications/' . $newfilename);
//            $publication_document = $newfilename;
//        endif;

        $get_last_order = 'SELECT max(publication_order) as max_publication_order FROM publications';
        $last_order_res = $mysqli->query($get_last_order);
        $last_order_row = mysqli_fetch_object($last_order_res);

        $insert_array['user_id'] = $user_info_row->id;
        $insert_array['image'] = $publication_image;
//        $insert_array['publication_document'] = $publication_document;
        $insert_array['title'] = trim(htmlspecialchars($_POST['title']));
        $insert_array['publication_content'] = trim($_POST['publication_content']);
        $insert_array['status'] = 'published';
        $insert_array['publication_order'] = $last_order_row->max_publication_order + 1;
        $insert_array['date_created'] = $curr_date_time;
        $last_insert_id = insert($mysqli, "publications", $insert_array);

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Publication content added.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        header('location: publication.php?msg=added');
    endif;
endif;
/* add publication content */


/* get publication content */
$get_publications = 'SELECT * FROM publications ORDER BY date_created DESC';
$publications_res = $mysqli->query($get_publications);
if ($publications_res->num_rows > 0):
    $i = $publications_res->num_rows;
    while ($publications_row = mysqli_fetch_object($publications_res)):
        if ($publications_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $publications_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $publications_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($publications_row->date_updated != '' && $publications_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $publications_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;
        if ($publications_row->image == ''):
            $publication_image = 'img/no_image.jpeg';
        else:
            $publication_image = 'img/publications/' . $publications_row->image;
        endif;

        $publications .= "<tr>
                        <td>{$i}</td>
                        <td><img src='{$publication_image}' style='width:100px;' /></td>
                        <td>{$publications_row->title}</td>
                        <td>{$publications_row->publication_content}</td>
                        <td>{$publications_row->date_created}</td>
                        <td>{$updated_date}</td>
                        <td>{$status} <a href='publication-edit.php?publication_id=" . $publications_row->id . "' class='edit btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a> <a class='btn btn-danger btn-xs' onclick='delete_record(" . $publications_row->id . ")'><i class='fa fa-trash-o'></i></a></td>
                    </tr>";
        $i--;
    endwhile;
//    <td><a href='publication-upload-content.php?id={$publications_row->id}' class='open_popup'>Upload Content</a></td>
endif;
/* get publication content */


/* get publication for sorting */
//$query = 'SELECT p.* FROM publications p WHERE p.`status` = "published" ORDER BY p.publication_order ASC';
//$res = $mysqli->query($query);
//if ($res->num_rows > 0):
//    while ($row = mysqli_fetch_object($res)):
//        $publication_sorting .= '<li id = "array_order_' . $row->id . '">' . $row->title . '</li>';
//    endwhile;
//endif;
/* get publication for sorting */


$template->load("templates/publication.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("title", $title);
$template->replace("publications", $publications);
$template->replace("publication_sorting", $publication_sorting);
$template->publish();
$db->mysqlclose();
?>