<?php

// セッション開始
session_start();

require_once '../classes/UserLogic.php';

if(!$logout = filter_input(INPUT_POST, 'logout')){
	exit('不正なリクエスト');
}

// ログインしているか判定し,
// セッションが切れていたらログインしてくださいとメッセージを表示する
$result = UserLogic::checkLogin();

if(!$result){
	exit('セッションが切れています。再ログインしてください。');
}

UserLogic::logout();

?>



<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ログアウト</title>
</head>

<body>
	<h2>ログアウト</h2>
	<p>ログアウトしました</p>
	<a href="login_form.php">ログイン画面</a>
</body>

</html>
