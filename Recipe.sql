-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 8 月 02 日 14:01
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `recipe`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `goods`
--

CREATE TABLE `goods` (
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `recipe_id` int(32) NOT NULL COMMENT 'レシピID',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `recipe_id` int(11) NOT NULL COMMENT 'レシピID',
  `file_name` varchar(255) NOT NULL COMMENT '画像名',
  `file_path` varchar(255) NOT NULL COMMENT '画像パス',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `images`
--

INSERT INTO `images` (`id`, `user_id`, `recipe_id`, `file_name`, `file_path`, `created_at`, `updated_at`) VALUES
(17, 6, 35, '01915_l.jpg', 'image/2022071218012001915_l.jpg', '2022-07-04 16:16:03', '2022-07-13 03:01:20'),
(21, 6, 39, 'シーザーサラダ.jpeg', 'image/20220712180846シーザーサラダ.jpeg', '2022-07-13 03:08:46', '2022-07-13 03:08:46'),
(22, 6, 40, 'とんかつ.jpeg', 'image/20220713063911とんかつ.jpeg', '2022-07-13 15:39:11', '2022-07-13 15:39:11'),
(27, 6, 45, '冷やし中華.jpg', 'image/20220724105025冷やし中華.jpg', '2022-07-24 19:50:25', '2022-07-24 19:50:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `processes`
--

CREATE TABLE `processes` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `recipe_id` int(32) NOT NULL COMMENT 'レシピID',
  `ingreadment` text NOT NULL COMMENT '材料',
  `method` text NOT NULL COMMENT '手順',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `processes`
--

INSERT INTO `processes` (`id`, `user_id`, `recipe_id`, `ingreadment`, `method`, `created_at`, `updated_at`) VALUES
(71, 6, 33, 'カレーライス', 'ご飯にかける', '2022-07-04 16:00:58', '2022-07-04 16:00:58'),
(72, 6, 34, 'カレーライス', 'ご飯にかける', '2022-07-04 16:02:28', '2022-07-04 16:02:28'),
(81, 6, 35, 'サラダ油適量、1口大に切った材料', '鍋を熱し、温まった時にサラダ油を入れる。その後豚肉、にんじん、ジャガイモ、玉ねぎの順番に入れて炒める。', '2022-07-13 02:40:49', '2022-07-13 02:40:49'),
(82, 6, 35, '水300cc', '炒めた後に水を入れてにんじんが柔らかくなるまで煮る。', '2022-07-13 02:40:49', '2022-07-13 02:40:49'),
(83, 6, 35, 'カレー粉（市販の量）', '煮た後に火を止め、カレー粉を入れる。とろみが付いたら完成。', '2022-07-13 02:40:49', '2022-07-13 02:40:49'),
(84, 6, 39, 'レタス3枚、水菜1束、ベビーリーフ2枚', 'レタス、ベビーリーフ、水菜は1口大に切る。', '2022-07-13 03:08:46', '2022-07-13 03:08:46'),
(85, 6, 39, 'バケット3切れ、卵1個', 'バケットはトースターで焼く。卵は半熟になるまで茹でる。', '2022-07-13 03:08:46', '2022-07-13 03:08:46'),
(86, 6, 39, 'シーザドレッシング', '切った野菜を盛り付け、その上から焼いたバゲッドとゆで卵を乗せる。最後にシーザードレッシングをかけたら完成。', '2022-07-13 03:08:46', '2022-07-13 03:08:46'),
(87, 6, 40, 'キャベツ3枚、水400cc', 'キャベツは千切りにして水にさらす。', '2022-07-13 15:39:11', '2022-07-13 15:39:11'),
(88, 6, 40, '豚ロース肉100g、パン粉100g、卵1個、小麦粉100g', '豚肉は筋を切り、小麦粉→たまご→パン粉の順につける。', '2022-07-13 15:39:11', '2022-07-13 15:39:11'),
(89, 6, 40, 'サラダ油適量', '油を温めた後に豚肉を入れる。5分揚げたら油から取り出し、お皿に乗せる。キャベツを添えたら完成。', '2022-07-13 15:39:11', '2022-07-13 15:39:11'),
(103, 6, 45, 'きゅうり1/2本、ハム1枚、トマト1個', 'きゅうり、ハムを5mm間隔で細切りにする。トマトは薄くスライスする。', '2022-07-24 19:50:25', '2022-07-24 19:50:25'),
(104, 6, 45, '中華麺1玉、水1L', '水を鍋に入れお湯を沸かし、沸騰したら中華麺を入れ3分茹でる。その後、麺は水でしめる。', '2022-07-24 19:50:25', '2022-07-24 19:50:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `recipes`
--

CREATE TABLE `recipes` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '料理名',
  `introduce` varchar(255) NOT NULL COMMENT '料理紹介',
  `time` int(32) NOT NULL COMMENT '調理時間',
  `cost` int(32) NOT NULL COMMENT '費用',
  `serving` int(32) NOT NULL COMMENT '人数分',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `name`, `introduce`, `time`, `cost`, `serving`, `created_at`, `updated_at`) VALUES
(35, 6, 'カレーライス', 'カレーライスを作りました。本当に美味しいです。ぜひ食べてみてください', 40, 200, 1, '2022-07-04 16:16:03', '2022-07-04 16:16:03'),
(39, 6, 'シーザーサラダ', 'パーティーの定番料理のシーザーサラダを作ってみました。', 15, 200, 2, '2022-07-13 03:08:46', '2022-07-13 03:08:46'),
(40, 6, 'とんかつ', '揚げ物の定番であるとんかつを作ってみました。', 20, 400, 1, '2022-07-13 15:39:11', '2022-07-13 15:39:11'),
(45, 6, '冷やし中華', '夏に定番の冷やし中華を作りました。簡単なのでぜひ作ってみてください。', 30, 300, 1, '2022-07-24 19:50:25', '2022-07-24 19:50:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT '名前',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `restaurant` varchar(255) NOT NULL COMMENT '飲食店',
  `comment` varchar(255) NOT NULL COMMENT 'ひとこと',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
  `roles` int(11) NOT NULL DEFAULT '0' COMMENT '管理者'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `restaurant`, `comment`, `created_at`, `update_at`, `roles`) VALUES
(6, 'test_user', 'test@test.jp', '$2y$10$/kNXP71PEe/EsRvs6drZZ.2s1NESjWa2kitark5nHN925PbXsYQeO', 'テスト', 'よろしくお願いします。', '2022-06-02 02:53:16', '2022-08-01 15:22:06', 1);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `processes`
--
ALTER TABLE `processes`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=105;

--
-- テーブルの AUTO_INCREMENT `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=46;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
