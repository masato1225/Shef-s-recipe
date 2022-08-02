<?php
require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db
{
    private $table = 'recipes';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    /**
    *Userテーブルに登録　
    *
    * @param $data array 登録情報
    * @return $result 結果
    */

    public function register($data)
    {
        $sql = 'INSERT INTO users (name, email, restaurant, comment, password, roles) 
                VALUES (:name, :email, :restaurant, :comment, :password, :role)';
        $sth = $this->dbh->prepare($sql);
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $sth->bindValue(':name', $data['name'], \PDO::PARAM_STR);
        $sth->bindValue(':email', $data['email'], \PDO::PARAM_STR);
        $sth->bindValue(':restaurant', $data['restaurant'], \PDO::PARAM_STR);
        $sth->bindValue(':comment', $data['comment'], \PDO::PARAM_STR);
        $sth->bindValue(':password', $hash, \PDO::PARAM_STR);
        $sth->bindValue(':role', $data['role'], \PDO::PARAM_INT);
        $sth->execute();
        return $sth;
    }

    /**
    *処理ログイン処理
    * @param string $email
    * @param string $password
    * @return array $user||false
    */

    public function login($email, $password)
    {
        $result = false;
        $user = self::getUserByEmail($email);
      
        if (!$user) {
            $_SESSION['email'] = 'emailが一致しません。';
            return $result;
        }

        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }

        $_SESSION['password'] = 'パスワードが一致しません。';
        return $result;
    }

    /**
     * パスワードを編集
     * @param string $email
     * @param string $password
     * @result Array $sth 変更したデータ
     */

    public function reset($email, $password)
    {
        //メールアドレスの一致を検証
        $user = self::getUserByEmail($email);
      
        if (!$user) {
            $_SESSION['email'] = 'emailが一致しません。';
            return false;
        }

        //パスワードの変更
        $sql = "UPDATE users 
                SET password = :password 
                WHERE email = :email";
        try {
            $sth = $this -> dbh -> prepare($sql);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sth -> bindParam(':email', $email, PDO::PARAM_STR);
            $sth -> bindParam(':password', $hash, PDO::PARAM_STR);
            $sth -> execute();
            return $sth;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
    *emailからユーザーを取得
    * @param string $email
    * @return array $user||false
    */

    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $arr = [];
        $arr[] = $email;
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($arr);
            //結果を返す
            $user = $sth->fetch();
            return $user;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 指定したデータ(プロフィール)を編集
     * @param intger $id ユーザのid
     * @result Array $sth 編集したデータ
     */

    public function update($data)
    {
        $sql = 'UPDATE users 
                SET name = :name,
                    restaurant = :restaurant,
                    comment = :comment
                WHERE id = :id';
        try {
            $sth = $this -> dbh -> prepare($sql);
            $sth -> bindParam(':id', $data['id'], PDO::PARAM_INT);
            $sth -> bindParam(':name', $data['name'], PDO::PARAM_STR);
            $sth -> bindParam(':restaurant', $data['restaurant'], PDO::PARAM_STR);
            $sth -> bindParam(':comment', $data['comment'], PDO::PARAM_STR);
            $sth -> execute();
            return $sth;
        } catch (PDOException $e) {
            return false;
        }
    }
}
