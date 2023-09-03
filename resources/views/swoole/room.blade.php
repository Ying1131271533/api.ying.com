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
    {{-- <script src="https://unpkg.com/socket.io-client@2.5.0/dist/socket.io.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
    <script>

        const socket = io('http://localhost:1215', {
            transports: ['websocket'],
            reconnection: false,
            query: {
                token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYXBpLnlpbmcuY29tL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjkzNzEzODI2LCJleHAiOjE2OTQwNzM4MjYsIm5iZiI6MTY5MzcxMzgyNiwianRpIjoiT282R2ppdjhBOXN1NFhCViIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.SXD2niLDhDy5UOyqnTPjO1DHXt_MIirikjfHwqfsD_g",
            },
        });

        let token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYXBpLnlpbmcuY29tL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjkzNzEzODI2LCJleHAiOjE2OTQwNzM4MjYsIm5iZiI6MTY5MzcxMzgyNiwianRpIjoiT282R2ppdjhBOXN1NFhCViIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.SXD2niLDhDy5UOyqnTPjO1DHXt_MIirikjfHwqfsD_g';

        // socket.emit('test', 'ddd');
        // socket.on('test', (data) => {
        //     console.log(data);
        // })
        socket.on('test', (data) => {
            console.log(data);
        })

        // 访问websockt的login路由
        function send() {
            // socket.emit("login", {
            //     headers: {
            //         'Authorization': 'Bearer ' + token
            //     },
            //     data: 'Hello Server!'
            // });
            socket.emit("login", { text: "i say hey", token: token});
            // socket.emit("test", { text: "i say hey" });
        }

        socket.on('akali', (data) => {
            console.log(data);
        })
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
