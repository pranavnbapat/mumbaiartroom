<?php

include './header.php';
include './footer.php';

$template->load("templates/location.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->publish();
$db->mysqlclose();
?>