<!-- 加载layuijs -->
{{-- <script src="{{ asset('static/admin/lib/layuiadmin/layui/layui.js') }}" charset="utf-8"></script> --}}
<script src="{{ asset('static/admin/lib/layuiadmin/layui/layui.js') }}" charset="utf-8"></script>

<script src="{{ asset('static/common/js/jquery.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('static/common/js/jquery.cookie.js') }}" charset="utf-8"></script>
<script src="{{ asset('static/common/js/common.js') }}" charset="utf-8"></script>
<script src="{{ asset('static/common/js/ajax_admin.js') }}" charset="utf-8"></script>
<script src="{{ asset('static/common/js/ajax_layui.js') }}" charset="utf-8"></script>
<script src="{{ asset('static/common/js/ajax_api.js') }}" charset="utf-8"></script>

<script>
    // 验证登录
    isAdminLogin();

    // 一些公共的脚本
    // Demo
    layui.use('form', function() {
        var form = layui.form;

        //监听提交
        form.on('submit(formDemo)', function(data) {
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });

    function notiy(icon, title) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'middle',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
        })

        Toast.fire({
            icon: icon,
            title: title
        })
    }

    // ajax全局设置
    $.ajaxSetup({
        headers: {
            'Accept': 'application/x.ying.v1+json',
            'Authorization': 'Bearer ' + getToken()
        }
    });

</script>
@yield('script')
