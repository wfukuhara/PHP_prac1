<?php

// セッション開始
session_start();

require_once '../classes/UserLogic.php';

// エラーメッセージ
$err = [];

// バリデーション(追加必要)
// メールアドレス
if(!$email = filter_input(INPUT_POST, 'email')){
	$err['email'] = 'メールアドレスを記入してください。';
}
// パスワード
if(!$password = filter_input(INPUT_POST, 'password')){
	$err['password'] = 'パスワードを記入してください。';
}

// エラー時の処理
if(count($err)  > 0){
    // エラーがあった場合は, トップ画面に戻す
    $_SESSION = $err;
    header('Location: login_form.php');
    return;
}

// ログイン処理
$result = UserLogic::login($email, $password);

// ログイン失敗時の処理
if(!$result){
    header('Location: login_form.php');
    return;
}

// テスト用
// echo 'ログイン成功';

?>



<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ログイン完了</title>
</head>

<body>
	<h2>ログイン完了</h2>
	<p>ログインしました</p>
	<a href="./mypage.php">マイページへ</a>
</body>

</html>
