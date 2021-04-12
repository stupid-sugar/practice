# practice
## 概要
SNS型ToDoアプリ  
ダイエットの目標などにイイネが付くことを想定
## 構成
本アプリは下記環境での動作を確認しています。
#### 言語
- PHP 7.4
- Apache 2.4.38
- MySQL 8.0
#### フレームワーク
- CakePHP 4.2.4
- jQuery 3.3.1
#### プラグイン
- CakePHP authentication 2.0 (https://github.com/cakephp/authentication)
- CakePHP search 6.2.3 (https://github.com/FriendsOfCake/search)
- jQuery Modal 0.9.1 (https://github.com/kylefox/jquery-modal#installation)
#### その他
- PHPMyAdmin 5.0
- Docker 20.10.5
- docker-compose 1.25.5
## 使用方法
Dockerを使用できる場合、下記コマンドで環境構築が可能です。  
デモ環境のため、下記を.gitignoreから外しています。  
- docker/env_file.env
- html/config/app_local.php
- html/webroot/.htaccess
```
git clone https://github.com/stupid-sugar/practice.git practice
cd practice/docker
docker-compose up -d
docker exec -it myapp-web bash
composer install
```
環境構築にあたり、下記サイトを参考にしました。  
https://tt-computing.com/docker-cake4-apache-mysql
#### 注意点
永続化していない場合、コンテナの起動ごとにvolumeが蓄積されていきます。  
必要に応じて、データ永続化に切り替えてください。
###### docker/docker-compose.yml
```
# MySQL
myapp-db:
  container_name: myapp-db
  image: mysql:8.0
  volumes:
    - "./initdb:/docker-entrypoint-initdb.d" # inditdbフォルダのSQLを実行して初期化
    #- "./mysql:/var/lib/mysql" # 永続化
  # 環境変数をファイルで指定
  env_file:
    - env_file.env
```
## 機能一覧
###### ユーザー
- 会員登録
- ToDo一覧の表示
- ToDoの登録・編集・削除
- ToDoにイイネをつける
###### 管理者 (/admin)
- 会員の管理
- ToDoの管理
- イイネの管理
## 補足
- ログイン情報: username: test1, password: password
- 管理者(/admin)とユーザーが存在
- モーダルはtemplates/element/modalで管理
- ユーザー側のCRUDはAjaxを使用
- メッセージはvalidation.poで管理
- 定数はconst/const.phpで管理
###### html/resources/locales/ja_JP/validation.po
```
msgid "successAdd"
msgstr "%sの追加に成功しました"
```
###### sample.php
```
$this->Flash->success(sprintf(__d('validation', 'successAdd'), 'タスク'));
```
## 今後の課題
- 主要な箇所にテストコードを追加
- 統計機能の追加
- CookieやSessionの理解と自動ログイン機能の追加
- ユーザーの行動ログ取得機能の追加
- ユーザー数が増えた場合を考える
- レスポンシブに対応