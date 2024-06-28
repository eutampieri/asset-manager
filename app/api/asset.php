<?php
require_once("../../db.php");
$asset = get_asset(intval($_GET["id"]));
header("Content-Type: application/json");
echo json_encode($asset);

