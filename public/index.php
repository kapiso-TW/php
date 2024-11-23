<?php
$password = @$_POST['password'];
$page = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                <form method="POST" action="index.php">
                    <input type="password" name="password" required>
                    <label>
                        <span style="transition-delay:0ms">P</span><span style="transition-delay:50ms">a</span><span
                            style="transition-delay:100ms">s</span><span style="transition-delay:150ms">s</span><span
                            style="transition-delay:200ms">w</span><span style="transition-delay:250ms">o</span><span
                            style="transition-delay:300ms">r</span><span style="transition-delay:350ms">d</span>
                        <span style="transition-delay:400ms">(</span><span style="transition-delay:400ms">b</span><span
                            style="transition-delay:400ms">i</span><span style="transition-delay:350ms">r</span><span
                            style="transition-delay:300ms">t</span><span style="transition-delay:250ms">h</span><span
                            style="transition-delay:200ms">d</span><span style="transition-delay:150ms">a</span><span
                            style="transition-delay:100ms">y</span><span style="transition-delay:50ms">)</span>
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
    
    <?php if ($page == 1 && isset($name)) { ?>
        <!--unlock page start-->
        <div class="container">
            
        </div>
        <!--unlock page end-->
    <?php } ?>
</body>

</html>
