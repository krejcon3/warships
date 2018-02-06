<?php

class Player {
    private $hash;
    private $map;

    public function __construct($hash) {
        $this->hash = $hash;
    }

    public function generateMap($size) {
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $this->map[$i][$j] = ".";
            }
        }
    }
}