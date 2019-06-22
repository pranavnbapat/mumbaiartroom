<?php

require_once './header.php';
require_once './footer.php';
require_once './js_lightbox.php';


$publications = '';
$publication_document = '';


if (isset($_GET['id']) && $_GET['id'] != ''):
    $get_publications = 'SELECT * FROM publications WHERE `status` = "published" AND id = "' . $_GET['id'] . '"';
    $publications_res = $mysqli->query($get_publications);
    if ($publications_res->num_rows > 0):
        $publications_row = mysqli_fetch_object($publications_res);
        if (!empty($publications_row->publication_file)):
            $publication_document = '<h5><a href="admin/files/publications/download.php?filename=' . $publications_row->publication_file . '">DOWNLOAD</a></h5>';
        elseif (empty($publications_row->publication_file)):
            $publication_document = '';
        endif;
        if ($publications_row->image != ''):
            $publications_image = 'admin/img/publications/' . $publications_row->image;
        else:
            $publications_image = '';
        endif;
        $publications = '  <div class="pubItem">
                                <div class="pdfImg">
                                    <a href="' . $publications_image . '" class="html5lightbox">
                                        <img src="' . $publications_image . '" width="184" height="260" />
                                    </a>
                                </div>
                                <div class="pdfText">
                                    <h3>' . $publications_row->title . '</h3>
                                    ' . $publications_row->publication_content . '
                                    ' . $publication_document . '
                                </div>
                            </div>';
    else:
        $publications = '<p>Invalid added.</p>';
    endif;
else:
    $get_publications = 'SELECT * FROM publications WHERE `status` = "published" ORDER BY publication_order ASC';
    $publications_res = $mysqli->query($get_publications);
    if ($publications_res->num_rows > 0):
        while ($publications_row = mysqli_fetch_object($publications_res)):
            if (!empty($publications_row->publication_file)):
                $publication_document = '<h5><a href="admin/files/publications/download.php?filename=' . $publications_row->publication_file . '">DOWNLOAD</a></h5>';
            elseif (empty($publications_row->publication_file)):
                $publication_document = '';
            endif;
            if ($publications_row->image != ''):
                $publications_image = 'admin/img/publications/' . $publications_row->image;
            else:
                $publications_image = '';
            endif;
            $publications .= '  <div class="pubItem">
                                    <div class="pdfImg">
                                        <a href="' . $publications_image . '" class="html5lightbox">
                                            <img src="' . $publications_image . '" width="184" height="260" />
                                        </a>
                                    </div>
                                    <div class="pdfText">
                                        <h3>' . $publications_row->title . '</h3>
                                        ' . $publications_row->publication_content . '
                                        ' . $publication_document . '
                                    </div>
                                </div>';
        endwhile;
    else:
        $publications = '<p>No content added.</p>';
    endif;
endif;


$template->load("templates/publications.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("publications", $publications);
$template->replace("js_lightbox", $js_lightbox);
$template->publish();
$db->mysqlclose();