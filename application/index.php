<?php

include './header.php';
include './footer.php';
include './js_lightbox.php';

/* variable declaration */
$home_page = '';
$project_title = '';
$project_date = '';
$project_content_1 = '';
$project_content_2 = '';
$project_content_3 = '';
$image_1 = '';
$image_link_1 = '';
$image_2 = '';
$image_link_2 = '';
$image_3 = '';
$image_link_3 = '';
$image_4 = '';
$image_link_4 = '';
$image_5 = '';
$image_link_5 = '';
$image_6 = '';
$image_link_6 = '';
$image_7 = '';
$image_link_7 = '';
$image_8 = '';
$image_link_8 = '';
$image_9 = '';
$image_link_9 = '';
$image_10 = '';
$image_link_10 = '';
$media = '';
$linking = '';
$image_layout = '';
$image_layout_2 = '';
$links = '';
/* variable declaration */


$get_home_page = 'SELECT * FROM projects WHERE `status` = "published" AND is_home = "Y"';
$home_page_res = $mysqli->query($get_home_page);
if ($home_page_res->num_rows > 0):
    $home_page_row = mysqli_fetch_object($home_page_res);
    $project_title = (strlen($home_page_row->project_title) > 35 ? '<span style="margin:0 !important">' . $home_page_row->project_title . '</span>' : '<span>' . $home_page_row->project_title . '</span>');
    $project_date = $home_page_row->project_date;
    $project_content_1 = $home_page_row->project_content_1;
    $project_content_2 = $home_page_row->project_content_2;
    $project_content_3 = $home_page_row->project_content_3;

    if ($home_page_row->image_1 != '' && $home_page_row->image_link_1 != ''):
        if ($home_page_row->image_layout_id == 3):
            $image_1 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $home_page_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_1 . '"><img src="admin/img/projects/' . $home_page_row->image_1 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id == 6):
            $image_1 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_1 . '"><img src="admin/img/projects/' . $home_page_row->image_1 . '" /></a></div>';
        else:
            $image_1 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_1 . '"><img src="admin/img/projects/' . $home_page_row->image_1 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_1 != '' && $home_page_row->image_link_1 == ''):
        if ($home_page_row->image_layout_id == 3):
            $image_1 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $home_page_row->image_1 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_1 . '"><img src="admin/img/projects/' . $home_page_row->image_1 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id == 6):
            $image_1 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_1 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_1 . '"><img src="admin/img/projects/' . $home_page_row->image_1 . '" /></a></div>';
        else:
            $image_1 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_1 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_1 . '"><img src="admin/img/projects/' . $home_page_row->image_1 . '" /></a></div>';
        endif;
    endif;
    if ($home_page_row->image_2 != '' && $home_page_row->image_link_2 != ''):
        if ($home_page_row->image_layout_id == 4):
            $image_2 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_link_2 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $home_page_row->image_2 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id == 6):
            $image_2 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_2 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_2 . '"><img src="admin/img/projects/' . $home_page_row->image_2 . '" /></a></div>';
        else:
            $image_2 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_2 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $home_page_row->image_2 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_2 != '' && $home_page_row->image_link_2 == ''):
        if ($home_page_row->image_layout_id == 4):
            $image_2 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_2 . '" class="html5lightbox" data-group="set1"><img src="admin/img/projects/' . $home_page_row->image_2 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id == 6):
            $image_2 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_2 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_2 . '"><img src="admin/img/projects/' . $home_page_row->image_2 . '" /></a></div>';
        else:
            $image_2 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_2 . '" class="html5lightbox" data-group="set1"><img src="admin/img/projects/' . $home_page_row->image_2 . '" /></a></div>';
        endif;
    endif;
    if ($home_page_row->image_3 != '' && $home_page_row->image_link_3 != ''):
        if ($home_page_row->image_layout_id == 5):
            $image_3 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_3 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $home_page_row->image_3 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id == 6):
            $image_3 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_3 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_3 . '"><img src="admin/img/projects/' . $home_page_row->image_3 . '" /></a></div>';
        else:
            $image_3 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_3 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $home_page_row->image_3 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_3 != '' && $home_page_row->image_link_3 == ''):
        if ($home_page_row->image_layout_id == 5):
            $image_3 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_3 . '" class="html5lightbox" data-group="set1"><img src="admin/img/projects/' . $home_page_row->image_3 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id == 6):
            $image_3 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_3 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_3 . '"><img src="admin/img/projects/' . $home_page_row->image_3 . '" /></a></div>';
        else:
            $image_3 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_3 . '" class="html5lightbox" data-group="set1"><img src="admin/img/projects/' . $home_page_row->image_3 . '" /></a></div>';
        endif;
    endif;
    if ($home_page_row->image_4 != '' && $home_page_row->image_link_4 != ''):
        if ($home_page_row->image_layout_id == 6):
            $image_4 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_4 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_4 . '"><img src="admin/img/projects/' . $home_page_row->image_4 . '" /></a></div>';
        else:
            $image_4 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_4 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $home_page_row->image_4 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_4 != '' && $home_page_row->image_link_4 == ''):
        if ($home_page_row->image_layout_id == 6):
            $image_4 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_4 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_4 . '"><img src="admin/img/projects/' . $home_page_row->image_4 . '" /></a></div>';
        else:
            $image_4 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_4 . '" class="html5lightbox" data-group="set1"><img src="admin/img/projects/' . $home_page_row->image_4 . '" /></a></div>';
        endif;
    endif;
    if ($home_page_row->image_5 != '' && $home_page_row->image_link_5 != ''):
        $image_5 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_5 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $home_page_row->image_5 . '" /></a></div>';
    elseif ($home_page_row->image_5 != '' && $home_page_row->image_link_5 == ''):
        $image_5 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_5 . '" class="html5lightbox" data-group="set1"><img src="admin/img/projects/' . $home_page_row->image_5 . '" /></a></div>';
    endif;

    if ($home_page_row->image_layout_id == 1):
        $image_layout .= $image_1 . $image_2 . $image_3 . $image_4 . $image_5;
    elseif ($home_page_row->image_layout_id == 2):
        $image_layout .= $image_2 . $image_3 . $image_4 . $image_5 . $image_1;
    elseif ($home_page_row->image_layout_id == 3):
        $image_layout .= $image_1;
    elseif ($home_page_row->image_layout_id == 4):
        $image_layout .= $image_1 . $image_2;
    elseif ($home_page_row->image_layout_id == 5):
        $image_layout .= $image_1 . $image_2 . $image_3;
    elseif ($home_page_row->image_layout_id == 6):
        $image_layout .= $image_1 . $image_2 . $image_3 . $image_4;
    endif;


    /* new set of images */
    if ($home_page_row->image_6 != '' && $home_page_row->image_link_6 != ''):
        if ($home_page_row->image_layout_id_2 == 3):
            $image_6 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $home_page_row->image_link_6 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $home_page_row->image_caption_6 . '"><img src="admin/img/projects/' . $home_page_row->image_6 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id_2 == 6):
            $image_6 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_6 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_6 . '"><img src="admin/img/projects/' . $home_page_row->image_6 . '" /></a></div>';
        else:
            $image_6 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_link_6 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $home_page_row->image_caption_6 . '"><img src="admin/img/projects/' . $home_page_row->image_6 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_6 != '' && $home_page_row->image_link_6 == ''):
        if ($home_page_row->image_layout_id_2 == 3):
            $image_6 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $home_page_row->image_6 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_6 . '"><img src="admin/img/projects/' . $home_page_row->image_6 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id_2 == 6):
            $image_6 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_6 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_6 . '"><img src="admin/img/projects/' . $home_page_row->image_6 . '" /></a></div>';
        else:
            $image_6 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_6 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_6 . '"><img src="admin/img/projects/' . $home_page_row->image_6 . '" /></a></div>';
        endif;
    endif;
    if ($home_page_row->image_7 != '' && $home_page_row->image_link_7 != ''):
        if ($home_page_row->image_layout_id_2 == 4):
            $image_7 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_link_7 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $home_page_row->image_caption_7 . '"><img src="admin/img/projects/' . $home_page_row->image_7 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id_2 == 6):
            $image_7 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_7 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_7 . '"><img src="admin/img/projects/' . $home_page_row->image_7 . '" /></a></div>';
        else:
            $image_7 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_7 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $home_page_row->image_caption_7 . '"><img src="admin/img/projects/' . $home_page_row->image_7 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_7 != '' && $home_page_row->image_link_2 == ''):
        if ($home_page_row->image_layout_id_2 == 4):
            $image_7 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $home_page_row->image_7 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_7 . '"><img src="admin/img/projects/' . $home_page_row->image_7 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id_2 == 6):
            $image_7 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_7 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_7 . '"><img src="admin/img/projects/' . $home_page_row->image_7 . '" /></a></div>';
        else:
            $image_7 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_7 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_7 . '"><img src="admin/img/projects/' . $home_page_row->image_7 . '" /></a></div>';
        endif;
    endif;
    if ($home_page_row->image_8 != '' && $home_page_row->image_link_8 != ''):
        if ($home_page_row->image_layout_id_2 == 5):
            $image_8 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_8 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $home_page_row->image_8 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id_2 == 6):
            $image_8 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_8 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_8 . '"><img src="admin/img/projects/' . $home_page_row->image_8 . '" /></a></div>';
        else:
            $image_8 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_8 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $home_page_row->image_caption_8 . '"><img src="admin/img/projects/' . $home_page_row->image_8 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_8 != '' && $home_page_row->image_link_8 == ''):
        if ($home_page_row->image_layout_id_2 == 5):
            $image_8 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_8 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_8 . '"><img src="admin/img/projects/' . $home_page_row->image_8 . '" /></a></div>';
        elseif ($home_page_row->image_layout_id_2 == 6):
            $image_8 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_8 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_8 . '"><img src="admin/img/projects/' . $home_page_row->image_8 . '" /></a></div>';
        else:
            $image_8 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_8 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_8 . '"><img src="admin/img/projects/' . $home_page_row->image_8 . '" /></a></div>';
        endif;
    endif;

    if ($home_page_row->image_9 != '' && $home_page_row->image_link_9 != ''):
        if ($home_page_row->image_layout_id_2 == 6):
            $image_9 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_link_9 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $home_page_row->image_caption_9 . '"><img src="admin/img/projects/' . $home_page_row->image_9 . '" /></a></div>';
        else:
            $image_9 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_9 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $home_page_row->image_caption_9 . '"><img src="admin/img/projects/' . $home_page_row->image_9 . '" /></a></div>';
        endif;
    elseif ($home_page_row->image_9 != '' && $home_page_row->image_link_9 == ''):
        if ($home_page_row->image_layout_id_2 == 6):
            $image_9 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $home_page_row->image_9 . '" class="html5lightbox" data-group="set1" title="' . $home_page_row->image_caption_9 . '"><img src="admin/img/projects/' . $home_page_row->image_9 . '" /></a></div>';
        else:
            $image_9 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_9 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_9 . '"><img src="admin/img/projects/' . $home_page_row->image_9 . '" /></a></div>';
        endif;
    endif;
    if ($home_page_row->image_10 != '' && $home_page_row->image_link_10 != ''):
        $image_10 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_link_10 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $home_page_row->image_caption_10 . '"><img src="admin/img/projects/' . $home_page_row->image_10 . '" /></a></div>';
    elseif ($home_page_row->image_10 != '' && $home_page_row->image_link_10 == ''):
        $image_10 = '<div class="imgThumb2"><a href="admin/img/projects/' . $home_page_row->image_10 . '" class="html5lightbox" data-group="set1" title = "' . $home_page_row->image_caption_10 . '"><img src="admin/img/projects/' . $home_page_row->image_10 . '" /></a></div>';
    endif;

    if ($home_page_row->image_layout_id_2 == 1):
        $image_layout_2 .= $image_6 . $image_7 . $image_8 . $image_9 . $image_10;
    elseif ($home_page_row->image_layout_id_2 == 2):
        $image_layout_2 .= $image_7 . $image_8 . $image_9 . $image_10 . $image_6;
    elseif ($home_page_row->image_layout_id_2 == 3):
        $image_layout_2 .= $image_6;
    elseif ($home_page_row->image_layout_id_2 == 4):
        $image_layout_2 .= $image_6 . $image_7;
    elseif ($home_page_row->image_layout_id_2 == 5):
        $image_layout_2 .= $image_6 . $image_7 . $image_8;
    elseif ($home_page_row->image_layout_id_2 == 6):
        $image_layout_2 .= $image_6 . $image_7 . $image_8 . $image_9;
    endif;

    $links = $home_page_row->links;
endif;

$template->load("templates/index.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("project_title", $project_title);
$template->replace("project_date", $project_date);
$template->replace("project_content_1", $project_content_1);
$template->replace("project_content_2", $project_content_2);
$template->replace("project_content_3", $project_content_3);
$template->replace("image_1", $image_1);
$template->replace("image_2", $image_2);
$template->replace("image_3", $image_3);
$template->replace("image_4", $image_4);
$template->replace("image_5", $image_5);
$template->replace("image_6", $image_6);
$template->replace("image_7", $image_7);
$template->replace("image_8", $image_8);
$template->replace("image_9", $image_9);
$template->replace("image_10", $image_10);
$template->replace("media", $media);
$template->replace("js_lightbox", $js_lightbox);
$template->replace("linking", $linking);
$template->replace("image_layout", $image_layout);
$template->replace("image_layout_2", $image_layout_2);
$template->replace("links", $links);
$template->publish();
$db->mysqlclose();
?>

