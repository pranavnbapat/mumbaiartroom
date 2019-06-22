<?php

session_start();

include 'config/common.php';

$get_user_info = 'SELECT um.id, um.fname, um.gender, um.avatar, um.lname, urm.role_name, um.role_id FROM user_master um INNER JOIN user_role_master urm ON urm.id = um.role_id WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_info_res = $mysqli->query($get_user_info);
$user_info_row = mysqli_fetch_object($user_info_res);

if (isset($_GET['project_id']) && $_GET['project_id'] != '' && isValidNumber($_GET['project_id'])):
    $get_project_media_record = 'SELECT * FROM projects WHERE id = "' . $_GET['project_id'] . '"';
    $project_media_record_res = $mysqli->query($get_project_media_record);
    if ($project_media_record_res->num_rows > 0):
        while ($project_media_record_row = mysqli_fetch_object($project_media_record_res)):
            if ($project_media_record_row->image_1 != ''):
                unlink('img/projects/' . $project_media_record_row->image_1);
            endif;
            if ($project_media_record_row->image_2 != ''):
                unlink('img/projects/' . $project_media_record_row->image_2);
            endif;
            if ($project_media_record_row->image_3 != ''):
                unlink('img/projects/' . $project_media_record_row->image_3);
            endif;
            if ($project_media_record_row->image_4 != ''):
                unlink('img/projects/' . $project_media_record_row->image_4);
            endif;
            if ($project_media_record_row->image_5 != ''):
                unlink('img/projects/' . $project_media_record_row->image_5);
            endif;
            if ($project_media_record_row->image_6 != ''):
                unlink('img/projects/' . $project_media_record_row->image_6);
            endif;
            if ($project_media_record_row->image_7 != ''):
                unlink('img/projects/' . $project_media_record_row->image_7);
            endif;
            if ($project_media_record_row->image_8 != ''):
                unlink('img/projects/' . $project_media_record_row->image_8);
            endif;
            if ($project_media_record_row->image_9 != ''):
                unlink('img/projects/' . $project_media_record_row->image_9);
            endif;
            if ($project_media_record_row->image_10 != ''):
                unlink('img/projects/' . $project_media_record_row->image_10);
            endif;
        endwhile;
    endif;

    if ($mysqli->query('DELETE FROM projects WHERE id = "' . $_GET['project_id'] . '"')):
        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Project record with id ' . $_GET['project_id'] . ' has been deleted.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);
        echo 'success';
    endif;
endif;

if (isset($_GET['publication_id']) && $_GET['publication_id'] != '' && isValidNumber($_GET['publication_id'])):
    $get_record = 'SELECT image, publication_document FROM publications WHERE id = "' . $_GET['publication_id'] . '"';
    $record_res = $mysqli->query($get_record);
    $record_row = mysqli_fetch_object($record_res);

    if ($record_row->image != ''):
        unlink('img/publications/' . $record_row->image);
    endif;
    if ($record_row->publication_document != ''):
        unlink('files/publications/' . $record_row->publication_document);
    endif;

    if ($mysqli->query('DELETE FROM publications WHERE id = "' . $_GET['publication_id'] . '"')):
        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Publication record with id ' . $_GET['publication_id'] . ' has been deleted.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);
        echo 'success';
    endif;
endif;

if (isset($_GET['about_id']) && $_GET['about_id'] != '' && isValidNumber($_GET['about_id'])):
    if ($mysqli->query('DELETE FROM about WHERE id = "' . $_GET['about_id'] . '"')):
        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'About record with id ' . $_GET['about_id'] . ' has been deleted.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);
        echo 'success';
    endif;
endif;

if (isset($_GET['programme_id']) && $_GET['programme_id'] != '' && isValidNumber($_GET['programme_id'])):
    if ($mysqli->query('DELETE FROM programmes WHERE id = "' . $_GET['programme_id'] . '"')):
        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Programme record with id ' . $_GET['programme_id'] . ' has been deleted.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);
        echo 'success';
    endif;
endif;

$db->mysqlclose();
?>