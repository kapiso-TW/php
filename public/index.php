<?php
session_start();

$dataFile = '/tmp/data.json';
$data = file_exists($dataFile) ? file_get_contents($dataFile) : '[]';
$data = json_decode($data, true);

$password = isset($_POST['password']) ? $_POST['password'] : null;
$mes = isset($_POST['messenger']) ? $_POST['messenger'] : null;

date_default_timezone_set('Asia/Taipei');
$currentTime = date('md - His');

if (!isset($_SESSION['page'])) {
    $_SESSION['page'] = 0; 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['page'] == 0 || $_SESSION['page'] == -1) { // login
        if (isset($password)) {
            if ($password == '1030') {
                $_SESSION['name'] = 'Sally';
                $_SESSION['page'] = 1; // success login
            } elseif ($password == 'simple') {
                $_SESSION['name'] = 'XXXXX';
                $_SESSION['page'] = 1; // success login
            } else {
                $_SESSION['page'] = -1; // bad login
            }
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($_SESSION['page'] == 1) { // save mes
        if (isset($_SESSION['name']) && isset($mes)) {
            $data[] = ['name' => $_SESSION['name'], 'message' => $mes, 'bool' => 1, 'time' => $currentTime];
            file_put_contents($dataFile, json_encode($data)); // save mes in /tmp/data.json
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
$page = $_SESSION['page']; // ensure page correct
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
    <!--background start-->
    <div class="stars"></div>
    <!--background end-->

    <?php if ($page == 0 || $page == -1) { ?>
        <!--login page start-->
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
        <!--login page end-->
    <?php } ?>

    <!--------------------------------------------------------------------------------------------------->

    <?php if ($page == 1 && isset($_SESSION['name'])) { ?>
        <!--unlock page start-->
        <div class="chat-container">
            <!-- chat panel -->
            <div class="chat-box">
                <?php
                foreach ($data as $msgs) {
                    $name = htmlentities($msgs['name']);
                    $msg = isset($msgs['message']) ? htmlentities($msgs['message']) : 'No message'; // check 'message' is exsit or not
                    echo "<div class='message'><div class='name'>$name</div>";
                    if($_SESSION['name'] === $msgs['name']) {
                        echo '<form method="POST" action="recall_message.php">
                                <input type="hidden" name="time" value="' . htmlentities($msgs['time']) . '">
                                <button type="submit">訊息已收回</button>
                              </form>';
                    }
                    if ($msgs['bool'] === 1) { // only unrecall can be post
                        echo "<div class='message'>$msg</div><br>";
                    } else {
                        echo "<div class='message' style='color: gray;'>[訊息已收回]</div><br>";
                    }
                    echo "</div>";
                }                
                ?>
            </div>

            <div class="input-area">
                <form method="POST">
                    <input id="message" name="messenger" placeholder="Type a message here" required>
                    <button type="submit" id="send-btn">Send</button>
                </form>
            </div>
        </div>
        <form method="POST" action="logout.php" onclick="">
            <button type="submit">Logout</button>
        </form>
        <!--unlock page end-->
    <?php } ?>
</body>

</html>
