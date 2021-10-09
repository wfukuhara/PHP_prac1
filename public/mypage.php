<?php

// セッション開始
session_start();

require_once '../classes/UserLogic.php';
require_once '../functions.php';

$result = UserLogic::checkLogin();

if(!$result){
	$_SESSION['login_err'] = 'ユーザが未登録もしくはログインされていません。';
	header('Location: signup_form.php');
	return;
}

$login_user = $_SESSION['login_user'];

?>



<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>マイページ</title>
</head>

<body>
	<h2>マイページ</h2>
	<p>ログインユーザ：<?php echo h($login_user["name"]) ?></p>
	<p>メールアドレス：<?php echo h($login_user["email"]) ?></p>
	<form action="./logout.php" method="POST">
		<input type="submit" name="logout" value="ログアウト">
	</form>
</body>

</html>
