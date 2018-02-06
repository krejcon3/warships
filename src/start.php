<?php
require_once('engine/utils/database_connection.php');
require_once('engine/game.php');

$result = Database::query("SELECT * FROM `users` WHERE `active` = 1");
if ($result) {
    $matches = array();
    $size = $result->num_rows;
    echo "<h1>Found " . $size . " players!</h1><br>";
    echo "<h2>Player list</h2>";
    echo "<table><thead><tr><th>Name</th><th>Active</th></tr></thead><tbody>";
    while($row = $result->fetch_assoc()) {
        do {
            $index = rand(0, $size - 1);
        } while ($matches[$index] != null);
        $matches[$index] = $row;

        echo "<tr><td>" . $row['name'] . "</td><td>";
        if ($row['active'] == 1) {
            echo "Yes";
        } else {
            echo "No";
        }
        echo "</td></tr>";
    }
    echo "</tbody></table>";

    echo "<h2>Matches</h2>";
    echo "<table><thead><tr><th>Player 1</th><th>Player 2</th></tr></thead><tbody>";
    for ($i = 0; $i < count($matches); $i += 2) {
        Game::create($matches[$i]['hash'], $matches[$i + 1]['hash']);
        echo "<tr><td>" . $matches[$i]['name'] . "</td><td>" . $matches[$i + 1]['name'] . "</td><tr>";
    }
    echo "</tbody></table>";
} else {
    echo "No players!";
}
