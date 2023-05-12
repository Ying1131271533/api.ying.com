// api域名
let api_domain = 'http://api.ying.com'
// ajax全局设置头部信息
/* $(document).ready(function () {
    let url = window.location.href, token = null;
    alert(url.search("api") !== -1);
    if (url.search("api") !== -1) {
        token = getApiToken();
    } else {
        token = getToken();
    }
    $.ajaxSetup({
        async: false,
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/x.ying.v1+json');
            request.setRequestHeader("Authorization", 'Bearer ' + getApiToken());
        },
    });
}); */

// 获取时间戳
function time() {
    let tmp = Date.parse(new Date()).toString();
    tmp = tmp.substr(0, 10);
    return tmp;
}

// 模仿php的empty()函数
function empty(val) {
    // 如果是数组
    if (val instanceof Array === true) {
        if ($(val).length < 1) {
            return true
        }
        return false;
    }
    // 如果是对象
    else if (val instanceof Object === true) {
        if ($.isEmptyObject(val)) {
            // if(JSON.stringify(data) == "{}"){
            return true
        }
        return false;
    }
    else {
        return typeof (val) === "undefined" || val == null || val === "" || val === "NaN";
    }

}

function arrayDuplicate(a, b) {
    let c = [];
    a.forEach(v => {
        if (b.indexOf(v) === -1) {
            c.push(v);
        }
    });
    return c;
}

// 获取url后面的参数 红叶
function getParams() {
    var url = location.search;
    url = decodeURI(url);
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        // if (url.indexOf("''") != -1) {
        var str = url.substring(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
        }
    }
    // url后传递的参数
    // var id = theRequest.id;
    return theRequest;
}

// 获取时间戳
function timeToTimeStamp($time) {
    if (empty($time)) {
        return null;
    }
    let date = new Date($time);
    return Date.parse(date) / 1000;
}

// 时间戳转换成日期
function timestampToTime(timestamp, is_date = false) {
    if (empty(timestamp)) {
        return "缺失时间";
    }
    let date = new Date(timestamp * 1000);
    // 年月日
    let Y = date.getFullYear() + '-';
    let M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    let D = date.getDate() < 10 ? '0' + date.getDate() + ' ' : date.getDate() + ' ';
    // 时分秒
    let H = date.getHours() + ':';
    let m = (date.getMinutes() < 10 ? '0' + (date.getMinutes()) : date.getMinutes()) + ':';
    let s = (date.getSeconds() < 10 ? '0' + (date.getSeconds()) : date.getSeconds());
    let result = is_date === false ? Y + M + D + H + m + s : Y + M + D;
    return result;
}

// 读取配置
function config(status) {

    $.ajaxSetup({ async: false });
    let res = null;
    $.getJSON("/static/common/js/code.json", function (data) {
        res = data[status];
    });
    return res;
}


// 获取api的token
function getApiToken() {
    return $.cookie('api_login_token');
}

// 获取管理员的token
function getToken() {
    return $.cookie('admin_login_token');
}


// 用户是否已登录
function isApiLogin() {
    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: api_domain + '/api/user',
        async: true,
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/x.ying.v1+json');
            request.setRequestHeader("Authorization", 'Bearer ' + getApiToken());
        },
        success: function (res) {
            alert(res);
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', { time: 500 }, function () {
                    $.removeCookie('api_login_token', { path: '/' });
                    // $.removeCookie('api_login_token', {api_domain: document.api_domain, path: '/'});
                    $(window).attr('location', "http://api.ying.com/admin/auth/login");
                });
            }
        },
        error:function(res) {
            console.log(res.responseJSON);
            if(res.responseJSON.status_code == 401) {
                layer.msg(res.responseJSON.message, { time: 500 }, function () {
                    $.removeCookie('admin_login_token', { path: '/' });
                    // $.removeCookie('api_login_token', {api_domain: document.api_domain, path: '/'});
                    $(window).attr('location', "http://api.ying.com/api/admin/login");
                });
            }
        }
    });
}


// 管理员是否已登录
function isAdminLogin() {
    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: api_domain + '/api/admin/admins/info',
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/x.ying.v1+json');
            request.setRequestHeader("Authorization", 'Bearer ' + getToken());
        },
        success: function (res) {

        },
        error:function(res) {
            console.log(res.responseJSON);
            if(res.responseJSON.status_code == 401) {
                layer.msg(res.responseJSON.message, { time: 500 }, function () {
                    $.removeCookie('admin_login_token', { path: '/' });
                    // $.removeCookie('admin_login_token', {api_domain: document.api_domain, path: '/'});
                    $(window).attr('location', "http://api.ying.com/admin/auth/login");
                });
            }
        }
    });
}


// 根据id获取用户
function getUserById(uid) {
    let user = null;
    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: api_domain + '/user/get-user-by-id/' + uid,
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/x.ying.v1+json');
            request.setRequestHeader("Authorization", 'Bearer ' + getApiToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', {}, function () {
                    $.removeCookie('api_login_token', { path: '/' });
                    $(window).attr('location', "http://api.ying.com/api/auth/login");
                });
            }

            if (res.code === config('failed')) {
                layer.msg(res.msg);
                return false;
            }
            // console.log(res.data);
            user = res.data;
        }
    });
    // 返回用户信息，必须要在ajax外面返回值
    return user;
}

// 根据id获取管理员
function getAdminById(uid) {
    let user = null;
    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: api_domain + '/api/'+ uid +'/get-admin-by-id',
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/x.ying.v1+json');
            request.setRequestHeader("Authorization", 'Bearer ' + getToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', {}, function () {
                    $.removeCookie('api_login_token', { path: '/' });
                    $(window).attr('location', "http://api.ying.com/admin/auth/login");
                });
            }

            if (res.code === config('failed')) {
                layer.msg(res.msg);
                return false;
            }
            // console.log(res.data);
            user = res.data;
        }
    });
    // 返回用户信息，必须要在ajax外面返回值
    return user;
}

// 获取用户
function getUser() {
    let user = null;
    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: api_domain + '/api/user',
        async: false,
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/x.ying.v1+json');
            request.setRequestHeader("Authorization", 'Bearer ' + getApiToken());
        },
        success: function (res) {
            console.log(res);
            user = res;
        },
        error:function(res) {
            console.log(res.responseJSON);
            if(res.responseJSON.status_code == 401) {
                layer.msg(res.responseJSON.message, { time: 500 }, function () {
                    $.removeCookie('api_login_token', { path: '/' });
                    // $.removeCookie('api_login_token', {api_domain: document.api_domain, path: '/'});
                    $(window).attr('location', "http://api.ying.com/admin/auth/login");
                });
            }

            if (res.responseJSON.status_code === 400) {
                layer.msg(res.msg);
                return false;
            }
        }
    });
    // 返回用户信息，必须要在ajax外面返回值
    return user;
}


// 获取管理员
function getAdmin() {
    let admin = null;
    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: api_domain + '/api/admin/admins/info',
        async: false,
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/x.ying.v1+json');
            request.setRequestHeader("Authorization", 'Bearer ' + getToken());
        },
        success: function (res) {
            // console.log(res);
            admin = res;
        },
        error:function(res) {
            console.log(res.responseJSON);
            if(res.responseJSON.status_code == 401) {
                layer.msg(res.responseJSON.message, { time: 500 }, function () {
                    $.removeCookie('admin_login_token', { path: '/' });
                    // $.removeCookie('admin_login_token', {api_domain: document.api_domain, path: '/'});
                    $(window).attr('location', "http://api.ying.com/admin/auth/login");
                });
            }

            if (res.responseJSON.status_code == 400) {
                layer.msg(res.msg);
                return false;
            }
        }
    });
    // 返回用户信息，必须要在ajax外面返回值
    return admin;
}

function open_img(obj) {

    // 获取图片路径
    var src = $(obj).attr("src");

    // 获取图片的真实宽高
    $('<img/>').attr("src", src).on('load', function () {

        // 设置图片的宽度不能超过1280px
        var width = this.width > 1280 ? 1280 : this.width;
        var height = this.height;
        var html = '<img src="' + src + '" width="' + width + '" />';

        // 页面层-佟丽娅
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: width + 'px',
            skin: 'layui-layer-nobg', // 没有背景色
            shadeClose: true,
            content: html
        });
    });
}

// Layui 中的富文本编辑器中遇到的html代码没有转换的解决方案
var HtmlUtil = {
    /*1.用浏览器内部转换器实现html转码*/
    htmlEncode: function (html) {
        //1.首先动态创建一个容器标签元素，如DIV
        var temp = document.createElement("div");
        //2.然后将要转换的字符串设置为这个元素的innerText(ie支持)或者textContent(火狐，google支持)
        (temp.textContent != undefined) ? (temp.textContent = html) : (temp.innerText = html);
        //3.最后返回这个元素的innerHTML，即得到经过HTML编码转换的字符串了
        var output = temp.innerHTML;
        temp = null;
        return output;
    },

    /*2.用浏览器内部转换器实现html解码*/
    htmlDecode: function (text) {
        //1.首先动态创建一个容器标签元素，如DIV
        var temp = document.createElement("div");
        //2.然后将要转换的字符串设置为这个元素的innerHTML(ie，火狐，google都支持)
        temp.innerHTML = text;
        //3.最后返回这个元素的innerText(ie支持)或者textContent(火狐，google支持)，即得到经过HTML解码的字符串了。
        var output = temp.innerText || temp.textContent;
        temp = null;
        return output;
    }

};


// 获取地址的id
function get_url_id() {
    // 正则匹配地址栏最后的数字
    var id = location.href.match(/\d+/g)[1];
    if (empty(id)) {
        layer.msg('地址参数出错！，请刷新页面', { icon: 2 });
        return false;
    }
    return id;
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/03/31 21:56
 *
 * 递归找子级数据
 *
 * @param  array    data            数据
 * @param  int      parent_id       父级id
 * @return array                    返回处理好的数组
 */
function get_chlidren(data = [], parent_id = 0) {
    var tmp = [];
    for (let value of data) {
        if (value['parent_id'] == parent_id) {
            value['children'] = get_chlidren(data, value['id']);
            tmp.push(value);
        }
    }
    return tmp;
}
