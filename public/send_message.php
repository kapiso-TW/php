<?php
session_start(); // Start the session

// Define the path to the chat data file
define('CHAT_FILE', '/tmp/chat_data.json');

// Check if there's a message to be sent
if (isset($_POST['messenger']) && !empty($_POST['messenger'])) {
    // Retrieve the message and user name from session
    $message = $_POST['messenger'];
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

    // Get the current chat data
    if (file_exists(CHAT_FILE)) {
        $data = @json_decode(file_get_contents(CHAT_FILE), true);
    } else {
        $data = [];
    }

    // Add the new message to the chat data
    $data[] = [
        'name' => $name,
        'message' => $message,
        'bool' => "1"
    ];

    // Save the updated chat data to the file
    file_put_contents(CHAT_FILE, json_encode($data));

    echo "Message sent successfully."; // Optional feedback for the AJAX request
} else {
    echo "No message to send."; // Handle the case where no message is provided
}
?>
