<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Image extends Db
{
    private $table = 'recipes';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    /**
     * ファイルデータの保存
     * @param strings $user_id ユーザーID
     * @param strings $recipe_id　レシピID
     * @param strings $filename ファイル名
     * @param strings $filepath ファイルパス
     * @return bool $result
     */
    public function savefile($user_id, $recipe_id, $filename, $filepath)
    {
        $result = false;
        $sql = 'INSERT INTO images(user_id, recipe_id, file_name, file_path)
                VALUE (:user_id, :recipe_id, :file_name, :file_path)';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> bindValue(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth -> bindValue(':file_name', $filename, \PDO::PARAM_STR);
        $sth -> bindValue(':file_path', $filepath, \PDO::PARAM_STR);
        $sth -> execute();
        return $result;
    }

    /**
     * ファイルデータの取得
     * @param strings $user_id ユーザーID
     * @return array $result
     */
    public function getImage($user_id)
    {
        $sql = 'SELECT * 
                FROM images
                WHERE user_id = :user_id;
                ORDER BY recipe_id ASC LIMIT 3';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> execute();
        while ($result = $sth -> fetch(PDO::FETCH_ASSOC)) {
            $image[] = $result;
        }
        return $image;
    }

    public function getImagelist($user_id)
    {
        $sql = 'SELECT * 
                FROM images
                WHERE user_id = :user_id;
                ORDER BY recipe_id DESC LIMIT 10';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> execute();
        while ($result = $sth -> fetch(PDO::FETCH_ASSOC)) {
            $image[] = $result;
        }
        return $image;
    }
    /**
     * ファイルデータの削除
     * @param int $recipe_id レシピID
     */
    public function delete($recipe_id)
    {
        $sth = $this -> dbh -> prepare('DELETE FROM images Where recipe_id = :recipe_id');
        $sth->bindParam(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth->execute();
    }

    /**
     * ファイルデータの変更
     * @param int $recipe_id レシピID
     */
    public function update($data)
    {
        $sql = 'UPDATE images
                SET file_path = :file_path,
                    file_name = :file_name;
                WHERE user_id = :user_id, recipe_id = :recipe_id';
        $sth = $this -> dbh -> prepare($sql);
        $sth->bindParam(':user_id', $data["user_id"], \PDO::PARAM_INT);
        $sth->bindParam(':recipe_id', $data["recipe_id"], \PDO::PARAM_INT);
        $sth->bindParam(':file_name', $data["file_name"], \PDO::PARAM_STR);
        $sth->bindParam(':file_path', $data["file_path"], \PDO::PARAM_STR);
        $sth->execute();
        return $sth;
    }
}
