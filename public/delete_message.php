<?php
session_start(); // Start the session

// Define the path to the chat data file
define('CHAT_FILE', '/tmp/chat_data.json');

// Check if the message index is set
if (isset($_POST['index']) && is_numeric($_POST['index'])) {
    $index = $_POST['index'];

    // Check if the chat data file exists
    if (file_exists(CHAT_FILE)) {
        // Read the chat data from the file
        $data = @json_decode(file_get_contents(CHAT_FILE), true);

        // Check if the index is valid
        if (isset($data[$index])) {
            // Remove the message from the array
            unset($data[$index]);

            // Reindex the array after removing the item
            $data = array_values($data);

            // Save the updated chat data back to the file
            file_put_contents(CHAT_FILE, json_encode($data));

            echo "Message deleted successfully.";
        } else {
            echo "Invalid message index.";
        }
    } else {
        echo "Chat data file does not exist.";
    }
} else {
    echo "No message index provided.";
}
?>
