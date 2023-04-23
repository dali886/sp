<?php
require "tv.class.php";
$tv = new Tv();
$data = $tv->home();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="renderer" content="webkit">
	<meta name="robots" content="noindex">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<title>眼力劲影视网主页</title>
	<meta name="keywords" content="眼力劲影视网">
	<meta name="description" content="眼力劲影视网的主页">
	<link rel="stylesheet" type="text/css" href="./static_yk/css/jquery.mobile.min.css">
	<link rel="stylesheet" type="text/css" href="./static_yk/css/common.css">
</head>

<body class="body">

	<div class="header">
		<a class="logo" href="./" style="background-image:url(./static_yk/images/q-y-m-a-o.png)"></a>
		<div class="search">
			<input type="text" placeholder="输入你想看的" id="search" />
			<a id="searchDo"></a>
		</div>
		<div class="navigate">
			<a href="./" class="current">精选</a>
			<a href="./list/dianying/">电影</a>
			<a href="./list/dianshi/">电视剧</a>
			<a href="./list/zongyi/">综艺</a>
			<a href="./list/dongman/">动漫</a>
		</div>
	</div>

	<span class="clear" style="height:0.1rem"></span>

	<div class="s-slider">
		<ul id="bannerList">
			<?php foreach ($data['banners'] as $v) { ?>
				<li><a href="<?php echo substr($v['url'], 0, 4) === 'http' ? $v['url'] : ('./play/?id=' . $v['url']) ?>"><i style="background-image:url(<?php echo $v['image'] ?>)"></i><span><?php echo htmlspecialchars($v['title']) ?></span></a></li>
			<?php } ?>
		</ul>
		<ol></ol>
		<div style="display:none"><span class="now"></span><span>/</span><span class="total"></span></div>
	</div>

	<div class="list">

		<h3 class="title">热播电视剧</h3>

		<div class="items" id="dianshiList">
			<?php foreach ($data['dianshi'] as $k => $v) { ?>
				<a href="./play/?id=<?php echo urlencode($v['id']) ?>" <?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
					<div>
						<img referrerpolicy="no-referrer" src="<?php echo $v['cover'] ?>" />
						<b><?php echo $v['status'] ?></b>
					</div>
					<span><?php echo htmlspecialchars($v['title']) ?></span>
				</a>
			<?php } ?>
			<span class="clear"></span>
		</div>

		<div class="more">
			<a href="./list/dianshi/"><img src="./static_yk/images/more_1.png" />更多精彩电视剧</a>
			<a class="switch-button" data-list-type="dianshi"><img src="./static_yk/images/more_2.png" />换一换</a>
		</div>
	</div>

	<div class="clear" style="height:0.8rem"></div>

	<div class="list">

		<h3 class="title">热播电影</h3>

		<div class="items" id="dianyingList">
			<?php foreach ($data['dianying'] as $k => $v) { ?>
				<a href="./play/?id=<?php echo urlencode($v['id']) ?>" <?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
					<div>
						<img referrerpolicy="no-referrer" src="<?php echo $v['cover'] ?>" />
						<b><?php echo $v['status'] ?></b>
					</div>
					<span><?php echo htmlspecialchars($v['title']) ?></span>
				</a>
			<?php } ?>
			<span class="clear"></span>
		</div>

		<div class="more">
			<a href="./list/dianying/"><img src="./static_yk/images/more_1.png" />更多精彩电影</a>
			<a class="switch-button" data-list-type="dianying"><img src="./static_yk/images/more_2.png" />换一换</a>
		</div>
	</div>

	<div class="clear" style="height:0.8rem"></div>

	<div class="list">

		<h3 class="title">热播综艺</h3>

		<div class="items" id="zongyiList">
			<?php foreach ($data['zongyi'] as $k => $v) { ?>
				<a href="./play/?id=<?php echo urlencode($v['id']) ?>" <?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
					<div>
						<img referrerpolicy="no-referrer" src="<?php echo $v['cover'] ?>" />
						<b><?php echo $v['status'] ?></b>
					</div>
					<span><?php echo htmlspecialchars($v['title']) ?></span>
				</a>
			<?php } ?>
			<span class="clear"></span>
		</div>

		<div class="more">
			<a href="./list/zongyi/"><img src="./static_yk/images/more_1.png" />更多精彩综艺</a>
			<a class="switch-button" data-list-type="zongyi"><img src="./static_yk/images/more_2.png" />换一换</a>
		</div>
	</div>

	<div class="clear" style="height:0.8rem"></div>

	<div class="list">

		<h3 class="title">热播动漫</h3>

		<div class="items" id="dongmanList">
			<?php foreach ($data['dongman'] as $k => $v) { ?>
				<a href="./play/?id=<?php echo urlencode($v['id']) ?>" <?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
					<div>
						<img referrerpolicy="no-referrer" src="<?php echo $v['cover'] ?>" />
						<b><?php echo $v['status'] ?></b>
					</div>
					<span><?php echo htmlspecialchars($v['title']) ?></span>
				</a>
			<?php } ?>
			<span class="clear"></span>
		</div>

		<div class="more">
			<a href="./list/dongman/"><img src="./static_yk/images/more_1.png" />更多精彩动漫</a>
			<a class="switch-button" data-list-type="dongman"><img src="./static_yk/images/more_2.png" />换一换</a>
		</div>
	</div>

	<div class="clear" style="height:2rem"></div>

	<div class="copyright">
		<p>本站内容均来自于互联网资源实时采集</p>
		<p>本源码仅用做学习交流</p>
	</div>

	<a class="scroll-to-top" id="scrollToTop"></a>

	<script src="./static_yk/js/jquery.min.js"></script>
	<script src="./static_yk/js/common.js"></script>
	<script src="./static_yk/js/index.js"></script>
</body>

</html>
