<?php

class Player {
    public $hash;
    public $success_shoots = 0;

    public function __construct() {
        $this->hash = sha1(microtime() . "player");
    }

    public function run() {
        while(true) {
            $game = Game::findForHash($this->hash);
            if ($game != null) {
                if ($this->success_shoots < 4 && rand(0, 99) > 75) {
                    if ($game->shoot(rand(0, 9), rand(0, 9))) {
                        $this->success_shoots++;
                    }
                } else {
                    if ($game->check()) break;
                }
                $game->update();
            }
            sleep(2);
        }
    }
}
