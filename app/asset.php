<?php
require_once("../db.php");
$asset = get_asset(intval($_GET["id"]));

$page_title = $asset["name"];
require_once("../templates/header.php");
?>
<h1><?=$asset["name"]?></h1>
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
      <td></td>
    </tr>
<?php }?>
  </tbody>
</table>
<a class="btn btn-outline-success btn-sm mb-3" href="add_kv.php?id=<?=$asset["id"]?>" role="button">Aggiungi</a>
<h2>Allegati</h2>
<ul>
<?php
foreach($asset["attachments"] as $attachment) {
?>
	<li><a href="attachment.php?id=<?=$attachment["id"]?>"><?=$attachment["file_name"]?></a></li>
<?php } ?>
</ul>
<a class="btn btn-outline-success btn-sm mb-3" href="add_attachment.php?id=<?=$asset["id"]?>" role="button">Aggiungi</a>
<?php
require_once("../templates/footer.php");

