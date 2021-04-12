<?= $this->Html->css(['users/login']) ?>
<div class="box login_form">
    <div class="box">
        <h3>ログイン</h3>
        <?= $this->Flash->render() ?>
        <?= $this->Form->create() ?>
        <?= $this->Form->control('username', ['required' => true, 'placeholder' => 'username', 'label' => false]) ?>
        <?= $this->Form->control('password', ['required' => true, 'placeholder' => 'password', 'label' => false]) ?>
        <?= $this->Form->button('ログイン') ?>
        <?= $this->Form->end() ?>
        <button class="regist button">アカウント作成</button>
    </div>
</div>