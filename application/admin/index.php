<?php

include 'admin_header.php';
include 'admin_footer.php';

$check_user = 'SELECT * FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_res = $mysqli->query($check_user);
$user_row = mysqli_fetch_object($user_res);

$template->load("templates/index.html");
$template->replace('header', $header);
$template->replace('footer', $footer);
$template->replace('name', ucwords($user_row->fname) . ' ' . ucwords($user_row->lname));
$template->publish();
$db->mysqlclose();
?>