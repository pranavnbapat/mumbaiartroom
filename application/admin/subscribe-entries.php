<?php

require_once 'admin_header.php';
require_once 'admin_footer.php';


/* declare variables */
$subscribe_list = '';
/* declare variables */


/* get programme content */
$get_subscriptions = 'SELECT DISTINCT fname, lname, email, city, date_created FROM subscribe ORDER BY date_created DESC';
$subscriptions_res = $mysqli->query($get_subscriptions);
if ($subscriptions_res->num_rows > 0):
    while ($subscriptions_row = mysqli_fetch_object($subscriptions_res)):
        $subscribe_list .= '<tr>
                                <td>' . $subscriptions_row->fname . '</td>
                                <td>' . $subscriptions_row->lname . '</td>
                                <td>' . $subscriptions_row->email . '</td>
                                <td>' . $subscriptions_row->city . '</td>
                                <td>' . $subscriptions_row->date_created . '</td>
                            </tr>';
    endwhile;
endif;
/* get programme content */



$template->load("templates/subscribe-entries.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("subscribe_list", $subscribe_list);
$template->publish();
$db->mysqlclose();
?>