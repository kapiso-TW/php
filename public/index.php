<?php
session_start(); // Session on

// set var
$password = @isset($_POST['password']) ? $_POST['password'] : null;
$data = @file_get_contents('data.json');
$data = @json_decode($data, true);
$mes = @isset($_POST['messenger']) ? $_POST['messenger'] : null;

// clear page
if (!isset($_SESSION['page'])) {
    $_SESSION['page'] = 0; // page = login
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
                $_SESSION['page'] = -1; // wrong password
            }
        }
    } elseif ($_SESSION['page'] == 1) { // send mes
        if (isset($_SESSION['name']) && isset($mes)) {
            $data[] = ['name' => $_SESSION['name'], 'message' => $mes, 'bool' => "1"];
            file_put_contents('data.json', json_encode($data)); // save in data.json
        }
    }
}
$page = $_SESSION['page']; // ensure page is currect
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

    <!-------------------------------------------------------------------------------------------------->

    <?php if ($page == 1 && isset($_SESSION['name'])) { ?>
        <!--unlock page start-->
        <div>
            <div class="chat-container">
                <!-- chat panel -->
                <br>
                <div class="chat-box">
                    <?php
                    foreach ($data as $msgs) {
                        if (isset($msgs['bool']) && $msgs['bool'] == '1') {
                            $name = htmlentities($msgs['name']);
                            $msg = isset($msgs['message']) ? htmlentities($msgs['message']) : 'Error'; // check 'message' btn is exist or not
                            echo "<div class='name'>$name</div><div class='message'>$msg</div><br>";
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
        <!--unlock page end-->
    <?php } ?>
</body>

</html>