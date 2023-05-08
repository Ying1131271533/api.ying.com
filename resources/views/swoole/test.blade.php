<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>聊天测试</title>
</head>

<body class="layui-card">

    <div id="akali"></div>
    <div>
        <input type="text" id="input" />
        <input type="button" onclick="send()" value="发送" />
    </div>
    <div id="message"></div>

    <script>

        // 不使用ssl
        let wsServer = 'ws://127.0.0.1:9502',
        // 使用ssl
        // let wsServer = 'wss://127.0.0.1:9502',
            websocket = null,
            lock = false; // 锁，用于断线重连

        $(document).ready(function () {
            link();
        });

        // 连接聊天室
        function link() {
            // 创建WebSocket Server对象，监听127.0.0.1:9502端口
            websocket = new WebSocket(wsServer);

            // 连接
            websocket.onopen = function (res) {
                console.log("Connected to WebSocket server.");
                $('#akali').append(
                    '<h1>连接成功！牡蛎摸牡蛎~</h1>'
                );
            };

            // 关闭连接
            websocket.onclose = function (res) {
                websocket.close();
                // 关闭连接时，重连
                relink();
            };

            // 服务器返回的数据
            websocket.onmessage = function (res) {
                console.log('Retrieved data from server: ' + res.data);
                $('#message').append(
                    '<h3>' + res.data + '</h3>'
                );
            };

            // 内容抛出的错误，可以写入日志，用户那边则显示404错误
            websocket.onerror = function (res, e) {
                console.log('Error occured: ' + res.data);
                websocket.close();
                // 关闭连接时，重连
                relink();
            };
        }

        // 发送消息
        function send() {
            var message = $('#input').val();
            websocket.send(message);
        }

        // 重连聊天室
        function relink() {
            if (lock) {
                return false;
            }
            // 锁住
            lock = true;
            setTimeout(() => {
                link();
                lock = false;
            }, 1000);
        }
    </script>
</body>

</html>
