
<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Good extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

   /** すでにお気に入りしているか判定（初回時）
   * @param int $user_id
   * @param int $recipe_id
   * @return bool $favorite
   */
    public function checkfavolite($user_id, $recipe_id)
    {
        $sql = "SELECT COUNT(recipe_id)
                FROM goods
                WHERE user_id = :user_id AND recipe_id = :recipe_id";
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> bindParam(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth -> execute();
        $count = $sth -> fetch(PDO::FETCH_ASSOC);
        if ($count["COUNT(recipe_id)"] == "1") {//カラムがある場合
            $result = true;//「いいね解除」と出る
            return $result;
        } elseif ($count["COUNT(recipe_id)"] == "0") {//カラムがない場合
            $result = false;//「いいね」と出る
            return $result;
        }
    }

    /** すでにお気に入りしているか判定（リロード時）
   * @param int $user_id
   * @param int $recipe_id
   * @return bool $result
   */
    public function reloadfavolite($user_id, $recipe_id)
    {
        $sql = "SELECT COUNT(recipe_id)
                FROM goods
                WHERE user_id = :user_id AND recipe_id = :recipe_id";
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> bindParam(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth -> execute();
        $count = $sth -> fetch(PDO::FETCH_ASSOC);
        if ($count["COUNT(recipe_id)"] == "1") {//カラムがある場合
            $result = true;//テーブルにあるので削除機能に繋げる
            return $result;
        } elseif (["COUNT(recipe_id)"] == "0") {
            $result = false;//テーブルに無いので登録機能に繋げる
            return $result;
        }
    }

    /** お気に入り登録
   * @param int $user_id
   * @param int $recipe_id
   * @return bool $result
   */
    public function favoriteDone($user_id, $recipe_id)
    {
        $sql = 'INSERT INTO goods(user_id, recipe_id)
                VALUES (:user_id, :recipe_id)';
        try {
            $sth = $this -> dbh -> prepare($sql);
            $sth -> bindParam(':user_id', $user_id, \PDO::PARAM_INT);
            $sth -> bindParam(':recipe_id', $recipe_id, \PDO::PARAM_INT);
            $result = $sth -> execute();
            return $result;
        } catch (\Exception $e) {
            return $result = false;
        }
    }

    /** お気に入り解除
     * @param int $user_id
     * @param int $recipe_id
     * @return bool $result
     */
    public function favoriteCansel($user_id, $recipe_id)
    {
        $sql = 'DELETE 
                FROM goods
                WHERE user_id = :user_id AND recipe_id = :recipe_id';
        try {
            $sth = $this -> dbh -> prepare($sql);
            $sth -> bindValue(':user_id', $user_id, \PDO::PARAM_INT);
            $sth -> bindValue(':recipe_id', $recipe_id, \PDO::PARAM_INT);
            $result = $sth -> execute();
            return $result;
        } catch (\Exception $e) {
            return $result = false;
        }
    }
}
