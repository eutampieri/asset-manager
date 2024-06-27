<?php
require_once("../db.php");
$attachment = get_attachment(intval($_GET["id"]));

header("Content-Type: ".$attachment["mime_type"]);
$quopri = quoted_printable_encode($attachment["file_name"]);
header("Content-Disposition: inline, filename=\"$quopri\"");
header("Content-Length: ".strval(strlen($attachment["data"])));

echo $attachment["data"];

