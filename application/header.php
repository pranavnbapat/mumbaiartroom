<?php

require_once 'config/common.php';
require_once 'seo.php';
require_once 'timings.php';


/* variable declaration */
$menu = '';
/* variable declaration */


/* get menu */
$get_menu = 'SELECT menu_display_name, page_name FROM menu_master WHERE `status` = "published" ORDER BY menu_order ASC';
$menu_res = $mysqli->query($get_menu);
if ($menu_res->num_rows > 0):
    $i = 0;
    while ($menu_row = mysqli_fetch_object($menu_res)):
        if ($menu_res->num_rows == 6):
            if ($i == 3):
                $menu .= '<li>&nbsp;</li>';
            endif;

            if ($i == 5):
                $menu .= '<li>&nbsp;</li>';
            endif;

        elseif ($menu_res->num_rows == 7):
            if ($i == 4):
                $menu .= '<li>&nbsp;</li>';
            endif;

            if ($i == 6):
                $menu .= '<li>&nbsp;</li>';
            endif;
        endif;

        if ($menu_row->page_name == substr($_SERVER['SCRIPT_NAME'], 1)):
            $check_project = 'SELECT project_type FROM projects WHERE id = "' . trim(htmlspecialchars($_GET['id'])) . '"';
            $check_project_res = $mysqli->query($check_project);
            if ($check_project_res->num_rows > 0):
                $check_project_row = mysqli_fetch_object($check_project_res);
                if ($check_project_row->project_type == 'project'):
                    $menu .= '<li><a href="' . $menu_row->page_name . '" class="act">' . strtoupper($menu_row->menu_display_name) . '</a></li>';
                else:
                    $menu .= '<li><a href="' . $menu_row->page_name . '">' . strtoupper($menu_row->menu_display_name) . '</a></li>';
                endif;
            else:
                $menu .= '<li><a href="' . $menu_row->page_name . '" class="act">' . strtoupper($menu_row->menu_display_name) . '</a></li>';
            endif;
        else:
            $menu .= '<li><a href="' . $menu_row->page_name . '">' . strtoupper($menu_row->menu_display_name) . '</a></li>';
        endif;
        $i++;
    endwhile;
endif;
/* get menu */


// Newest colour value
// #FD3A5A - Red
// #03AD5E - Green
// New colour value
// #EA687D - Red
// #00934F - Green
// Old colour values
// #F0515F - Red
// #009779 - Green



$header = ' <!DOCTYPE html>
            <html>
                <head>
                    <title>' . $title . '</title>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
                    <meta name="Keywords" content="' . $keywords . '" />
                    <meta name="Description" content="' . $description . '" />

                    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
                    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
                    <link href="css/style.css" rel="stylesheet" />

                    <script src="js/jquery-1.8.3.min.js"></script>
                    <!--[if lt IE 9]><script src="js/html5shiv.js"></script><![endif]-->
                    
                    <style>
                        .mainArea .projects .homeArea2 p, nav ul li a:hover, nav ul li a.act, .mrtlogo, .mainArea .homeArea2 p, #accordian h1, .homeArea2 a:hover, #accordian li a:hover, .projItem h3 a:hover, input[type="submit"], .pdfText h5 a:hover, .textRed, .textBlue {
                            color:' . $color_value . ' !important;
                        }
                        
                        #html5-text {
                            text-align:center !important;
                            font-family: universltstd !important;
                        }
                    </style>
                </head>
                <body>
                    <div class="wrapper">
                        <header>
                            <a href="index.php">
                                <!--<img class="mrtlogo" src="images/mumbai-art-room-logo.jpg" alt="Mumbai Art Room Logo">-->
                            	<span class="mrtlogo">MUMBAI ART ROOM</span>
                            </a>
                            <div class="mobileMenu"><div class="down" id="updwn"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="menuArea">
                            <nav class="menu">
                                <ul>
                                    ' . $menu . '
                                    <li class="last marBtm15">Pipewala Building <br />Fourth Pasta Lane, Colaba <br /> Mumbai 400 005, India <br />
                                        <a href="mailto:office@mumbaiartroom.org" target="_blank">office@mumbaiartroom.org</a>
                                    </li>
                                    ' . $gallery_timing . $gallery_timing_comment . '
                                </ul>
                            </nav>
                        </div>
                    </header>';