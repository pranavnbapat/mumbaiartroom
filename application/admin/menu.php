<?php

include 'admin_header.php';
include 'admin_footer.php';

$msg = '';
$menu_list = '';

if (isset($_GET['msg']) && $_GET['msg'] == 'edited'):
    $msg = '<p style="color:green; font-weight:bold;">Contact information has been updated.</p>';
endif;


/* get page list */
$get_menu = 'SELECT mm.*, um.email FROM menu_master mm INNER JOIN user_master um ON um.id = mm.user_id ORDER BY mm.menu_order ASC';
$menu_res = $mysqli->query($get_menu);
if ($menu_res->num_rows > 0):
    $i = $menu_res->num_rows;
    while ($menu_row = mysqli_fetch_object($menu_res)):
        if ($menu_row->status == 'archieved'):
            $status = '<a onclick="change_status(' . $menu_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        elseif ($menu_row->status == 'disabled'):
            $status = '<a onclick="change_status(' . $menu_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-check"></i></a>';
        else:
            $status = '<a onclick="change_status(' . $menu_row->id . ')" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
        endif;
        if ($menu_row->date_updated != '' && $menu_row->date_updated != '0000-00-00 00:00:00'):
            $updated_date = $menu_row->date_updated;
        else:
            $updated_date = 'No last update.';
        endif;

        $menu_list .= "<tr>
                        <td>{$i}</td>
                        <td>{$menu_row->email}</td>
                        <td>" . strtoupper($menu_row->menu_display_name) . "</td>
                        <td>{$menu_row->menu_order}</td>
                        <td>{$status}</td>
                        <td>{$menu_row->date_created}</td>
                        <td>{$updated_date}</td>
                        <td><a href='menu-edit.php?id=" . $menu_row->id . "' class='edit btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a></td>
                    </tr>";
        $i--;
    endwhile;
endif;
/* get page list */


$template->load("templates/menu.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("msg", $msg);
$template->replace("menu_list", $menu_list);
$template->publish();
$db->mysqlclose();
?>