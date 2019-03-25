<?php
include_once "dbconfig.php";
$username = $_REQUEST["username"];
$passward = $_REQUEST["password"];

$connstr = "host=" . HOST . " port=" . PORT . " dbname=" . DBNAME . " user=" . USER . " password=" . PASSWORD;
$conn = pg_connect($connstr);
if (!$conn) {
    echo json_encode(array(
        "success" => false
    ));
    exit(1);
}

$sql = "SELECT COUNT(1) FROM register WHERE username='{$username}' AND passward='{$passward}';";
$result = pg_query($conn, $sql);
$row = pg_fetch_row($result, 0);
if (intval($row[0]) === 1) {
    echo json_encode(array(
        "success" => true
    ));
} else {
    echo json_encode(array(
        "success" => false
    ));
}

pg_free_result($result);
pg_close($conn);
