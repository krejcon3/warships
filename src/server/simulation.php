<?php
header("Access-Control-Allow-Origin: *", false);

require_once('engine/utils/database_connection.php');
require_once('./engine/utils/header_status.php');
require_once('engine/Game.php');

$hash = trim($_GET['hash']);

if (strlen($hash) > 0) {
    $player_hash = sha1(microtime() . "_player");
    Game::create($hash, $player_hash);
    echo '
        <!DOCTYPE html>
        <html lang="cz">
            <head>
                <meta charset="UTF-8">
                <title>Warships [simulation]</title>
            <link rel="stylesheet" type="text/css" href="./src/style.css">
            </head>
            <body>
                <div id="player_id" data-hash="' . $player_hash . '"></div>
                <canvas id="canvas" width="500" height="500"></canvas>
                <script src="./src/jquery-3.3.1.min.js"></script>
                <script src="./src/script.js"></script>
            </body>
        </html>
    ';

} else {
    header_status(400);
}