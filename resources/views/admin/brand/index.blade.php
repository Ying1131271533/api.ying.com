@extends('admin.layout.app')

@section('title', '品牌列表')

<!-- 主体内容 -->
@section('content')
<div class="layui-fluid">
    <div class="layui-row layui-col-md-offset0" style="margin-bottom:20px;">
      <div class="layui-col-md9">
        <a href="/admin/brands/create" class="layui-btn layui-btn-danger">添加品牌</a>
      </div>
    </div>
    <div class="layui-form">
      <div class="layui-input-inline">
        <input class="layui-input" type="text" name="name" value="" placeholder="标题" id="nameReload">
      <div class="layui-input-inline">
        <input class="layui-input" type="text" name="status" value="" placeholder="状态" id="statusReload">
      </div>
      <div class="layui-input-inline">
        <button class="layui-btn" id="search" data-type="reload">搜索<button>
      </div>
    </div>


    <table id="table_akali" lay-filter="table_akali"></table>
</div>
@endsection

@section('script')

  <script type="text/html" id="logoTpl">
    <img src="/@{{ d.logo }}" width="70" style="cursor:pointer;" onclick="open_img(this)" />
  </script>

  <script type="text/html" id="sortTpl">
    <p>@{{ d.sort }}</p>
  </script>

  <script type="text/html" id="statusTpl">
      <a onclick="ajax_change_status(this, '/api/admin/brands/@{{ d.id }}/status')"
      data-id="@{{ d.id }}"
      data-value="@{{ d.status }}"
      data-field="status"
      data-db="news"
        class="layui-btn layui-btn-sm @{{ d.status == 1 ? '' : 'layui-btn-danger' }}">
        @{{ d.status == 1 ? '开启' : '关闭' }}
      </a>
  </script>

  <script type="text/html" id="createTimeTpl">
    <p>@{{ d.created_at ? d.created_at : '--' }}</p>
  </script>

  <script type="text/html" id="operationTpl">
      <button class="layui-btn layui-btn-sm" lay-event="update">
              <i class="layui-icon">&#xe642;</i>
              修改
          </button>
      <button class="layui-btn layui-btn-sm layui-bg-black" lay-event="delete">
              <i class="layui-icon">&#xe640;</i>
              删除
          </button>
  </script>

  <script>
    layui.use(['jquery', 'layer', 'table', 'flow', 'form'], function () {
      var table = layui.table
        , $ = layui.$
        , layer = layui.layer
        , flow = layui.flow
        , form = layui.form

      // 第一个实例
      var ins1 = table.render({
        elem: '#table_akali'
        , url: '/api/admin/brands' // 数据接口
        , method: 'GET'  // 可选项。HTTP类型
        , headers: { 'Accept': 'application/x.ying.v1+json', 'Authorization': 'Bearer ' + getToken() }
        , page: true // 开启分页
        , id: 'table_akali'
        , limit: 20
        , limits: [20, 100, 200, 500]
        , size: 'lg'
        , cols: [[ //表头
          { field: 'id', title: 'ID', width: 80, sort: true, fixed: 'left' }
          , { field: 'name', title: '品牌名称', width: 400 }
          , { field: 'logo', title: 'logo', width: 150, templet: '#logoTpl' }
          , { field: 'sort', title: '排序', width: 150, templet: '#sortTpl' }
          , { field: 'status', title: '状态', width: 90, templet: '#statusTpl', fixed: 'right' }
          , { field: 'created_at', title: '创建时间', width: 180, sort: true, templet: '#createTimeTpl' }
          , { field: 'edit', title: '操作', minwidth: 160, templet: '#operationTpl', fixed: 'right' }
        ]]
      });



      var $ = layui.$, active = {
        reload: function () {
          var nameReload = $('#nameReload');
          var statusReload = $('#statusReload');

          //执行重载
          table.reload('table_akali', {
            where: {
                nameReload: nameReload.val(),
                statusReload: statusReload.val(),
            }
          });
        }
      };

      //点击事件
      $('#search').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
      });

      // 监听排序事件
      table.on('sort(table_akali)', function (obj) {
        console.log(obj.field);
        console.log(obj.type);
        console.log(this);

        table.reload('table_akali', {
          initSort: obj
          , where: {
            field: obj.field
            , order: obj.type
          }
        });

      });

      //监听工具条
      table.on('tool(table_akali)', function (obj) {
        var data = obj.data; // 获得当前行数据
        var layEvent = obj.event; // 获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）

        // 修改
        if (layEvent === 'update') {
          layer.open({
            type: 2,
            title: '品牌更新',
            content: '/admin/brands/edit?id=' + data.id,
            shadeClose: true,
            shade: [0.8, '#000000'],
            area: ['1280px', '600px'],
          });

          // 删除
        }else if (layEvent === 'delete') {
          layui_form_delete(this, '/admin/brands/' + data.id);
        }
      });
    });

  </script>
@endsection
