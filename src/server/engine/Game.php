<?php

class Game {
    public static $size = 10;
    private $id;
    private $hash;
    private $target;
    private $blind;
    private $status;

    private function __construct($id, $hash, $target, $blind, $flag, $status) {
        $this->id = $id;
        $this->hash = $hash;
        $this->target = $target;

        $this->blind = $blind;
        $this->flag = $flag;
        $this->status = $status;
    }

    public static function findForHash($hash) {
        $result = Database::query("SELECT `id`, `p1_hash` as `hash`, `p1_target` as target, `p1_blind` as blind, `flag`, `status` FROM `game` WHERE `p1_hash`='" . $hash . "' LIMIT 1");
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                if ($row["status"] == "CLOSED") {
                    return "GAME #" . $row['id'] . " CLOSED. WINNER IS: " . $row['flag'];
                }
                if ($row['flag'] == 0) {
                    return new Game($row['id'], $row['hash'], json_decode($row['target']), json_decode($row['blind']), $row['flag'], $row['status']);
                }
                return null;
            }
        }
        $result = Database::query("SELECT `id`, `p2_hash` as `hash`, `p2_target` as target, `p2_blind` as blind, `flag`, `status` FROM `game` WHERE `p2_hash`='" . $hash . "' LIMIT 1");
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                if ($row["status"] == "CLOSED") {
                    return "GAME #" . $row['id'] . " CLOSED. WINNER IS: " . $row['flag'];
                }
                if ($row['flag'] == 1) {
                    return new Game($row['id'], $row['hash'], json_decode($row['target']), json_decode($row['blind']), $row['flag'], $row['status']);
                }
                return null;
            }
        }
        return null;
    }

    public function shoot($x, $y) {
        switch ($this->target[$x][$y]) {
            case "O": $this->blind[$x][$y] = "X"; break;
            case " ": $this->blind[$x][$y] = "."; break;
        }
        return $this->blind[$x][$y] == "X";
    }

    public function closeGame() {
        $query = "UPDATE `game` SET `status` = 'CLOSED' WHERE `id` = " . $this->id;
        return Database::query($query);
    }

    public function update() {
        $query = "UPDATE `game` SET";
        if ($this->flag == 0) {
            $query .= " `p1_blind` = '" . json_encode($this->blind) . "'";
        } else {
            $query .= " `p2_blind` = '" . json_encode($this->blind) . "'";
        }
        $query .= ", `flag` = " . (($this->flag + 1) % 2);
        $query .= " WHERE `id` = " . $this->id;
        return Database::query($query);
    }

    public function check() {
        for ($x = 0; $x < Game::$size; $x++) {
            for ($y = 0; $y < Game::$size; $y++) {
                if ($this->target[$x][$y] == "O" && $this->blind[$x][$y] == " ") {
                    return false;
                }
            }
        }
        return true;
    }

    public static function create($p1_hash, $p2_hash) {
        $p1_target = self::generateMap(self::$size);
        $p1_blind = self::generateEmptyMap(self::$size);
        $p2_target = self::generateMap(self::$size);
        $p2_blind = self::generateEmptyMap(self::$size);
        $query = "INSERT INTO `game` (`p1_hash`, `p1_target`, `p1_blind`, `p2_hash`, `p2_target`, `p2_blind`) ";
        $query .= "VALUES ('" . $p1_hash ."', '" . json_encode($p1_target) ."', '" . json_encode($p1_blind) ."', '" . $p2_hash ."', '" . json_encode($p2_target) ."', '" . json_encode($p2_blind) ."')";
        return !!Database::query($query) . "<br>";
    }

    public static function generateEmptyMap($size) {
        return array_fill(0, $size, array_fill(0, $size, " "));
    }

    public static function generateMap($size) {
        $map = self::generateEmptyMap($size);
        $map = self::drawSubmarine($map);
        return $map;
    }

    public static function drawA($map) {
    //        $x = rand(0, self::$size - 1 - 2);
    //        $y = rand(1, self::$size - 1);
        $x = 2;
        $y = 6;
        $map[$x][$y] = "O";
        $map[$x - 1][$y + 1] = "O";
        $map[$x][$y + 1] = "O";
        $map[$x + 1][$y + 1] = "O";
        $map[$x - 1][$y + 2] = "O";
        $map[$x + 1][$y + 2] = "O";
        return $map;
    }

    public static function drawL($map) {
//        $x = rand(0, self::$size - 1 - 2);
//        $y = rand(1, self::$size - 1);
        $x = 7;
        $y = 6;
        $map[$x][$y] = "O";
        $map[$x][$y + 1] = "O";
        $map[$x][$y + 2] = "O";
        $map[$x - 1][$y + 3] = "O";
        return $map;
    }

    public static function drawK($map) {
//        $x = rand(0, self::$size - 1 - 2);
//        $y = rand(1, self::$size - 1);
        $x = 7;
        $y = 2;
        $map[$x][$y] = "O";
        $map[$x + 1][$y] = "O";
        $map[$x][$y + 1] = "O";
        $map[$x + 1][$y + 1] = "O";
        return $map;
    }

    public static function drawO($map) {
//        $x = rand(0, self::$size - 1 - 2);
//        $y = rand(1, self::$size - 1);
        $x = 2;
        $y = 2;
        $map[$x][$y] = "O";
        return $map;
    }
}