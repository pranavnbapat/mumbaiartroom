<?php

/* set gallery timing colour */
$gallery_timing = '';
$curr_date_time = date('H:i:s');
$curr_day = date('N');
if ($curr_day == 7 || $curr_day == 1):
    $gallery_timing = '<li class="textRed">Tuesday – Saturday 11 – 7pm</li>';
    $color_value = '#FD3A5A';
elseif ($curr_day != 7 || $curr_day != 1):
    if ($curr_date_time > '11:00:00' && $curr_date_time < '19:00:00'):
        // Green
        $gallery_timing = '<li class="textBlue">Tuesday – Saturday 11am – 7pm</li>';
        $color_value = '#03AD5E';
    else:
        // Red
        $gallery_timing = '<li class="textRed">Tuesday – Saturday 11am – 7pm</li>';
        $color_value = '#FD3A5A';
    endif;
endif;
/* set gallery timing colour */


$get_gallery_comment = 'SELECT gallery_timing_comment FROM timing WHERE status = "published"';
$gallery_timing_comment_res = $mysqli->query($get_gallery_comment);
if ($gallery_timing_comment_res->num_rows > 0):
    $gallery_timing_comment_row = mysqli_fetch_object($gallery_timing_comment_res);
    $gallery_timing_comment = '<li style="position:absolute; font:9px; top:670px; letter-spacing:0px;">' . $gallery_timing_comment_row->gallery_timing_comment . '</li>';
else:
    $gallery_timing_comment = '';
endif;
?>