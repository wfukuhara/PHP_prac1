<?php

// DB接続情報を定義したenv.phpを読み込み
require_once 'env.php';
// エラー表示設定をON
ini_set('display_errors', true);

/**
 * DB(MySQL)へ接続する関数
 * @param void
 * @return void
*/
function connect()
{
	// 接続情報を設定
	$host = DB_HOST; // ホスト名
	$db   = DB_NAME; // データベース名
	$user = DB_USER; // ユーザ名
	$pass = DB_PASS; // パスワード

	// データソース名を設定
	$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

	try {
		// ドライバ呼び出しを使用して、MySQLへ接続する
		$pdo = new PDO($dsn, $user, $pass, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]
		);
		//echo '接続成功';
		return $pdo;
	} catch (PDOException $e) {
		// 接続失敗時の処理
		echo '接続失敗 '. $e->getMessage();
		exit();
	}
}

// 接続テスト
//echo connect();

?>
