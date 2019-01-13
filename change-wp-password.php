<?php
error_reporting(0);

$form_info = [
	"mysql_url" => "localhost",
	"mysql_port" => "3306",
	"mysql_user" => "root",
	"mysql_user" => "root",
	"mysql_password" => "",
	"mysql_name" => "wordpress",
	"mysql_pre" => "wp_",
	"wordpress_user" => "admin",
	"wordpress_password" => "",
];

foreach ($form_info as $name => $info){
	if(!empty($_POST[$name])){
		${$name} = $_POST[$name];
	}else{
		${$name} = $info;
	}
}
$mysql_url_port = $mysql_url.":".$mysql_port;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="zh-TW">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="zh-TW">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html lang="zh-TW">
<!--<![endif]-->
<head>
<meta charset="UTF-8">
<title>一鍵修改WordPress密碼 By Arefly</title>
<link rel="stylesheet" href="//cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
<style>
#footer{
	padding-top: 20px;
	padding-bottom: 10px;
}
</style>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
	<script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
<h1>一鍵修改WordPress密碼</h1>
<p class="lead">你只需要輸入數據庫的相關信息和你想更改的密碼，我們就會幫你立刻搞定！</p>
<form class="form-horizontal" action="" method="POST" role="form">
	<div class="form-group">
		<label for="mysql_url" class="col-sm-2 control-label">數據庫地址</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="mysql_url" name="mysql_url" value="<?php echo $mysql_url; ?>" required="required" />
		</div>
		<label for="mysql_port" class="col-sm-2 control-label">數據庫端口</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="mysql_port" name="mysql_port" value="<?php echo $mysql_port; ?>" required="required" />
		</div>
	</div>
	<div class="form-group">
		<label for="mysql_user" class="col-sm-2 control-label">數據庫用戶名</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="mysql_user" name="mysql_user" value="<?php echo $mysql_user; ?>" required="required" />
		</div>
		<label for="mysql_password" class="col-sm-2 control-label">數據庫密碼</label>
		<div class="col-sm-3">
			<input type="password" class="form-control" id="mysql_password" name="mysql_password" value="<?php echo $mysql_password; ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="mysql_name" class="col-sm-2 control-label">數據庫名稱</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="mysql_name" name="mysql_name" value="<?php echo $mysql_name; ?>" required="required" />
		</div>
		<label for="mysql_pre" class="col-sm-2 control-label">數據庫前綴</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="mysql_pre" name="mysql_pre" value="<?php echo $mysql_pre; ?>" required="required" />
		</div>
	</div>
	<div class="form-group">
		<label for="wordpress_user" class="col-sm-2 control-label">WordPress用戶名</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="wordpress_user" name="wordpress_user" value="<?php echo $wordpress_user; ?>" required="required" />
		</div>
		<label for="wordpress_password" class="col-sm-2 control-label">WordPress新密碼</label>
		<div class="col-sm-3">
			<input type="password" class="form-control" id="wordpress_password" name="wordpress_password" value="<?php echo $wordpress_password; ?>" required="required" />
		</div>
	</div>
	<div class="form-group">
		<div class="text-center">
			<button name="submit" id="submit" type="submit" class="btn btn-primary">重新設定密碼</button>
		</div>
	</div>
</form>
<?php
if(isset($_POST['submit'])){
	if(!mysql_connect($mysql_url_port, $mysql_user, $mysql_password)){
		?><div class="alert alert-warning">無法連接數據庫！請檢查數據庫用戶名及密碼是否正確！</div><?php
		goto end;
	}
	$db_selected = mysql_select_db($mysql_name, mysql_connect($mysql_url_port, $mysql_user, $mysql_password));
	if(!$db_selected){
		?><div class="alert alert-warning">成功鏈接數據庫，但無法找到你輸入的數據庫名稱！</div><?php
		goto end;
	}
	if(!mysql_query("update ".$mysql_pre."users set user_pass='".md5($wordpress_password)."' where user_login='".$wordpress_user."'")){
		?><div class="alert alert-danger">無法修改WordPress密碼！請聯絡 <a href="Mailto:info@arefly.com" title="Send Email To Arefly">暢想資源</a> 以獲取解決方法！</div><?php
		goto end;
	}
	?>
<div class="alert alert-success">
	<p class="text-info">成功修改你的WordPress密碼！登陸信息如下：</p>
	<p class="text-info">用戶名：<?php echo $wordpress_user; ?></p>
	<p class="text-info">密碼：<?php echo $wordpress_password; ?></p>
	<br />
	<p>如果你欣賞我的勞動成果，請<a href="http://www.arefly.com/donate/" title="Donate To Arefly">給我捐款</a>吧！</p>
	<p>感謝你使用本工具！</p>
	<br />
	<p class="text-warning">注意：為確保你的網站安全，本頁面將會自動刪除！</p>
</div>
	<?php
	if(!unlink(__FILE__)){
		?><div class="alert alert-warning">無法自動刪除本文件，請手動刪除！</div><?php
	}else{
		unlink(__FILE__);
	}
}
end:
?>
</div><!-- /.container -->

<div id="footer">
	<div class="container">
		<p class="text-center text-muted credit">Copyright &copy; 2013-2014 <a href="http://www.arefly.com/" title="暢想資源" target="_blank">Arefly</a> All rights reserved</p>
	</div>
</div><!-- /.footer -->

<script src="//cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
</body>
</html>