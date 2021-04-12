<?php
use Cake\Core\Configure;
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Controle Panel</title>
    <?= $this->Html->meta('icon') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'style', 'modal', 'admin/style']) ?>
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="/admin/"><span>管理ページ</span></a>
        </div>
        <div class="top-nav-links">
            <a href="/admin/users/logout">ログアウト</a>
        </div>
    </nav>
    <main class="main">
        <div class="container" style="display:flex;height: 80vh;">
            <div class="sidebar">
                <a>メニュー</a>
                <a href='/admin/users'>ユーザーマスタ</a>
                <a href='/admin/tasks'>タスクマスタ</a>
                <a href='/admin/likes'>イイネマスタ</a>
            </div>
            <div style="width:80%;overflow: auto;">
                <?= nl2br($this->Flash->render()) ?>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>