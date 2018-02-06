<?php

class Shoot {
    private $player;
    private $x;
    private $y;
    private $timestamp;

    public function __construct($player, $x, $y) {
        $this->player = $player;
        $this->x = $x;
        $this->y = $y;
        $this->timestamp = time();
    }
}