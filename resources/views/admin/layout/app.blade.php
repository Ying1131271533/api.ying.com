<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=chrome">
    {{-- <link rel="shortcut icon" href="/favicon.ico"> --}}
    <title>@yield('title', '神织知更的博客') - 神织知更的博客</title>
    @include('admin.layout.style')
</head>

<body>
    <!-- 主体内容 -->
    @yield('content')
    @include('admin.layout.script')
</body>

</html>

