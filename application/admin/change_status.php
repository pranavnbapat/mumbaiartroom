<?php

session_start();

include 'config/common.php';

$get_user_info = 'SELECT um.id, um.fname, um.gender, um.avatar, um.lname, urm.role_name, um.role_id FROM user_master um INNER JOIN user_role_master urm ON urm.id = um.role_id WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_info_res = $mysqli->query($get_user_info);
$user_info_row = mysqli_fetch_object($user_info_res);

if (isset($_GET['about_id']) && $_GET['about_id'] != '') {
    $update = "UPDATE about SET status = 'archieved'";
    $mysqli->query($update);
    $check_status = 'SELECT status FROM about WHERE id = ' . $_GET['about_id'];
    $check_status_res = $mysqli->query($check_status);
    $check_status_row = mysqli_fetch_object($check_status_res);

    if ($check_status_row->status == 'published'):
        $change_status = 'UPDATE about SET status = "archieved", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['about_id'];
    else:
        $change_status = 'UPDATE about SET status = "published", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['about_id'];
    endif;
    $mysqli->query($change_status);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'About status updated.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;
    insert($mysqli, 'log_user_activity', $insert_log);

    echo 'success';
}

if (isset($_GET['contact_us_id']) && $_GET['contact_us_id'] != ''):
    $update = "UPDATE contact_us SET status = 'archieved'";
    $mysqli->query($update);
    $check_status = 'SELECT status FROM contact_us WHERE id = ' . $_GET['contact_us_id'];
    $check_status_res = $mysqli->query($check_status);
    $check_status_row = mysqli_fetch_object($check_status_res);

    if ($check_status_row->status == 'published'):
        $change_status = 'UPDATE contact_us SET status = "archieved", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['contact_us_id'];
    else:
        $change_status = 'UPDATE contact_us SET status = "published", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['contact_us_id'];
    endif;
    $mysqli->query($change_status);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'Contact us status updated.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;
    insert($mysqli, 'log_user_activity', $insert_log);

    echo 'success';
endif;

if (isset($_GET['publication_id']) && $_GET['publication_id'] != ''):
    $check_status = 'SELECT status FROM publications WHERE id = ' . $_GET['publication_id'];
    $check_status_res = $mysqli->query($check_status);
    if ($check_status_res->num_rows > 0):
        $status = '';
        $check_status_row = mysqli_fetch_object($check_status_res);
        if ($check_status_row->status == 'published'):
            $change_status = 'UPDATE publications SET status = "archieved", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['publication_id'];
            $status = 'archieved';
        else:
            $change_status = 'UPDATE publications SET status = "published", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['publication_id'];
            $status = 'published';
        endif;
        $mysqli->query($change_status);

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Status of publication id ' . $_GET['publication_id'] . ' set to ' . $status . '.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        echo 'success';
    endif;
endif;

if (isset($_GET['menu_id']) && $_GET['menu_id'] != ''):
    $check_status = 'SELECT status FROM menu_master WHERE id = ' . $_GET['menu_id'];
    $check_status_res = $mysqli->query($check_status);
    $check_status_row = mysqli_fetch_object($check_status_res);

    if ($check_status_row->status == 'published'):
        $change_status = 'UPDATE menu_master SET status = "disabled", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['menu_id'];
    else:
        $change_status = 'UPDATE menu_master SET status = "published", date_updated = "' . $curr_date_time . '" WHERE id = ' . $_GET['menu_id'];
    endif;
    $mysqli->query($change_status);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'Menu status updated.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;
    insert($mysqli, 'log_user_activity', $insert_log);

    echo 'success';
endif;


if (isset($_GET['project_id']) && $_GET['project_id'] != '' && isValidNumber($_GET['project_id'])):
    $get_project = 'SELECT id, status FROM projects WHERE id = ' . $_GET['project_id'];
    $project_res = $mysqli->query($get_project);
    if ($project_res->num_rows > 0):
        $project_row = mysqli_fetch_object($project_res);
        if ($project_row->status == 'published'):
            $change_status = 'UPDATE projects SET status = "archieved", date_updated = "' . $curr_date_time . '" WHERE id = ' . trim(htmlspecialchars($_GET['project_id']));
        else:
            $change_status = 'UPDATE projects SET status = "published", date_updated = "' . $curr_date_time . '" WHERE id = ' . trim(htmlspecialchars($_GET['project_id']));
        endif;
        $mysqli->query($change_status);

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Project status updated.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);

        echo 'success';
    endif;
endif;


if (isset($_GET['programme_id']) && $_GET['programme_id'] != '' && isValidNumber($_GET['programme_id'])):
    $get_programme = 'SELECT id, status FROM programmes WHERE id = ' . $_GET['programme_id'];
    $programme_res = $mysqli->query($get_programme);
    if ($programme_res->num_rows > 0):
        $status = '';
        $programme_row = mysqli_fetch_object($programme_res);
        if ($programme_row->status == 'published'):
            $change_status = 'UPDATE programmes SET status = "archieved", date_updated = "' . $curr_date_time . '" WHERE id = ' . trim(htmlspecialchars($_GET['programme_id']));
            $status = 'archieved';
        else:
            $change_status = 'UPDATE programmes SET status = "published", date_updated = "' . $curr_date_time . '" WHERE id = ' . trim(htmlspecialchars($_GET['programme_id']));
            $status = 'published';
        endif;
        $mysqli->query($change_status);

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Status of programme id ' . $_GET['programme_id'] . ' set to ' . $status . '.';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['user_platform'] = $browser->getPlatform();
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);
        echo 'success';
    endif;
endif;

if (isset($_GET['gallery_id']) && $_GET['gallery_id'] != '' && isValidNumber($_GET['gallery_id'])):
    $get_gallery = 'SELECT id, status FROM gallery_master WHERE id = ' . $_GET['gallery_id'];
    $gallery_res = $mysqli->query($get_gallery);
    if ($gallery_res->num_rows > 0):
        $status = '';
        $gallery_row = mysqli_fetch_object($gallery_res);
        if ($gallery_row->status == 'enabled'):
            $change_status = 'UPDATE gallery_master SET status = "disabled", updated_at = "' . $curr_date_time . '" WHERE id = ' . trim(htmlspecialchars($_GET['gallery_id']));
            $status = 'disabled';
        else:
            $change_status = 'UPDATE gallery_master SET status = "enabled", updated_at = "' . $curr_date_time . '" WHERE id = ' . trim(htmlspecialchars($_GET['gallery_id']));
            $status = 'enabled';
        endif;
        $mysqli->query($change_status);

        $insert_log['user_id'] = $user_info_row->id;
        $insert_log['message'] = 'Status of gallery id ' . $_GET['gallery_id'] . ' set to ' . $status . '.';
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