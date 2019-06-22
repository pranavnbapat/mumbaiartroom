<?php

include './header.php';
include './footer.php';
include './js_lightbox.php';


$projects = '';
$media = '';
$media_2 = '';
$title = '';
$project_content_1 = '';
$project_content_2 = '';
$project_content_3 = '';
$type = '';
$image_1 = '';
$image_2 = '';
$image_3 = '';
$image_4 = '';
$image_5 = '';
$image_6 = '';
$image_7 = '';
$image_8 = '';
$image_9 = '';
$image_10 = '';
$image_layout = '';
$image_layout_2 = '';
$links = '';


if (isset($_GET['id']) && !empty($_GET['id'])):
    $get_projects = 'SELECT * FROM projects WHERE `status` = "published" AND id = "' . $_GET['id'] . '"';
    $projects_res = $mysqli->query($get_projects);
    if ($projects_res->num_rows > 0):
        $projects_row = mysqli_fetch_object($projects_res);
        $type = $projects_row->project_type;
        if ($type == 'project'):
            $project_id = $projects_row->id;
            if ($projects_row->image_1 != '' && $projects_row->image_link_1 != ''):
                //this is video
                $media = '<div class="imgThumb">
                            <a href="' . $projects_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_1 . '">
                                <img src="admin/img/projects/' . $projects_row->image_1 . '" />
                            </a>
                      </div>';
            else:
                //this is image
                $media = '<div class="imgThumb">
                            <a href="admin/img/projects/' . $projects_row->image_1 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_1 . '">
                                <img src="admin/img/projects/' . $projects_row->image_1 . '" />
                            </a>
                      </div>';
            endif;
            if ($projects_row->image_6 != '' && $projects_row->image_link_6 != ''):
                //this is video
                $media_2 = '<div class="imgThumb">
                            <a href="' . $projects_row->image_link_6 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_6 . '">
                                <img src="admin/img/projects/' . $projects_row->image_6 . '" />
                            </a>
                      </div>';
            else:
                //this is image
                $media_2 = '<div class="imgThumb">
                            <a href="admin/img/projects/' . $projects_row->image_6 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_6 . '">
                                <img src="admin/img/projects/' . $projects_row->image_6 . '" />
                            </a>
                      </div>';
            endif;

            $projects = '<div class="projects">
                        <div class="projTextContent">
                            <h1>' . $projects_row->project_title . '</h1>
                            <div class="galArea">
                            ' . $media . '
                                <div class="image_caption">' . $projects_row->image_caption_1 . '</div>
                            </div>
                            <div class="homeArea">
                                ' . $projects_row->project_content_1 . '
                                ' . $projects_row->project_content_2 . '
                            </div>
                            <!--<div class="galArea">
                            $media_2
                                <div class="image_caption">$projects_row->image_caption_6</div>
                            </div>-->
                            <div class="homeArea">
                                ' . $projects_row->project_content_3 . '
                            </div>
                        </div>
                        <div class="homeArea2">
                            ' . $projects_row->links . '
                        </div>
                    </div>';
        elseif ($type == 'event' || $type == 'exhibition'):
            $project_title = (strlen($projects_row->project_title) > 35 ? '<span style="margin:0 !important">' . $projects_row->project_title . '</span>' : '<span>' . $projects_row->project_title . '</span>');
            $project_date = $projects_row->project_date;
            $project_content_1 = $projects_row->project_content_1;
            $project_content_2 = $projects_row->project_content_2;
            $project_content_3 = $projects_row->project_content_3;
            $links = $projects_row->links;

            if ($projects_row->image_1 != '' && $projects_row->image_link_1 != ''):
                if ($projects_row->image_layout_id == 3):
                    $image_1 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $projects_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_1 . '"><img src="admin/img/projects/' . $projects_row->image_1 . '" /></a></div>';
                elseif ($projects_row->image_layout_id == 6):
                    $image_1 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_1 . '"><img src="admin/img/projects/' . $projects_row->image_1 . '" /></a></div>';
                else:
                    $image_1 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_1 . '"><img src="admin/img/projects/' . $projects_row->image_1 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_1 != '' && $projects_row->image_link_1 == ''):
                if ($projects_row->image_layout_id == 3):
                    $image_1 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $projects_row->image_1 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_1 . '"><img src="admin/img/projects/' . $projects_row->image_1 . '" /></a></div>';
                elseif ($projects_row->image_layout_id == 6):
                    $image_1 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_1 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_1 . '"><img src="admin/img/projects/' . $projects_row->image_1 . '" /></a></div>';
                else:
                    $image_1 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_1 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_1 . '"><img src="admin/img/projects/' . $projects_row->image_1 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_2 != '' && $projects_row->image_link_2 != ''):
                if ($projects_row->image_layout_id == 4):
                    $image_2 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_link_2 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_2 . '"><img src="admin/img/projects/' . $projects_row->image_2 . '" /></a></div>';
                elseif ($projects_row->image_layout_id == 6):
                    $image_2 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_2 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_2 . '"><img src="admin/img/projects/' . $projects_row->image_2 . '" /></a></div>';
                else:
                    $image_2 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_2 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_2 . '"><img src="admin/img/projects/' . $projects_row->image_2 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_2 != '' && $projects_row->image_link_2 == ''):
                if ($projects_row->image_layout_id == 4):
                    $image_2 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_2 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_2 . '"><img src="admin/img/projects/' . $projects_row->image_2 . '" /></a></div>';
                elseif ($projects_row->image_layout_id == 6):
                    $image_2 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_2 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_2 . '"><img src="admin/img/projects/' . $projects_row->image_2 . '" /></a></div>';
                else:
                    $image_2 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_2 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_2 . '"><img src="admin/img/projects/' . $projects_row->image_2 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_3 != '' && $projects_row->image_link_3 != ''):
                if ($projects_row->image_layout_id == 5):
                    $image_3 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_3 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $projects_row->image_3 . '" /></a></div>';
                elseif ($projects_row->image_layout_id == 6):
                    $image_3 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_3 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_3 . '"><img src="admin/img/projects/' . $projects_row->image_3 . '" /></a></div>';
                else:
                    $image_3 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_3 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_3 . '"><img src="admin/img/projects/' . $projects_row->image_3 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_3 != '' && $projects_row->image_link_3 == ''):
                if ($projects_row->image_layout_id == 5):
                    $image_3 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_3 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_3 . '"><img src="admin/img/projects/' . $projects_row->image_3 . '" /></a></div>';
                elseif ($projects_row->image_layout_id == 6):
                    $image_3 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_3 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_3 . '"><img src="admin/img/projects/' . $projects_row->image_3 . '" /></a></div>';
                else:
                    $image_3 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_3 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_3 . '"><img src="admin/img/projects/' . $projects_row->image_3 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_4 != '' && $projects_row->image_link_4 != ''):
                if ($projects_row->image_layout_id == 6):
                    $image_4 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_4 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_4 . '"><img src="admin/img/projects/' . $projects_row->image_4 . '" /></a></div>';
                else:
                    $image_4 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_4 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_4 . '"><img src="admin/img/projects/' . $projects_row->image_4 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_4 != '' && $projects_row->image_link_4 == ''):
                if ($projects_row->image_layout_id == 6):
                    $image_4 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_4 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_4 . '"><img src="admin/img/projects/' . $projects_row->image_4 . '" /></a></div>';
                else:
                    $image_4 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_4 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_4 . '"><img src="admin/img/projects/' . $projects_row->image_4 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_5 != '' && $projects_row->image_link_5 != ''):
                $image_5 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_5 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_5 . '"><img src="admin/img/projects/' . $projects_row->image_5 . '" /></a></div>';
            elseif ($projects_row->image_5 != '' && $projects_row->image_link_5 == ''):
                $image_5 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_5 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_5 . '"><img src="admin/img/projects/' . $projects_row->image_5 . '" /></a></div>';
            endif;

            if ($projects_row->image_layout_id == 1):
                $image_layout .= $image_1 . $image_2 . $image_3 . $image_4 . $image_5;
            elseif ($projects_row->image_layout_id == 2):
                $image_layout .= $image_2 . $image_3 . $image_4 . $image_5 . $image_1;
            elseif ($projects_row->image_layout_id == 3):
                $image_layout .= $image_1;
            elseif ($projects_row->image_layout_id == 4):
                $image_layout .= $image_1 . $image_2;
            elseif ($projects_row->image_layout_id == 5):
                $image_layout .= $image_1 . $image_2 . $image_3;
            elseif ($projects_row->image_layout_id == 6):
                $image_layout .= $image_1 . $image_2 . $image_3 . $image_4;
            endif;
            
            
            /* new set of images */
            if ($projects_row->image_6 != '' && $projects_row->image_link_6 != ''):
                if ($projects_row->image_layout_id_2 == 3):
                    $image_6 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $projects_row->image_link_6 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_6 . '"><img src="admin/img/projects/' . $projects_row->image_6 . '" /></a></div>';
                elseif ($projects_row->image_layout_id_2 == 6):
                    $image_6 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_6 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_6 . '"><img src="admin/img/projects/' . $projects_row->image_6 . '" /></a></div>';
                else:
                    $image_6 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_link_6 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_6 . '"><img src="admin/img/projects/' . $projects_row->image_6 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_6 != '' && $projects_row->image_link_6 == ''):
                if ($projects_row->image_layout_id_2 == 3):
                    $image_6 = '<div class="imgThumbBig height220"><a href="admin/img/projects/' . $projects_row->image_6 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_6 . '"><img src="admin/img/projects/' . $projects_row->image_6 . '" /></a></div>';
                elseif ($projects_row->image_layout_id_2 == 6):
                    $image_6 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_6 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_6 . '"><img src="admin/img/projects/' . $projects_row->image_6 . '" /></a></div>';
                else:
                    $image_6 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_6 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_6 . '"><img src="admin/img/projects/' . $projects_row->image_6 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_7 != '' && $projects_row->image_link_7 != ''):
                if ($projects_row->image_layout_id_2 == 4):
                    $image_7 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_link_7 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_7 . '"><img src="admin/img/projects/' . $projects_row->image_7 . '" /></a></div>';
                elseif ($projects_row->image_layout_id_2 == 6):
                    $image_7 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_7 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_7 . '"><img src="admin/img/projects/' . $projects_row->image_7 . '" /></a></div>';
                else:
                    $image_7 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_7 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_7 . '"><img src="admin/img/projects/' . $projects_row->image_7 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_7 != '' && $projects_row->image_link_2 == ''):
                if ($projects_row->image_layout_id_2 == 4):
                    $image_7 = '<div class="imgThumb height220"><a href="admin/img/projects/' . $projects_row->image_7 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_7 . '"><img src="admin/img/projects/' . $projects_row->image_7 . '" /></a></div>';
                elseif ($projects_row->image_layout_id_2 == 6):
                    $image_7 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_7 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_7 . '"><img src="admin/img/projects/' . $projects_row->image_7 . '" /></a></div>';
                else:
                    $image_7 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_7 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_7 . '"><img src="admin/img/projects/' . $projects_row->image_7 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_8 != '' && $projects_row->image_link_8 != ''):
                if ($projects_row->image_layout_id_2 == 5):
                    $image_8 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_8 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400"><img src="admin/img/projects/' . $projects_row->image_8 . '" /></a></div>';
                elseif ($projects_row->image_layout_id_2 == 6):
                    $image_8 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_8 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_8 . '"><img src="admin/img/projects/' . $projects_row->image_8 . '" /></a></div>';
                else:
                    $image_8 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_8 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_8 . '"><img src="admin/img/projects/' . $projects_row->image_8 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_8 != '' && $projects_row->image_link_8 == ''):
                if ($projects_row->image_layout_id_2 == 5):
                    $image_8 = '<div class="imgThumb2"><a><img src="images/solid_white.png" /></a></div><div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_8 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_8 . '"><img src="admin/img/projects/' . $projects_row->image_8 . '" /></a></div>';
                elseif ($projects_row->image_layout_id_2 == 6):
                    $image_8 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_8 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_8 . '"><img src="admin/img/projects/' . $projects_row->image_8 . '" /></a></div>';
                else:
                    $image_8 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_8 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_8 . '"><img src="admin/img/projects/' . $projects_row->image_8 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_9 != '' && $projects_row->image_link_9 != ''):
                if ($projects_row->image_layout_id_2 == 6):
                    $image_9 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_link_9 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title="' . $projects_row->image_caption_9 . '"><img src="admin/img/projects/' . $projects_row->image_9 . '" /></a></div>';
                else:
                    $image_9 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_9 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_9 . '"><img src="admin/img/projects/' . $projects_row->image_9 . '" /></a></div>';
                endif;
            elseif ($projects_row->image_9 != '' && $projects_row->image_link_9 == ''):
                if ($projects_row->image_layout_id_2 == 6):
                    $image_9 = '<div class="imgThumb height220" style="width:23%"><a href="admin/img/projects/' . $projects_row->image_9 . '" class="html5lightbox" data-group="set1" title="' . $projects_row->image_caption_9 . '"><img src="admin/img/projects/' . $projects_row->image_9 . '" /></a></div>';
                else:
                    $image_9 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_9 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_9 . '"><img src="admin/img/projects/' . $projects_row->image_9 . '" /></a></div>';
                endif;
            endif;
            if ($projects_row->image_10 != '' && $projects_row->image_link_10 != ''):
                $image_10 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_link_10 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400" title = "' . $projects_row->image_caption_10 . '"><img src="admin/img/projects/' . $projects_row->image_10 . '" /></a></div>';
            elseif ($projects_row->image_10 != '' && $projects_row->image_link_10 == ''):
                $image_10 = '<div class="imgThumb2"><a href="admin/img/projects/' . $projects_row->image_10 . '" class="html5lightbox" data-group="set1" title = "' . $projects_row->image_caption_10 . '"><img src="admin/img/projects/' . $projects_row->image_10 . '" /></a></div>';
            endif;

            if ($projects_row->image_layout_id_2 == 1):
                $image_layout_2 .= $image_6 . $image_7 . $image_8 . $image_9 . $image_10;
            elseif ($projects_row->image_layout_id_2 == 2):
                $image_layout_2 .= $image_7 . $image_8 . $image_9 . $image_10 . $image_6;
            elseif ($projects_row->image_layout_id_2 == 3):
                $image_layout_2 .= $image_6;
            elseif ($projects_row->image_layout_id_2 == 4):
                $image_layout_2 .= $image_6 . $image_7;
            elseif ($projects_row->image_layout_id_2 == 5):
                $image_layout_2 .= $image_6 . $image_7 . $image_8;
            elseif ($projects_row->image_layout_id_2 == 6):
                $image_layout_2 .= $image_6 . $image_7 . $image_8 . $image_9;
            endif;
        endif;
    else:
        $projects = '<p>Invalid content!</p>';
    endif;
else:
    $get_projects = 'SELECT p.* FROM projects p WHERE p.`status` = "published" AND p.is_home = "N" AND project_type = "project" ORDER BY p.project_order ASC';
    $projects_res = $mysqli->query($get_projects);
    if ($projects_res->num_rows > 0):
        $projects .= '<div class="textContent"><div class="projectArea">';
        while ($projects_row = mysqli_fetch_object($projects_res)):
            $type = $projects_row->project_type;

            if ($projects_row->image_1 != '' && $projects_row->image_link_1 != ''):
                $media = '  <a href="' . $projects_row->image_link_1 . '" class="html5lightbox" data-group="set1" data-width="600" data-height="400">
                                <img src="admin/img/projects/' . $projects_row->image_1 . '" width="184" height="260" />
                            </a>';
            else:
                $media = '  <a href="admin/img/projects/' . $projects_row->image_1 . '" class="html5lightbox" data-group="set1">
                                <img src="admin/img/projects/' . $projects_row->image_1 . '" width="184" height="260" />
                            </a>';
            endif;

            /* multiple projects */
            $projects .= '  <div class="projItem">
                                <div class="pdfImg">
                                    ' . $media . '
                                </div>
                                <div class="projTitle">
                                    <h3><a href="projects.php?id=' . $projects_row->id . '">' . $projects_row->project_title . '</a></h3>
                                </div>
                            </div>';
            /* multiple projects */
        endwhile;
        $projects .= '</div></div>';
    else:
        $projects = '<p>No content added</p>';
    endif;
endif;


if ($type == 'project'):
    $template->load("templates/projects.html");
    $template->replace("header", $header);
    $template->replace("footer", $footer);
    $template->replace("projects", $projects);
    $template->replace("js_lightbox", $js_lightbox);
elseif ($type == 'event' || $type == 'exhibition'):
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
    $template->replace("media", $media);
    $template->replace("js_lightbox", $js_lightbox);
    $template->replace("image_layout", $image_layout);
    $template->replace("image_layout_2", $image_layout_2);
    $template->replace("links", $links);
endif;
$template->publish();
$db->mysqlclose();
?>