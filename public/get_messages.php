<?php
// Define the path to the chat data file
define('CHAT_FILE', '/tmp/chat_data.json');

// Check if the chat data file exists
if (file_exists(CHAT_FILE)) {
    // Read the chat data from the file
    $data = @json_decode(file_get_contents(CHAT_FILE), true);

    // Return the chat data as JSON
    foreach ($data as $msg) {
        if (isset($msg['bool']) && $msg['bool'] == '1') {
            $name = htmlentities($msg['name']);
            $message = htmlentities($msg['message']);
            echo "<div><div class='name'>$name</div><div class='message'>$message</div><br></div>";
        }
    }
} else {
    echo "No chat data available.";
}
?>
