<?php
require_once("../db.php");
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Add kv pair
	require_once("../db.php");
	add_kv_pair(intval($_POST["asset"]), $_POST["key"], $_POST["value"]);
	header("Location: asset.php?id=".$_REQUEST["asset"]);
	die();
}
$asset = get_asset(intval($_GET["id"]));

$page_title = $asset["name"];
require_once("../templates/header.php");
?>
<script>
function getValues(k) {
	fetch("api/values.php?key=" + encodeURIComponent(k))
		.then(x => x.json())
		.then(x => {
			let list = document.getElementById("values");
			list.innerHTML = "";
			for(const v of x) {
				let e = document.createElement("option");
				e.innerText = v;
				list.appendChild(e);
			}
		});
}
</script>
<h1><?=$asset["name"]?></h1>
<form method="POST">
      <datalist id="keys">
      <?php foreach(get_frequent_kv_keys() as $k) {?>
        <option><?=$k?></option>
      <?php } ?>
</datalist>
<datalist id="values">
</datalist>
<input type="hidden" name="asset" value="<?=$asset["id"]?>">
<table class="table">
  <tbody>
	<tr>
		<th scope="row">Serial number</th>
		<td><?=$asset["serial_number"]?></td>
		<td></td>
	</tr>
<?php
foreach($asset["kv"] as $pair) {
?>
    <tr>
      <th scope="row"><?=$pair["key"]?></th>
      <td><?=$pair["value"]?></td>
    </tr>
<?php }?>
    <tr>
      <th scope="row"><input name="key" type="text" class="form-control" list="keys" onchange="getValues(this.value)"></th>
      <td><input name="value" type="text" class="form-control" list="values"></td>
      <td><button type="submit" class="btn btn-success btn-sm">Salva</button></td>
    </tr>
  </tbody>
</table>
</form>
<a class="btn btn-outline-success btn-sm mb-3" href="add_kv.php?id=<?=$asset["id"]?>" role="button">Aggiungi</a>
