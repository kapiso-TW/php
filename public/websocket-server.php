<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\App;

require __DIR__ . '/../vendor/autoload.php'; // 引入 Composer 加載器

// 定義一個 WebSocket 聽眾
class WebSocketServer implements MessageComponentInterface {
    public function onOpen(ConnectionInterface $conn) {
        echo "New connection: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Message received: $msg\n";
        $from->send("You said: $msg");
    }

    public function onClose(ConnectionInterface $conn) {
        echo "Connection {$conn->resourceId} closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

// 創建 WebSocket 服務
$app = new App('localhost', 8080);
$app->route('/ws', new WebSocketServer(), ['*']);
$app->run();
?>