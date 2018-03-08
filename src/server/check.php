<?php
header("Access-Control-Allow-Origin: *", false);
require_once('./engine/utils/database_connection.php');
require_once('./engine/Game.php');
require_once('./engine/utils/header_status.php');

$hash = trim($_GET['hash']);

if (strlen($hash) > 0) {
    $game = Game::findForHash($hash);
    if ($game == null) {
        header_status(403);
    } elseif (is_string($game)) {
        header_status(410);
    } else {
        if ($game->check()) {
            $game->closeGame();
            header_status(200);
        } else {
            $game->update();
            header_status(204);
        }
    }

} else {
    header_status(400);
}