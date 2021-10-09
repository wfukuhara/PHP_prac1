<?php

// セッション開始
session_start();

require_once '../classes/UserLogic.php';

// エラーメッセージ
$err = [];

// 新規登録画面から送信されたトークンを取得
$token = filter_input(INPUT_POST, 'csrf_token');

// var_dump($token);
// var_dump($_SESSION);

// トークンがない or トークンが一致しない場合, 処理を中止
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
	exit('不正なリクエスト');
}

// セッションを削除
// 多重送信, 別のリンクからアクセス時の対策
unset($_SESSION['csrf_token']);

// バリデーション(追加必要)
// ユーザ名
if(!$username = filter_input(INPUT_POST, 'username')){
	$err[] = 'ユーザ名を記入してください。';
}
// メールアドレス
if(!$email = filter_input(INPUT_POST, 'email')){
	$err[] = 'メールアドレスを記入してください。';
}
// パスワード
$password = filter_input(INPUT_POST, 'password');
// 正規表現でチェック
if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
	$err[] = 'パスワードは英数字8文字以上100文字以上にしてください。';
}
// パスワード確認
$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf){
	$err[] = '確認用パスワードと異なっています。';
}

// エラー無しの場合, ユーザを新規登録
if(count($err) === 0){
	// ユーザ登録処理
	$hasCreated = UserLogic::createUser($_POST);
	if(!$hasCreated){
		$err[] = '登録に失敗しました。';
	}
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ユーザ登録完了画面</title>
</head>

<body>
	<!-- 入力内容にエラーあれば, エラー内容を表示 -->
	<?php if(count($err) > 0): ?>
		<?php foreach($err as $e): ?>
			<p><?php echo $e; ?></p>
		<?php endforeach; ?>
	<?php else: ?>
		<p>ユーザ登録が完了しました。</p>
	<?php endif; ?>

	<!-- 戻るボタン -->
	<a href="./signup_form.php">戻る</a>
</body>

</html>
