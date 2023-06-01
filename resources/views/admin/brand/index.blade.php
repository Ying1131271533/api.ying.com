@extends('layout.app')

@section('title', '品牌列表')

@section('style')
    <!-- css -->
    <link href="{{ asset('static/css/site.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('static/css/main.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('static/lib/layui/cropper/cropper.css') }}" rel="stylesheet" type="text/css">
    <style>
        .info-ul {
            border-bottom: #ddd 1px solid;
            padding-bottom: 30px;
            margin: 0 20px;
        }

        .info-ul li {
            min-height: 50px;
            line-height: 50px;
            background: #fff;
            padding: 0 10px;
            font-size: 1.6rem
        }

        .thumb-div {
            padding: 15px 0;
            float: left;
        }

        .thumb-div .user-thumb {
            float: left;
        }

        .thumb-div .user-thumb img {
            width: 81px;
            height: 81px;
            border-radius: 50%;
        }

        .thumb-div .tips {
            float: left;
            margin-left: 38px;
            font-size: 16px;
            line-height: 82px;
        }

        .info-ul .title {
            width: 90px;
            float: left;
        }

        .info-ul .data {
            color: #999;
            margin-left: 10px;
        }

        .info-ul li .desc {
            line-height: 22px;
            padding-top: 14px;
        }

        .btn-div {
            /*text-align: center;*/
            padding: 20px 10px;
            background-color: #fff;
            margin-left: 90px;
        }

        .btn-div .btn {
            border-radius: 5px;
            color: #fff;
            width: 100px;
            height: 35px;
        }

        .btn-div .btn-ok {
            background-color: #fff;
            border: 1px solid #fc9d27;
            color: #fc9d27;
        }

        .info-ul li input {
            height: 30px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .user_name,
        .user_website {
            width: 233px;
        }

        .user_desc {
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        .avatar_img_jzc .avatar-view {
            width: 150px;
            height: 150px;
            margin-left: 80px;
        }
    </style>
@endsection

<!-- 主体内容 -->
@section('content')
<div class="layui-fluid">
    <div class="layui-row layui-col-md-offset0" style="margin-bottom:20px;">
      <div class="layui-col-md9">
        <a href="/view/news_save" class="layui-btn layui-btn-danger">添加新闻</a>
      </div>
    </div>
    <div class="layui-form">
      <div class="layui-input-inline">
        <input class="layui-input" type="text" name="id" value="" placeholder="ID" id="idReload">
      </div>
      <div class="layui-input-inline">
        <input class="layui-input" type="text" name="title" value="" placeholder="新闻标题" id="titleReload">
      </div>
      <div class="layui-input-inline">
        <button class="layui-btn" id="search" data-type="reload">搜索<button>
      </div>
    </div>


    <table id="table_akali" lay-filter="table_akali"></table>
  </div>
@endsection

@section('script')

<script type="text/html" id="cateTpl">
    <p>{{ d.cate.cate_name }}</p>
  </script>

  <script type="text/html" id="imageTpl">
    <img src="{{ d.image }}" width="70" style="cursor:pointer;" onclick="open_img(this)" />
  </script>

  <script type="text/html" id="createTimeTpl">
    <p>{{ d.create_time ? timestampToTime(d.create_time) : '--' }}</p>
  </script>

  <script type="text/html" id="statusTpl">
      <a onclick="ajax_change_status(this)"
      data-id="{{ d.id }}"
      data-value="{{ d.status }}"
      data-field="status"
      data-db="news"
        class="layui-btn layui-btn-sm {{ d.status == 1 ? '' : 'layui-btn-danger' }}">
        {{ d.status == 1 ? '开启' : '关闭' }}
      </a>
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
        , url: '/news' // 数据接口
        , method: 'GET'  // 可选项。HTTP类型
        , headers: { 'access-token': getToken() }
        , page: true // 开启分页
        , id: 'table_akali'
        , limit: 20
        , limits: [20, 100, 200, 500]
        , size: 'lg'
        , cols: [[ //表头
          { field: 'id', title: 'ID', width: 80, sort: true, fixed: 'left' }
          , { field: 'cate.cate_name', title: '新闻分类', width: 100, templet: '#cateTpl' }
          , { field: 'title', title: '新闻标题', width: 400 }
          , { field: 'image', title: '封面', width: 150, templet: '#imageTpl' }
          , { field: 'view', title: '浏览次数', width: 120, sort: true }
          , { field: 'create_time', title: '创建时间', width: 180, sort: true, templet: '#createTimeTpl' }
          , { field: 'status', title: '状态', width: 90, templet: '#statusTpl', fixed: 'right' }
          , { field: 'edit', title: '操作', minwidth: 160, templet: '#operationTpl', fixed: 'right' }
        ]]
      });



      var $ = layui.$, active = {
        reload: function () {
          var idReload = $('#idReload');
          var titleReload = $('#titleReload');

          //执行重载
          table.reload('table_akali', {
            where: {
              idReload: idReload.val(),
              titleReload: titleReload.val(),
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
            title: '新闻更新',
            content: '/view/news_update?id=' + data.id,
            shadeClose: true,
            shade: [0.8, '#000000'],
            area: ['1280px', '600px'],
          });

          // 删除
        }else if (layEvent === 'delete') {
          layui_form_delete(this, '/news/' + data.id);
        }
      });
    });

  </script>
@endsection
