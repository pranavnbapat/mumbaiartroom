<?php

require_once 'admin_header.php';
require_once 'admin_footer.php';


/* declare variables */
$msg = '';
$programme_year = '<option value = "0">Please select a programme year</option>';
$programme_title = '';
$programme_subtitle = '';
$programme_date = '';
$programme_list = '';
$sort = '';
/* declare variables */


if (isset($_GET['msg']) && $_GET['msg'] == 'added'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content successfully added!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Content successfully edited!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'canceled'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:#b94a48; font-weight:bold;">Content editing cancelled!</p></div></div>';
endif;


/* get programme year */
$get_programme_year = 'SELECT id, programme_year FROM programme_year WHERE status = "published"';
$programme_year_res = $mysqli->query($get_programme_year);
if ($programme_year_res->num_rows > 0):
    while ($programme_year_row = mysqli_fetch_object($programme_year_res)):
        $programme_year .= '<option value = "' . $programme_year_row->id . '">' . $programme_year_row->programme_year . '</option>';
    endwhile;
endif;
/* get programme year */


/* add programme year */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add Year'):
    $insert_array['programme_year'] = trim($_POST['programme_year']);
    $insert_array['date_created'] = $curr_date_time;
    insert($mysqli, 'programme_year', $insert_array);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'Program year ' . $_POST['programme_year'] . ' has been added.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;

    header('Location:programme.php?msg=added');
endif;
/* add programme year */


/* add programme content */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
    $get_last_order = 'SELECT max(p.programme_order) as max_programme_order FROM programmes p INNER JOIN programme_year py ON py.id = p.programme_year_id WHERE py.programme_year = "2016"';
    $last_order_res = $mysqli->query($get_last_order);
    $last_order_row = mysqli_fetch_object($last_order_res);
    $insert_array2['programme_title'] = trim(htmlspecialchars(addslashes($_POST['programme_title'])));
    $insert_array2['programme_subtitle'] = trim(htmlspecialchars(addslashes($_POST['programme_subtitle'])));
    $insert_array2['programme_date'] = trim(htmlspecialchars(addslashes($_POST['programme_date'])));
    $insert_array2['programme_year_id'] = trim(addslashes($_POST['programme_year']));
    $insert_array2['programme_order'] = $last_order_row->max_programme_order + 1;
    $insert_array2['link'] = trim(addslashes($_POST['link']));
    $insert_array2['date_created'] = $curr_date_time;
    $last_insert_id = insert($mysqli, 'programmes', $insert_array2);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'Program with id ' . $last_insert_id . ' has been added.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;

    header('Location:programme.php?msg=added');
endif;
/* add programme content */


/* get programme content */
$get_programmes = 'SELECT p.*, py.programme_year FROM programmes p INNER JOIN programme_year py ON p.programme_year_id = py.id ORDER BY p.programme_order DESC';
$programmes_res = $mysqli->query($get_programmes);
if ($programmes_res->num_rows > 0):
    $i = $programmes_res->num_rows;
    while ($programmes_row = mysqli_fetch_object($programmes_res)):
        if ($programmes_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $programmes_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $programmes_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($programmes_row->date_updated != '' && $programmes_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $programmes_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;
        $programme_list .= '<tr>
                                <td>' . $i . '</td>
                                <td>' . $programmes_row->programme_year . '</td>
                                <td>' . $programmes_row->programme_title . '</td>
                                <td>' . $programmes_row->programme_subtitle . '</td>
                                <td>' . $programmes_row->programme_date . '</td>
                                <td>' . $programmes_row->programme_order . '</td>
                                <td>' . $programmes_row->date_created . '</td>
                                <td>' . $updated_date . '</td>
                                <td>' . $status . ' <a href="programme-edit.php?id=' . $programmes_row->id . '" class="edit btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-xs" onclick="delete_record(' . $programmes_row->id . ')"><i class="fa fa-trash-o"></i></a>' . '</td>
                            </tr>';
        $i--;
    endwhile;
endif;
/* get programme content */


/* get programme content for sorting */
//$query = 'SELECT p.*, py.programme_year FROM programmes p INNER JOIN programme_year py ON p.programme_year_id = py.id ORDER BY py.programme_year DESC, p.date_created DESC';
////$query = 'SELECT p.*, py.programme_year FROM programmes p INNER JOIN programme_year py ON p.programme_year_id = py.id WHERE py.programme_year IN (SELECT programme_year FROM programme_year GROUP BY programme_year) ORDER BY py.programme_year DESC, p.date_created DESC ';
//$res = $mysqli->query($query);
//if ($res->num_rows > 0):
//    while ($row = mysqli_fetch_object($res)):
//        $sort .= '<li id = "array_order_' . $row->programme_order . '">' . $row->programme_year . ' -- ' . $row->programme_title . ' -- ' . $row->programme_subtitle . ' -- ' . ' -- ' . $row->programme_date . '</li>';
//    endwhile;
//endif;

//$get_programme_year = 'SELECT DISTINCT py.programme_year, py.id FROM programme_year py WHERE py.status = "published" ORDER BY py.programme_year DESC';
//$programme_res_year = $mysqli->query($get_programme_year);
//if ($programme_res_year->num_rows > 0):
//    while ($programme_row_year = mysqli_fetch_object($programme_res_year)):
//        $get_programme = 'SELECT p.* FROM programmes p INNER JOIN programme_year py ON py.id = p.programme_year_id WHERE py.status = "published" AND p.status = "published" AND p.programme_year_id = ' . $programme_row_year->id . ' ORDER BY py.programme_year DESC, p.programme_order DESC;';
//        $programme_res = $mysqli->query($get_programme);
//        if ($programme_res->num_rows > 0):
//            while ($programmes_row = mysqli_fetch_object($programme_res)):
//                $sort .= '<li id = "array_order_' . $programmes_row->id . '">' . $programme_row_year->programme_year . ' -- ' . $programmes_row->programme_title . ' -- ' . $programmes_row->programme_subtitle . ' -- ' . ' -- ' . $programmes_row->programme_date . '</li>';
//            endwhile;
//        endif;
//    endwhile;
//endif;
/* get programme content for sorting */


$template->load("templates/programme.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("programme_year", $programme_year);
$template->replace("programme_title", $programme_title);
$template->replace("programme_subtitle", $programme_subtitle);
$template->replace("programme_date", $programme_date);
$template->replace("programme_list", $programme_list);
//$template->replace("programme_order", $programme_order);
$template->replace("sort", $sort);
$template->publish();
$db->mysqlclose();
?>