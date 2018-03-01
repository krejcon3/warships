<?php
header("Access-Control-Allow-Origin: *", false);
require_once('engine/utils/database_connection.php');
require_once('engine/game.php');
require_once('./engine/utils/header_status.php');

$hash = trim($_GET['hash']);

if (strlen($hash) > 0) {
    $game = Game::findForHash($hash);
    if ($game == null) {
        header_status(403);
    } else {
        if ($game->check()) {
            header_status(200);
        } else {
            $game->update();
            header_status(204);
        }
    }

} else {
    header_status(400);
}