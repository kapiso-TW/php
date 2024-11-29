<?php
session_start();
$dataFile = '/tmp/data.json';
$data = file_exists($dataFile) ? file_get_contents($dataFile) : '[]';
$data = json_decode($data, true);

foreach ($data as $msgs) {
    $name = htmlentities($msgs['name']);
    $msg = isset($msgs['message']) ? htmlentities($msgs['message']) : 'No message';
    
    if ($msgs['bool'] === 1) { // unrecalled
        if ($_SESSION['name'] === $msgs['name']) {
            // self message
            echo "<div class='message-self'>";
            echo "<div class='name-self'>$name</div>";
            echo "<div class='text'>$msg</div>";
            echo "</div>";
        } else {
            // other's message
            echo "<div class='message-post'>";
            echo "<div class='name'>$name</div>";
            echo "<div class='text'>$msg</div>";
            echo "</div>";
        }
    } else { // recalled
        echo "<div class='message-post'>";
        echo "<div class='name'>$name</div>";
        echo "<div class='text' style='color: gray;'>[訊息已收回]</div>";
        echo "</div>";
    }
}
?>
