<?php

session_start();

include 'config/common.php';

$get_user_info = 'SELECT um.id, um.fname, um.gender, um.avatar, um.lname, urm.role_name, um.role_id FROM user_master um INNER JOIN user_role_master urm ON urm.id = um.role_id WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_info_res = $mysqli->query($get_user_info);
$user_info_row = mysqli_fetch_object($user_info_res);

$array = $_POST['array_order'];
if ($_POST['update'] == "update" && $_POST['type'] == 'programme'):
    $count = 1;
    foreach ($array as $idval):
        $query = "UPDATE programmes SET programme_order = " . $count . " WHERE id = " . $idval;
        $mysqli->query($query);
        $count ++;
    endforeach;
    echo 'All saved! Refresh the page on the front-end to see the changes.';
elseif ($_POST['update'] == "update" && $_POST['type'] == 'project'):
    $count = 1;
    foreach ($array as $idval):
        $query = "UPDATE projects SET project_order = " . $count . " WHERE id = " . $idval;
        $mysqli->query($query);
        $count ++;
    endforeach;
    echo 'All saved! Refresh the page on the front-end to see the changes.';
elseif ($_POST['update'] == "update" && $_POST['type'] == 'publication'):
    $count = 1;
    foreach ($array as $idval):
        $query = "UPDATE publications SET publication_order = " . $count . " WHERE id = " . $idval;
        $mysqli->query($query);
        $count ++;
    endforeach;
    echo 'All saved! Refresh the page on the front-end to see the changes.';
endif;
?>