<?php

include 'admin_header.php';
include 'admin_footer.php';


/* declare variables */
$projects_list = '';
$publications_list = '';
$galleries_list = '';
/* declare variables */


/* show projects list */
$get_projects = 'SELECT * FROM projects';
$projects_res = $mysqli->query($get_projects);
if ($projects_res->num_rows > 0):
    $i = $projects_res->num_rows;
    while ($projects_row = mysqli_fetch_object($projects_res)):
        if ($projects_row->date_updated != '' && $projects_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $projects_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;
        $projects_list .= ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $projects_row->project_title . '</td>
                                <td>' . ucwords($projects_row->project_type) . '</td>
                                <td>' . $projects_row->is_home . '</td>
                                <td>http://www.mumbaiartroom.org/projects.php?id=' . $projects_row->id . '</td>
                                <td>' . $projects_row->date_created . '</td>
                                <td>' . $updated_date . '</td>
                            </tr>';
        $i--;
    endwhile;
endif;
/* show projects list */


/* show publications list */
$get_publications = 'SELECT * FROM publications';
$publications_res = $mysqli->query($get_publications);
if ($publications_res->num_rows > 0):
    $i = $publications_res->num_rows;
    while ($publications_row = mysqli_fetch_object($publications_res)):
        if ($publications_row->date_updated != '' && $publications_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $publications_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;
        $publications_list .= ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $publications_row->title . '</td>
                                <td>Publication</td>
                                <td>N</td>
                                <td>http://www.mumbaiartroom.org/publications.php?id=' . $publications_row->id . '</td>
                                <td>' . $publications_row->date_created . '</td>
                                <td>' . $updated_date . '</td>
                            </tr>';
    endwhile;
endif;
/* show publications list */


/* show gallery list */
$get_galleries = 'SELECT gallery_name, id, updated_at, created_at FROM gallery_master WHERE `status` = "enabled"';
$galleries_res = $mysqli->query($get_galleries);
if ($galleries_res->num_rows > 0):
    $i = $galleries_res->num_rows;
    while ($galleries_row = mysqli_fetch_object($galleries_res)):
        if ($galleries_row->updated_at != '' && $galleries_row->updated_at != '0000-00-00 00:00:00'):
            $updated_date = $galleries_row->updated_at;
        else:
            $updated_date = 'No last update.';
        endif;
        $galleries_list .= ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $galleries_row->gallery_name . '</td>
                                <td>Gallery</td>
                                <td>N</td>
                                <td>http://www.mumbaiartroom.org/gallery.php?id=' . $galleries_row->id . '</td>
                                <td>' . $galleries_row->created_at . '</td>
                                <td>' . $updated_date . '</td>
                            </tr>';
        $i--;
    endwhile;
endif;
/* show gallery list */


$all_list = $projects_list . $publications_list . $galleries_list;


$template->load("templates/all-links.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("projects_list", $all_list);
$template->publish();
$db->mysqlclose();
?>