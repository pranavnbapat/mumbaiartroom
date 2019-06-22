<?php

include 'admin_header.php';
include 'admin_footer.php';


/* declare variables */
$msg = '';
$gallery_name = '';
$gallery_id = '';
$gallery_list = '';
$path = '';
$digits = 9;
$gallery_image = '';
$gallery_images_list = '';
/* declare variables */


/* generate message */
if (isset($_GET['msg']) && $_GET['msg'] == 'added'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Gallery image added!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'canceled'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:#b94a48; font-weight:bold;">Gallery editing canceled!</p></div></div>';
endif;
/* generate message */


/* get gallery name */
$get_gallery_name = 'SELECT * FROM gallery_master WHERE id = "' . $_GET['id'] . '"';
$gallery_name_res = $mysqli->query($get_gallery_name);
if ($gallery_name_res->num_rows > 0):
    $gallery_name_row = mysqli_fetch_object($gallery_name_res);
    $gallery_name = $gallery_name_row->gallery_name;
    $path = 'img/gallery/' . $gallery_name . '/';
    $gallery_id = $gallery_name_row->id;
endif;
/* get gallery name */


/* get gallery images */
$get_gallery_images = 'SELECT gi.id, gm.id as gid, gm.gallery_name, gi.gallery_image, gi.created_at FROM gallery_master gm INNER JOIN gallery_images gi ON gi.gallery_id = gm.id WHERE gi.gallery_id = "' . $_GET['id'] . '" ORDER BY gi.created_at DESC';
$gallery_images_res = $mysqli->query($get_gallery_images);
if ($gallery_images_res->num_rows > 0):
    $i = $gallery_images_res->num_rows;
    while ($gallery_images_row = mysqli_fetch_object($gallery_images_res)):
        $gallery_images_list .= '<tr>
                                    <td>' . $i . '</td>
                                    <td><img src="img/gallery/' . $gallery_images_row->gallery_name . '/' . $gallery_images_row->gallery_image . '" width="100" /></td>
                                    <td><a href="remove-gallery-image.php?gallery_image_id=' . $gallery_images_row->id . '&gallery_name=' . $gallery_images_row->gallery_name . '&gallery_id=' . $gallery_images_row->gid . '">Remove this image</a></td>
                                    <td>' . $gallery_images_row->created_at . '</td>
                                 </tr>';
        $i--;
    endwhile;
endif;
/* get gallery images */


/* add gallery */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
    if (isset($_FILES["gallery_image"]) && $_FILES["gallery_image"]["name"]):
        $date = new DateTime();
        $newfilename = '';
        $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $temp = explode(".", $_FILES["gallery_image"]["name"]);
        $extension = end($temp);
        $newfilename = $random_number . '-' . date('d_m_Y_H_i_s') . '-' . $date->getTimestamp() . '.' . $extension;
        move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $_POST['path'] . $newfilename);
        $gallery_image = $newfilename;
    else:
        $gallery_image = '';
    endif;

    $insert_array['gallery_id'] = $_POST['gallery_id'];
    $insert_array['gallery_image'] = $gallery_image;
    $insert_array['created_at'] = $curr_date_time;
    $last_insert_id = insert($mysqli, 'gallery_images', $insert_array);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'Gallery image with id ' . $last_insert_id . ' and gallery id ' . $_POST['gallery_id'] . ' has been added.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;

    header('Location:add-gallery-images.php?msg=added&id=' . $_POST['gallery_id']);
endif;
/* add gallery */


$template->load("templates/add-gallery-images.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("gallery_name", $gallery_name);
$template->replace("gallery_id", $gallery_id);
$template->replace("gallery_images_list", $gallery_images_list);
$template->replace("path", $path);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>