<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>聊天测试</title>

    <script src="{{ asset('static/common/js/jquery.min.js') }}" charset="utf-8"></script>
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
        let wsServer = 'ws://127.0.0.1:9502';
        // 使用ssl
        // let wsServer = 'wss://127.0.0.1:9502',

        // 发送消息
        function send() {
            var message = $('#input').val();
            alert('阿卡丽');
        }
    </script>
</body>

</html>
