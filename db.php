<?php
function get_db_filename() {
	return 'sqlite:'.dirname(__FILE__).'/db/db.sqlite';
}
function migrate_db() {
	// This function runs migrations contained in the migrations folder
	$migrations = glob(dirname(__FILE__)."/migrations/*.sql");
	$db = new PDO(get_db_filename());
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("CREATE TABLE IF NOT EXISTS migration(name TEXT)");
	$migration_check = $db->prepare("SELECT COUNT(*) FROM migration WHERE name = ?");
	$migration_insert = $db->prepare("INSERT INTO migration VALUES(?)");
	foreach($migrations as $migration) {
		$migration_check->execute([basename($migration)]);
		if($migration_check->fetch()[0] == 0) {
			$query = file_get_contents($migration);
			$db->exec($query);
			$migration_insert->execute([basename($migration)]);
		}
	}
}

function add_asset($sn, $name) {
	$db = new PDO(get_db_filename());
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$insertion_stmt = $db->prepare("INSERT INTO asset (serial_number, name) VALUES (?, ?)");
	$insertion_stmt->execute([$sn, $name]);
}

function last_n_assets($n) {
	$db = new PDO(get_db_filename());
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$assets_stmt = $db->prepare("SELECT * FROM asset ORDER BY id DESC LIMIT ?");
	$assets_stmt->execute([$n]);
	return $assets_stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_asset($id) {
	$db = new PDO(get_db_filename());
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$assets_stmt = $db->prepare("SELECT * FROM asset WHERE id = ?");
	$assets_stmt->execute([$id]);
	$data = $assets_stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($data) == 1) {
		$data = $data[0];
		$kv_stmt = $db->prepare("SELECT * FROM kv WHERE asset_id = ?");
		$kv_stmt->execute([$id]);
		$data["kv"] = $kv_stmt->fetchAll(PDO::FETCH_ASSOC); 
		
		$attachments_stmt = $db->prepare("SELECT id, file_name FROM attachments WHERE asset_id = ?");
		$attachments_stmt->execute([$id]);
		$data["attachments"] = $attachments_stmt->fetchAll(PDO::FETCH_ASSOC); 
	} else {
		$data = null;
	}
	return $data;
}

function add_attachment($asset, $name, $mime, $data) {
	$db = new PDO(get_db_filename());
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$insertion_stmt = $db->prepare("INSERT INTO attachments (asset_id, file_name, mime_type, data) VALUES (?, ?, ?, ?)");
	$insertion_stmt->execute([$asset, $name, $mime, $data]);
}

function get_attachment($id) {
	$db = new PDO(get_db_filename());
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare("SELECT * FROM  attachments WHERE id = ?");
	$stmt->execute([$id]);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return count($data) == 1 ? $data[0] : null;
}
