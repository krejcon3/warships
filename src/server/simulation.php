<?php
header("Access-Control-Allow-Origin: *", false);

require_once('engine/utils/database_connection.php');
require_once('./engine/utils/header_status.php');
require_once('engine/Game.php');
require_once('engine/Player.php');

$hash = trim($_GET['hash']);

if (strlen($hash) > 0) {
    $player = new Player();
    Game::create($hash, $player->hash);
    $player->run();
} else {
    header_status(400);
}