<?php

class ConnectionResponse {
    public $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public static function create() { return new ConnectionResponse("zatlanka" . time()); }
}

header('Content-Type: application/json');
echo json_encode(ConnectionResponse::create());
