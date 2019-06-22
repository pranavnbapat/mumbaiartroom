<?php

function select($mysqli, $tablename, $data) {
    $select = $mysqli->query("SELECT * FROM" . $tablename);
    if ($result) {
        return $mysqli->insert_id;
    } else {
        printf("Errormessage: %s\n", $mysqli->error);
        exit();
    }
}


function insert($mysqli, $tblname, $tbl_data) {
    $field_name = '';
    $field_value = '';
    while ($element = each($tbl_data)) {
        if ($field_name == "") {
            $field_name = $element['key'];
        } elseif ($field_name != "") {
            $field_name = $field_name . "," . $element['key'];
        }
        if ($field_value == "") {
            $field_value = "'" . $element['value'] . "'";
        } elseif ($field_value != "") {
            $field_value = $field_value . "," . "'" . $element['value'] . "'";
        }
    }
    $result = $mysqli->query("Insert into " . $tblname . " (" . $field_name . ")values(" . $field_value . ")");
    if ($result) {
        return $mysqli->insert_id;
    } else {
        printf("Errormessage: %s\n", $mysqli->error);
        exit();
    }
}


function update($mysqli, $tblname, $tbl_data, $id, $field) {
    $field_name = '';
    while ($element = each($tbl_data)) {
        if ($field_name == "") {
            $field_name = $element['key'] . "=" . "'" . $element['value'] . "'";
        } elseif ($field_name != "") {
            $field_name = $field_name . "," . $element['key'] . "=" . "'" . $element['value'] . "'";
        }
    }
    $result = $mysqli->query("update " . $tblname . "  set " . $field_name . " where $field='$id'");
    if ($result) {
        return true;
    } else {
        printf("Errormessage: %s\n", $mysqli->error);
        exit();
    }
}


function delete($mysqli, $tblname, $id, $field) {
    $result = $mysqli->query("delete from " . $tblname . " where " . $field . "='" . $id . "'");
    if ($result) {
        return true;
    } else {
        printf("Errormessage: %s\n", $mysqli->error);
        exit();
    }
}
?>
