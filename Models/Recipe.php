<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Recipe extends Db
{
    private $table = 'recipes';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    /**
     * Recipeテーブルに登録
     * @param $data array 登録情報
     * @return $result 結果
     */
    public function recipe($id, $data)
    {
        $sql = 'INSERT INTO recipes (user_id, name, introduce, time, cost, serving)
                VALUES (:user_id, :name, :introduce, :time, :cost, :serving)';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':user_id', $id, \PDO::PARAM_INT);
        $sth -> bindValue(':name', $data['name'], \PDO::PARAM_STR);
        $sth -> bindValue(':introduce', $data['intro'], \PDO::PARAM_STR);
        $sth -> bindValue(':time', $data['time'], \PDO::PARAM_INT);
        $sth -> bindValue(':cost', $data['cost'], \PDO::PARAM_INT);
        $sth -> bindValue(':serving', $data['serving'], \PDO::PARAM_INT);
        $sth -> execute();
        return $sth;
    }

    /**
     * Recipeテーブルのidを出す
     * @return $result 結果
     */
    public function lastid()
    {
        $sql = 'SELECT id
                FROM recipes';
        $sql.= ' WHERE id = (SELECT max(id) FROM recipes)';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> execute();
        $result = $sth -> fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function list($user_id)
    {
        $sql = 'SELECT  recipes.id,
                        recipes.user_id,
                        recipes.name,
                        recipes.introduce,
                        images.file_path
                FROM recipes
                LEFT JOIN images ON recipes.id = images.recipe_id';
        $sql .= ' WHERE recipes.user_id = :user_id';
        $sql .= ' ORDER BY recipes.id DESC LIMIT 3';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> execute();
        while ($result = $sth -> fetch(PDO::FETCH_ASSOC)) {
            $list[] = $result;
        }
        return $list;
    }

    /**
     * recipeテーブルから指定idに一致するデータを取得
     *
     * @params integer $id 選手のID
     * @return Array 指定の選手データ
     */
    public function findById($id = 0)
    {
        $sql = 'SELECT r.id,
                       r.user_id,
                       r.name,
                       r.introduce,
                       r.time,
                       r.cost,
                       r.serving,
                       images.file_path
                FROM recipes r
                LEFT JOIN images ON  r.id = images.recipe_id
                WHERE r.id = :id';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindParam(':id', $id, PDO::PARAM_INT);
        $sth -> execute();
        $result = $sth -> fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Recipeテーブルを更新
     * @param $data array 登録情報
     * @return $result 結果
     */
    public function update($data)
    {
        $sql = 'UPDATE recipes SET name = :name,introduce = :introduce,time = :time,cost = :cost,serving = :serving
        WHERE id = :id';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':name', $data['name'], PDO::PARAM_STR);
        $sth -> bindValue(':introduce', $data['intro'], PDO::PARAM_STR);
        $sth -> bindValue(':time', $data['time'], PDO::PARAM_INT);
        $sth -> bindValue(':cost', $data['cost'], PDO::PARAM_INT);
        $sth -> bindValue(':serving', $data['serving'], PDO::PARAM_INT);
        $sth -> bindValue(':id', $data['id'], PDO::PARAM_INT);
        $sth -> execute();
        return $sth;
    }

    /**レシピ数を数える
    * @param $user_id ユーザーID
    * @return $count カウント数
    */
    public function countMyrecipe($user_id):Int
    {
        $sql = 'SELECT count(*)
                FROM recipes
                WHERE user_id = :user_id';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $sth -> execute();
        $count = $sth -> fetchColumn();
        return $count;
    }

    /**ユーザーのレシピを全て閲覧
     * @param $user_id ユーザーID
     * @param $page ページ数
     */
    public function findAll($user_id, $page = 0)
    {
        $sql = 'SELECT recipes.id,
                       recipes.name,
                       recipes.introduce,
                       images.file_path
                FROM recipes
                JOIN images ON images.recipe_id = recipes.id
                WHERE recipes.user_id = :user_id';
        $sql .= ' LIMIT 10 OFFSET ' .(10 * $page);
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $sth -> execute();
        $result = $sth -> fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**キーワード検索の結果
     * @param $word
     * @param $page ページ数
     */
    public function search($word, $page = 0)
    {
        $sql = 'SELECT recipes.id,
                       recipes.name,
                       recipes.introduce,
                       images.file_path
                FROM recipes
                LEFT JOIN images ON  recipes.id = images.recipe_id
                WHERE recipes.name LIKE :word';
        $sql .= ' LIMIT 10 OFFSET ' .(10 * $page);
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindParam(':word', $word, PDO::PARAM_STR);
        $sth -> execute();
        $result = $sth -> fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**検索したレシピ数を数える
    * @param $word 検索ワード
    * @return $count カウント数
    */
    public function countSearchrecipe($word)
    {
        $sql = 'SELECT count(*)
                FROM recipes
                WHERE recipes.name LIKE :word';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':word', $word, PDO::PARAM_STR);
        $sth -> execute();
        $count = $sth -> fetchColumn();
        return $count;
    }

    /*データの削除
    * @param $id レシピID
    */
    public function delete($recipe_id)
    {
        $sth = $this -> dbh -> prepare('DELETE FROM recipes Where id = :id');
        $sth->bindParam(':id', $recipe_id, \PDO::PARAM_INT);
        $sth->execute();
    }
}
