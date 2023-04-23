$(function() {
    // 搜索
    $('#searchDo').tap(function() {
        if (!$('#search').val()) { $('#search').myBubble('h5', '请输入想看的影视名称', 1000); return false; }
        if (location.href.indexOf('/list/') > -1) { // 判断当前是否在list目录
            if (location.href.indexOf('search') < 0) { // 判断当前是否为搜索页
                location.href = '../search/?q=' + encodeURIComponent($('#search').val());
            } else {
                location.replace('./?q=' + encodeURIComponent($('#search').val()));
            }
        } else if (location.href.indexOf('play') > -1) { // 判断当前是否为播放页
            location.href = '../list/search/?q=' + encodeURIComponent($('#search').val());
        } else {
            location.href = './list/search/?q=' + encodeURIComponent($('#search').val());
        }
    })

    // 回车搜索
    $('#search').keydown(function(e) {
        if (e.keyCode == 13) {
            $('#searchDo').trigger('tap');
            return false;
        }
    });

    // 回到顶部
    $(window).scroll(function(e) {
        if ($(window).scrollTop() > $(window).height()) {
            $('#scrollToTop').css('display', 'block');
        } else {
            $('#scrollToTop').css('display', 'none');
        }
        // 触底自动加载
        if ($('#loadMore').length) {
            if ($(window).scrollTop() + $(window).height() > $('#loadMore').offset().top - 200) {
                $('#loadMore').trigger('tap');
            }
        }
    })
    $('#scrollToTop').tap(function() { $('html,body').animate({ scrollTop: 0 }, 300); })
})

// 模板解析函数
function parseTemplate(template, data) {
    if (data.id) {
        if (location.href.indexOf('/list/') < 0) { // 判断当前是否在list目录
            data.href = './play.html?id=' + encodeURIComponent(data.id);
        } else {
            data.href = '../play.html?id=' + encodeURIComponent(data.id);
        }
    }
    for (var i in data) {
        template = template.replace('{{' + i + '}}', data[i]).replace('{{' + i + '}}', data[i]).replace('{{' + i + '}}', data[i]);
    }
    return template;
}

// 初始化js
var jsApi, jsUrl, pageLoaded;

function jsApiConfig(api) {

    if (typeof api === 'object') {
        jsApi = api;
        if (typeof pageLoad == 'function') {
            pageLoad();
        }
    } else {
        alert('接口配置错误');
    }
}

// 载入配置文件
$(function() {
    if (location.href.indexOf('/list/') > -1) {
        var configUrl = '../../config.js?_=' + $.now();
    } else if (location.href.indexOf('/play/') > -1) {
        var configUrl = '../config.js?_=' + $.now();
    } else {
        var configUrl = 'config.js?_=' + $.now();
    }
    $.loadScript(configUrl);
    $('img').one('error', function() {
        if (location.href.indexOf('/list/') > -1) {
            $(this).attr('src', '../../static_yk/images/cover.png');
        } else if (location.href.indexOf('/play/') > -1) {
            $(this).attr('src', '../static_yk/images/cover.png');
        } else {
            $(this).attr('src', 'static_yk/images/cover.png');
        }
    });
});