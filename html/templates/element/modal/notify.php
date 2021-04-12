<!-- Notify Modal -->
<div id="notify_modal" class="modal">
    <p class="msg"></p>
    <div class="box">
        <a class="button" href=<?= $this->Url->build(["controller" => 'Users', "action" => "login"]) ?>>ログイン</a>
        <a class="regist button">アカウント作成</a>
    </div>
</div>