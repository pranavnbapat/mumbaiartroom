<?php

$js_lightbox = '';
if (isset($_SERVER['SCRIPT_NAME']) && ($_SERVER['SCRIPT_NAME'] == '' || $_SERVER['SCRIPT_NAME'] == '/index.php' || $_SERVER['SCRIPT_NAME'] == '/projects.php') || ($_SERVER['SCRIPT_NAME'] == '/publications.php')):
    $js_lightbox = '<script src="js/html5lightbox.js"></script>';
endif;
?>