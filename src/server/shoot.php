<?php
header("Access-Control-Allow-Origin: *", false);

require_once('engine/utils/database_connection.php');
require_once('engine/game.php');
require_once('./engine/utils/header_status.php');

class ShootResponse {
    public $hit;
    public $x;
    public $y;

    public function __construct($hit, $x, $y) {
        $this->hit = $hit;
        $this->x = $x;
        $this->y = $y;
    }
}

$hash = trim($_GET['hash']);
$x = trim($_GET['x']);
$y = trim($_GET['y']);

if (strlen($hash) > 0 && $x >= 0 && $x <= Game::$size && $y >= 0 && $y <= Game::$size) {
    $game = Game::findForHash($hash);
    if ($game == null) {
        header_status(403);
    } else {
        $result = new ShootResponse($game->shoot($x, $y), $x, $y);
        $game->update();
        header('Content-Type: application/json');
        echo json_encode($result);
    }
} else {
    header_status(400);
}
