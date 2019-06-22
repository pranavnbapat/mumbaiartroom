<?php

include 'admin_header.php';
include 'admin_footer.php';


/* declare variables */
$msg = '';
$gallery_id = '';
$gallery_name = '';
/* declare variables */


/* get programme */
if (isset($_GET['id']) && $_GET['id'] != ''):
    $get_gallery = 'SELECT id, gallery_name FROM gallery_master WHERE id = ' . $_GET['id'];
    $gallery_res = $mysqli->query($get_gallery);
    if ($gallery_res->num_rows > 0):
        $gallery_row = mysqli_fetch_object($gallery_res);
        $gallery_name = $gallery_row->gallery_name;
        $gallery_id = $gallery_row->id;
    endif;
endif;
/* get programme */


/* edit programme content */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $update_array['gallery_name'] = trim(htmlspecialchars(addslashes($_POST['gallery_name'])));
    update($mysqli, 'gallery_master', $update_array, $_POST['gallery_id'], 'id');
    header('Location:image-gallery.php?msg=edited');
endif;
/* edit programme content */


$template->load("templates/gallery-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("gallery_name", $gallery_name);
$template->replace("gallery_id", $gallery_id);
$template->publish();
$db->mysqlclose();
?>