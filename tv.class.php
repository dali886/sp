<?php

/**
 * TV 盒子数据源
 * 接口文档：http://tvurl.cn/tv/assets/doc/api.html
 */

class Tv
{
    private $apis = array(
        // 主页
        'home' => 'https://tvurl.cn/?f=json',
        // 电影列表
        'dianying' => 'https://tvurl.cn/dianying/?f=json',
        // 电视列表
        'dianshi' => 'https://tvurl.cn/dianshi/?f=json',
        // 综艺列表
        'zongyi' => 'https://tvurl.cn/zongyi/?f=json',
        // 动漫列表
        'dongman' => 'https://tvurl.cn/dongman/?f=json',
        // 影视搜索
        'search' => 'https://tvurl.cn/search/?f=json',
        // 影视详情
        'detail' => 'https://tvurl.cn/play/{id}.html?f=json',
        // 剧集列表
        'episodes' => 'https://tvurl.cn/episodes/?f=json',
    );

    public function home()
    {
        return $this->request($this->apis['home']);
    }

    public function getList($type, $params)
    {
        return $this->request($this->apis[$type] . '&' . http_build_query($params));
    }

    public function search($params)
    {
        return $this->request($this->apis['search'] . '&' . http_build_query($params));
    }

    public function detail($id)
    {
        return $this->request(str_replace('{id}', $id, $this->apis['detail']));
    }
    public function episodes($id, $source)
    {
        return $this->request($this->apis['episodes'] . '&id=' . urlencode($id) . '&source=' . urlencode($source));
    }

    private function request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (substr($url, 0, 5) === 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if ($response['rt'] === 'Success') {
            return $response['data'];
        } else {
            die('<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"><title>网络异常</title></head><body style="background:#F0F0F0"><div style="line-height:50px;margin-top:50px;text-align:center;font-size:22px;color:#333">资源获取失败<br />请检查服务器网络状况<br />（┬＿┬）</div></body></html>');
        }
    }
}
