<?php
require_once("../../db.php");
header("Content-Type: application/json");
echo json_encode(last_n_assets(isset($_GET["n"]) ? intval($_GET["n"]) : 100));

