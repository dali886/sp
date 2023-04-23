function pageLoad() {
    var template = { 'from': null, 'episodes': null, 'item': null };
    $(function() {
        if ($.URI.id) {
            // 关闭播放提示
            $('#playBoxIframe .tip .close').tap(function() { $('#playBoxIframe .tip').fadeOut(200); })

            // 初始化模板
            for (var i in template) {
                if ($('#' + i + 'List .template').length) {
                    template[i] = $('#' + i + 'List .template').html();
                    $('#' + i + 'List .template').remove();
                }
            }

            // 上一集
            $('#episodesControl a.prev').tap(function() {
                if ($('#episodesList .current').next().length) {
                    $('#episodesList .current').next().trigger('tap');
                }
            })

            // 下一集
            $('#episodesControl a.next').tap(function() {
                if ($('#episodesList .current').prev().length) {
                    $('#episodesList .current').prev().trigger('tap');
                }
            })

            // 播放
            var tipInterval
            $('#fromList,#episodesList').tap(function(e) {
                if (!$(this).attr('data-href')) { return false; }
                if ($(this).hasClass('current')) { return true; }
                $(this).parent().find('.current').removeClass('current');
                $(this).addClass('current');
                if ($(this).attr('data-name')) { $('#playBoxIframe .tip a span').html($(this).attr('data-name')); }

                if (!$(this).attr('data-site') || $('body').attr('tv-type') === 'mv') {
                    if ($(this).attr('data-api')) {

                        console.log('播放来源：' + $(this).attr('data-api') + encodeURIComponent($(this).attr('data-href')));

                        $('#playBoxIframe .tip').show().find('a').attr('href', $(this).attr('data-href'));
                        if (tipInterval) { clearInterval(tipInterval); }
                        tipInterval = setInterval(function() { $('#playBoxIframe .tip').fadeOut(200) }, 3000);

                        // 记录当前剧集
                        if ($(this).attr('value')) {
                            var episodes_log = $.cookie('episodes_log'),
                                episodes_number = $(this).attr('value');
                            if (episodes_log) {
                                try {
                                    var episodes_log = JSON.parse(episodes_log);
                                    if (episodes_log[$.URI.vid]) { delete episodes_log[$.URI.vid]; }
                                    episodes_log[$.URI.vid] = episodes_number;
                                    var episodes_log_keys = Object.keys(episodes_log);
                                    if (episodes_log_keys.length > 2) { // 最多记录10个
                                        for (i = 0; i < episodes_log_keys.length - 2; ++i) {
                                            delete episodes_log[episodes_log_keys[i]];
                                        }
                                    }
                                } catch (e) {
                                    episodes_log = {};
                                    episodes_log[$.URI.vid] = episodes_number;
                                }
                            } else {
                                episodes_log = {};
                                episodes_log[$.URI.vid] = episodes_number;
                            }
                            $.cookie('episodes_log', JSON.stringify(episodes_log), 2592000);

                            // 更新标题
                            $('#titleItem').html($.htmlEncode($('#titleItem').attr('value')) + '<span>' + $.htmlEncode((/^\d+$/.test(episodes_number) ? '第' + episodes_number + '集' : episodes_number)) + '</span>');

                            // 更新剧集操作
                            if ($('#episodesList .current').next('a').length) {
                                $('#episodesControl a.prev').css('display', 'block');
                            } else {
                                $('#episodesControl a.prev').hide();
                            }
                            if ($('#episodesList .current').prev('a').length) {
                                $('#episodesControl a.next').css('display', 'block');
                            } else {
                                $('#episodesControl a.next').hide();
                            }
                        }

                        $('#playBoxIframe iframe').remove();
                        $('#playBoxIframe').append('<iframe frameborder="no" border="0" scrolling="no" allowfullscreen="true" allowtransparency="true" src="./box/?src=' + encodeURIComponent($(this).attr('data-api') + encodeURIComponent($(this).attr('data-href'))) + '"></iframe>');

                        $('html,body').animate({ scrollTop: 0 }, 300);
                    } else {
                        location.href = $(this).attr('data-href');
                    }
                } else {
                    $('#episodesList').removeClass('float-none');
                    $('#loadBox2').show();
                    $('#episodesBox').hide();
                    var api = $(this).attr('data-api');
                    $.get('./episodes/', { id: $.URI.id, source: $(this).attr('data-href') }, function(response) {
                        try {
                            var data = JSON.parse(response);
                            $('#episodesList a').remove();
                            // 载入剧集
                            if (template.episodes) {
                                // 显示剧集
                                $('#loadBox2').hide();
                                $('#episodesBox').show();

                                if (Object.keys(data.list).length) {
                                    if (data.is_long_title) { $('#episodesList').addClass('float-none'); }

                                    for (var i in data.list) {
                                        $(parseTemplate(template.episodes, { api: api, href: data.list[i], number: i })).prependTo($('#episodesList'));
                                    }

                                    // 是否有剧集记录
                                    var episodes_log = $.cookie('episodes_log');
                                    if (episodes_log) {
                                        try {
                                            var episodes_log = JSON.parse(episodes_log);
                                            if (episodes_log[$.URI.vid] && $('#episodesList a[value="' + episodes_log[$.URI.vid] + '"]').length == 1) {
                                                // 自动点击记录剧集
                                                if ($('#episodesList a[value="' + episodes_log[$.URI.vid] + '"]').attr('data-api')) {
                                                    $('#episodesList a[value="' + episodes_log[$.URI.vid] + '"]').trigger('tap');
                                                }
                                            } else {
                                                // 自动点击第一个
                                                if ($('#episodesList a:eq(0)').attr('data-api')) { $('#episodesList a:eq(0)').trigger('tap'); }
                                            }

                                        } catch (e) {
                                            // 自动点击第一个
                                            if ($('#episodesList a:eq(0)').attr('data-api')) { $('#episodesList a:eq(0)').trigger('tap'); }
                                        }
                                    } else {
                                        // 自动点击第一个
                                        if ($('#episodesList a:eq(0)').attr('data-api')) { $('#episodesList a:eq(0)').trigger('tap'); }
                                    }

                                    // 更新剧集操作
                                    if ($('#episodesList .current').next('a').length) {
                                        $('#episodesControl a.prev').css('display', 'block');
                                    } else {
                                        $('#episodesControl a.prev').hide();
                                    }
                                    if ($('#episodesList .current').prev('a').length) {
                                        $('#episodesControl a.next').css('display', 'block');
                                    } else {
                                        $('#episodesControl a.next').hide();
                                    }
                                } else {
                                    $('#episodesList').addClass('float-none');
                                    $('<a>暂无剧集</a>').prependTo($('#episodesList'));
                                    $('#episodesControl a').hide();
                                }
                            } else {
                                console.log('未知的列表模板');
                            }
                        } catch (e) {
                            $.showDataError();
                        }
                    })
                }
            }, 'a');

            // 载入线路
            if ($('#fromList').length && $('#fromList').attr('from')) {
                $('#fromList a').remove();
                if (template.from) {
                    var from = JSON.parse($('#fromList').attr('from')).data;
                    var number = 0;
                    for (var i in from) {
                        console.log(from[i]);
                        if (jsApi && jsApi.length) {
                            for (var j in jsApi) {
                                from[i].api = jsApi[j];
                                from[i].number = ++number;
                                $(parseTemplate(template.from, from[i])).insertBefore($('#fromList .clear'));
                            }
                        } else {
                            $('#playBoxIframe').hide();
                            from[i].api = '';
                            from[i].number = ++number;
                            $(parseTemplate(template.from, from[i])).insertBefore($('#fromList .clear'));
                        }
                    }

                    // 显示并自动点击第一个
                    if ($('body').attr('tv-type') === 'mv') { $('#loadBox2').hide(); }
                    $('#fromList').show();
                    if ($('body').attr('tv-type') !== 'mv' || $('#fromList a:eq(0)').attr('data-api')) { $('#fromList a:eq(0)').trigger('tap'); }
                } else {
                    console.log('未知的列表模板');
                }
            }
        } else {
            location.href = '../';
        }
    })
    pageLoaded = true;
}
if (typeof(pageLoaded) == 'undefined' && typeof(jsApi) != 'undefined') { pageLoad(); }