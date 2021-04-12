<!-- Login Modal -->
<div id="login_modal" class="modal">
    <?= $this->Form->create(null, ['id' => 'modal_login_form', 'url' => ['action' => 'login']]); ?>
    <?= $this->Form->control('username'); ?>
    <?= $this->Form->control('password'); ?>
    <p class="msg"></p>
    <div class="box">
        <?= $this->Form->button('ログイン'); ?>
        <?= $this->Form->button('アカウント作成', ['id' => 'regist']); ?>
    </div>
    <?= $this->Form->end(); ?>
</div>