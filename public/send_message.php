<?php
session_start();

$dataFile = '/tmp/data.json';
$data = file_exists($dataFile) ? file_get_contents($dataFile) : '[]';
$data = json_decode($data, true);

if (isset($_SESSION['name']) && isset($_POST['messenger'])) {
    $message = $_POST['messenger'];
    $currentTime = date('Y-m-d H:i:s');
    
    // Save message
    $data[] = ['name' => $_SESSION['name'], 'message' => $message, 'bool' => 1, 'time' => $currentTime];
    file_put_contents($dataFile, json_encode($data));
}
?>
