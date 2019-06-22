<?php
error_reporting(0);
// -------how many pages we have when using paging?-------
$maxPage = ceil($numrows / $rowsPerPage);
// -------print the link to access each page-------
$self = $_SERVER['PHP_SELF'];
$nav = '';

if ($pageNum - 2 < 1) {
	$pagemin = 1;
	$sg = 1;
} else {
	$sg = 0;
	$pagemin = $pageNum - 2;
}

if ($pageNum + 2 > $maxPage) {
	$pagemax = $maxPage;
	$qg = 1;
} else {
	$qg = 0;
	$pagemax = $pageNum + 2;
}

$search_criteria = '';
if (isset($_GET['video_title_search']) && $_GET['video_title_search'] != "") {
	$video_title_search = $_GET['video_title_search'];
	$search_criteria .= "&video_title_search=" . $video_title_search . "";
}
if (isset($_GET['video_description_search']) && $_GET['video_description_search'] != "") {
	$video_description_search = $_GET['video_description_search'];
	$search_criteria .= "&video_description_search=" . $video_description_search . "";
}
if($_GET['video_title_search'] == '' && $_GET['video_description_search'] == '') {
	$search_criteria = 'q=0';
}

for ($page = $pagemin; $page <= $pagemax; $page++) {
	if ($page == $pageNum) {
		$nav .= "<li class='active'><a class='active1' style='font-size:15px;' href=''> $page </a></li>"; // no need to create a link to current page
	} else {
		$nav .= "<li class='normal'> <a href=\"$self?page=$page$search_criteria\">$page</a></li> ";
	}
}

if ($pageNum > 1) {
	$page = $pageNum - 1;
	$prev = "<li> <a href=\"$self?page=$page$search_criteria\">[Prev]</a> </li>";
	$first = "<li> <a href=\"$self?page=1$search_criteria\">[First page]</a> </li>";
} else {
	$prev = '&nbsp;'; // we're on page one, don't print previous link
	$first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage) {
	$page = $pageNum + 1;
	$next = " <li><a href=\"$self?page=$page$search_criteria\">[Next]</a> </li>";
	$last = "<li> <a href=\"$self?page=$maxPage$search_criteria\">[last page]</a> </li>";
} else {
	$next = '&nbsp;'; // we're on the last page, don't print next link
	$last = '&nbsp;'; // nor the last page link
}
// print the navigation link

if (($sg == 1) && ($qg == 1)) {
	$pag = '<ul id="pagination-flickr" style="margin-bottom:20px;"><li>' . $first . '</li><li class="previous-off">' . $prev . '</li><li>' . $nav . '</li><li>' . '</li><li class="next">' . $next . '</li><li>' . $last . '</li></ul>';
} else {
	if (($sg == 1) && ($qg == 0)) {
		$pag = '<ul id="pagination-flickr" style="margin-bottom:20px;"><li>' . $first . '</li><li class="previous-off">' . $prev . '</li><li>' . $nav . '</li><li>' . '</li><li class="next">' . $next . '</li><li>' . $last . '</li></ul>';
	} else {
		if (($sg == 0) && ($qg == 0)) {
			$pag = '<ul id="pagination-flickr" style="margin-bottom:20px;"><li>' . $first . '</li><li class="previous-off">' . $prev . '</li><li>' . '</li><li>' . $nav . '</li><li>' . '</li><li class="next">' . $next . '</li><li>' . $last . '</li></ul>';
		} else {
			if (($sg == 0) && ($qg == 1)) {
				$pag = '<ul id="pagination-flickr" style="margin-bottom:20px;"><li>' . $first . '</li><li class="previous-off">' . $prev . '</li><li>' . '</li><li>' . $nav . '</li><li class="next">' . $next . '</li><li>' . $last . '</li></ul>';
			}
		}
	}
}
?>
