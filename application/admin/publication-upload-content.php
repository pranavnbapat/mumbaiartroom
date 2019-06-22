<?php

require_once 'admin_header.php';
require_once 'admin_footer.php';

$template->load("templates/publication-upload-content.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->publish();
$db->mysqlclose();