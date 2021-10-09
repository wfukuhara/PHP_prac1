<?php

require_once '../dbconnect.php';

class UserLogic
{
    /**
     * ユーザを登録する
     * @param array $userData
     * @return bool $result
     */
    public static function createUser($userData)
    {
        // SQL作成
        $sql = 'INSERT INTO users (name, email, password) VALUES (?, ?, ?)';

        // ユーザ情報を配列に格納
        $arr = [];
        $arr[] = $userData['username'];
        $arr[] = $userData['email'];
        // パスワードをハッシュ化
        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

        // DB接続
        $result = false;
        try {
            // SQLの準備. prepare()はSQL中に変動値がある場合に使用する
            $statement = connect()->prepare($sql);
            // SQLの実行. execute()はSQL中に変動値がある場合に使用する
            $result = $statement->execute($arr);
            return $result;
        } catch (\Exception $e) {
            return $result;
        }
    }

    /**
     * ログイン処理
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function login($email, $password)
    {
        $result = false;
        // メールアドレスをキーにユーザ情報を取得
        $user = self::getUserByEmail($email);

        // 取得したユーザ情報確認用
        // var_dump($user);
        // return;

        // メールアドレスが一致しない場合
        if(!$user){
            $_SESSION['msg'] = 'emailが一致しません。';
            return $result;
        }

        // パスワードのチェック
        if(password_verify($password, $user['password'])){
            // セッションIDを再生成(セッションハイジャック対策)
            session_regenerate_id(true);

            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }

        // パスワードが一致しない場合
        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $result;
}

    /**
     * メールアドレスからユーザを取得
     * @param string $email
     * @return array|bool $user|false
     */
    public static function getUserByEmail($email)
    {
        // SQL作成
        $sql = 'SELECT * FROM users WHERE email = ?';

        // メールアドレスを配列に格納
        $arr = [];
        $arr[] = $email;

        // DB接続
        $result = false;
        try {
            // SQLの準備
            $statement = connect()->prepare($sql);
            // SQLの実行
            $statement->execute($arr);
            // 結果を取得
            $user = $statement->fetch();
            // ユーザ情報を返す
            return $user;
        } catch (\Exception $e) {
            // 例外発生時は, FALSEを返す
            return false;
        }
    }

    /**
     * ログインチェック
     * @param void
     * @return bool $result
     */
    public static function checkLogin()
    {
        $result = false;
        if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
            $result = true;
        }

        return $result;
    }

    /**
     * ログアウト処理
     * @param void
     * @return void
     */
    public static function logout()
    {
        $_SESSION = array();
        session_destroy();
    }

}