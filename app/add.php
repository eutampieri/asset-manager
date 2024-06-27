<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Add asset
	require_once("../db.php");
	add_asset($_POST["sn"], $_POST["name"]);
	header("Location: .");
	die();
}
$page_title = "Aggiungi";
require_once("../templates/header.php");
?>
<h1>Aggiungi asset</h1>
<form action="<?=basename(__FILE__)?>" method=POST>
  <div class="mb-3">
    <label for="sn" class="form-label">Serial number</label>
    <input type="text" class="form-control" id="sn" name="sn">
  </div>
  <div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <button type="submit" class="btn btn-primary">Aggiungi</button>
</form>
<?php
require_once("../templates/footer.php");
?>
