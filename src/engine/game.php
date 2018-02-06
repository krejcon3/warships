<?php

class Game {
    private $playerA;
    private $playerB;

    function __construct($playerA, $playerB) {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
    }
}