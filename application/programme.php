<?php

include './header.php';
include './footer.php';


$programmes = '';
$programme_year = '';
$programmes_accordion = '';


/* get programme list */
$get_programme_year = 'SELECT DISTINCT py.programme_year, py.id FROM programme_year py WHERE py.status = "published" ORDER BY py.programme_year DESC';
$programme_res_year = $mysqli->query($get_programme_year);
if ($programme_res_year->num_rows > 0):
    while ($programme_row_year = mysqli_fetch_object($programme_res_year)):
        $get_programme = 'SELECT p.* FROM programmes p INNER JOIN programme_year py ON py.id = p.programme_year_id WHERE py.status = "published" AND p.status = "published" AND p.programme_year_id = ' . $programme_row_year->id . ' ORDER BY p.programme_order DESC;';
        $programme_res = $mysqli->query($get_programme);
        if ($programme_res->num_rows > 0):
            $programme_year = '<h1>' . $programme_row_year->programme_year . '</h1>';
            $programmes = '<div class="acc_data"><p><ul>';
            while ($programme_row = mysqli_fetch_object($programme_res)):
                if ($programme_row->link != '0'):
                    $link = $programme_row->link;
                else:
                    $link = '#';
                endif;
                $programmes .= '<li><div class="dateArea">' . $programme_row->programme_date . '</div><h5><a href="' . $link . '">' . $programme_row->programme_title . '</a></h5><div class="subline">' . $programme_row->programme_subtitle . '</div></li>';
            endwhile;
            $programmes .= '</p></ul></div>';
            $programmes_accordion .= $programme_year . $programmes;
        endif;
    endwhile;
else:
    $programmes_accordion = '<p>No content added.</p>';
endif;
/* get programme list */


$template->load("templates/programme.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("programmes_accordion", $programmes_accordion);
$template->publish();
$db->mysqlclose();
?>