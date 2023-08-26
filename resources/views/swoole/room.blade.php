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
    {{-- <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script> --}}
    {{-- <script src="https://cdn.socket.io/socket.io-3.0.4.min.js"></script> --}}
    <script src="https://unpkg.com/socket.io-client@2.5.0/dist/socket.io.js"></script>
    <script>

        const socket = io("ws://127.0.0.1:1215");
        // socket.on("connect", function (event) {
        //     console.log(event);
        // });
        // function send() {
        //     socket.emit("test", { text: "i say hey" });
        // }

        // const socket = io('127.0.0.1:1215');

        // socket.on('connect', () => {
        //     console.log('Connected to server');
        // });

        // socket.on('disconnect', () => {
        //     console.log('Disconnected from server');
        // });

        // socket.emit('test', 'Hello');
    </script>
</body>

</html>
