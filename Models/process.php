<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Process extends Db
{
    private $table = 'recipes';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function process($user_id, $recipe_id, $ing, $method)
    {
        $sql = 'INSERT INTO processes (user_id, recipe_id, ingreadment, method)
                VALUES (:user_id, :recipe_id, :ingreadment, :method)';
        $sth = $this->dbh->prepare($sql);
        $sth -> bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> bindValue(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth -> bindValue(':ingreadment', $ing, \PDO::PARAM_STR);
        $sth -> bindValue(':method', $method, \PDO::PARAM_STR);
        $sth -> execute();
        return $sth;
    }

     /**
     * processesテーブルから指定idに一致するデータを取得
     *
     * @params integer $id 選手のID
     * @return Array 指定の選手データ
     */
    public function findById($id = 0)
    {
        $sql = 'SELECT  processes.id,
                        processes.user_id,
                        processes.recipe_id,
                        processes.ingreadment,
                        processes.method
                FROM processes
                JOIN recipes ON recipes.id = processes.recipe_id
                WHERE recipes.id = :id';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindParam(':id', $id, PDO::PARAM_INT);
        $sth -> execute();
        while ($result = $sth -> fetch(PDO::FETCH_ASSOC)) {
            $process[] = $result;
        }
        return $process;
    }

    /**
     * 指定したデータを編集
     * @param intger $id ユーザのid
     * @result Array $sth 編集したデータ
     */

    public function update($data, $recipe_id)
    {
        $sql = 'UPDATE processes
                SET ingreadment = :ingreadment, 
                    method = :method
                WHERE id = :id AND recipe_id = :recipe_id';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindParam(':id', $data["edit_id"], \PDO::PARAM_INT);
        $sth -> bindParam(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth -> bindParam(':ingreadment', $data["edit_ingredment"], PDO::PARAM_STR);
        $sth -> bindParam(':method', $data["edit_method"], PDO::PARAM_STR);
        $sth -> execute();
        $result = $sth -> fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**変更後に余った工程を削除する
     * @param $id processID
     */
    public function reduce($id)
    {
        $sth = $this -> dbh -> prepare('DELETE FROM processes Where id = :id');
        $sth -> bindParam(':id', $id, \PDO::PARAM_INT);
        $sth -> execute();
    }

    public function add($user_id, $recipe_id, $data)
    {
        $sql = 'INSERT INTO processes (user_id, recipe_id, ingreadment, method)
                VALUES (:user_id, :recipe_id, :ingreadment, :method)';
        $sth = $this -> dbh -> prepare($sql);
        $sth -> bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $sth -> bindValue(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth -> bindValue(':ingreadment', $data["edit_ingredment"], \PDO::PARAM_STR);
        $sth -> bindValue(':method', $data["edit_method"], \PDO::PARAM_STR);
        $sth -> execute();
        return $sth;
    }

    /*データの削除
    * @param $id レシピID
    */
    public function delete($recipe_id)
    {
        $sth = $this -> dbh -> prepare('DELETE FROM processes Where recipe_id = :recipe_id');
        $sth->bindParam(':recipe_id', $recipe_id, \PDO::PARAM_INT);
        $sth->execute();
    }
}
