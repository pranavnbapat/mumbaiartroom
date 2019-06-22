<?php

include 'db.class.php';

include 'function.php';

include 'functiondb.php';

include 'backend_validation.php';

include 'BrowserDetection.php';
$browser = new BrowserDetection();

include 'template.class.php';
$template = new Template;

$db = new DbaseMySQL();
$mysqli = $db->mySQLConnect();
$mysqli->set_charset("utf8");
?>