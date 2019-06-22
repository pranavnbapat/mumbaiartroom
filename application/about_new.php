<?php

include './header.php';
include './footer.php';

$about = '';

$get_about = 'SELECT about_content FROM about WHERE status = "published"';
$about_res = $mysqli->query($get_about);
if ($about_res->num_rows > 0):
    $about_row = mysqli_fetch_object($about_res);
    $about = $about_row->about_content;
else:
    $about = '<p>No content added.</p>';
endif;

$template->load("templates/about_new.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("about", $about);
$template->publish();
$db->mysqlclose();
?>