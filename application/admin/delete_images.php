<?php

session_start();

include 'config/common.php';

$get_user_info = 'SELECT um.id, um.fname, um.gender, um.avatar, um.lname, urm.role_name, um.role_id FROM user_master um INNER JOIN user_role_master urm ON urm.id = um.role_id WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_info_res = $mysqli->query($get_user_info);
$user_info_row = mysqli_fetch_object($user_info_res);

if (isset($_POST['image']) && ($_POST['image'] != '' || $_POST['image'] != 'no_image.jpeg' || $_POST['image'] != 'no_image.jpg' || $_POST['image'] != 'no_image.gif')):
    $find_image = 'SELECT * FROM projects WHERE id = ' . $_POST['project_id'];
    $find_image_res = $mysqli->query($find_image);
    if ($find_image_res->num_rows > 0):
        unlink('img/projects/' . $_POST['image']);
        $find_image_row = mysqli_fetch_object($find_image_res);
        if ($find_image_row->image_1 == $_POST['image']):
            $update = 'UPDATE projects SET image_1 = "", image_caption_1 = "", image_link_1 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_2 == $_POST['image']):
            $update = 'UPDATE projects SET image_2 = "", image_caption_2 = "", image_link_2 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_3 == $_POST['image']):
            $update = 'UPDATE projects SET image_3 = "", image_caption_3 = "", image_link_3 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_4 == $_POST['image']):
            $update = 'UPDATE projects SET image_4 = "", image_caption_4 = "", image_link_4 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_5 == $_POST['image']):
            $update = 'UPDATE projects SET image_5 = "", image_caption_5 = "", image_link_5 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_6 == $_POST['image']):
            $update = 'UPDATE projects SET image_6 = "", image_caption_6 = "", image_link_6 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_7 == $_POST['image']):
            $update = 'UPDATE projects SET image_7 = "", image_caption_7 = "", image_link_7 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_8 == $_POST['image']):
            $update = 'UPDATE projects SET image_8 = "", image_caption_8 = "", image_link_8 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_9 == $_POST['image']):
            $update = 'UPDATE projects SET image_9 = "", image_caption_9 = "", image_link_9 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        elseif ($find_image_row->image_10 == $_POST['image']):
            $update = 'UPDATE projects SET image_10 = "", image_caption_10 = "", image_link_10 = "" WHERE id = ' . $_POST['project_id'];
            if ($mysqli->query($update)):
                echo 'success';
            endif;
        endif;
    endif;
else:
    echo'error';
endif;
?>