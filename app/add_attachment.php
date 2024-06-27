<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Add asset
	require_once("../db.php");
	var_dump($_FILES);
	var_dump($_REQUEST);
	$data = file_get_contents($_FILES["file"]["tmp_name"]);
	$mime = $_FILES["file"]["type"];
	$name = $_FILES["file"]["name"];
	$asset = intval($_REQUEST["asset"]);
	add_attachment($asset, $name, $mime, $data);
	header("Location: asset.php?id=".$_REQUEST["asset"]);
	die();
}
$page_title = "Carica";
require_once("../templates/header.php");
?>
<h1>Carica allegato</h1>
<form enctype="multipart/form-data" action="<?=basename(__FILE__)?>" method=POST>
  <input type="hidden" name="asset" value="<?=$_GET["id"]?>">
  <div class="mb-3">
    <label for="formFile" class="form-label">Allegato</label>
    <input class="form-control" type="file" id="formFile" name="file">
  </div>
  <button type="submit" class="btn btn-primary">Carica</button>
</form>
<?php
require_once("../templates/footer.php");
?>
