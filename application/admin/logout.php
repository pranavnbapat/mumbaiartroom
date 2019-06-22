<?php

session_start();

include './config/common.php';

$get_user = 'SELECT id, email FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_res = $mysqli->query($get_user);
if ($user_res->num_rows > 0):
    $user_row = mysqli_fetch_object($user_res);
    $insert_log['user_id'] = $user_row->id;
    $insert_log['message'] = 'User logged out';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;
    insert($mysqli, 'log_user_activity', $insert_log);
endif;

session_destroy();
header('location: login.php?err=1');
?>