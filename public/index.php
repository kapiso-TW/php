<?php
error_reporting(0); // Debug off
ini_set('display_errors', 0); // No error
session_start();

// 初始化 $page
if (!isset($page)) {
    $page = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $password = $_POST['password'];
    if ($password === '1030') {
        $_SESSION['name'] = 'Sally';
        $page = 1;
    } elseif ($password === 'simple') {
        $_SESSION['name'] = 'XXXX';
        $page = 1;
    } else {
        $page = -1;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>A Page?</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Background start -->
    <div class="stars"></div>
    <!-- Background end -->

    <?php if ($page == 0 || $page == -1) { ?>
        <!-- Login page -->
        <div class="container">
            <div class="form-control">
                <form method="POST">
                    <input type="password" name="password" required>
                    <label>
                        <span></span><span></span>
                        <span style="transition-delay:0ms">P</span><span style="transition-delay:50ms">a</span><span
                            style="transition-delay:100ms">s</span><span style="transition-delay:150ms">s</span><span
                            style="transition-delay:200ms">w</span><span style="transition-delay:250ms">o</span><span
                            style="transition-delay:300ms">r</span><span style="transition-delay:350ms">d</span>
                        <span style="transition-delay:400ms">(</span><span style="transition-delay:400ms">b</span><span
                            style="transition-delay:300ms">i</span><span style="transition-delay:350ms">r</span><span
                            style="transition-delay:200ms">t</span><span style="transition-delay:250ms">h</span><span
                            style="transition-delay:100ms">d</span><span style="transition-delay:150ms">a</span><span
                            style="transition-delay:0ms">y</span><span style="transition-delay:50ms">)</span>
                    </label>
            </div>
            <button class="ubt">Unlock</button>
            </form>
            <?php if ($page == -1) { ?>
                <p style="color: red;"><?= "!!! Wrong password !!!" ?></p>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if ($page == 1 && isset($_SESSION['name'])) { ?>
        <!-- Chat page -->
        <div>
            <div class="chat-container">
                <br>
                <div class="chat-box" id="chat-box">
                    <?php
                    foreach ($data as $index => $msgs) {
                        if (isset($msgs['bool']) && $msgs['bool'] == '1') {
                            $name = htmlentities($msgs['name']);
                            $msg = isset($msgs['message']) ? htmlentities($msgs['message']) : 'Error';
                            echo "<div><div class='name'>$name";

                            if (isset($name) && $name == $msgs['name']) {
                                // Only show the button if the names match
                                echo "<button class='delete-btn' data-index='$index'>Delete</button>";
                            }
                            echo "</div><div class='message'>$msg</div><br></div>";
                        }
                    }
                    ?>
                </div>

                <div class="input-area" class="container">
                    <form method="POST" id="message-form">
                        <input id="message" name="messenger" placeholder="Type a message here" required>
                        <button type="submit" id="send-btn" class="send">Send</button>
                    </form>
                </div>
            </div>
            <div class="container">
                <form method="POST" action="logout.php">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    <?php } ?>

    <script>
        // Function to load new messages
        function loadMessages() {
            $.ajax({
                url: 'get_messages.php', // PHP file to get messages
                method: 'GET',
                success: function (response) {
                    $('#chat-box').html(response); // Update the chat-box with new messages
                }
            });
        }

        // Load messages every 3 seconds
        setInterval(loadMessages, 3000);

        // Submit message via AJAX
        $('#message-form').submit(function (event) {
            event.preventDefault(); // Prevent the form from submitting normally

            var message = $('#message').val();

            $.ajax({
                url: 'send_message.php', // PHP file to handle message sending
                method: 'POST',
                data: { messenger: message },
                success: function (response) {
                    $('#message').val(''); // Clear the input field after sending
                    loadMessages(); // Load the latest messages after sending
                }
            });
        });

        // Delete message via AJAX
        $(document).on('click', '.delete-btn', function () {
            var messageIndex = $(this).data('index'); // Get the message index to delete

            $.ajax({
                url: 'delete_message.php',
                method: 'POST',
                data: { index: messageIndex }, // Send the index to the server
                success: function (response) {
                    alert(response); // Show success or error message
                    loadMessages(); // Reload the chat messages
                }
            });
        });
    </script>
</body>

</html>