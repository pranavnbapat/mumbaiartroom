<?php

include 'admin_header.php';
include 'admin_footer.php';


/* declare variables */
$msg = '';
$programme_year = '';
$programme_title = '';
$programme_subtitle = '';
$programme_date = '';
$programme_order = '';
$programme_id = '';
$link = '';
/* declare variables */


/* get programme */
if (isset($_GET['id']) && !empty($_GET['id'])):
    $get_programme = 'SELECT py.programme_year, p.* FROM programme_year py INNER JOIN programmes p ON p.programme_year_id = py.id WHERE p.id = ' . $_GET['id'];
    $programme_res = $mysqli->query($get_programme);
    if ($programme_res->num_rows > 0):
        $programme_row = mysqli_fetch_object($programme_res);

        $get_programme_year = 'SELECT programme_year, id FROM programme_year WHERE status = "published"';
        $programme_year_res = $mysqli->query($get_programme_year);
        if ($programme_year_res->num_rows > 0):
            while ($programme_year_row = mysqli_fetch_object($programme_year_res)):
                if ($programme_row->programme_year == $programme_year_row->programme_year):
                    $programme_year .= '<option value = "' . $programme_year_row->id . '" selected>' . $programme_year_row->programme_year . '</option>';
                else:
                    $programme_year .= '<option value = "' . $programme_year_row->id . '">' . $programme_year_row->programme_year . '</option>';
                endif;
            endwhile;
        else:
            $programme_year = '<option id = "0">No programme year found</option>';
        endif;

        $programme_title = $programme_row->programme_title;
        $programme_subtitle = $programme_row->programme_subtitle;
        $programme_date = $programme_row->programme_date;
        $link = $programme_row->link;
        $programme_id = $programme_row->id;
        $programme_order = $programme_row->programme_order;
    endif;
endif;
/* get programme */


/* edit programme content */
if (isset($_POST['submit']) && $_POST['submit'] == 'Update'):
    $update_array['programme_title'] = trim(addslashes($_POST['programme_title']));
    $update_array['programme_subtitle'] = trim(addslashes($_POST['programme_subtitle']));
    $update_array['programme_date'] = trim(addslashes($_POST['programme_date']));
    $update_array['programme_year_id'] = trim(addslashes($_POST['programme_year']));
    $update_array['programme_order'] = trim(addslashes($_POST['programme_order']));
    $update_array['link'] = trim(addslashes($_POST['link']));
    $update_array['date_created'] = $curr_date_time;
    update($mysqli, 'programmes', $update_array, $_POST['programme_id'], 'id');
    header('Location:programme.php?msg=edited');
endif;
/* edit programme content */


$template->load("templates/programme-edit.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("programme_year", $programme_year);
$template->replace("programme_title", $programme_title);
$template->replace("programme_subtitle", $programme_subtitle);
$template->replace("programme_date", $programme_date);
$template->replace("programme_order", $programme_order);
$template->replace("link", $link);
$template->replace("programme_id", $programme_id);
$template->publish();
$db->mysqlclose();
?>