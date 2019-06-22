<?php

include 'config/common.php';


$publications = '';
$projects = '';


$get_publications = 'SELECT id, title FROM publications WHERE status = "published"';
$publications_res = $mysqli->query($get_publications);

$get_projects = 'SELECT id, project_title, project_type FROM projects WHERE status = "published"';
$projects_res = $mysqli->query($get_projects);


if (isset($_GET['type']) && ($_GET['type'] == 'programme' && $_GET['link'] != '')):
    $get_programme_link = 'SELECT link FROM programmes WHERE id = ' . $_GET['id'];
    $programme_link_res = $mysqli->query($get_programme_link);
    $programme_link_row = mysqli_fetch_object($programme_link_res);

    if ($publications_res->num_rows > 0):
        while ($publications_row = mysqli_fetch_object($publications_res)):
            if ($programme_link_row->link == 'publications.php?id=' . $publications_row->id):
                $publications .= '<option value = "publications.php?id=' . $publications_row->id . '" selected>Publications - ' . $publications_row->title . '</option>';
            else:
                $publications .= '<option value = "publications.php?id=' . $publications_row->id . '">Publications - ' . $publications_row->title . '</option>';
            endif;
        endwhile;
    endif;

    if ($projects_res->num_rows > 0):
        while ($projects_row = mysqli_fetch_object($projects_res)):
            if ($programme_link_row->link == 'projects.php?id=' . $projects_row->id):
                if ($projects_row->project_type == 'project'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '" selected>Project - ' . $projects_row->project_title . '</option>';
            elseif ($projects_row->project_type == 'exhibition'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '" selected>Exhibition - ' . $projects_row->project_title . '</option>';
            elseif ($projects_row->project_type == 'event'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '" selected>Event - ' . $projects_row->project_title . '</option>';
            endif;
            else:
                if ($projects_row->project_type == 'project'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '">Project - ' . $projects_row->project_title . '</option>';
            elseif ($projects_row->project_type == 'exhibition'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '">Exhibition - ' . $projects_row->project_title . '</option>';
            elseif ($projects_row->project_type == 'event'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '">Event - ' . $projects_row->project_title . '</option>';
            endif;
            endif;
        endwhile;
    endif;

    echo $publications . $projects;
elseif (isset($_GET['type']) && ($_GET['type'] == 'project' && $_GET['link'] != '')):
    $get_project_link = 'SELECT link FROM project_linking WHERE project_id = ' . $_GET['id'];
    $project_link_res = $mysqli->query($get_project_link);
    $project_link_row = mysqli_fetch_object($project_link_res);

    if ($publications_res->num_rows > 0):
        while ($publications_row = mysqli_fetch_object($publications_res)):
            if ($project_link_row->link == 'publications.php?id=' . $publications_row->id):
                $publications .= '<option value = "publications.php?id=' . $publications_row->id . '" selected>Publications - ' . $publications_row->title . '</option>';
            else:
                $publications .= '<option value = "publications.php?id=' . $publications_row->id . '">Publications - ' . $publications_row->title . '</option>';
            endif;
        endwhile;
    endif;

    if ($projects_res->num_rows > 0):
        while ($projects_row = mysqli_fetch_object($projects_res)):
            if ($project_link_row->link == 'projects.php?id=' . $projects_row->id):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '" selected>Projects - ' . $projects_row->project_title . '</option>';
            else:
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '">Projects - ' . $projects_row->project_title . '</option>';
            endif;
        endwhile;
    endif;

    echo $publications . $projects;
else:
    if ($publications_res->num_rows > 0):
        while ($publications_row = mysqli_fetch_object($publications_res)):
            $publications .= '<option value = "publications.php?id=' . $publications_row->id . '">Publications - ' . $publications_row->title . '</option>';
        endwhile;
    endif;

    if ($projects_res->num_rows > 0):
        while ($projects_row = mysqli_fetch_object($projects_res)):
            if ($projects_row->project_type == 'project'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '">Project - ' . $projects_row->project_title . '</option>';
            elseif ($projects_row->project_type == 'exhibition'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '">Exhibition - ' . $projects_row->project_title . '</option>';
            elseif ($projects_row->project_type == 'event'):
                $projects .= '<option value = "projects.php?id=' . $projects_row->id . '">Event - ' . $projects_row->project_title . '</option>';
            endif;
        endwhile;
    endif;

    echo '<option value = "0">Please select linking (Optional)</option>' . $publications . $projects;
endif;
?>