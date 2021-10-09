<?php

// セッション開始
session_start();

// セッション情報の確認用
//var_dump($_SESSION);

require_once '../classes/UserLogic.php';

$result = UserLogic::checkLogin();
if($result){
	header('Location: mypage.php');
	return;
}

// エラー情報を格納
$err = $_SESSION;;

// セッション情報の初期化
$_SESSION = array();
// セッション終了
session_destroy();

?>



</!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ログイン画面</title>
</head>

<body>
	<!-- ログインフォーム -->
	<h2>ログインフォーム</h2>
    <?php if(isset($err['msg'])): ?>
        <p><?php echo $err['msg']; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
		<!-- メールアドレス -->
		<p>
		 	<label for="email">メールアドレス：</label>
		 	<input type="email" name="email">
            <?php if(isset($err['email'])): ?>
                <p><?php echo $err['email']; ?></p>
            <?php endif; ?>
		</p>
		<!-- パスワード -->
		<p>
		 	<label for="password">パスワード：</label>
		 	<input type="password" name="password">
            <?php if(isset($err['password'])): ?>
                <p><?php echo $err['password']; ?></p>
            <?php endif; ?>
		</p>
		<!-- 新規登録ボタン -->
		<p>
		 	<input type="submit" value="ログイン">
		</p>
	</form>
    <!-- 新規登録画面へのリンク -->
    <a href="signup_form.php">新規登録はこちら</a>
</body>

</html>
