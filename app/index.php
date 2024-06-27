<?php
require_once("../db.php");
migrate_db();

require_once("../templates/header.php");
?>
<h1>Gestione asset</h1>
<a class="btn btn-outline-success btn-lg" href="add.php" role="button">Aggiungi</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nome</th>
      <th scope="col">S/N</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach(last_n_assets(100) as $asset) {
?>
    <tr>
      <th scope="row"><a href="asset.php?id=<?=$asset["id"]?>"><?=$asset["name"]?></a></th>
      <td><?=$asset["serial_number"]?></td>
    </tr>
<?php }?>
  </tbody>
</table>
<?php
require_once("../templates/footer.php");

