<?php

require_once 'header.php';
require_once 'footer.php';


$template->load("templates/subscribe.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->publish();
$db->mysqlclose();