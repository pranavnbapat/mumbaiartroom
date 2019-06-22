<?php

include './header.php';
include './footer.php';
include './js_lightbox.php';

$gallery_name = '';
$gallery_images = '';
$gallery_area = '';
$js_lightbox = '';
$prev_page = '';

if (isset($_GET['id']) && !empty($_GET['id'])):
    if (isset($_SERVER['HTTP_REFERER'])):
        $prev_page = explode('/', $_SERVER['HTTP_REFERER']);
        $prev_page = end($prev_page);
    endif;
    $get_gallery_images = 'SELECT gm.gallery_name, gi.gallery_image FROM gallery_master gm INNER JOIN gallery_images gi ON gi.gallery_id = gm.id WHERE gi.gallery_id = "' . $_GET['id'] . '"';
    $gallery_images_res = $mysqli->query($get_gallery_images);
    if ($gallery_images_res->num_rows > 0):
        $gallery_area = '';
        while ($gallery_images_row = mysqli_fetch_object($gallery_images_res)):
            $gallery_name = (strlen($gallery_images_row->gallery_name) > 35 ? '<span style="margin:0 !important">' . $gallery_images_row->gallery_name . '</span>' : '<span>' . $gallery_images_row->gallery_name . '</span>');
            $gallery_images .= '<div class="imgThumb"><a href="admin/img/gallery/' . $gallery_images_row->gallery_name . '/' . $gallery_images_row->gallery_image . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400">
                                <img src="admin/img/gallery/' . $gallery_images_row->gallery_name . '/' . $gallery_images_row->gallery_image . '" width="184" />
                            </a></div>';
        endwhile;
    endif;
endif;


$template->load("templates/gallery.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("js_lightbox", $js_lightbox);
$template->replace("gallery_name", $gallery_name);
$template->replace("gallery_images", $gallery_images);
$template->replace("prev_page", $prev_page);
$template->publish();
$db->mysqlclose();
?>