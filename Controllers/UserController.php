<?php

require_once(ROOT_PATH .'/Models/User.php');
require_once(ROOT_PATH .'/Models/Recipe.php');
require_once(ROOT_PATH .'/Models/process.php');
require_once(ROOT_PATH .'/Models/Image.php');
require_once(ROOT_PATH .'/Models/Good.php');

class UserController
{
    private $request; //リクエストパラメータ(GET,POST)
    private $User;  //Userモデル
    private $Recipe; //Recipeモデル
    private $Process; //Processモデル
    private $Image; //Imagesモデル
    private $Good; //Goodモデル

    public function __construct()
    {
    //インスタンス化で最初に走る処理
    //get['id']とpostはrequestに入る
        $this -> request['get'] = $_GET;
        $this -> request['post'] = $_POST;

    //モデルオブジェクトの生成
        $this -> User = new User();
        $dbh = $this -> User -> getDbHandler();
        $this -> Recipe = new Recipe($dbh);
        $this -> Process = new Process($dbh);
        $this -> Image = new Image($dbh);
        $this -> Good = new Good($dbh);
    }

    //Usersテーブル

    /**
     * アカウント作成
     * $data array
     * @return param
     */
    public function register($data)
    {
        if (isset($this->request['get']['id'])) {
        }

        $register = $this->User->register($data);
        $params = [
        'register' => $register
        ];
        return $params;
    }
    
    public function login($email, $password)
    {
        $login = $this -> User -> login($email, $password);
        $params = $login;
        return $params;
    }

    /**
    *ログインチェック
    * @param void
    * @return bool $result
    */
    public function checkLogin()
    {
        $result = false;

        if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
            return $result = true;
        }
    }

    public function update($data)
    {
        $update = $this -> User -> update($data);
        $params = [
          'update' => $update
        ];
        return $params;
    }

    public function reset($email, $password)
    {
        $reset = $this -> User -> reset($email, $password);
        $params = $reset;
        return $params;
    }

    //Recipesテーブル

    public function recipe($id, $data)
    {
        if (isset($this->request['get']['id'])) {
        }

        $recipe = $this -> Recipe -> recipe($id, $data);
        $params = [
        'recipe' => $recipe
        ];
        return $params;
    }

    public function lastid()
    {
        $lastid = $this -> Recipe -> lastid();
        return $lastid;
    }

    public function list($id)
    {
        $list = $this -> Recipe -> list($id);
        $params = $list;
        return $params;
    }

    public function view()
    {
        $recipe = $this -> Recipe -> findById($this -> request['get']['id']);
        $params = [
            'recipe' => $recipe
        ];
        return $params;
    }

    public function recipeupdate($data)
    {
        $update = $this -> Recipe -> update($data);
        $params = [
          'update' => $update,
        ];
        return $params;
    }

    public function countMyrecipe($user_id)
    {
        $count = $this -> Recipe -> countMyrecipe($user_id);
        $param = $count;
        return $param;
    }

    public function findAll($user_id)
    {
        $page = 0;
        if (isset($this -> request['get']['page'])) {
            $page = $this -> request['get']['page'];
        }

        $recipes = $this -> Recipe -> findAll($user_id, $page);
        $recipes_count = $this -> Recipe -> countMyrecipe($user_id);
        $params = [
            'recipes' => $recipes,
            'pages' => $recipes_count/10
        ];
        return $params;
    }

    public function search($word)
    {
        $page = 0;
        if (isset($this -> request['get']['page'])) {
            $page = $this -> request['get']['page'];
        }
        $search = $this -> Recipe -> search($word, $page);
        $search_count = $this -> Recipe -> countSearchrecipe($word);
        $params = [
            'search' => $search,
            'pages' => $search_count/10
        ];
        return $params;
    }

    public function deleteRecipe()
    {
        $delete = $this -> Recipe -> delete($this -> request['get']['id']);
        $params[] = $delete;
        return $params;
    }

    //Processesテーブル
    public function process($user_id, $recipe_id, $ing, $method)
    {
        if (isset($this->request['get']['id'])) {
        }
        $process = $this -> Process -> process($user_id, $recipe_id, $ing, $method);
        $params = [
        'process' => $process
        ];
        return $params;
    }

    public function method()
    {
        $method = $this -> Process -> findById($this -> request['get']['id']);
        $params = [
            'method' => $method
        ];
        return $params;
    }

    public function processupdate($data, $user_id, $recipe_id)
    {
        $update = $this -> Process -> update($data, $user_id, $recipe_id);
        $params = $update;
        return $params;
    }

    public function reduce($id)
    {
        $reduce = $this -> Process -> reduce($id);
    }

    public function add($user_id, $recipe_id, $data)
    {
        $add = $this -> Process -> add($user_id, $recipe_id, $data);
        $params = [
            'add' => $add
        ];
        return $params;
    }

    public function deleteProcess()
    {
        $delete = $this -> Process -> delete($this -> request['get']['id']);
        $params[] = $delete;
        return $params;
    }

    //Imageテーブル
    public function savefile($user_id, $recipe_id, $filename, $filepath)
    {
        $image = $this -> Image -> savefile($user_id, $recipe_id, $filename, $filepath);
        $params =  $image;
        return $params;
    }

    public function getImage($user_id)
    {
        $getImage = $this -> Image -> getImage($user_id);
        $params = $getImage;
        return $params;
    }

    public function deleteImage()
    {
        $delete = $this -> Image -> delete($this -> request['get']['id']);
        $params[] = $delete;
        return $params;
    }

    public function updateImage($data)
    {
        $update = $this -> Image -> update($data);
        $params = $update;
        return $params;
    }

    public function getImagelist($data)
    {
        $getimage = $this -> Image -> getImagelist($data);
        $params = $getimage;
        return $params;
    }
    //Goodsテーブル
    
    public function checkfavolite($user_id, $recipe_id)
    {
        $good = $this -> Good -> checkfavolite($user_id, $recipe_id);
        $params = $good;
        return $params;
    }
}
