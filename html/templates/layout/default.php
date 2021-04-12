<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'style', 'modal']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!-- jQuery -->
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />    

    <!-- Login Modal -->
    <?= $this->Html->script(['login.js']) ?>
    <?= $this->element('/modal/regist');?>
    <?= $this->element('/modal/notify');?>

    <!-- Login Info -->
    <?php
        $isLoggedIn = !empty($this->request->getAttribute('identity')->id);
        $username = $isLoggedIn ? $this->request->getAttribute('identity')->username : 'ゲスト';
    ?>
    <input type="hidden" id="isLoggedIn" value=<?=$isLoggedIn?>>
    
    <!-- Controller Action Info -->
    <?php
        $controllerName = $this->getRequest()->getParam('controller');
        $actionName = $this->getRequest()->getParam('action');
    ?>
    
    <!-- Default Login Logout Url -->
    <?php
        $loginUrl = $this->Url->build(["controller" => 'Users', "action" => "login"]);
        $logoutUrl = $this->Url->build(["controller" => 'Users', "action" => "logout"]);
    ?>
    
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>ToDo</span>App</a>
        </div>
        <div class="top-nav-links">
            <a id="name"> <?= $username ?></a>
            <a id="logout" href=<?= $logoutUrl ?> style=<?= !$isLoggedIn ? "display:none" : ""?>>ログアウト</a>
            <a id="login" href=<?= $loginUrl ?> style=<?= $isLoggedIn ? "display:none" : ""?>>ログイン</a>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= nl2br($this->Flash->render()) ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
