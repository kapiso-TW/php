<?php
$password = isset($_POST['password']) ? $_POST['password'] : null;
$page = 0;
$data = file_get_contents('data.json');
$data = json_decode($data, true);
$mes = isset($_POST['messenger']) ? $_POST['messenger'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($page==0 || $page==-1){
        if (isset($password)) {
            if ($password == '1030') {
                $name = 'Sally';
                $page = 1;
            } elseif ($password == 'simple') {
                $name = 'XXXXX';
                $page = 1;
            } else {
                $page = -1;
            }
        }
    }elseif($page==1){
        if (isset($name) && isset($mes)) {
            $data[] = ['name' => $name, 'message' => $mes];
            file_put_contents('data.json', json_encode($data));
        }
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

    <?php if ($page == 1 && isset($name)) { ?>
        <!--unlock page start-->
        <div class="chat-container">
            <!-- chat panel -->
            <div class="chat-box">
                <?php
                foreach ($data as $msgs) {
                    $name = htmlentities($msgs['name']);
                    $msg = isset($msgs['message']) ? htmlentities($msgs['message']) : 'No message'; // 检查是否存在 'message' 键
                    echo "<div class='name'>$name</div><div class='message'>$msg</div><br>";
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
        <!--unlock page end-->
    <?php } ?>
</body>

</html>