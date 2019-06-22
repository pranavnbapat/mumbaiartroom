<?php

include 'admin_header.php';
include 'admin_footer.php';


/* declare variables */
$msg = '';
$gallery_name = '';
$gallery_list = '';
/* declare variables */


/* generate message */
if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Gallery updated!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'added'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:green; font-weight:bold;">Gallery created!</p></div></div>';
elseif (isset($_GET['msg']) && $_GET['msg'] == 'canceled'):
    $msg = '<div class="form-group"><div class="col-sm-5 control-label">&nbsp;</div><div class="col-sm-5 controls"><p style="color:#b94a48; font-weight:bold;">Gallery editing canceled!</p></div></div>';
endif;
/* generate message */


/* get gallery list */
$get_gallery_list = 'SELECT * FROM gallery_master';
$gallery_list_res = $mysqli->query($get_gallery_list);
if ($gallery_list_res->num_rows > 0):
    $i = $gallery_list_res->num_rows;
    while ($gallery_list_row = mysqli_fetch_object($gallery_list_res)):
        if ($gallery_list_row->status == 'disabled'):
            $status = '<a onclick="change_status(' . $gallery_list_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $gallery_list_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($gallery_list_row->updated_at != '' && $gallery_list_row->updated_at != '0000-00-00 00:00:00'):
            $updated_at = $gallery_list_row->updated_at;
        else:
            $updated_at = 'No last update.';
        endif;
        $gallery_list .= '<tr>
                            <td>' . $i . '</td>
                            <td>' . $gallery_list_row->gallery_name . '</td>
                            <td><a href="add-gallery-images.php?id=' . $gallery_list_row->id . '">Add Images</a></td>
                            <td>' . $status . ' <a href="gallery-edit.php?id=' . $gallery_list_row->id . '" class="edit btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a></td>
                            <td>' . $gallery_list_row->created_at . '</td>
                            <td>' . $updated_at . '</td>
                          </tr>';
        $i--;
    endwhile;
endif;
/* get gallery list */


/* add gallery */
if (isset($_POST['submit']) && $_POST['submit'] == 'Add'):
    mkdir('img/gallery/' . trim(htmlspecialchars(addslashes($_POST['gallery_name']))));
    $insert_array['gallery_name'] = trim(htmlspecialchars(addslashes($_POST['gallery_name'])));
    $insert_array['created_at'] = $curr_date_time;
    $last_insert_id = insert($mysqli, 'gallery_master', $insert_array);

    $insert_log['user_id'] = $user_info_row->id;
    $insert_log['message'] = 'Gallery with id ' . $last_insert_id . ' has been added.';
    $insert_log['activity_from'] = get_client_ip();
    $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
    $insert_log['user_platform'] = $browser->getPlatform();
    $insert_log['date_created'] = $curr_date_time;

    header('Location:image-gallery.php?msg=added');
endif;
/* add gallery */


$template->load("templates/image-gallery.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("gallery_name", $gallery_name);
$template->replace("gallery_list", $gallery_list);
$template->replace("msg", $msg);
$template->publish();
$db->mysqlclose();
?>