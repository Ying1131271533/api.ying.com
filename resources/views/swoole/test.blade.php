<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>测试</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('static/common/js/jquery.min.js') }}" charset="utf-8"></script>
</head>

<body class="layui-card">

    <div id="status"></div>
    <div>
        <input type="text" id="input" />
        <input type="button" onclick="send()" value="发送" />
    </div>
    <div id="message"></div>

    {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> --}}
    <script>

    import Echo from "laravel-echo";
    import Pusher from "pusher-js";

    // 启用推进器日志记录-不包括在生产中
    Pusher.logToConsole = true;
    // 实例化
    // var pusher = new Pusher('9c4bd1644e4d169d5885', {
    //     cluster: 'mt1'
    // });

    export default {
        data() {
            return {
                messages: [],
                text: "",
            };
        },

        mounted() {
            this.initEcho();
            this.fetchMessages();
        },

        methods: {
            initEcho() {
                window.Echo = new Echo({
                    broadcaster: "pusher",
                    key: "9c4bd1644e4d169d5885",
                    cluster: "mt1",
                    forceTLS: true,
                    authEndpoint: "/api/authenticate",
                    auth: {
                        headers: {
                            Authorization: "Bearer " + localStorage.getItem("access_token"),
                        },
                    },
                });

                window.Echo.join(`chat`).here((users) => {
                    console.log(users);
                });

                // 订阅的频道名称
                window.Echo.channel(`chat`)
                // 要监听的事件名称
                .listen(".message.sent", (event) => {
                    // 传递数据
                    this.messages.push(event.message);
                });
            },

            fetchMessages() {
                axios.get(`/api/chat/messages`).then((response) => {
                    this.messages = response.data.messages;
                });
            },

            send() {
                axios.post(`/api/chat/messages`, { text: this.text }).then(() => {
                    this.text = "";
                });
            },
        },
    };
    </script>
</body>

</html>
