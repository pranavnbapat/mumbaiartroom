<?php

session_start();

require_once 'config/common.php';

$get_user_info = 'SELECT um.id, um.fname, um.gender, um.avatar, um.lname, urm.role_name, um.role_id FROM user_master um INNER JOIN user_role_master urm ON urm.id = um.role_id WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_info_res = $mysqli->query($get_user_info);
$user_info_row = mysqli_fetch_object($user_info_res);

if (isset($_GET['gallery_image_id']) && !empty($_GET['gallery_image_id'])):
    $get_image_name = 'SELECT gallery_image FROM gallery_images WHERE id = "' . $_GET['gallery_image_id'] . '"';
    $image_name_res = $mysqli->query($get_image_name);
    if ($image_name_res->num_rows > 0):
        $image_name_row = mysqli_fetch_object($image_name_res);
        $delete_image = 'DELETE FROM gallery_images WHERE id = "' . $_GET['gallery_image_id'] . '"';
        if ($mysqli->query($delete_image)):
            unlink('img/gallery/' . $_GET['gallery_name'] . '/' . $image_name_row->gallery_image);
        endif;
    endif;
    header('location: add-gallery-images.php?id=' . $_GET['gallery_id']);
endif;