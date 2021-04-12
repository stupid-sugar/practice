<!-- Regist Modal -->
<div id="regist_modal" class="modal">
    <p class="msg">アカウントを登録しましょう</p>
    <?= $this->Form->create(null, ['id' => 'modal_regist_form', 'url' => ['controller' => 'Users', 'action' => 'add']]); ?>
    <?= $this->Form->control('username'); ?>
    <?= $this->Form->control('password'); ?>
    <div class="right"><?= $this->Form->button('登録'); ?></div>
    <?= $this->Form->end(); ?>
</div>