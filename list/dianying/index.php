<?php
require "../../tv.class.php";
if (empty($_GET['page'])) {
	$_GET['page'] = 1;
}
$tv = new Tv();
$data = $tv->getList('dianying', $_GET);
$current_page = $_GET['page'];
unset($_GET['page']);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<title>电影</title>
	<meta name="keywords" content="演示网站电影集合页">
	<meta name="description" content="这是一个演示网站的电影集合页">
	<link rel="stylesheet" type="text/css" href="../../static_yk/css/jquery.mobile.min.css">
	<link rel="stylesheet" type="text/css" href="../../static_yk/css/common.css">
</head>

<body class="body" ltype="dianying">

	<div class="header">
		<a class="logo" href="../../" style="background-image:url(../../static_yk/images/q-y-m-a-o.png)"></a>
		<div class="search">
			<input type="text" placeholder="输入你想看的" id="search" />
			<a id="searchDo"></a>
		</div>
		<div class="navigate">
			<a href="../../">精选</a>
			<a href="../dianying/" class="current">电影</a>
			<a href="../dianshi/">电视剧</a>
			<a href="../zongyi/">综艺</a>
			<a href="../dongman/">动漫</a>
		</div>
	</div>

	<div class="clear" style="height:0.2rem"></div>

	<div class="condition" id="conditionBox">
		<?php foreach ($data['menus'] as $v) { ?>
			<div class="s-slide-menu">
				<div>
					<?php foreach ($v as $k2 => $v2) { ?>
						<a href="./?<?php echo $v2 ?>" <?php echo $v2 === $data['current_menu'] ? ' class="now"' : '' ?>><?php echo  htmlspecialchars(substr($k2, 1)) ?></a>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="list">

		<?php if (!isset($data['list']) || count($data['list']) === 0) { ?>
			<div class="no-data" id="noDataBox" style="margin-top:1rem;background:none">没有找到相关影片，请尝试其他分类！</div>

		<?php } else { ?>
			<div class="items" id="listList">
				<?php foreach ($data['list'] as $v) { ?>
					<a href="../../play/?id=<?php echo urlencode($v['id']) ?>">
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
				<a class="prev" href="./?page=<?php echo $current_page - 1 ?>&<?php echo http_build_query($_GET) ?>" <?php echo $current_page <= 1 ? ' style="display:none"' : '' ?>><img src="../../static_yk/images/more.png" />上一页</a>
				<a class="next" href="./?page=<?php echo $current_page + 1 ?>&<?php echo http_build_query($_GET) ?>" <?php echo !$data['hasmore'] ? ' style="display:none"' : '' ?>>下一页<img src="../../static_yk/images/more.png" /></a>
			</div>
		<?php } ?>
	</div>

	<div class="clear" style="height:2rem"></div>

	<div class="copyright">
		<p>本站内容均来自于互联网资源实时采集</p>
		<p>本源码仅用做学习交流</p>
	</div>

	<a class="scroll-to-top" id="scrollToTop"></a>

	<script src="../../static_yk/js/jquery.min.js"></script>
	<script src="../../static_yk/js/common.js"></script>
	<script src="../../static_yk/js/list.js"></script>
</body>

</html>
