<?php
header("Access-Control-Allow-Origin: *", false);

require_once('./engine/utils/header_status.php');
require_once('./engine/utils/database_connection.php');

class ConnectionResponse {
    public $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public static function create($name) {
        $hash = sha1($name . "zatlanka" . microtime());
        Database::query("INSERT INTO `users` (`hash`, `name`)  VALUES ('" . $hash ."', '" . $name ."')");
        return new ConnectionResponse($hash);
    }
}

$name = trim($_GET["name"]);
if (strlen($name) > 0) {
    header('Content-Type: application/json', false);
    echo json_encode(ConnectionResponse::create($name));
} else {
    header_status(400);
}
