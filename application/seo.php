<?php

$page_name = $_SERVER['SCRIPT_NAME'];

$get_seo = 'SELECT s.title, s.keywords, s.description FROM seo s INNER JOIN menu_master pm ON pm.id = s.page_id WHERE s.`status` = "published" AND pm.`status` = "published" AND page_name = "' . $page_name . '"';
$seo_res = $mysqli->query($get_seo);
$title = 'Mumbai Art Room';
$keywords = 'mumbai,art,room,gallery,project,programs';
$description = '';
if ($seo_res->num_rows > 0):
    $seo_row = mysqli_fetch_object($seo_res);
    $title = $seo_row->title;
    $keywords = $seo_row->keywords;
    $description = $seo_row->description;
endif;
?>