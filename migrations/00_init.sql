CREATE TABLE asset(id INTEGER PRIMARY KEY, serial_number VARCHAR(50), name TEXT);
CREATE TABLE kv(id INTEGER PRIMARY KEY, asset_id INTEGER, key VARCHAR(20), value TEXT);
CREATE TABLE attachments(id INTEGER PRIMARY KEY, asset_id INTEGER, mime_type INTEGER, file_name TEXT, data BLOB);

