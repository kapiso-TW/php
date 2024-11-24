<?php
session_start(); // Start the session

// Define the temporary storage path
define('CHAT_FILE', '/tmp/chat_data.json');

// Initialize the file data
if (!file_exists(CHAT_FILE)) {
    @file_put_contents(CHAT_FILE, json_encode([])); // Create an empty JSON file if it doesn't exist
}

// Get POST data
$password = isset($_POST['password']) ? $_POST['password'] : null;
$data = @json_decode(file_get_contents(CHAT_FILE), true); // Load data from /tmp
$mes = isset($_POST['messenger']) ? $_POST['messenger'] : null;

// Initialize page state
if (!isset($_SESSION['page'])) {
    $_SESSION['page'] = 0; // Default to login page
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['page'] == 0 || $_SESSION['page'] == -1) { // Login handling
        if (!empty($password)) {
            if ($password === '1030') {
                $_SESSION['name'] = 'Sally';
                $_SESSION['page'] = 1; // Login successful
            } elseif ($password === 'simple') {
                $_SESSION['name'] = 'XXXXX';
                $_SESSION['page'] = 1; // Login successful
            } else {
                $_SESSION['page'] = -1; // Login failed
            }
        }
    } elseif ($_SESSION['page'] == 1) { // Message sending
        if (isset($_SESSION['name']) && !empty($mes)) {
            $data[] = [
                'name' => $_SESSION['name'],
                'message' => $mes,
                'bool' => "1"
            ];
            file_put_contents(CHAT_FILE, json_encode($data)); // Save to /tmp directory
        }
    }
}

// Ensure the current page state is correct
$page = $_SESSION['page'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>A Page?</title>
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
                <div class="chat-box">
                    <?php
                    foreach ($data as $msgs) {

                        if (isset($msgs['bool']) && $msgs['bool'] == '1') {
                            
                            $name = htmlentities($msgs['name']);
                            $msg = isset($msgs['message']) ? htmlentities($msgs['message']) : 'Error';
                            echo "<div><div class='name'>$name";

                            if (isset($name) && $name == $msgs['name']) {
                                // Only show the button if the names match
                                echo "<button class='delete-btn'>Delete</button>";
                            }
                            echo "</div><div class='message'>$msg</div><br></div>";


                        }
                    }
                    ?>
                </div>

                <div class="input-area" class="container">
                    <form method="POST">
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
</body>

</html>